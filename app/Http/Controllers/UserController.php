<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserModel;
use App\Models\OrderModel;
use App\Models\ProductModel;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class UserController extends Controller
{
    
    public function index()
    {
        return view('user.index');
    }

   
    public function create()
    {
        return view('user.add');
    }

   
    public function store(Request $request)
    {
        $data =  $request->except('_token');
        $validated = $request->validate([
            'user_firstname' => 'required|max:255',
            'user_lastname' => 'required',
            'user_email' => 'required|email|unique:user,user_email',
            'user_phonenumber' => 'required',
            'user_password' => 'required',
            'user_address' => 'required',
            'user_image.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ],[
            'user_firstname.required' => 'The First Name  is required.',
            'user_lastname.required' => 'The Last Name  is required.',
            'user_email.required' => 'The Email  is required.',
            'user_phonenumber.required' => 'The Phone Number  is required.',
            'user_password.required' => 'The Password is required.',
            'user_address.required' => 'The Address is required.',
            'user_image.required' => 'Please Select Image',
        ]);
      
       $img=[];
        if ($request->hasFile('user_image')) {
            $image = $request->file('user_image');
                $destinationPath = 'public/user_image/';
                $file_name = time() . "." . $image->getClientOriginalName();
                $image->move($destinationPath, $file_name);
                $img[] = $file_name;
        }
        $image_string=implode(',',$img);
        $model = new UserModel();
        $model->user_firstname=$validated['user_firstname'];
        $model->user_lastname=$validated['user_lastname'];
        $model->user_email=$validated['user_email'];
        $model->user_image=$image_string;
        $model->user_phonenumber=$validated['user_phonenumber'];
        $model->user_password=Hash::make($validated['user_password']);
        $model->user_address=$validated['user_address'];

        $model->save();
        return redirect()->back()->with('success', 'Data Inserted'); 
    }

   
    public function show($id)
    {
        //
    }

    public function display_user(Request $request){
        date_default_timezone_set('Asia/Kolkata');
        $columns = array(
            0 => 'id',
            1 => 'name',
            2 => 'status',
            3 => 'created_at',
            4 => 'updated_at',
        );  
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        $query = UserModel::where('del_status','1');
        if(isset($_GET['user_name'])){
           $name=$_GET['user_name'];
           if($name!=""){
                $query=  $query->where('user_firstname', 'LIKE', '%'.$name.'%');
            }
        }
        if(isset($_GET['user_email'])){
            $name=$_GET['user_email'];
            if($name!=""){
                 $query=  $query->where('user_email', 'LIKE', '%'.$name.'%');
             }
         }
        if(isset($_GET['user_phonenumber'])){
            $user_phonenumber=$_GET['user_phonenumber'];
            if($user_phonenumber!=""){
                 $query=  $query->where('user_phonenumber', 'LIKE', '%'.$user_phonenumber.'%');
             }
         }

        $count = $query->count();
        $titles = $query->select('id','user_firstname','user_lastname','user_image','user_email','user_phonenumber','status','del_status')
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, 'DESC')
                ->get();
        $totalTitles = $count;
        $totalFiltered = $totalTitles;

        if($request->input('order.0.column') == '0' && $request->input('order.0.dir') == 'desc') {
            $count = $totalTitles - $start;
        } else {
            $count = $start + 1;
        }

        if (!empty($titles)) {
            $data = array();

            foreach ($titles as $title) {
                
                $enbdisu =route('enable_dispbale_subcat',$title->id);
                $edit_subcategory =route('user.edit',$title->id);
                $delete_brand =route('user.destroy',$title->id);
                $order_detail =url('user_order_detail',$title->id);
                
                if($title->status == 0){
                    $statuss = '<a class="dropdown-item waves-light waves-effect" href="'.$enbdisu.'">Enable</a>';
                }else{
                     $statuss = '<a class="dropdown-item waves-light waves-effect" href="'.$enbdisu.'">Disable</a>';
                }
                $nestedData['id'] = $count;
                $image=explode(',',$title->user_image);
                $key = array_key_last($image);
                $nestedData['multidelete']='<td><input type="checkbox" class="sub_chk" data-id="'.$title->id.'"></td>';
                $nestedData['user_image'] = isset($title->user_image[$key])?'<img src ='.asset("/public/user_image/".$title->user_image).' height="50px" width="50px">':'Image not available';
                $nestedData['action'] = '<div class="dropdown">
                <button class="btn btn-sm btn-primary btn-active-pink dropdown-toggle dropdown-toggle-icon" data-toggle="dropdown" type="button" aria-expanded="true">
                    Action <i class="dropdown-caret"></i>
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item waves-light waves-effect" href="'.$edit_subcategory.'">Edit</a></li>
                    <li>'.$statuss.'</li>
                    <li><a class="dropdown-item waves-light waves-effect" href="'.$order_detail.'">Order Deatils</a></li>
                    <form action="'.$delete_brand.'" method="post" id="form-'.$title->id.'">
                        <input type="hidden" name="_token" value="'.csrf_token().'" />
                        <input type="hidden" name="_method" value="DELETE" />
                    </form>
                    <li>
                        <a class="dropdown-item waves-light waves-effect curson-pointer" onclick="document.getElementById(`form-'.$title->id.'`).submit();">Delete</a>
                    </li>
                </ul>
            </div>';
                $nestedData['user_firstname'] = $title->user_firstname;
                $nestedData['user_lastname'] = $title->user_lastname;
                $nestedData['user_email'] = $title->user_email;
                $nestedData['user_phonenumber'] = $title->user_phonenumber;
                $data[] = $nestedData;
                if( $request->input('order.0.column') == '0' and $request->input('order.0.dir') == 'desc') {
                    $count--;
                } else {
                    $count++;
                }
            }
        }

        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalTitles),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data,
        );
        echo json_encode($json_data);
    }
    
    public function edit($id)
    {
        $edit_user=UserModel::where('id',$id)->first();
        return view('user.edit',compact('edit_user'));
    }

    
    public function update(Request $request, $id)
    {
        $data =  $request->except('_token','_method');
        $validated = $request->validate([
            'user_firstname' => 'required|max:255',
            'user_lastname' => 'required',
            // 'user_email' => 'required',
            'user_phonenumber' => 'required',
            'user_password' => 'required',
            'user_address' => 'required',
            'user_image.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ],[
            'user_firstname.required' => 'The First Name  is required.',
            'user_lastname.required' => 'The Last Name  is required.',
            // 'user_email.required' => 'The Email  is required.',
            'user_phonenumber.required' => 'The Phone Number  is required.',
            'user_password.required' => 'The Password is required.',
            'user_address.required' => 'The Address is required.',
            'user_image.required' => 'Please Select Image',
        ]);

       $img=[];
       if ($request->hasFile('user_image')) {
        $image = $request->file('user_image');
            $destinationPath = 'public/user_image/';
            $file_name = time() . "." . $image->getClientOriginalName();
            $image->move($destinationPath, $file_name);
            $img[] = $file_name;
            $data['user_image']=implode(',',$img);

        }else{
            unset($data['user_image']);
        }
        UserModel::where('id',$id)->update($data);
        return redirect()->back()->with('success', 'Data Updated');
    }

   
    public function destroy($id)
    {
        $status="";
        $del_status=UserModel::where('id',$id)->pluck('del_status');
        if(!empty($del_status)){
            foreach($del_status as $del){
                if($del =='1'){
                    $status="0";
                }else{
                    $status="1";
                }
                UserModel::where('id',$id)->update(['del_status' =>$status]);
            }
        }
        return redirect()->back()->with('warning','Category Deleted');
    }

    public function multiple_delete_user(Request $request){
        $status="";
        $del_status=UserModel::whereIn('id',explode(',',$request['ids']))->pluck('del_status');
        if(!empty($del_status)){
            foreach($del_status as $del){
                if($del =='1'){
                    $status="0";
                }else{
                    $status="1";
                }
                UserModel::whereIn('id',explode(',',$request['ids']))->update(['del_status' =>$status]);
            }
        }
        return response()->json(['success' => ' Data has been deleted!']);
    }
    public function enable_dispbale_user($id){
        $cat_status=UserModel::where('id',$id)->pluck('status')->toArray();
        if($cat_status[0] == '1'){
            UserModel::where('id',$id)->update(['status' =>'0']);
        }else{
            UserModel::where('id',$id)->update(['status' =>'1']);
        }
        return redirect()->back()->with('success','Status Updated');
    }

    public function user_order_detail($id){
        $user_order_data=OrderModel::where('user_id',$id)->get();
        return view('user.order_detail',compact('user_order_data'));
    }

    public function create_order($id){
        $user_order_data=OrderModel::where('user_id',$id)->get();
        $user=UserModel::where('id',$id)->first();
        $product=ProductModel::select('product_name','id')->get();
        $product_name=json_decode($product);
        return view('user.create_order',compact('user_order_data','product_name','user'));
    }

    public function create_pdf_user(Request $request){
        $user_data=UserModel::get()->toArray();
        view()->share('employee',$user_data);
        $pdf = PDF::loadView('user.userpdf', compact('user_data'))->setOptions(['defaultFont' => 'sans-serif']);
        return $pdf->download('user.pdf');
    }
    public function create_csv_user(){
        return Excel::download(new UserModel(), 'category.xlsx');
    }
}

<?php

namespace App\Http\Controllers;

use App\Api\ApiResponse;
use App\Exports\OrderExport;
use App\Models\CouponModel;
use App\Models\OrderModel;
use App\Models\UserModel;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class OrderController extends Controller
{
    
    public function index()
    {
        return view('order.index');
    }

    
    public function create()
    {
        return view('order.add');
    }

    
    public function store(Request $request)
    {
        $unique_order_id='MED'.random_int(100000, 999999);
        $new_coupon_code='MED'.Str::random(9);
        $data =  $request->except('_token');
        $validated = $request->validate([
            'product_name' => 'required|max:255',
            'product_qty' => 'required',
            'order_amount' => 'required',
            'priscription.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'user_id' => 'required',
            'user_address' => 'required',
        ],[
            'product_name.required' => 'The Product name field is required.',
            'order_amount.required' => 'The Order amount name field is required.',
            'priscription.required' => 'Please Select Image',
            'user_address.required' => 'The Addresss is required.',
            'user_id.required' => 'The user id field is required.',
        ]);
            $product_name=implode(',',($request['product_name']));
        $img=[];
        if ($request->hasFile('priscription')){
        
            $image = $request->file('priscription');
                $destinationPath = 'public/pricription/';
                $file_name = time() . "." . $image->getClientOriginalName();
                $image->move($destinationPath, $file_name);
                $img[] = $file_name;
        }
        $image_string=implode(',',$img);
        
        // if(isset($request['coupon_code']) && $request['coupon']){
            
        // }
        //insert data in order table
        $validated['order_id']=$unique_order_id;
        $validated['prescription']=$image_string;
        $validated['user_id']=$validated['user_id'];
        $validated['coupon']=(!empty($validated['coupon']))?$validated['coupon']:"";
        OrderModel::create($validated);

        //for coupon
        $validated['coupon']=$new_coupon_code;
        $validated['prescription']=$image_string;
        $validated['user_id']=$validated['user_id'];
        $validated['coupon']=$validated['coupon'];
        CouponModel::create($validated);

        return redirect()->back()->with('success', 'Data Inserted');
    }

    public function show($id)
    {
        //
    }

   
    public function edit($id)
    {
        $edit_data=OrderModel::where('id',$id)->first()->toArray();
        $user_data=UserModel::where('id',$edit_data['user_id'])->select('user_firstname','user_lastname','user_phonenumber')->first();
        return view('order.edit',compact('edit_data','user_data'));
    }

   
    public function update(Request $request, $id)
    {
        $data =  $request->except('_token','_method');
        $validated = $request->validate([
            'order_id' => 'required|max:255',
            'order_status' => 'required',
            'suborder_status' => 'required',
            'purchase_price' => 'required',
            'sale_price' => 'required',
            'prod_desc' => 'required',
        ],[
            'order_id.required' => 'The category name field is required.',
            'order_status.required' => 'The Subcategory name field is required.',
            'suborder_status.required' => 'The category type field is required.',
            'purchase_price.required' => 'The purchase price field is required.',
            'sale_price.required' => 'The sale price field is required.',
            'prod_desc.required' => 'The cat status field is required.',
        ]);
      
       $img=[];
        if ($request->hasFile('prescription')) {
            $image = $request->file('prescription');
            foreach ($image as $files) {
                $destinationPath = 'public/prescription/';
                $file_name = time() . "." . $files->getClientOriginalName();
                $files->move($destinationPath, $file_name);
                $img[] = $file_name;
                $data['prescription']=implode(',',$img);

            }
        }else{
            unset($data['prescription']);
        }
        $data['product']=implode(',',($request['product_name']));
        OrderModel::where('id',$id)->update($data);
        return redirect()->back()->with('success', 'Data Updated');
    }

    
    public function destroy($id)
    {
        $status="";
        $del_status=OrderModel::where('id',$id)->pluck('del_status');
        if(!empty($del_status)){
            foreach($del_status as $del){
                if($del =='1'){
                    $status="0";
                }else{
                    $status="1";
                }
                OrderModel::where('id',$id)->update(['del_status' =>$status]);
            }
        }
        return redirect()->back()->with('warning','Category Deleted');
    }
    
    public function display_order(Request $request){
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
        $query =OrderModel::where('del_status','1');
        if(isset($_GET['order_id'])){
           $name=$_GET['order_id'];
           if($name!="" && $name!='null'){
                $query=  $query->where('order_id', 'LIKE', '%'.$name.'%');
            }
        }

        if(isset($_GET['order_status'])){
            $order_status=$_GET['order_status'];
            if($order_status!="" && $order_status!='null'){
                 $query=  $query->where('order_status', $order_status);

             }
         }
        $count = $query->count();
        $titles = $query->select('id','order_id','order_status','status','del_status')
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
            $order_status="";
            foreach ($titles as $title) {
                
                $enbdisu =route('enable_disable_order',$title->id);
                $edit_category =route('order.edit',$title->id);
                $delete_category =route('order.destroy',$title->id);
                $nestedData['id'] = $count;
                $nestedData['multidelete']='<td><input type="checkbox" class="sub_chk" data-id="'.$title->id.'"></td>';
                $nestedData['action'] = '<div class="dropdown">
                <button class="btn btn-sm btn-primary btn-active-pink dropdown-toggle dropdown-toggle-icon" data-toggle="dropdown" type="button" aria-expanded="true">
                    Action <i class="dropdown-caret"></i>
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item waves-light waves-effect" href="'.$edit_category.'">Edit</a></li>
                    <form action="'.$delete_category.'" method="post" id="form">
                        <input type="hidden" name="_token" value="'.csrf_token().'" />
                        <input type="hidden" name="_method" value="DELETE" />
                    </form>
                    <li>
                        <a class="dropdown-item waves-light waves-effect curson-pointer" onclick="document.getElementById(`form`).submit();">Delete</a>
                    </li>
                </ul>
            </div>';
                $nestedData['order_id'] = $title->order_id;
                $nestedData['order_id'] = $title->order_id;
                if($title->order_status == '1'){
                    $order_status="Create";
                }else if($title->order_status=='2'){
                    $order_status="Pending";
                }else if($title->order_status=='3'){
                    $order_status="Dispatch";
                }else if($title->order_status=='4'){
                    $order_status="Delivered";
                }else if($title->order_status=='5'){
                    $order_status="Denied";
                }else if($title->order_status=='6'){
                    $order_status="Cancel";
                }else{
                    $order_status="Return";
                }
                $nestedData['order_status'] = $order_status;
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

    public function enable_disable_product($id){
        $cat_status=OrderModel::where('id',$id)->pluck('status')->toArray();
        if($cat_status[0] == '1'){
            OrderModel::where('id',$id)->update(['status' =>'0']);
        }else{
            OrderModel::where('id',$id)->update(['status' =>'1']);
        }
        return redirect()->back()->with('success','Status Updated');
    }

    public function multiple_delete_product(Request $request){
        $status="";
        $del_status=OrderModel::whereIn('id',explode(',',$request['ids']))->pluck('del_status');
        if(!empty($del_status)){
            foreach($del_status as $del){
                if($del =='1'){
                    $status="0";
                }else{
                    $status="1";
                }
                OrderModel::whereIn('id',explode(',',$request['ids']))->update(['del_status' =>$status]);
            }
        }
        return response()->json(['success' => ' Data has been deleted!']);
    }
    public function status_update($order_id,$id){
        OrderModel::where('order_id',$order_id)->update(['order_status' =>$id]);
        return redirect()->back()->with('success','Order Status Updated');      
    }
    public function create_pdf_order(Request $request){
        $order_data=OrderModel::where('del_status','1')->get()->toArray();
        view()->share('employee',$order_data);
        $pdf = PDF::loadView('order.orderpdf', compact('order_data'))->setOptions(['defaultFont' => 'sans-serif']);
        return $pdf->download('order.pdf');
    }
    public function create_csv_order(){
        return Excel::download(new OrderExport, 'orders.xlsx');

    }

    
}

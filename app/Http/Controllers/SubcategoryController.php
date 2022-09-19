<?php

namespace App\Http\Controllers;

use App\Exports\SubcategoryExport;
use App\Models\CategoryModel;
use App\Models\SubcategoryModel;
use category;
use Illuminate\Http\Request;
use PDF;
use Maatwebsite\Excel\Facades\Excel;
use Subcategory;

class SubcategoryController extends Controller
{
    
    public function index()
    {
        return view('subcategory.index');
    }

    
    public function create()
    {
        $category=CategoryModel::all();
        return view('subcategory.add',compact('category'));
    }

    
    public function store(Request $request)
    {
        $data =  $request->except('_token');
        $validated = $request->validate([
            'subcategory_name' => 'required|max:255',
            'category_id' => 'required',
            'subcategory_image.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ],[
            'subcategory_name.required' => 'The category name field is required.',
            'category_id.required' => 'The Subcategory name field is required.',
            'subcategory_image.required' => 'Please Select Image',
        ]);
      
       $img=[];
        if ($request->hasFile('subcategory_image')) {
            $image = $request->file('subcategory_image');
                $destinationPath = 'public/subcategory_image/';
                $file_name = time() . "." . $image->getClientOriginalName();
                $image->move($destinationPath, $file_name);
                $img[] = $file_name;
        }
        $image_string=implode(',',$img);
        $model = new SubcategoryModel();
        $model->subcategory_name=$validated['subcategory_name'];
        $model->category_id=$validated['category_id'];
        $model->subcategory_image=$image_string;
        $model->save();
        return redirect()->back()->with('success', 'Data Inserted');  
    }

    public function display_subcategory(Request $request){
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
        $query = SubcategoryModel::where('subcategory.del_status','1');
        if(isset($_GET['subcat_name'])){
           $name=$_GET['subcat_name'];
           if($name!=""){
                $query=  $query->where('subcategory_name', 'LIKE', '%'.$name.'%');
            }
        }
        if(isset($_GET['cat_name'])){
            $cat_name=$_GET['cat_name'];
            if($cat_name!=""){
                 $query=  $query->where('category_id', 'LIKE', '%'.$cat_name.'%');
             }
         }
         
        $count = $query->count();
        $titles = $query->join('category','subcategory.category_id','category.id')->select('subcategory.id','subcategory_name','category_id','subcategory_image','subcategory.status','category_name')
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
                $edit_subcategory =route('subcategory.edit',$title->id);
                $delete_brand =route('subcategory.destroy',$title->id);
                
                if($title->status == 0){
                    $statuss = '<a class="dropdown-item waves-light waves-effect" href="'.$enbdisu.'">Enable</a>';
                }else{
                     $statuss = '<a class="dropdown-item waves-light waves-effect" href="'.$enbdisu.'">Disable</a>';
                }
                $nestedData['id'] = $count;
                $image=explode(',',$title->subcategory_image);
                $key = array_key_last($image);
                $nestedData['multidelete']='<td><input type="checkbox" class="sub_chk" data-id="'.$title->id.'"></td>';
                $nestedData['subcategory_image'] = isset($title->subcategory_image[$key])?'<img src ='.asset("/public/subcategory_image/".$title->subcategory_image).' height="50px" width="50px">':'Image not available';
                $nestedData['action'] = '<div class="dropdown">
                <button class="btn btn-sm btn-primary btn-active-pink dropdown-toggle dropdown-toggle-icon" data-toggle="dropdown" type="button" aria-expanded="true">
                    Action <i class="dropdown-caret"></i>
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item waves-light waves-effect" href="'.$edit_subcategory.'">Edit</a></li>
                    <li>'.$statuss.'</li>
                    <form action="'.$delete_brand.'" method="post" id="form-'.$title->id.'">
                        <input type="hidden" name="_token" value="'.csrf_token().'" />
                        <input type="hidden" name="_method" value="DELETE" />
                    </form>
                    <li>
                        <a class="dropdown-item waves-light waves-effect curson-pointer" onclick="document.getElementById(`form-'.$title->id.'`).submit();">Delete</a>
                    </li>
                </ul>
            </div>';
                $nestedData['subcat_name'] = $title->subcategory_name;
                $nestedData['category_id'] = $title->category_name;
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
    
    public function show($id)
    {
        //
    }

   
    public function edit($id)
    {
        $category=CategoryModel::all();
        $edit_subcategory=SubcategoryModel::where('id',$id)->first();
        return view('subcategory.edit',compact('edit_subcategory','category'));
    }

    
    public function update(Request $request, $id)
    {
        $data =  $request->except('_token','_method');
        $validated = $request->validate([
            'subcategory_name' => 'required|max:255',
            'category_id' => 'required',
            'subcategory_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ],[
            'subcategory_name.required' => 'The category name field is required.',
            'category_id.required' => 'The Subcategory name field is required.',
            'subcategory_image.required' => 'Please Select Image',
        ]);
       $img=[];
       if ($request->hasFile('subcategory_image')) {
        $image = $request->file('subcategory_image');
            $destinationPath = 'public/subcategory_image/';
            $file_name = time() . "." . $image->getClientOriginalName();
            $image->move($destinationPath, $file_name);
            $img[] = $file_name;
            $data['subcategory_image']=implode(',',$img);

        }else{
            unset($data['subcategory_image']);
        }
        SubcategoryModel::where('id',$id)->update($data);
        return redirect()->back()->with('success', 'Data Updated');
    }

   
    public function destroy($id)
    {
        $status="";
        $del_status=SubcategoryModel::where('id',$id)->pluck('del_status');
        if(!empty($del_status)){
            foreach($del_status as $del){
                if($del =='1'){
                    $status="0";
                }else{
                    $status="1";
                }
                SubcategoryModel::where('id',$id)->update(['del_status' =>$status]);
            }
        }
        return redirect()->back()->with('warning','Category Deleted');
    }

    public function multiple_delete(Request $request){
        $status="";
        $del_status=SubcategoryModel::whereIn('id',explode(',',$request['ids']))->pluck('del_status');
        if(!empty($del_status)){
            foreach($del_status as $del){
                if($del =='1'){
                    $status="0";
                }else{
                    $status="1";
                }
                SubcategoryModel::whereIn('id',explode(',',$request['ids']))->update(['del_status' =>$status]);
            }
        }
        return response()->json(['success' => ' Data has been deleted!']);
    }

    public function enable_dispbale_subcat($id){
        $cat_status=SubcategoryModel::where('id',$id)->pluck('status')->toArray();
        if($cat_status[0] == '1'){
            SubcategoryModel::where('id',$id)->update(['status' =>'0']);
        }else{
            SubcategoryModel::where('id',$id)->update(['status' =>'1']);
        }
        return redirect()->back()->with('success','Status Updated');
    }
    public function create_pdf_subcategory(Request $request){
        $subcategory=SubcategoryModel::join('category','subcategory.category_id','category.id')->where('subcategory.del_status','1')->where('category.del_status','1')->get()->toArray();
        if(!empty($subcategory)){
            view()->share('employee',$subcategory);
            $pdf = PDF::loadView('subcategory.subcategorypdf', compact('subcategory'))->setOptions(['defaultFont' => 'sans-serif']);
            return $pdf->download('subcategory.pdf');
        }else{
            return redirect()->back()->with('danger','No Data in Table');
        }
        
    }
    public function create_csv_subcategory(){
        return Excel::download(new SubcategoryExport, 'subcategory.xlsx');
    }
}

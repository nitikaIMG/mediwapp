<?php

namespace App\Http\Controllers;
use App\Models\BrandModel;
use Illuminate\Http\Request;
use PDF;
use Maatwebsite\Excel\Facades\Excel;

class BrandController extends Controller
{
    
    public function index()
    {
        return view('brand.index');
    }

   
    public function create()
    {
        return view('brand.add_brand');
    }

    
    public function store(Request $request)
    {
        $data =  $request->except('_token');
        $validated = $request->validate([
            'brand_name' => 'required|max:255',
            'category_id' => 'required',
            'brand_image.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'subcategory_id' => 'required',
        ],[
            'brand_name.required' => 'The category name field is required.',
            'category_id.required' => 'The Category name field is required.',
            'brand_image.required' => 'Please Select Image',
            'subcategory_id.required' => 'The Subcategory type field is required.',
        ]);
        $img=[];
        if ($request->hasFile('brand_image')) {
            $image = $request->file('brand_image');
                $destinationPath = 'public/brand_image/';
                $file_name = time() . "." . $image->getClientOriginalName();
                $image->move($destinationPath, $file_name);
                $img[] = $file_name;
        }
        $image_string=implode(',',$img);
        $model = new BrandModel;
        $model->brand_name=$validated['brand_name'];
        $model->category_id=$validated['category_id'];
        $model->brand_image=$image_string;
        $model->subcategory_id=$validated['subcategory_id'];
        $model->save();
        return redirect()->back()->with('success', 'Data Inserted');
    }

    public function display_brand(Request $request){
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
            $query = BrandModel::where('del_status','1');
            if(isset($_GET['brand_name'])){
               $name=$_GET['brand_name'];
               if($name!=""){
                    $query=  $query->where('brand_name', 'LIKE', '%'.$name.'%');
                }
            }
            if(isset($_GET['category_id'])){
                $category_id=$_GET['category_id'];
                if($category_id!=""){
                     $query=  $query->where('category_id', 'LIKE', '%'.$category_id.'%');
                 }
             }
    
            $count = $query->count();
            $titles = $query->select('id','brand_name','subcategory_id','brand_image','category_id')
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
                    
                    $enbdisu =route('enable_disable_brand',$title->id);
                    $edit_brand =route('brand.edit',$title->id);
                    $delete_brand =route('brand.destroy',$title->id);
                    
    
                    if($title->cat_status == 0){
                        $statuss = '<a class="dropdown-item waves-light waves-effect" href="'.$enbdisu.'">Enable</a>';
                    }else{
                         $statuss = '<a class="dropdown-item waves-light waves-effect" href="'.$enbdisu.'">Disable</a>';
                    }
    
                    $nestedData['id'] = $count;
                    $image=explode(',',$title->brand_image);
                    $key = array_key_last($image);
                    $nestedData['multidelete']='<td><input type="checkbox" class="sub_chk" data-id="'.$title->id.'"></td>';
                    $nestedData['brand_image'] = isset($title->brand_image[$key])?'<img src ='.asset("/public/brand_image/".$title->brand_image).' height="50px" width="50px">':'Image not available';
                    $nestedData['action'] = '<div class="dropdown">
                    <button class="btn btn-sm btn-primary btn-active-pink dropdown-toggle dropdown-toggle-icon" data-toggle="dropdown" type="button" aria-expanded="true">
                        Action <i class="dropdown-caret"></i>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item waves-light waves-effect" href="'.$edit_brand.'">Edit</a></li>
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
                    $nestedData['brand_name'] = $title->brand_name;
                    $nestedData['category_id'] = $title->category_id;
                    $nestedData['subcategory_id'] = $title->subcategory_id;
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
        $edit_brand=BrandModel::where('id',$id)->first();
        return view('brand.edit_brand',compact('edit_brand'));
    }

    
    public function update(Request $request, $id)
    {
        $data =  $request->except('_token','_method');
        $validated = $request->validate([
            'brand_name' => 'required|max:255',
            'subcategory_id' => 'required',
            'brand_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'category_id' => 'required',
        ],[
            'brand_name.required' => 'The category name field is required.',
            'subcategory_id.required' => 'The Subcategory name field is required.',
            'brand_image.required' => 'Please Select Image',
            'category_id.required' => 'The category type field is required.',
        ]);
       $img=[];
       if ($request->hasFile('brand_image')) {
        $image = $request->file('brand_image');
            $destinationPath = 'public/brand_image/';
            $file_name = time() . "." . $image->getClientOriginalName();
            $image->move($destinationPath, $file_name);
            $img[] = $file_name;
            $data['brand_image']=implode(',',$img);

        }else{
            unset($data['brand_image']);
        }
        BrandModel::where('id',$id)->update($data);
        return redirect()->back()->with('success', 'Data Updated');
    }

    public function destroy($id)
    {
        $del_status=BrandModel::where('id',$id)->pluck('status');
        if(!empty($del_status)){
            foreach($del_status as $del){
                if($del =='1'){
                    BrandModel::where('id',$id)->update(['del_status' =>'0']);
                }else{
                    BrandModel::where('id',$id)->update(['del_status' =>'1']);

                }
            }
        }
        return redirect()->back()->with('warning','Category Deleted');
    }

    public function enable_disable_brand($id){
        $cat_status=BrandModel::where('id',$id)->pluck('cat_status')->toArray();
        if($cat_status[0] == '1'){
            BrandModel::where('id',$id)->update(['cat_status' =>'0']);
        }else{
            BrandModel::where('id',$id)->update(['cat_status' =>'1']);
        }
        return redirect()->back()->with('success','Status Updated');
    }

    public function brand_multiple_delete(Request $request){
        $del_status=BrandModel::whereIn('id',explode(',',$request['ids']))->pluck('del_status');
        if(!empty($del_status)){
            foreach($del_status as $del){
                if($del =='1'){
                    BrandModel::whereIn('id',explode(',',$request['ids']))->update(['del_status' =>'0']);
                }else{
                    BrandModel::whereIn('id',explode(',',$request['ids']))->update(['del_status' =>'1']);

                }
            }
        }
        return response()->json(['success' => ' Data has been deleted!']);
    }
    public function create_pdf_brand(Request $request){
        $brand_data=BrandModel::get()->toArray();
        view()->share('employee',$brand_data);
        $pdf = PDF::loadView('brand.brandpdf', compact('brand_data'))->setOptions(['defaultFont' => 'sans-serif']);
        return $pdf->download('brand.pdf');
    }
    public function create_csv_brand(){
        return Excel::download(new BrandModel(), 'category.xlsx');
    }
}

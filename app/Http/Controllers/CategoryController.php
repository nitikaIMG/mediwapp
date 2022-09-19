<?php

namespace App\Http\Controllers;
use App\Exports\StudentExport;
use Illuminate\Http\Request;
use App\Models\CategoryModel;
use App\Models\CategoryModel as ModelsCategoryModel;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
class CategoryController extends Controller
{
        // public function __construct()
        // {
        //     $this->middleware('auth');
        // }
    
    public function index()
    {
        return view('category.index');
    }

    
    public function create()
    {
       return view('category.add_category');
    }

    public function store(Request $request)
    {
        $data =  $request->except('_token');
        $validated = $request->validate([
            'category_name' => 'required|max:255',
            'category_image.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'meta_title' => 'required',
            'meta_description' => 'required',
            'meta_keyword' => 'required',
            // 'banner' => 'required',
            'cat_desc' => 'required',
        ],[
            'category_name.required' => 'The category name field is required.',
            'category_image.required' => 'Please Select Image',
            'meta_title.required' => 'The meta title field is required.',
            'meta_description.required' => 'The meta description field is required.',
            'meta_keyword.required' => 'The meta keyword field is required.',
            // 'banner.required' => 'The banner  field is required.',
            'cat_desc.required' => 'The category Descripction field is required.',
        ]);
      
       $img=[];
        if ($request->hasFile('category_image')) {
            $image = $request->file('category_image');
                $destinationPath = 'public/category_image/';
                $file_name = time() . "." . $image->getClientOriginalName();
                $image->move($destinationPath, $file_name);
                $img[] = $file_name;
        }
        $image_string=implode(',',$img);
        $model = new CategoryModel;
        $model->category_name=$validated['category_name'];
        $model->category_image=$image_string;
        $model->cat_desc=$validated['cat_desc'];
        $model->meta_title=$validated['meta_title'];
        $model->meta_keyword=$validated['meta_keyword'];
        $model->meta_description=$validated['meta_description'];
        $model->save();
        return redirect()->back()->with('success', 'Data Inserted');   

    }

    
    public function show($id)
    {
       
    }

  
    public function edit($id)
    {
        $edit_data=CategoryModel::where('id',$id)->first()->toArray();
        $file=CategoryModel::where('id',$id)->pluck('category_image');
        return view('category.edit_category',compact('edit_data','file'));
    }
    

    public function update(Request $request, $id)
    {
        $data =  $request->except('_token','_method');
        $validated = $request->validate([
            'category_name' => 'required|max:255',
            'meta_title' => 'required',
            'meta_description' => 'required',
            'meta_keyword' => 'required',
            // 'banner' => 'required',
            'cat_desc' => 'required',
        ],[
            'category_name.required' => 'The category name field is required.',
            'meta_title.required' => 'The meta title field is required.',
            'meta_description.required' => 'The meta description field is required.',
            'meta_keyword.required' => 'The meta keyword field is required.',
            // 'banner.required' => 'The banner  field is required.',
            'cat_desc.required' => 'The category Descripction field is required.',
        ]);
       $banner_img=[];
       $img=[];
        if ($request->hasFile('category_image')) {
            $image = $request->file('category_image');
                $destinationPath = 'public/category_image/';
                $file_name = time() . "." . $image->getClientOriginalName();
                $image->move($destinationPath, $file_name);
                $img[] = $file_name;
                $data['category_image']=implode(',',$img);
        }else{
            unset($data['category_image']);
        }

        if ($request->hasFile('banner')) {
           if ($request->hasFile('banner')) {
            $banner_image = $request->file('banner');
            $destination = 'public/banner/';
            $banner_file_name = time() . "." . $banner_image->getClientOriginalName();
            $banner_image->move($destination, $banner_file_name);
            $banner_img[] = $banner_file_name;
            $data['banner']=implode(',',$banner_img);

        }
        }else{
            unset($data['banner']);
        }

        CategoryModel::where('id',$id)->update($data);
        return redirect()->back()->with('success', 'Data Updated');
    }

    
    public function destroy($id)
    {
        $status="";
        $del_status=CategoryModel::where('id',$id)->pluck('del_status');
        if(!empty($del_status)){
            foreach($del_status as $del){
                if($del =='1'){
                    $status="0";
                }else{
                    $status="1";
                }
                CategoryModel::where('id',$id)->update(['del_status' =>$status]);
            }
        }
        return redirect()->back()->with('warning','Category Deleted');
    }

    public function display_category(Request $request){
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
        $query =CategoryModel::where('del_status','1');
        if(isset($_GET['cat_name'])){
           $name=$_GET['cat_name'];
           if($name!=""){
                $query=  $query->where('category_name', 'LIKE', '%'.$name.'%');
            }
        }
       

        $count = $query->count();
        $titles = $query->select('id','category_name','subcategory_id','category_image','cat_desc','cat_status')
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
                
                $enbdisu =route('enable_disable_category',$title->id);
                $edit_category =route('category.edit',$title->id);
                $delete_category =route('category.destroy',$title->id);
                

                if($title->cat_status == 0){
                    $statuss = '<a class="dropdown-item waves-light waves-effect" href="'.$enbdisu.'">Enable</a>';
                }else{
                     $statuss = '<a class="dropdown-item waves-light waves-effect" href="'.$enbdisu.'">Disable</a>';
                }

                $nestedData['id'] = $count;
                $image=explode(',',$title->category_image);
                $key = array_key_last($image);
                $nestedData['multidelete']='<td><input type="checkbox" class="sub_chk" data-id="'.$title->id.'"></td>';
                $nestedData['category_image'] = isset($title->category_image[$key])?'<img src ='.asset("/public/category_image/".$title->category_image).' height="50px" width="50px">':'Image not available';
                $nestedData['action'] = '<div class="dropdown">
                <button class="btn btn-sm btn-primary btn-active-pink dropdown-toggle dropdown-toggle-icon" data-toggle="dropdown" type="button" aria-expanded="true">
                    Action <i class="dropdown-caret"></i>
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item waves-light waves-effect" href="'.$edit_category.'">Edit</a></li>
                    <li>'.$statuss.'</li>
                    <form action="'.$delete_category.'" method="post" id="form-'.$title->id.'">
                        <input type="hidden" name="_token" value="'.csrf_token().'" />
                        <input type="hidden" name="_method" value="DELETE" />
                    </form>
                    <li>
                        <a class="dropdown-item waves-light waves-effect curson-pointer" onclick="document.getElementById(`form-'.$title->id.'`).submit();">Delete</a>
                    </li>
                </ul>
            </div>';
                $nestedData['category_name'] = $title->category_name;
                $nestedData['meta_title'] = $title->meta_title;
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

    public function enable_disable_category($id){
        $cat_status=CategoryModel::where('id',$id)->pluck('cat_status')->toArray();
        if($cat_status[0] == '1'){
            CategoryModel::where('id',$id)->update(['cat_status' =>'0']);
        }else{
            CategoryModel::where('id',$id)->update(['cat_status' =>'1']);
        }
        return redirect()->back()->with('success','Status Updated');
    }
    public function delete_all(Request $request){
        $status="";
        $del_status=CategoryModel::whereIn('id',explode(',',$request['ids']))->pluck('del_status');
        if(!empty($del_status)){
            foreach($del_status as $del){
                if($del =='1'){
                    $status="0";
                }else{
                    $status="1";
                }
                CategoryModel::whereIn('id',explode(',',$request['ids']))->update(['del_status' =>$status]);
            }
        }
        return response()->json(['success' => ' Data has been deleted!']);
    }
    public function create_pdf_category(Request $request){
        $category_data=CategoryModel::where('del_status','1')->get()->toArray();
        view()->share('employee',$category_data);
        $pdf = PDF::loadView('category.categorypdf', compact('category_data'))->setOptions(['defaultFont' => 'sans-serif']);
        return $pdf->download('category.pdf');
    }
    public function create_csv_category(){

        return Excel::download(new StudentExport, 'Categorydata.xlsx');
    }
    
}

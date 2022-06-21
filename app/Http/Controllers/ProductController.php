<?php

namespace App\Http\Controllers;

use App\Models\ProductModel;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
class ProductController extends Controller
{
    
    public function index()
    {
        return view('product.index');
    }

    
    public function create()
    {
        return view('product.add');
    }

   
    public function store(Request $request)
    {
        $data =  $request->except('_token');
        $validated = $request->validate([
            'product_name' => 'required|max:255',
            'category_id' => 'required',
            // 'product_image.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'subcategory_id' => 'required',
            'prod_desc' => 'required',
            'price' => 'required',
            'opening_quantity' => 'required',
            'min_quantity' => 'required',
            'package_type' => 'required',
            'brand_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'validate_date' => 'required',
            'offer' => 'required',
            'offer_type' => 'required',
        ],[
            'product_name.required' => 'The Product name field is required.',
            'category_id.required' => 'The category name field is required.',
            // 'product_image.required' => 'Please Select Image',
            'subcategory_id.required' => 'The subcategory type field is required.',
            'price.required' => 'The price  field is required.',
            'opening_quantity.required' => 'The opening quantity field is required.',
            'prod_desc.required' => 'The product description field is required.',
            'min_quantity.required' => 'The min quantity field is required.',
            'package_type.required' => 'The package type field is required.',
            'brand_image.required' => 'The brand image field is required.',
            'validate_date.required' => 'The validate date field is required.',
            'offer.required' => 'The offer field is required.',
            'offer_type.required' => 'The offer type field is required.',
        ]);
      
       $img=[];
       $brand_image=[];
        if ($request->hasFile('product_image')) {
            $image = $request->file('product_image');
            foreach ($image as $files) {
                $destinationPath = 'public/product_image/';
                $file_name = time() . "." . $files->getClientOriginalName();
                $files->move($destinationPath, $file_name);
                $img[] = $file_name;
            }
        }

        if ($request->hasFile('brand_image')) {
            $brand_image = $request->file('brand_image');
                $destination = 'public/brand_image/';
                $fil = time() . "." . $brand_image->getClientOriginalName();
                $brand_image->move($destination, $fil);
                $brand_image = $fil;
        }
        $data['product_image']=implode(',',$img);
        $data['brand_image']=$brand_image;
        ProductModel::create($data);
        return redirect()->back()->with('success', 'Data Inserted');
    }

    
    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $edit_data=ProductModel::where('id',$id)->first()->toArray();
        $file=ProductModel::where('id',$id)->pluck('product_image');
        return view('product.edit',compact('edit_data','file'));
    }

    
    public function update(Request $request, $id)
    {
        $data =  $request->except('_token','_method');
        $validated = $request->validate([
            'product_name' => 'required|max:255',
            'category_id' => 'required',
            // 'product_image.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'subcategory_id' => 'required',
            'prod_desc' => 'required',
            'price' => 'required',
            'opening_quantity' => 'required',
            'min_quantity' => 'required',
            'package_type' => 'required',
            // 'brand_image' => 'required',
            'validate_date' => 'required',
            'offer' => 'required',
            'offer_type' => 'required',
        ],[
            'product_name.required' => 'The Product name field is required.',
            'category_id.required' => 'The category name field is required.',
            // 'product_image.required' => 'Please Select Image',
            'subcategory_id.required' => 'The subcategory type field is required.',
            'price.required' => 'The price  field is required.',
            'opening_quantity.required' => 'The opening quantity field is required.',
            'prod_desc.required' => 'The product description field is required.',
            'min_quantity.required' => 'The min quantity field is required.',
            'package_type.required' => 'The package type field is required.',
            // 'brand_image.required' => 'The brand image field is required.',
            'validate_date.required' => 'The validate date field is required.',
            'offer.required' => 'The offer field is required.',
            'offer_type.required' => 'The offer type  field is required.',
        ]);
      
       $img=[];
       $brand_image=[];
       if ($request->hasFile('brand_image')) {
        $brand_image = $request->file('brand_image');
            $destination = 'public/brand_image/';
            $fil = time() . "." . $brand_image->getClientOriginalName();
            $brand_image->move($destination, $fil);
            $brand_image = $fil;
            $data['brand_image']=$brand_image;
        }else{
            unset($data['brand_image']);
        }

        if ($request->hasFile('product_image')) {
            $image = $request->file('product_image');
            foreach ($image as $files) {
                $destinationPath = 'public/product_image/';
                $file_name = time() . "." . $files->getClientOriginalName();
                $files->move($destinationPath, $file_name);
                $img[] = $file_name;
                $data['product_image']=implode(',',$img);

            }
        }else{
            unset($data['product_image']);
        }
        ProductModel::where('id',$id)->update($data);
        return redirect()->back()->with('success', 'Data Updated');
    }

    
    public function destroy($id)
    {
        $status="";
        $del_status=ProductModel::where('id',$id)->pluck('del_status');
        if(!empty($del_status)){
            foreach($del_status as $del){
                if($del =='1'){
                    $status="0";
                }else{
                    $status="1";
                }
                ProductModel::where('id',$id)->update(['del_status' =>$status]);
            }
        }
        return redirect()->back()->with('warning','Category Deleted');
    }

    public function display_product(Request $request){
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
        $query =ProductModel::where('del_status','1');
        if(isset($_GET['product_name'])){
           $name=$_GET['product_name'];
           if($name!=""){
                $query=  $query->where('product_name', 'LIKE', '%'.$name.'%');
            }
        }
        if(isset($_GET['category_id'])){
            $category_id=$_GET['category_id'];
            if($category_id!=""){
                 $query=  $query->where('category_id', 'LIKE', '%'.$category_id.'%');
             }
         }

        $count = $query->count();
        $titles = $query->select('id','product_name','subcategory_id','product_image','category_id','status','price','package_type')
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
                
                $enbdisu =route('enable_disable_product',$title->id);
                $edit_category =route('product.edit',$title->id);
                $delete_category =route('product.destroy',$title->id);
                

                if($title->status == 0){
                    $statuss = '<a class="dropdown-item waves-light waves-effect" href="'.$enbdisu.'">Enable</a>';
                }else{
                     $statuss = '<a class="dropdown-item waves-light waves-effect" href="'.$enbdisu.'">Disable</a>';
                }

                $nestedData['id'] = $count;
                $image=explode(',',$title->product_image);
                $key = array_key_last($image);
                $nestedData['multidelete']='<td><input type="checkbox" class="sub_chk" data-id="'.$title->id.'"></td>';
                $nestedData['product_image'] = isset($title->product_image[$key])?'<img src ='.asset("/public/product_image/".$title->product_image).' height="50px" width="50px">':'Image not available';
                $nestedData['action'] = '<div class="dropdown">
                <button class="btn btn-sm btn-primary btn-active-pink dropdown-toggle dropdown-toggle-icon" data-toggle="dropdown" type="button" aria-expanded="true">
                    Action <i class="dropdown-caret"></i>
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item waves-light waves-effect" href="'.$edit_category.'">Edit</a></li>
                    <li>'.$statuss.'</li>
                    <form action="'.$delete_category.'" method="post" id="form">
                        <input type="hidden" name="_token" value="'.csrf_token().'" />
                        <input type="hidden" name="_method" value="DELETE" />
                    </form>
                    <li>
                        <a class="dropdown-item waves-light waves-effect curson-pointer" onclick="document.getElementById(`form`).submit();">Delete</a>
                    </li>
                </ul>
            </div>';
                $nestedData['product_name'] = $title->product_name;
                $nestedData['category_id'] = $title->category_id;
                $nestedData['subcategory_id'] = $title->subcategory_id;
                $nestedData['price'] = $title->price;
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
        $cat_status=ProductModel::where('id',$id)->pluck('status')->toArray();
        if($cat_status[0] == '1'){
            ProductModel::where('id',$id)->update(['status' =>'0']);
        }else{
            ProductModel::where('id',$id)->update(['status' =>'1']);
        }
        return redirect()->back()->with('success','Status Updated');
    }

    public function multiple_delete_product(Request $request){
        $status="";
        $del_status=ProductModel::whereIn('id',explode(',',$request['ids']))->pluck('del_status');
        if(!empty($del_status)){
            foreach($del_status as $del){
                if($del =='1'){
                    $status="0";
                }else{
                    $status="1";
                }
                ProductModel::whereIn('id',explode(',',$request['ids']))->update(['del_status' =>$status]);
            }
        }
        return response()->json(['success' => ' Data has been deleted!']);
    }
    public function create_pdf_product(Request $request){
        $product=ProductModel::get()->toArray();
        view()->share('employee',$product);
        $pdf = PDF::loadView('product.productpdf', compact('product'))->setOptions(['defaultFont' => 'sans-serif']);
        return $pdf->download('product.pdf');
    }
    public function create_csv_product(){
        return Excel::download(new ProductModel(), 'category.xlsx');
    }

}

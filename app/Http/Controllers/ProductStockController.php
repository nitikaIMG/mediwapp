<?php

namespace App\Http\Controllers;
use App\Models\ProductModel;
use Illuminate\Http\Request;

class ProductStockController extends Controller
{
    
    public function index()
    {
        return view('productstock.index');
    }

    public function create()
    {
        $products=ProductModel::select('id','product_name')->get();
        return view('productstock.add',compact('products'));
    }

    
    public function store(Request $request)
    {
        $data =  $request->except('_token');
        $validated = $request->validate([
            'product_id' => 'required|max:255',
            'product_quantity' => 'required',
        ],[
            'product_id.required' => 'The product name field is required.',
            'product_quantity.required' => 'The product quantity field is required.',
        ]);
        ProductModel::where('id',$data['product_id'])->update(['product_quantity' =>$data['product_quantity']]);
        return redirect()->back()->with('success', 'Data Inserted');
    }

   
    public function show($id)
    {
        //
    }

    
    public function edit($id)
    {
        $edit_data=ProductModel::where('id',$id)->first();
        return view('productstock.edit',compact('edit_data'));
    }

    
    public function update(Request $request, $id)
    {
        $data =  $request->except('_token','_method');
        $validated = $request->validate([
            'product_quantity' => 'required',
        ],[
            'product_quantity.required' => 'The product quantity field is required.',
        ]);
        ProductModel::where('id',$id)->update(['product_quantity' =>$data['product_quantity']]);
        return redirect()->back()->with('success', 'Data Inserted');
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

    public function display_product_quantity(Request $request){
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
            $product_name=$_GET['product_name'];
            if($product_name!=""){
                 $query=  $query->where('product_name', 'LIKE', '%'.$product_name.'%');
             }
         }

        $count = $query->count();
        $titles = $query->select('id','product_name','product_quantity','status')
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
                
                $enbdisu =url('enable_disable_productstock/'.$title->id);
                $edit_category =route('productstock.edit',$title->id);
                $delete_category =route('productstock.destroy',$title->id);
                    if($title->status == 0){
                    $statuss = '<a class="dropdown-item waves-light waves-effect" href="'.$enbdisu.'">Enable</a>';
                }else{
                     $statuss = '<a class="dropdown-item waves-light waves-effect" href="'.$enbdisu.'">Disable</a>';
                }
                $nestedData['id'] = $count;
                
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
                $nestedData['product_quantity'] = $title->product_quantity;
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

    public function enable_disable_productstock($id){
        $cat_status=ProductModel::where('id',$id)->pluck('status')->toArray();
        if($cat_status[0] == '1'){
            ProductModel::where('id',$id)->update(['status' =>'0']);
        }else{
            ProductModel::where('id',$id)->update(['status' =>'1']);
        }
        return redirect()->back()->with('success','Status Updated');
    }
}

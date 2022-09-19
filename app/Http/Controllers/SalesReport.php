<?php

namespace App\Http\Controllers;

use App\Models\OrderModel;
use App\Models\UserModel;
use App\Models\ProductModel;
use Illuminate\Http\Request;

class SalesReport extends Controller
{
    
    public function index()
    {
        $user=UserModel::get();
        $product_name=ProductModel::get();
        return view('salesreport.user',compact('user','product_name'));
    }

   
    public function create()
    {
        return view('salesreport.product');
    }

    public function display_usersalesreport(Request $request){
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
            $user_email=$_GET['user_email'];
            if($user_email!=""){
                 $query=  $query->where('user_email', 'LIKE', '%'.$user_email.'%');
             }
         }
        $count = $query->count();
        $titles = $query->select('id','user_firstname','user_email','status')
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
                
                $edit_subcategory =route('slider.edit',$title->id);
                $delete_brand =route('slider.destroy',$title->id);
                
                $nestedData['id'] = $count;
                $nestedData['action'] = '<div class="dropdown">
                <button class="btn btn-sm btn-primary btn-active-pink dropdown-toggle dropdown-toggle-icon" data-toggle="dropdown" type="button" aria-expanded="true">
                    Action <i class="dropdown-caret"></i>
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item waves-light waves-effect" href="'.$edit_subcategory.'">Edit</a></li>
                    <form action="'.$delete_brand.'" method="post" id="form-'.$title->id.'">
                        <input type="hidden" name="_token" value="'.csrf_token().'" />
                        <input type="hidden" name="_method" value="DELETE" />
                    </form>
                    <li>
                        <a class="dropdown-item waves-light waves-effect curson-pointer" onclick="document.getElementById(`form-'.$title->id.'`).submit();">Delete</a>
                    </li>
                </ul>
            </div>';
                $u_order=OrderModel::where('user_id',$title->id)->count();
                $nestedData['user_name'] = $title->user_firstname;
                $nestedData['user_email'] = $title->user_email;
                $nestedData['cnt'] =(isset($u_order))?$u_order:0;
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
    public function display_productsalesreport(Request $request){
        date_default_timezone_set('Asia/Kolkata');
        $columns = array(
            0 => 'id',
            1 => 'name',
            2 => 'status',
            3 => 'created_at',
            4 => 'updated_at',
        );  
        $arr_data=[];
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        $query = ProductModel::where('del_status','1');
        if(isset($_GET['product_name'])){
           $name=$_GET['product_name'];
           if($name!=""){
                $query=  $query->where('product_name', 'LIKE', '%'.$name.'%');
            }
        }
        $count = $query->count();
        $productdata=OrderModel::pluck('product')->join(',');
        $order_p=explode(',',$productdata);
        $res = array_count_values($order_p);
      
        $titles = $query->select('id','product_name','status')
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
            $order_product=OrderModel::pluck('product');
            
            foreach ($titles as $title) {
                
                
                $enbdisu =route('enable_dispbale_slider',$title->id);
                $edit_subcategory =route('slider.edit',$title->id);
                $delete_brand =route('slider.destroy',$title->id);
                
               
                $nestedData['id'] = $count;
                $nestedData['action'] = '<div class="dropdown">
                <button class="btn btn-sm btn-primary btn-active-pink dropdown-toggle dropdown-toggle-icon" data-toggle="dropdown" type="button" aria-expanded="true">
                    Action <i class="dropdown-caret"></i>
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item waves-light waves-effect" href="'.$edit_subcategory.'">Edit</a></li>
                    <form action="'.$delete_brand.'" method="post" id="form-'.$title->id.'">
                        <input type="hidden" name="_token" value="'.csrf_token().'" />
                        <input type="hidden" name="_method" value="DELETE" />
                    </form>
                    <li>
                        <a class="dropdown-item waves-light waves-effect curson-pointer" onclick="document.getElementById(`form-'.$title->id.'`).submit();">Delete</a>
                    </li>
                </ul>
            </div>';
               
                $nestedData['product_name'] = $title->product_name;
                $nestedData['cnt'] =(isset($res[$title->id]))?$res[$title->id]:0;
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
    
    public function store(Request $request)
    {
        //
    }

    
    public function show($id)
    {
    }

    
    public function edit($id)
    {
        //
    }

    
    public function update(Request $request, $id)
    {
        //
    }

   
    public function destroy($id)
    {
        //
    }
}

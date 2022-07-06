<?php

namespace App\Http\Controllers;

use App\Models\SupportModel;
use Illuminate\Http\Request;

class SupportController extends Controller
{
    
    public function index()
    {
        return view('customersupport.index');        
    }

    
    public function create()
    {
        //
    }

    
    public function store(Request $request)
    {
        //
    }

    
    public function show($id)
    {
        //
    }

    
    public function edit($id)
    {
        $edit_data=SupportModel::where('id',$id)->get();
        return view('customersupport.edit',compact('edit_data'));
    }

   
    public function update(Request $request, $id)
    {
        //
    }

    
    public function destroy($id)
    {
        $status="";
        $del_status=SupportModel::where('id',$id)->pluck('del_status');
        if(!empty($del_status)){
            foreach($del_status as $del){
                if($del =='1'){
                    $status="0";
                }else{
                    $status="1";
                }
                SupportModel::where('id',$id)->update(['del_status' =>$status]);
            }
        }
        return redirect()->back()->with('warning','Category Deleted');
    }

    public function displaysupport(Request $request){
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
        $query =SupportModel::where('customer_support.del_status','1');
        if(isset($_GET['ticket_number'])){
           $ticket_number=$_GET['ticket_number'];
           if($ticket_number!=""){
                $query=  $query->where('ticket_number', 'LIKE', '%'.$ticket_number.'%');
            }
        }
       

        $count = $query->count();
        $titles = $query->join('user','customer_support.user_id','user.id')->select('user.id','ticket_number','user.user_firstname','user_phonenumber','user.status','user.del_status')
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
                $edit_category =route('customersupport.edit',$title->id);
                $delete_category =route('customersupport.destroy',$title->id);
                

                if($title->cat_status == 0){
                    $statuss = '<a class="dropdown-item waves-light waves-effect" href="'.$enbdisu.'">Enable</a>';
                }else{
                     $statuss = '<a class="dropdown-item waves-light waves-effect" href="'.$enbdisu.'">Disable</a>';
                }

                $nestedData['id'] = $count;
                $nestedData['multidelete']='<td><input type="checkbox" class="sub_chk" data-id="'.$title->id.'"></td>';
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
                $nestedData['user_name'] = $title->user_firstname;
                $nestedData['user_phonenumber'] = $title->user_phonenumber;
                $nestedData['ticket_number'] = $title->ticket_number;
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
}

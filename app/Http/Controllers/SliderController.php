<?php

namespace App\Http\Controllers;
use App\Models\SliderModel;
use Illuminate\Http\Request;

class SliderController extends Controller
{
   
    public function index()
    {
       return view('slider.index');
    }

    
    public function create()
    {
       return view('slider.add');
    }

    public function display_sldier(Request $request){
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
        $query = SliderModel::where('del_status','1');
        if(isset($_GET['slider_title'])){
           $name=$_GET['slider_title'];
           if($name!=""){
                $query=  $query->where('slider_title', 'LIKE', '%'.$name.'%');
            }
        }
        $count = $query->count();
        $titles = $query->select('id','slider_title','slider_content','status')
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
                
                $enbdisu =route('enable_dispbale_slider',$title->id);
                $edit_subcategory =route('slider.edit',$title->id);
                $delete_brand =route('slider.destroy',$title->id);
                
                if($title->status == 0){
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
                $nestedData['slider_title'] = $title->slider_title;
                $nestedData['slider_content'] =$title->slider_content;
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
        $data =  $request->except('_token');
        $validated = $request->validate([
            'slider_title' => 'required|max:255',
            'slider_content' => 'required',
        ],[
            'slider_title.required' => 'The Slider Title field is required.',
            'slider_content.required' => 'The slider content name field is required.',
        ]);
        $model = new SliderModel();
        $model->slider_title=$validated['slider_title'];
        $model->slider_content=$validated['slider_content'];
        $model->save();
        return redirect()->back()->with('success', 'Data Inserted');  
    }

    
    public function show($id)
    {
        //
    }

   
    public function edit($id)
    {
        $edit_slider=SliderModel::where('id',$id)->first();
        return view('slider.edit',compact('edit_slider'));
    }

   
    public function update(Request $request, $id)
    {
        $data =  $request->except('_token','_method');
        $validated = $request->validate([
            'slider_title' => 'required|max:255',
            'slider_content' => 'required',
        ],[
            'slider_title.required' => 'The slidet natitleme field is required.',
            'slider_content.required' => 'The sldier content field is required.',
        ]);

    
        SliderModel::where('id',$id)->update($data);
        return redirect()->back()->with('success', 'Data Updated');
    }

    
    public function destroy($id)
    {
        $status="";
        $del_status=SliderModel::where('id',$id)->pluck('del_status');
        if(!empty($del_status)){
            foreach($del_status as $del){
                if($del =='1'){
                    $status="0";
                }else{
                    $status="1";
                }
                SliderModel::where('id',$id)->update(['del_status' =>$status]);
            }
        }
        return redirect()->back()->with('warning','Category Deleted');
    }

    public function multiple_delete_slider(Request $request){
        $status="";
        $del_status=SliderModel::whereIn('id',explode(',',$request['ids']))->pluck('del_status');
        if(!empty($del_status)){
            foreach($del_status as $del){
                if($del =='1'){
                    $status="0";
                }else{
                    $status="1";
                }
                SliderModel::whereIn('id',explode(',',$request['ids']))->update(['del_status' =>$status]);
            }
        }
        return response()->json(['success' => ' Data has been deleted!']);
    }

    public function enable_dispbale_slider($id){
        $cat_status=SliderModel::where('id',$id)->pluck('status')->toArray();
        if($cat_status[0] == '1'){
            SliderModel::where('id',$id)->update(['status' =>'0']);
        }else{
            SliderModel::where('id',$id)->update(['status' =>'1']);
        }
        return redirect()->back()->with('success','Status Updated');
    }
}

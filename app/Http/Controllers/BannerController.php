<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BannerModel;

class BannerController extends Controller
{
    
    public function index()
    {
        $banner_data=BannerModel::where('del_status',1)->get();
        return view('banner.index',compact('banner_data'));
    }

   
    public function create()
    {
        return view('banner.add');
        
    }

   
    public function store(Request $request)
    {
        $data =  $request->except('_token');
        $validated = $request->validate([
            'banner_type' => 'required',
            'banner_url' => 'required',
            'banner.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            
        ],[
            'banner_type.required' => 'The Banner type field is required.',
            'banner_url.required' => 'The category name field is required.',
            'banner.required' => 'Please add banner',
            
        ]);
       $img=[];
        if ($request->hasFile('banner')) {
            $banner_image = $request->file('banner');
            $destination = 'public/banner/';
            $banner_file_name = $banner_image->getClientOriginalName();
            $banner_image->move($destination, $banner_file_name);
            $banner_img = $banner_file_name;
        }
        $data['banner']=$banner_img;
        BannerModel::create($data);
        return redirect()->back()->with('success', 'Data Inserted');   

    }

   
    public function show($id)
    {
        //
    }

   
    public function edit($id)
    {
        $edit_data=BannerModel::where('id',$id)->first();
        return view('banner.edit',compact('edit_data'));
    }

    
    public function update(Request $request, $id)
    {
        $data =  $request->except('_token','_method');
        $validated = $request->validate([
            'banner_type' => 'required',
            'banner_url' => 'required',
            'banner.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            
        ],[
            'banner_type.required' => 'The Banner type field is required.',
            'banner_url.required' => 'The category name field is required.',
            'banner.required' => 'Please add banner',
            
        ]);
      
       $img=[];
       if ($request->hasFile('banner')) {
        $banner_image = $request->file('banner');
        $destination = 'public/banner/';
        $banner_file_name = $banner_image->getClientOriginalName();
        $banner_image->move($destination, $banner_file_name);
        $banner_img = $banner_file_name;
        $data['banner']=$banner_img;

    }   else{
            unset($data['banner']);
        }
        BannerModel::where('id',$id)->update($data);
        return redirect()->back()->with('success', 'Data Updated');
    }

    
    public function destroy($id)
    {
        $del_status=BannerModel::where('id',$id)->pluck('del_status');
        if($del_status[0] == '1'){
            BannerModel::where('id',$id)->update(['del_status' =>'0']);
        }else{
            BannerModel::where('id',$id)->update(['del_status' =>'1']);
        }
        return redirect()->back()->with('success','Status Updated');
    }
}

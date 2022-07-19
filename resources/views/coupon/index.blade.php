@extends('layouts.home')
@section('content')
@php
    $i=1;
@endphp
<div class="col-lg-10 grid-margin stretch-card">
              <div class="card">
                          <div class="col-md-1 pt-1">
                            <a class="btn" href="{{route('banner.create')}}" style="background-color: #f16f23; margin:0%; padding:10px;"><i class="fa fa-plus text-white"></i></a>
                            {{-- <a class="btn multiple_delete" style="background-color: #f16f23; margin:0%; padding:10px;"><i class="fa fa-trash text-white"></i></a> --}}
                          </div>
                <h5 class="card-header">Banner</h5>
                <div class="card-body">
                  <div class="table-responsive">
                    
                    <table class="table table-bordered table-striped table-hover text-nowrap" id="display_cat" width="100%" cellspacing="0">
                      <thead>
                          <tr>
                              <th>Sno.</th>
                              <th>Banner</th>
                              <th>Banner Url</th>
                              <th>Action</th>
                          </tr>
                      </thead>
                      
                      @if(!empty($banner_data))
                        @foreach ($banner_data as $item)
                          <tr>
                            <td>{{$i++}}</td>
                            <td><img src="{{asset('public/banner/'.$item['banner'])}}" height="50px" width="50px"></td>
                            <td>{{$item['banner_url']}}</td>
                            <td><div class="dropdown">
                              <button class="btn btn-sm btn-primary btn-active-pink dropdown-toggle dropdown-toggle-icon" data-toggle="dropdown" type="button" aria-expanded="true">
                                  Action <i class="dropdown-caret"></i>
                              </button>
                              <ul class="dropdown-menu">
                                  <li><a class="dropdown-item waves-light waves-effect" href="{{route('banner.edit',$item->id)}}">Edit</a></li>
                                  <form action="{{route('banner.destroy',$item->id)}}" method="post" id="form-'{{$item->id}}'">
                                    @csrf
                                    @method('DELETE')
                                  </form>
                                  <li>
                                      <a class="dropdown-item waves-light waves-effect curson-pointer" onclick="document.getElementById(`form-'{{$item->id}}'`).submit();">Delete</a>
                                  </li>
                              </ul>
                          </div></td>
                          </tr>
                        
                        @endforeach
                        @else
                          <h1>No data</h1>
                        @endif
                      <tbody>
                      </tbody>
                  </table>
                  </div>
                </div>
              </div>
            </div>
@endsection


<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
      <li class="nav-item">
        <a class="nav-link" href="{{url('/home')}}">
          <i class="typcn typcn-device-desktop menu-icon"></i>
          <span class="menu-title">Dashboard</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui- ">
          <i class="typcn typcn-document-text menu-icon"></i>
          <span class="menu-title">Category</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="ui-basic">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item"> <a class="nav-link" href="{{route('category.index')}}">All Category</a></li>
          </ul>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#subcategory_id" aria-expanded="false" aria-controls="ui- ">
          <i class="typcn typcn-document-text menu-icon"></i>
          <span class="menu-title">Subcategory</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="subcategory_id">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item"> <a class="nav-link" href="{{route('subcategory.index')}}">All Subcategory</a></li>
          </ul>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#form-elements" aria-expanded="false" aria-controls="form-elements">
          <i class="typcn typcn-film menu-icon"></i>
          <span class="menu-title">Brands</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="form-elements">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item"><a class="nav-link" href="{{route('brand.index')}}">All Brands</a></li>
          </ul>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#charts" aria-expanded="false" aria-controls="charts">
          <i class="typcn typcn-chart-pie-outline menu-icon"></i>
          <span class="menu-title">Products</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="charts">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item"> <a class="nav-link" href="{{route('product.index')}}">View Products</a></li>
          </ul>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#tables" aria-expanded="false" aria-controls="tables">
          <i class="typcn typcn-th-small-outline menu-icon"></i>
          <span class="menu-title">Coupons</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="tables">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item"> <a class="nav-link" href="{{asset('public/pages/tables/basic-table.html')}}">Create Coupons</a></li>
          </ul>
          <ul class="nav flex-column sub-menu">
              <li class="nav-item"> <a class="nav-link" href="{{asset('public/pages/tables/basic-table.html')}}">All Coupons</a></li>
            </ul>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#icons" aria-expanded="false" aria-controls="icons">
          <i class="typcn typcn-compass menu-icon"></i>
          <span class="menu-title">Orders</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="icons">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item"> <a class="nav-link" href="{{route('order.index')}}">All Orders</a></li>
          </ul>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#auth" aria-expanded="false" aria-controls="auth">
          <i class="typcn typcn-user-add-outline menu-icon"></i>
          <span class="menu-title">Sales Report</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="auth">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item"> <a class="nav-link" href="{{asset('public/pages/samples/login.html')}}">User Base </a></li>
            <li class="nav-item"> <a class="nav-link" href="{{asset('public/pages/samples/register.html')}}"> Product Base  </a></li>
          </ul>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#error" aria-expanded="false" aria-controls="error">
          <i class="typcn typcn-globe-outline menu-icon"></i>
          <span class="menu-title">Product Stock</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="error">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item"> <a class="nav-link" href="{{asset('public/pages/samples/error-404.html')}}"> Add Quantity </a></li>
            <li class="nav-item"> <a class="nav-link" href="{{asset('public/pages/samples/error-500.html')}}"> All Products Quantity </a></li>
          </ul>
        </div>
      </li>
      <li class="nav-item">
          <a class="nav-link" data-toggle="collapse" href="#slider" aria-expanded="false" aria-controls="slider">
            <i class="typcn typcn-globe-outline menu-icon"></i>
            <span class="menu-title">Slider</span>
            <i class="menu-arrow"></i>
          </a>
          <div class="collapse" id="slider">
            <ul class="nav flex-column sub-menu">
              <li class="nav-item"> <a class="nav-link" href="{{route('slider.index')}}">All Sliders </a></li>
              
            </ul>
          </div>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-toggle="collapse" href="#users" aria-expanded="false" aria-controls="user">
            <i class="typcn typcn-globe-outline menu-icon"></i>
            <span class="menu-title">Users</span>
            <i class="menu-arrow"></i>
          </a>
          <div class="collapse" id="users">
            <ul class="nav flex-column sub-menu">
              <li class="nav-item"> <a class="nav-link" href="{{url('user')}}">View Users </a></li>
              
            </ul>
          </div>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-toggle="collapse" href="#support" aria-expanded="false" aria-controls="support">
            <i class="typcn typcn-globe-outline menu-icon"></i>
            <span class="menu-title">Support Tickets</span>
            <i class="menu-arrow"></i>
          </a>
          <div class="collapse" id="support">
            <ul class="nav flex-column sub-menu">
              <li class="nav-item"> <a class="nav-link" href="{{asset('public/pages/samples/error-404.html')}}">All Sliders </a></li>
              
            </ul>
          </div>
        </li>
    </ul>
    
  </nav>

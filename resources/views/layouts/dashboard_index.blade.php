@extends('layouts.home')
@section('content')
<div class="main-panel">
    <div class="content-wrapper">

     

      <div class="row">
        <div class="col-md-4 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <div class="d-flex align-items-center justify-content-between justify-content-md-center justify-content-xl-between flex-wrap mb-4">
                <div>
                  <p class="mb-2 text-md-center text-lg-left">Total Products</p>
                  <h1 class="mb-0">87</h1>
                </div>
                <i class="typcn typcn-briefcase icon-xl text-secondary"></i>
              </div>
              <canvas id="expense-chart" height="80"></canvas>
            </div>
          </div>
        </div>
        <div class="col-md-4 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <div class="d-flex align-items-center justify-content-between justify-content-md-center justify-content-xl-between flex-wrap mb-4">
                <div>
                  <p class="mb-2 text-md-center text-lg-left">Total Dispatched Orders</p>
                  <h1 class="mb-0">40</h1>
                </div>
                <i class="typcn typcn-chart-pie icon-xl text-secondary"></i>
              </div>
              <canvas id="budget-chart" height="80"></canvas>
            </div>
          </div>
        </div>
        <div class="col-md-4 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <div class="d-flex align-items-center justify-content-between justify-content-md-center justify-content-xl-between flex-wrap mb-4">
                <div>
                  <p class="mb-2 text-md-center text-lg-left">Total Active User</p>
                  <h1 class="mb-0">100</h1>
                </div>
                <i class="typcn typcn-clipboard icon-xl text-secondary"></i>
              </div>
              <canvas id="balance-chart" height="80"></canvas>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-4 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <div class="d-flex align-items-center justify-content-between justify-content-md-center justify-content-xl-between flex-wrap mb-4">
                <div>
                  <p class="mb-2 text-md-center text-lg-left">Total Users</p>
                  <h1 class="mb-0">20</h1>
                </div>
                <i class="typcn typcn-briefcase icon-xl text-secondary"></i>
              </div>
              <canvas id="expense-chart" height="80"></canvas>
            </div>
          </div>
        </div>
        <div class="col-md-4 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <div class="d-flex align-items-center justify-content-between justify-content-md-center justify-content-xl-between flex-wrap mb-4">
                <div>
                  <p class="mb-2 text-md-center text-lg-left">Completed order</p>
                  <h1 class="mb-0">0</h1>
                </div>
                <i class="typcn typcn-briefcase icon-xl text-secondary"></i>
              </div>
              <canvas id="expense-chart" height="80"></canvas>
            </div>
          </div>
        </div>
        <div class="col-md-4 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <div class="d-flex align-items-center justify-content-between justify-content-md-center justify-content-xl-between flex-wrap mb-4">
                <div>
                  <p class="mb-2 text-md-center text-lg-left">Total Orders</p>
                  <h1 class="mb-0">47</h1>
                </div>
                <i class="typcn typcn-chart-pie icon-xl text-secondary"></i>
              </div>
              <canvas id="budget-chart" height="80"></canvas>
            </div>
          </div>
        </div>
        <div class="col-md-4 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <div class="d-flex align-items-center justify-content-between justify-content-md-center justify-content-xl-between flex-wrap mb-4">
                <div>
                  <p class="mb-2 text-md-center text-lg-left">Total Pending Orders</p>
                  <h1 class="mb-0">7</h1>
                </div>
                <i class="typcn typcn-clipboard icon-xl text-secondary"></i>
              </div>
              <canvas id="balance-chart" height="80"></canvas>
            </div>
          </div>
        </div>
      </div>

    

    </div>
    <!-- content-wrapper ends -->
    <!-- partial:partials/_footer.html -->
    {{-- @include('layouts.footer') --}}
    <!-- partial -->
  </div>
@endsection
@extends('layouts.app',['title'=>'Dashboard'])

@section('content')
<section class="section">
    <div class="section-header">
      <h1>Dashboard</h1>
    </div>

    @if (auth()->user()->role[0]->pivot['role_id']==1)
      <div class="row">
        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
          <div class="card card-statistic-1">
            <div class="card-icon bg-primary">
              <i class="far fa-user"></i>
            </div>
            <div class="card-wrap">
              <div class="card-header">
                <h4>Total User</h4>
              </div>
              <div class="card-body">
                {{$user}}
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
          <div class="card card-statistic-1">
            <div class="card-icon bg-danger">
              <i class="far fa-newspaper"></i>
            </div>
            <div class="card-wrap">
              <div class="card-header">
                <h4>Attendance</h4>
              </div>
              <div class="card-body">
                {{$attendance}}
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
          <div class="card card-statistic-1">
            <div class="card-icon bg-warning">
              <i class="far fa-file"></i>
            </div>
            <div class="card-wrap">
              <div class="card-header">
                <h4>Position</h4>
              </div>
              <div class="card-body">
                {{$position}}
              </div>
            </div>
          </div>
        </div>
      </div>
    @else
      <div class="section-body">
        <div class="card">
          <div class="card-header">
            <h5 class="card-title mb-0">Welcome {{auth()->user()->name}}</h5>
          </div>
          <div class="card-body">
            <p class="card-text">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Itaque cum voluptas error reiciendis perspiciatis adipisci recusandae aliquam vel laudantium, praesentium repudiandae animi mollitia officia amet aperiam! Doloremque id expedita nobis?</p>
            <a href="#" class="btn btn-primary">Go somewhere</a>
          </div>
        </div>
      </div>
    @endif
  </section>
@endsection
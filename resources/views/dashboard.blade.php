@extends('layouts.app',['title'=>'Dashboard'])

@section('content')
<section class="section">
    <div class="section-header">
      <h1>Dashboard</h1>
    </div>

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
  </section>
@endsection
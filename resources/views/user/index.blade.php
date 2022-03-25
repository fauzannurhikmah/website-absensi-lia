@extends('layouts.app',['title'=>'User'])

@section('style')
    <link rel="stylesheet" href="{{asset('assets/iziToast/dist/css/iziToast.min.css')}}">
    <link rel="stylesheet" href="https://getstisla.com/dist/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
@endsection

@section('content')
<!-- Toastification -->
@if (session()->has('errors')||session()->has('success'))
    <span id="toast" data-status=true data-type="{{session()->has('errors') ? 'error' :'success'}}" data-message="{{session('success')}}"></span>
@endif

<section class="section">
    <div class="section-header">
      <h1>User</h1>
    </div>
</section>
<div class="section-body">
  <div class="card">
    <div class="card-header">
        <h4>User List
          @if (request('search'))
            <small class="d-block text-dark">Search <strong>{{request('search')}}</strong></small>
          @endif
        </h4>

      <div class="card-header-form">
        <form method="GET" action="{{route('user')}}">
          <div class="input-group">
            <input type="text" class="form-control" name="search" placeholder="Search">
            <div class="input-group-btn">
              <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
            </div>
          </div>
        </form>
      </div>

      <a href="{{route('create-user')}}" class="btn btn-primary ml-1" ><i class="fas fa-plus"></i></a>
    </div>
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-striped" id="data-table">
          <thead>
            <tr>
            <th>No</th>
            <th>Name</th>
            <th>Position</th>
            <th>Email</th>
            <th>Action</th>
          </tr>
          </thead>
          <tbody>
          @forelse ($user as $index=>$data)
            <tr>
              <td>{{++$index}}</td>
              <td>
                <span class="font-weight-bold">{{$data->name}} </span>
                @foreach ($data->role as $item)
                @if ($item->pivot['role_id']==1)
                  <span class="badge rounded badge-primary p-1 roles">Admin</span>
                @endif
                @endforeach
                <p class="small text-primary my-0">{{$data->nik}}</p>
              </td>
              <td>{!!$data->position->position ?? "---"!!}
                <p class="small text-primary my-0">Department : {{$data->position->department ?? '---'}}</p>
              </td>
              <td>{{$data->email}}</td>
              <td>
                <a href="{{route('edit-user',$data->id)}}" class="btn btn-sm mr-1 btn-outline-info border-0 shadow-sm">Edit</a>
                <button data-toggle="modal" data-target="#deleteModal{{$data->id}}" class="btn btn-sm btn-outline-danger border-0 shadow-sm">Delete</button>
                <x-delete-modal id="{{$data->id}}" link="{{route('delete-user',$data->id)}}" data="{{$data->name}}"></x-delete-modal>  
              </td>
            </tr>
          @empty
              <tr>
                <td colspan="4"><p class="text-center lead">Empty <i class="fas fa-exclamation-triangle"></i></p></td>
              </tr>
          @endforelse
        </tbody></table>
      </div>

      <div class="d-flex text-right justify-content-end mt-2">
        {!! $user->links() !!}
      </div>
    </div>
  </div>
</div>
@endsection

@push('script')
  <script src="/assets/iziToast/dist/js/iziToast.min.js"></script>
  <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
  <script src="/assets/js/custom.js"></script>
@endpush
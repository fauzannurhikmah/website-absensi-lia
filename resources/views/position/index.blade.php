@extends('layouts.app',['title'=>'Department'])

@section('style')
    <link rel="stylesheet" href="{{asset('assets/iziToast/dist/css/iziToast.min.css')}}">
    <link rel="stylesheet" href="https://getstisla.com/dist/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
@endsection

@section('content')
<!-- Toastification -->
@if (session()->has('errors')||session()->has('success'))
    <span id="toast" data-status=true data-type="{{session()->has('errors') ? 'error' :'success'}}" data-message="{{session('success') ?? "Something went wrong!"}}"></span>
@endif

<section class="section">
    <div class="section-header">
      <h1>Departments</h1>
    </div>
</section>
<div class="section-body">
  <div class="card">
    <div class="card-header">
      <h4>Department List
        @if (request('search'))
            <small class="d-block text-dark">Search <strong>{{request('search')}}</strong></small>
          @endif
      </h4>
      <div class="card-header-form">
        <form>
          <div class="input-group">
            <input type="text" class="form-control" placeholder="Search" name="search">
            <div class="input-group-btn">
              <button class="btn btn-primary"><i class="fas fa-search"></i></button>
            </div>
          </div>
        </form>
      </div>

      <button class="btn btn-primary ml-1" data-toggle="modal" data-target="#createModal"><i class="fas fa-plus"></i></button>
    </div>
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-striped" id="data-table">
          <thead>
            <tr>
              <th>No</th>
              <th>Department</th>
              <th>Position</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
          @forelse ($position as $index=>$data)
            <tr>
              <td>{{++$index}}</td>
              <td>{{$data->department}}</td>
              <td>{{$data->position}}</td>
              <td>
                <button data-toggle="modal" data-target="#editModal{{$data->id}}" class="btn btn-sm mr-1 btn-outline-info border-0 shadow-sm">Edit</button>
                <button data-toggle="modal" data-target="#deleteModal{{$data->id}}" class="btn btn-sm btn-outline-danger border-0 shadow-sm">Delete</button>
                <x-delete-modal id="{{$data->id}}" link="{{route('delete-position',$data->id)}}" data="{{$data->name}}"></x-delete-modal>  
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
        {!! $position->links() !!}
      </div>
    </div>
  </div>
</div>

<!-- Edit Modal -->
@foreach ($position as $data)
<div class="modal fade" id="editModal{{$data->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Position</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{route('edit-position',$data->id)}}" method="post">
        @method('PUT')
        @csrf
        <div class="modal-body">
          <div class="form-group">
            <label for="position">Position</label>
            <input type="text" name="position" id="position" class="form-control" value="{{old('position')??$data->position}}">
            @error('position')
                <small class="text-danger">{{$message}}</small>
            @enderror
          </div>
          <div class="form-group">
            <label for="department">Department</label>
            <input type="text" name="department" id="department" class="form-control" value="{{old('department')??$data->department}}">
            @error('department')
                <small class="text-danger">{{$message}}</small>
            @enderror
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Update</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endforeach

<!-- Create Modal -->
<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Department</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{route('create-position')}}" method="post">
        @csrf
        <div class="modal-body">
          <div class="form-group">
            <label for="position">Position</label>
            <input type="text" name="position" id="position" class="form-control">
            @error('position')
                <small class="text-danger">{{$message}}</small>
            @enderror
          </div>
          <div class="form-group">
            <label for="department">Department</label>
            <input type="text" name="department" id="department" class="form-control">
            @error('department')
                <small class="text-danger">{{$message}}</small>
            @enderror
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save</button>
        </div>
      </form>
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
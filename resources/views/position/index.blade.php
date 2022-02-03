@extends('layouts.app',['title'=>'Position'])

@section('style')
    <link rel="stylesheet" href="{{asset('assets/iziToast/dist/css/iziToast.min.css')}}">
@endsection

@section('content')
<!-- Toastification -->
@if (session()->has('errors')||session()->has('success'))
    <span id="toast" data-status=true data-type="{{session()->has('errors') ? 'error' :'success'}}" data-message="{{session('success')}}"></span>
@endif

<section class="section">
    <div class="section-header">
      <h1>Positions</h1>
    </div>
</section>
<div class="section-body">
  <div class="card">
    <div class="card-header">
      <h4>Position List
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
        <table class="table table-striped">
          <tbody>
            <tr>
            <th>No</th>
            <th>Name</th>
            <th>Action</th>
          </tr>
          @forelse ($position as $index=>$data)
            <tr>
              <td>{{++$index}}</td>
              <td>{{$data->name}}</td>
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
            <label for="name">Name</label>
            <input type="text" name="name" id="name" class="form-control" value="{{old('name') ?? $data->name}}">
            @error('name')
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
        <h5 class="modal-title" id="exampleModalLabel">Add Position</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{route('create-position')}}" method="post">
        @csrf
        <div class="modal-body">
          <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" class="form-control">
            @error('name')
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
  <script src="/assets/js/custom.js"></script>
@endpush
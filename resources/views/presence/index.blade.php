@extends('layouts.app',['title'=>'Attendance'])

@section('style')
    <link rel="stylesheet" href="{{asset('assets/iziToast/dist/css/iziToast.min.css')}}">
    <style>
      .presence{
        display: inline-block;
        width: 10px;
        height: 10px;
        background-color: #6777ef !important;
        border-radius: 50%;
      }

      .absent{
        display: inline-block;
        width: 10px;
        height: 10px;
        background-color: #f54545 !important;
        border-radius: 50%;
      }
    </style>
@endsection

@section('content')
<!-- Toastification -->
@if (session()->has('errors')||session()->has('success'))
    <span id="toast" data-status=true data-type="{{session()->has('errors') ? 'error' :'success'}}" data-message="{{session('success') }}"></span>
@endif

@if (session()->has('failed'))
  <span id="toast" data-status=true data-type="error" data-message="{{session('failed')}}"></span>
@endif

<section class="section">
    <div class="section-header">
      <h1>Attendances</h1>
    </div>
</section>
<div class="section-body">
  <div class="card">
    <div class="card-header">
        <h4>Attendance List
          @if (request('search'))
            <small class="d-block text-dark"><strong>{{request('search')}}</strong></small>
          @else
            <small class="d-block text-dark"><i class="far fa-calendar mr-2"></i><strong>{{date('F')}}</strong></small>
          @endif
        </h4>

      <div class="card-header-form">
        <form method="GET" action="{{route('attendance')}}">
          <div class="input-group">
            <input type="date" class="form-control" name="search" placeholder="Search">
            <div class="input-group-btn">
              <button class="btn btn-primary" type="submit"><i class="fas fa-filter"></i></button>
            </div>
          </div>
        </form>
      </div>

      <button class="btn btn-primary ml-1" data-toggle="modal" data-target="#exportFile" ><i class="fas fa-file-download"></i></button>
      @can('view', auth()->user())
        <button class="btn btn-primary ml-1" data-toggle="modal" data-target="#createModal"><i class="fas fa-plus"></i></button>
      @endcan
      <button class="btn btn-primary ml-1" data-toggle="modal" data-target="#addAttendance"><i class="fas fa-plus"></i></button>
    </div>
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-striped">
          <tbody>
            <tr>
            <th>No</th>
            <th>Name</th>
            <th>Position</th>
            @for ($i = 1; $i <= Carbon\Carbon::now()->daysInMonth; $i++)
              <th>{{$i}}</th>
            @endfor
            <th>Total</th>
            <th>Action</th>
          </tr>
          @forelse ($attendance as $index=>$data)
            <tr>
              <td>{{++$index}}</td>
              <td>
                <strong class="d-block">{{$data->employee->name}}</strong>
                <small class="text-primary">{{$data->employee->nik}}</small>
              </td>
              <td>{{$data->position->name}}</td>
              @for ($i = 1; $i <= Carbon\Carbon::now()->daysInMonth; $i++)
                @foreach ($data->attendance as $item)
                  @if ($i < $item->date->format('d'))
                    <td><span class="absent"></span></td>
                  @endif
                  @if ($i==$item->date->format('d') && $item->status)
                    <td><span class="presence"></span></td>
                  @endif
                  @if ($i>$item->date->format('d'))
                    <td>-</td>
                  @endif
                @endforeach
              @endfor
              <td>
                3
              </td>
              <td>
                <button data-toggle="modal" data-target="#editModal{{$data->id}}" class="btn btn-sm mr-1 btn-outline-info border-0 shadow-sm"><i class="fas fa-edit"></i></button>
                <button data-toggle="modal" data-target="#deleteModal{{$data->id}}" class="btn btn-sm btn-outline-danger border-0 shadow-sm"><i class="fas fa-trash"></i></button>
                <x-delete-modal id="{{$data->id}}" link="{{route('delete-attendance',$data->id)}}" data="{{$data->name}}"></x-delete-modal>  
              </td>
            </tr>
          @empty
              <tr>
                <td colspan="{{Carbon\Carbon::now()->daysInMonth}}"><p class="text-center lead">Empty <i class="fas fa-exclamation-triangle"></i></p></td>
              </tr>
          @endforelse
        </tbody></table>
      </div>

      {{-- <div class="d-flex text-right justify-content-end mt-2">
        {!! $attendance->links() !!}
      </div> --}}
    </div>
  </div>
</div>

<!-- Edit Modal -->
@foreach ($attendance as $data)
<div class="modal fade" id="editModal{{$data->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Attendance</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{route('edit-attendance',$data->id)}}" method="post">
        @method('PUT')
        @csrf
        <div class="modal-body">
          <div class="form-group">
            <label for="nik">NIK</label>
            <input type="text" name="nik" id="nik" class="form-control" value="{{old('nik') ?? $data->nik}}">
            @error('nik')
                <small class="text-danger">{{$message}}</small>
            @enderror
          </div>
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
@can('view', auth()->user())
<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Attendance</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{route('create-attendance')}}" method="post">
        @csrf
        <div class="modal-body">
          <div class="form-group">
            <label for="name">Name</label>
            <select name="name" id="name" class="custom-select">
                <option selected disabled>Select Name</option>
                @foreach ($employee as $item)
                    <option value="{{$item->id}}">{{$item->name}}</option>
                @endforeach
            </select>
            @error('name')
                <small class="text-danger">{{$message}}</small>
            @enderror
          </div>
          <div class="form-group">
            <label for="position">Position</label>
            <select name="position" id="position" class="custom-select">
                <option selected disabled>Select Position</option>
                @foreach ($position as $item)
                    <option value="{{$item->id}}">{{$item->name}}</option>
                @endforeach
            </select>
            @error('position')
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
@endcan

@include('attendance-status.add')
@include('export.index')
@endsection

@push('script')
  <script src="/assets/iziToast/dist/js/iziToast.min.js"></script>
  <script src="/assets/js/custom.js"></script>
@endpush
@extends('layouts.app',['title'=>'Attendance'])

@section('style')
    <link rel="stylesheet" href="{{asset('assets/iziToast/dist/css/iziToast.min.css')}}">
    <link rel="stylesheet" href="https://getstisla.com/dist/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
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
      .daterange{
        width: 200px !important;
      }
      .select2-container{
        width: 100% !important;
      }
      .select2-container--default .select2-selection--single .select2-selection__rendered{
        line-height: 3 !important;
      }
    </style>
    {{-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> --}}
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
          @if (request('filter'))
            <small class="d-block text-dark"><i class="far fa-calendar mr-2"></i><strong>{{date('d F, Y',strtotime(request('filter')))}}</strong></small>
          @else
            <small class="d-block text-dark"><i class="far fa-calendar mr-2"></i><strong>{{date('d F, Y')}}</strong></small>
          @endif
        </h4>

      <div class="card-header-form">
        <form method="GET" action="{{route('attendance')}}">
          <div class="input-group">
            <input type="date" class="form-control" name="filter" placeholder="Search">
            <div class="input-group-btn">
              <button class="btn btn-primary" type="submit"><i class="fas fa-filter"></i></button>
            </div>
          </div>
        </form>
      </div>

      @can('view', auth()->user())
      <button class="btn btn-primary ml-1" data-toggle="modal" data-target="#exportFile" ><i class="fas fa-file-download"></i></button>
      @endcan
      <button class="btn btn-primary ml-1" data-toggle="modal" data-target="#addAttendance"><i class="fas fa-plus"></i></button>
    </div>
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-striped" id="data-table">
          @if (auth()->user()->role[0]->pivot['role_id']==1)
          <thead>
            <tr>
              <th>No</th>
              <th>Name</th>
              <th>Position</th>
              <th>Date</th>
              <th>Time Check In</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($attendance as $index=>$data)
              <tr>
                <td>{{++$index}}</td>
                <td>
                  <strong class="d-block">{{$data->user->name}}</strong>
                  <small class="text-primary">{{$data->user->nik}}</small>
                </td>
                <td>{!!$data->user->position->position ?? "---"!!}
                  <p class="small text-primary my-0">Department : {{$data->user->position->department ?? '---'}}</p>
                </td>
                <td>{{date('d F Y',strtotime($data->date))}}</td>
                <td>{{$data->timeIn}}</td>
                <td>
                  <button data-toggle="modal" data-target="#deleteModal{{$data->id}}" class="btn btn-sm btn-outline-danger border-0 shadow-sm"><i class="fas fa-trash"></i> Delete</button>
                  <x-delete-modal id="{{$data->id}}" link="{{route('delete-attendance',$data->id)}}" data="{{$data->name}}"></x-delete-modal>  
                </td>
              </tr>
            @empty
                <tr>
                  <td colspan="{{Carbon\Carbon::now()->daysInMonth}}"><p class="text-center lead">Empty <i class="fas fa-exclamation-triangle"></i></p></td>
                </tr>
            @endforelse
            
          @else
            <tr>
              <th>No</th>
              <th>Name</th>
              <th>Date</th>
              <th>Time Check In</th>
            </tr>
            @forelse ($attendance as $index=>$item)
              <tr>
                <td>{{++$index}}</td>
                <td>
                  <strong class="d-block">{{$item->user->name}}</strong>
                  <small class="text-primary">{{$item->user->nik}}</small>
                </td>
                @if (date('d F Y',strtotime($item->date))==date('d F Y'))
                  <td> {{date('d F Y',strtotime($item->date))}} <span class="ml-1 presence"></span></td>
                @else
                  <td> {{date('d F Y',strtotime($item->date))}}</td>
                @endif
                <td> {{$item->timeIn}} </td>
              </tr>
            @empty
              <tr>
                <td colspan="5"><p class="lead text-center">Empty <i class="fas fa-exclamation-triangle"></i></p></td>
              </tr>
            @endforelse
          @endif
        </tbody>
      </table>
      </div>

      @if ($attendance->count()>9)
      <div class="d-flex text-right justify-content-end mt-2">
        {!! $attendance->links() !!}
      </div>
      @endif
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

@include('attendance-status.add')
@include('export.index')
@endsection

@push('script')
  <script src="/assets/iziToast/dist/js/iziToast.min.js"></script>
  <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
  {{-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> --}}
  <script src="/assets/js/custom.js"></script>
@endpush
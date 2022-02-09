@extends('layouts.app',['title'=>'Create User'])

@section('style')
    <link rel="stylesheet" href="{{asset('assets/iziToast/dist/css/iziToast.min.css')}}">
@endsection

@section('content')
<!-- Toastification -->
@if (session()->has('errors')||session()->has('success'))
    <span id="toast" data-status=true data-type="{{session()->has('errors') ? 'error' :'success'}}" data-message="{{session('success') ?? "Something went wrong!"}}"></span>
@endif

<section class="section">
    <div class="section-header">
      <h1>User</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{route('user')}}">User</a></div>
        <div class="breadcrumb-item">Create User</div>
      </div>
    </div>
</section>
<div class="section-body">
  <div class="card">
    <div class="card-header">
        <h4>Create User
          @if (request('search'))
            <small class="d-block text-dark">Search <strong>{{request('search')}}</strong></small>
          @endif
        </h4>

      <a href="{{route('user')}}" class="ml-auto btn btn-primary"><i class="fas fa-backward"></i> Back</a>
    </div>
    <div class="card-body p-0">
        <form action="{{route('create-user')}}" method="post">
            @csrf
            <div class="modal-body">
              <div class="form-group row">
                <label for="nik" class="col-form-label col-md-2">NIK</label>
                <div class="col">
                    <input type="text" name="nik" id="nik" class="form-control" value="{{old('nik')}}">
                    @error('nik')
                        <small class="text-danger">{{$message}}</small>
                    @enderror
                </div>
              </div>
              <div class="form-group row">
                <label for="name" class="col-form-label col-md-2">Name</label>
                <div class="col">
                    <input type="text" name="name" id="name" class="form-control" value="{{old('name')}}">
                    @error('name')
                        <small class="text-danger">{{$message}}</small>
                    @enderror
                </div>
              </div>
              <div class="form-group row">
                <label for="email" class="col-form-label col-md-2">Email</label>
                <div class="col">
                    <input type="text" name="email" id="email" class="form-control" value="{{old('email')}}">
                    @error('email')
                        <small class="text-danger">{{$message}}</small>
                    @enderror
                </div>
              </div>
              <div class="form-group row">
                <label for="position" class="col-form-label col-md-2">Position</label>
                <div class="col">
                    <select name="position" id="position" class="custom-select">
                        <option selected disabled>Select Position</option>
                        @foreach ($position as $item)
                            <option value="{{$item->id}}" {{old('position')==$item->id?'selected':''}}>{{$item->position}}</option>
                        @endforeach
                    </select>
                    @error('position')
                        <small class="text-danger">{{$message}}</small>
                    @enderror
                </div>
              </div>
              <div class="form-group row">
                    <label for="password" class="col-form-label col-md-2">{{ __('Password') }}</label>
                    <div class="col">
                        <input id="password" type="password" class="form-control" name="password">
                        @error('password')
                            <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                </div>
                
                <div class="form-group row">
                    <label for="password-confirm" class="col-form-label col-md-2">{{ __('Confirm Password') }}</label>
                    <div class="col">
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation">
                    </div>
                </div>
                <div class="form-group row">
                  <label for="role" class="col-form-label col-md-2">Role</label>
                  <div class="col">
                    <div class="selectgroup selectgroup-pills">
                      <label class="selectgroup-item ">
                        <input type="radio" name="role" value="1" class="selectgroup-input">
                        <span class="selectgroup-button selectgroup-button-icon px-3"><i class="fas fa-user-cog mr-1"></i>Admin</span>
                      </label>
                      <label class="selectgroup-item">
                        <input type="radio" name="role" value="2" class="selectgroup-input" checked>
                        <span class="selectgroup-button selectgroup-button-icon px-3"><i class="fas fa-user mr-1"></i>User</span>
                      </label>
                    </div>
                  </div>
                </div>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-lg btn-primary">Save</button>
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
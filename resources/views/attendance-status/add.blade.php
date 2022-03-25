  <!-- Create Modal -->
<div class="modal fade" id="addAttendance" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content" id="attendance-status">
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
              <select name="name" id="name" class="custom-select d-block w-100 select2">
                  @if (auth()->user()->role[0]->pivot['role_id']==1)
                    <option selected disabled>Select Name</option>
                    @foreach ($user as $item)
                        <option value="{{$item->id}}" {{$item->id==auth()->id() ? 'selected' :''}}>{{$item->name}}</option>
                    @endforeach
                  @else
                      <option value="{{auth()->id()}}" selected>{{auth()->user()->name}}</option>
                  @endif
              </select>
              @error('name')
                  <small class="text-danger">{{$message}}</small>
              @enderror
            </div>
            <div class="form-group">
                <label for="date">Date</label>
                <input type="date" name="date" id="date" class="form-control" value="{{date('Y-m-d')}}" {{auth()->user()->role[0]->pivot['role_id']==1?'':'readonly'}}>
                @error('date')
                    <small class="text-danger">{{$message}}</small>
                @enderror
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Presence</button>
          </div>
        </form>
      </div>
    </div>
  </div>
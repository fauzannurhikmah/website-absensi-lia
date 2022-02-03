  <!-- Create Modal -->
  <div class="modal fade" id="exportFile" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Export File</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="" method="post">
          @csrf
          <div class="modal-body">
            <div class="form-group">
              <label for="month">Month</label>
              <select name="month" id="month" class="custom-select">
                  <option selected disabled>Select Month</option>
                  @for ($i = 1; $i <= 12; $i++)
                    <option value="{{$i}}">{{date('F', mktime(0, 0, 0, $i))}}</option>
                  @endfor
              </select>
              @error('month')
                  <small class="text-danger">{{$message}}</small>
              @enderror
            </div>
            <div class="form-group">
              <label for="year">Year</label>
              <select name="year" id="year" class="custom-select">
                  <option selected disabled>Select Year</option>
              </select>
              @error('year')
                  <small class="text-danger">{{$message}}</small>
              @enderror
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Export</button>
          </div>
        </form>
      </div>
    </div>
  </div>
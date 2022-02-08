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
        <form action="{{route('export-file')}}" method="post">
          @csrf
          <div class="modal-body">
            <div class="form-group">
              <label for="Date">Date</label>
              <input type="date" class="form-control" name="date">
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
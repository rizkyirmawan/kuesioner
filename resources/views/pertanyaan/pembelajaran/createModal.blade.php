<div class="modal fade" id="createModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tambah Pertanyaan</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('question.pembelajaran.store') }}" method="post">

          @csrf

          <div class="form-group">
            <label for="pertanyaan" class="text-dark">Pertanyaan:</label>
            <input type="text" name="pertanyaan" class="form-control" required>
          </div>

      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>

          <button type="submit" class="btn btn-primary">Tambah</button>

        </form>
      </div>
    </div>
  </div>
</div>
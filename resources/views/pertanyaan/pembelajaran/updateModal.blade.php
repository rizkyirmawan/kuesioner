<div class="modal fade" id="update-{{ $pertanyaan->id }}" tabindex="-1" role="dialog" aria-labelledby="update-{{ $pertanyaan->id }}" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="update-{{ $pertanyaan->id }}">Ubah Pertanyaan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('question.pembelajaran.update', ['pertanyaan' => $pertanyaan->id]) }}" method="post">
          @method('patch')
          @csrf
          <label for="pertanyaan" class="text-dark">Pertanyaan:</label>
          <input type="text" name="pertanyaan" value="{{ $pertanyaan->pertanyaan }}" class="form-control" required>
      </div>
      <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Ubah</button>
        </form>
      </div>
    </div>
  </div>
</div>
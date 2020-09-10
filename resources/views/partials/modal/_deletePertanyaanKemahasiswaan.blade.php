<div class="modal fade" id="delete-{{ $pertanyaan->id }}" tabindex="-1" role="dialog" aria-labelledby="delete-{{ $pertanyaan->id }}" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="delete-{{ $pertanyaan->id }}">Hapus Pertanyaan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Hapus pertanyaan ini?
      </div>
      <div class="modal-footer">
        <form action="{{ route('pertanyaan.kemahasiswaan.destroy', ['kemahasiswaan' => $kemahasiswaan, 'pertanyaan' => $pertanyaan->id]) }}" method="post">
          @method('delete')
          @csrf
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-danger">Hapus</button>
        </form>
      </div>
    </div>
  </div>
</div>
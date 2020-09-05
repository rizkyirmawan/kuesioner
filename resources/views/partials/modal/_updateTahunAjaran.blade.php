<div class="modal fade" id="update-{{ $tahun->id }}" tabindex="-1" role="dialog" aria-labelledby="update-{{ $tahun->id }}" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="update-{{ $tahun->id }}">Aktifkan Tahun Ajaran</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Aktifkan tahun ajaran: Semester {{ $tahun->semester . ' ' . $tahun->tahun_ajaran }}?
      </div>    
      <div class="modal-footer">
        <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
        <form action="{{ route('tahunAjaran.activate', ['tahunAjaran' => $tahun->id]) }}" method="post" class="d-inline">

          @method('patch')

          @csrf

          <button type="submit" class="btn btn-primary">Aktifkan</button>

        </form>
      </div>
    </div>
  </div>
</div>
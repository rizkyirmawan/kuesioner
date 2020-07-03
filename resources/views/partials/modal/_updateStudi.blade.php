<div class="modal fade" id="update-{{ $studi->id }}" tabindex="-1" role="dialog" aria-labelledby="update-{{ $studi->id }}" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="update-{{ $studi->id }}">Ubah Kelas & Dosen</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('matkul.studi.update', ['mataKuliah' => $mataKuliah, 'studi' => $studi->id]) }}" method="post">
          
          @method('patch')
          @csrf

          <div class="form-row">

            <div class="col-md-6 mb-3">
              <label for="kelas" class="text-dark">Kelas:</label>
              <input type="text" name="kelas" class="form-control" value="{{ $studi->kelas->kelas }}" readonly>
            </div>
            <div class="col-md-6 mb-3">
              <label for="dosen" class="text-dark">Dosen</label>
              <select name="dosen" class="form-control">
                <option disabled selected>Pilih Dosen</option>
                @foreach($dosen as $ds)
                <option value="{{ $ds->id }}" @if($ds->id === $studi->dosen->id) selected @endif>{{ $ds->nama }}</option>
                @endforeach
              </select>              
            </div>

          </div>
      </div>
      <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Ubah</button>
        </form>
      </div>
    </div>
  </div>
</div>
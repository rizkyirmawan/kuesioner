@extends('app')

@section('content')
	<h1 class="h3 mb-2 text-gray-800">Pengisian Formulir Identitas Perusahaan</h1>
  <hr>
	
	<a href="#" class="btn btn-dark btn-sm btn-icon-split mb-3">
    <span class="icon text-white-50">
      <i class="fas fa-arrow-left"></i>
    </span>
    <span class="text">Kembali</span>
  </a>

  <div class="card shadow mb-4">
    <form action="{{ route('alumni.tracerStudy.identitas.store', ['identitas' => $identitas]) }}" method="post">
      <div class="card-body">
        <div class="text-center">
        	<h4 class="text-dark font-italic text-underline">Formulir Identitas Perusahaan</h4>
        </div>
        <hr>

        <div class="form-row">

          @csrf

          <div class="col-md-4 mb-2">
            <div class="form-group">
              <label for="perusahaan" class="text-dark">Nama Perusahaan:</label>
              <input type="text" name="perusahaan" class="form-control" value="{{ old('perusahaan') }}">
              @if($errors->count() <= 0)
                <small class="form-text text-muted">Silahkan isi nama perusahaan tempat anda bekerja.</small>
              @endif
              @error('perusahaan')
                <small class="form-text text-danger">{{ $message }}</small>
              @enderror
            </div>
          </div>

          <div class="col-md-4 mb-2">
            <div class="form-group">
              <label for="email_perusahaan" class="text-dark">Email Perusahaan:</label>
              <input type="email" name="email_perusahaan" class="form-control" value="{{ old('email_perusahaan') }}">
              @if($errors->count() <= 0)
                <small class="form-text text-muted">Silahkan isi email perusahaan tempat anda bekerja.</small>
              @endif
              @error('email_perusahaan')
                <small class="form-text text-danger">{{ $message }}</small>
              @enderror
            </div>
          </div>

          <div class="col-md-4 mb-2">
            <div class="form-group">
              <label for="bidang" class="text-dark">Bidang Perusahaan:</label>
              <select name="bidang" class="form-control">
                <option selected disabled>Pilih Bidang</option>
                <option value="IT">IT</option>
                <option value="Non IT">Non IT</option>
              </select>
              @if($errors->count() <= 0)
                <small class="form-text text-muted">Silahkan pilih bidang perusahaan tempat anda bekerja.</small>
              @endif
              @error('bidang')
                <small class="form-text text-danger">{{ $message }}</small>
              @enderror
            </div>
          </div>

          <div class="col-md-8 mb-2">
            <div class="form-group">
              <label for="alamat_perusahaan" class="text-dark">Alamat Perusahaan:</label>
              <input type="text" name="alamat_perusahaan" class="form-control" value="{{ old('alamat_perusahaan') }}">
              @if($errors->count() <= 0)
                <small class="form-text text-muted">Silahkan isi alamat perusahaan tempat anda bekerja.</small>
              @endif
              @error('alamat_perusahaan')
                <small class="form-text text-danger">{{ $message }}</small>
              @enderror
            </div>
          </div>

          <div class="col-md-4 mb-2">
            <div class="form-group">
              <label for="kontak_perusahaan" class="text-dark">Kontak Perusahaan:</label>
              <input type="text" name="kontak_perusahaan" 
              class="form-control @error('kontak_perusahaan') is-invalid @enderror" maxlength="12" onkeypress="isNumber(event)" value="{{ old('kontak_perusahaan') }}">
              @if($errors->count() <= 0)
                <small class="form-text text-muted">Silahkan isi kontak perusahaan tempat anda bekerja.</small>
              @endif
              @error('kontak_perusahaan')
                <small class="form-text text-danger">{{ $message }}</small>
              @enderror
            </div>
          </div>

        </div>

      </div>
      <div class="card-footer">
        <div class="d-flex justify-content-end">
          <button class="btn btn-primary btn-icon-split" type="submit">
            <span class="icon text-white-50">
              <i class="fas fa-save"></i>
            </span>
            <span class="text">Submit</span>
          </button>
        </div>
      </div>
    </form>
  </div>
@endsection

@section('scripts')
  <script src="{{ asset('js/app.js') }}"></script>
@endsection
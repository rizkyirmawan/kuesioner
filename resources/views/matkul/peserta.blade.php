@extends('app')

@section('content')
  <h1 class="h3 mb-2 text-gray-800">{{ $mataKuliah->mata_kuliah }}</h1>
  <hr>

  @include('partials._messages')

  <div class="d-flex mb-2">
    <div class="mr-auto p-2">
      <a href="{{ route('matkul.show', ['mataKuliah' => $mataKuliah]) }}" class="btn btn-dark btn-sm btn-icon-split">
        <span class="icon text-white-50">
          <i class="fas fa-arrow-left"></i>
        </span>
        <span class="text">Kembali</span>
      </a>
    </div>
  </div>

  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Kelola Peserta Didik</h6>
    </div>
    <div class="card-body">
      <div class="row">

        <div class="col-md-6">
          <h6 class="text-dark">Informasi Kelas</h6>
          <hr>
          <table class="table table-bordered">
            <tr>
              <td class="text-dark">Kode</td>
              <td>{{ $mataKuliah->kode }}</td>
            </tr>
            <tr>
              <td class="text-dark">Mata Kuliah</td>
              <td>{{ $mataKuliah->mata_kuliah }}</td>
            </tr>
            <tr>
              <td class="text-dark">Jurusan</td>
              <td>
                @foreach($jurusan as $jrs)
                  <span class="badge badge-info d-block mt-2">{{ $jrs->jurusan }}</span>
                @endforeach
              </td>
            </tr>
          </table>
        </div>

        <div class="col-md-6">
          <h6 class="text-dark">Kelas & Dosen</h6>
          <hr>
          <table class="table table-bordered">
            <tr>
              <th>Kelas</th>
              <th>Dosen</th>
            </tr>
            @forelse($mataKuliah->studi as $studi)
                <tr>
                  <td>{{ $studi->kelas->kelas }}</td>
                  <td>{{ $studi->dosen->nama }}</td>
                </tr>
              @empty
                <tr>
                  <td class="text-center" colspan="2">Mata kuliah ini belum memiliki kelas.</td>
                </tr>
            @endforelse
          </table>
        </div>

      </div>

      <div id="peserta-wrapper">

        <div class="row">

          <div class="col-md-6">
            <div class="card">
              <div class="card-header">
                Pilih Mahasiswa
              </div>
              <div class="card-body">

                <div class="row">

                  <div class="col-md-4">
                    <select class="custom-select" id="kelas-select">
                      <option selected disabled>Pilih Kelas</option>
                      @foreach($mataKuliah->studi as $studi)
                        <option value="{{ $studi->kelas->id }}">{{ $studi->kelas->kelas }}</option>
                      @endforeach
                    </select>
                  </div>

                  <div class="col-md-4">
                    <select class="custom-select" id="jurusan-select">
                      <option selected disabled>Pilih Jurusan</option>
                      @foreach($jurusan as $jrs)
                        <option value="{{ $jrs->id }}">{{ $jrs->jurusan }}</option>
                      @endforeach
                    </select>
                  </div>

                  <div class="col-md-4">
                    <select class="custom-select" id="angkatan-select">
                      <option selected disabled>Pilih Angkatan</option>
                    </select>
                  </div>

                </div>

                <div class="text-center mt-3 mb-3" id="loading-spinner">
                  <div class="spinner-border text-primary text-center" role="status">
                    <span class="sr-only">Loading...</span>
                  </div>
                </div>
                
                <div class="list-group mt-3" id="unchosen-list">
                </div>
                <div class="text-center p-2" id="silahkan-pilih">
                  <span class="text-dark">Pilih peserta didik.</span>
                </div>
              </div>
            </div>
          </div>

          <div class="col-md-6">
            <div class="card">
              <div class="card-header">
                Mahasiswa Terpilih
              </div>
              <form action="{{ route('matkul.peserta.store', ['mataKuliah' => $mataKuliah]) }}" method="post">

                @csrf

              <div class="card-body" id="chosen-list">
                <div class="text-center p-2" id="belum-ada">
                  <span class="text-dark">Belum ada peserta terpilih.</span>
                </div>
              </div>
            </div>

                <button type="submit" class="btn btn-primary btn-sm btn-icon-split mt-2" id="btn-simpan">
                  <span class="icon text-white-50">
                    <i class="fas fa-save"></i>
                  </span>
                  <span class="text">Simpan Perubahan</span>
                </button>

              </form>

          </div>

        </div>
        
      </div>

    </div>
  </div>
@endsection

@section('scripts')
  <script src="{{ asset('js/peserta.js') }}"></script>
@endsection
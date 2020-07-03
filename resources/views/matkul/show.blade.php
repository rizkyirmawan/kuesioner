@extends('app')

@section('content')
  <h1 class="h3 mb-2 text-gray-800">Data Mata Kuliah</h1>
  <hr>

  @include('partials._messages')

  <div class="d-flex mb-2">
    <div class="mr-auto p-2">
      <a href="{{ route('matkul.index') }}" class="btn btn-dark btn-sm btn-icon-split">
        <span class="icon text-white-50">
          <i class="fas fa-arrow-left"></i>
        </span>
        <span class="text">Kembali</span>
      </a>
    </div>
    <div class="p-2">
      <a href="{{ route('matkul.edit', ['mataKuliah' => $mataKuliah]) }}" class="btn btn-success btn-sm btn-icon-split">
        <span class="icon text-white-50">
          <i class="fas fa-edit"></i>
        </span>
        <span class="text">Ubah</span>
      </a>
    </div>
    <div class="p-2">
      <a href="#" class="btn btn-danger btn-sm btn-icon-split" data-target="#deleteModal" data-toggle="modal">
        <span class="icon text-white-50">
          <i class="fas fa-trash"></i>
        </span>
        <span class="text">Hapus</span>
      </a>
    </div>
  </div>

  <div class="card shadow mb-4">
    <div class="card-header py-3">
			<div class="d-flex">
        <div class="p-2 mr-auto">
          <h6 class="font-weight-bold text-primary">Mata Kuliah: {{ $mataKuliah->mata_kuliah }}</h6>
        </div>
        <div class="p-2">
          <a href="#" class="btn btn-warning btn-sm btn-icon-split"  data-target="#kelasModal" data-toggle="modal">
            <span class="icon text-white-50">
              <i class="fas fa-plus"></i>
            </span>
            <span class="text">Kelas & Dosen</span>
          </a>
        </div>
        <div class="p-2">
          <a href="{{ route('matkul.peserta', ['mataKuliah' => $mataKuliah]) }}" class="btn btn-primary btn-sm btn-icon-split @if($mataKuliah->studi->count() <= 0) disabled @endif">
            <span class="icon text-white-50">
              <i class="fas fa-plus"></i>
            </span>
            <span class="text">Peserta Didik</span>
          </a>
        </div>
      </div>
    </div>
    <div class="card-body">
      <div class="row">

        <div class="col-md-6">
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
                @forelse($mataKuliah->jurusan as $jurusan)
                  <span class="badge badge-info d-block mt-2">{{ $jurusan->jurusan }}</span>
                @empty
                  Belum Ada
                @endforelse
              </td>
            </tr>
            <tr>
              <td class="text-dark">Kelas & Dosen</td>
              <td>
                <ul class="list-group">
                  @forelse($mataKuliah->studi as $std)
                    <span class="badge badge-success d-block mt-2">{{ $std->kelas->kelas }}: {{ $std->dosen->nama }}</span>
                  @empty
                    Belum Dikelola
                  @endforelse
                </ul>
              </td>
            </tr>
          </table>
        </div>

        <div class="col-md-6">
          <h5 class="text-dark">Peserta Didik</h5>
          <hr>
          <table class="table table-bordered">
            <tr>
              <th>Kelas</th>
              <th>Peserta</th>
            </tr>
            @forelse($mataKuliah->studi as $studi)
              <tr>
                <td>
                  {{ $studi->kelas->kelas }}

                  <div class="d-flex flex-row-reverse mt-2">
                    <a href="#" class="badge badge-danger p-2" data-toggle="modal" data-target="#delete-{{ $studi->id }}">
                      <i class="fa fa-times"></i>
                    </a>
                    <a href="#" class="badge badge-success p-2 mr-2" data-toggle="modal" data-target="#update-{{ $studi->id }}">
                      <i class="fa fa-edit"></i>
                    </a>
                  </div>

                  @include('partials.modal._updateStudi')
                  @include('partials.modal._deleteStudi')

                </td>
                <td>
                  <ol>
                  @forelse($mataKuliah->mahasiswa->where('kelas_id', $studi->kelas->id) as $mahasiswa)
                    <li>{{ $mahasiswa->nama . ' (' . $mahasiswa->nim . ')' }}</li>
                  @empty
                    <h6>Belum ada peserta pada kelas ini.</h6>
                  @endforelse
                  </ol>
                </td>
              </tr>
              @empty
              <tr>
                <td class="text-center" colspan="2">Belum Dikelola</td>
              </tr>
            @endforelse
          </table>
        </div>

      </div>
    </div>
  </div>

  <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Hapus Data</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Hapus data mata kuliah: {{ $mataKuliah->mata_kuliah }}?</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
          <form action="{{ route('matkul.destroy', ['mataKuliah' => $mataKuliah]) }}" method="post" class="d-inline">
            
            @method('delete')

            @csrf

            <button type="submit" class="btn btn-danger">Hapus</button>

          </form>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="kelasModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Kelola Kelas & Dosen</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="{{ route('matkul.studi', ['mataKuliah' => $mataKuliah]) }}" method="post">

            @csrf

            <div class="row">

              <div class="col-md-6">
                <label for="kelas" class="text-dark">Kelas:</label>
                <select name="kelas" class="form-control" required>
                  <option disabled selected>Pilih Kelas</option>
                  @foreach($kelas as $kls)
                    <option value="{{ $kls->id }}">{{ $kls->kelas }}</option>
                  @endforeach
                </select>
              </div>

              <div class="col-md-6">
                <label for="dosen" class="text-dark">Dosen:</label>
                <select name="dosen" class="form-control" required>
                  <option disabled selected>Pilih Dosen</option>
                  @foreach($dosen as $ds)
                    <option value="{{ $ds->id }}">{{ $ds->nama }}</option>
                  @endforeach
                </select>
              </div>

            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
            <button class="btn btn-primary" type="submit">Simpan</button>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection

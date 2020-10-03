@extends('app')

@section('content')
  <h1 class="h3 mb-2 text-gray-800">Data Alumni</h1>
  <hr>

  @include('partials._messages')

  <div class="d-flex mb-2">
    <div class="mr-auto p-2">
      <a href="{{ route('alumni.index') }}" class="btn btn-dark btn-sm btn-icon-split">
        <span class="icon text-white-50">
          <i class="fas fa-arrow-left"></i>
        </span>
        <span class="text">Kembali</span>
      </a>
    </div>
    <div class="p-2">
      <a href="{{ route('alumni.edit', ['alumni' => $alumni]) }}" class="btn btn-success btn-sm btn-icon-split">
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
			<h6 class="font-weight-bold text-primary">Detail dari {{ $alumni->nama }}</h6>
    </div>
    <div class="card-body">
      <div class="row">

        @if($alumni->foto)
          <div class="col-md-6 text-center">
            <img src="/storage/{{ $alumni->foto }}" class="img-fluid img-thumbnail rounded">
          </div>
        @else
          <div class="col-md-6 text-center">
            <img src="/img/user.png" class="img-fluid img-thumbnail rounded" width="295">
          </div>
        @endif

        <div class="col-md-6">
          <table class="table table-bordered text-dark">
            <tr>
              <td class="text-dark">NIM</td>
              <td>{{ $alumni->nim }}</td>
            </tr>
            <tr>
              <td class="text-dark">Nama</td>
              <td>{{ $alumni->nama }}</td>
            </tr>
            <tr>
              <td class="text-dark">Jenis Kelamin</td>
              <td>{{ $alumni->jenis_kelamin }}</td>
            </tr>
            <tr>
              <td class="text-dark">Alamat</td>
              <td>{{ $alumni->alamat }}</td>
            </tr>
            <tr>
              <td class="text-dark">Angkatan</td>
              <td>{{ $alumni->angkatan }}</td>
            </tr>
            <tr>
              <td class="text-dark">Jurusan</td>
              <td>{{ $alumni->jurusan->jurusan }}</td>
            </tr>
            <tr>
              <td class="text-dark">Tahun Lulus</td>
              <td>{{ $alumni->tahun_lulus }}</td>
            </tr>
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
        <div class="modal-body">Hapus data alumni atas nama: {{ $alumni->nama }}?</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
          <form action="{{ route('alumni.destroy', ['alumni' => $alumni]) }}" method="post" class="d-inline">
            
            @method('delete')

            @csrf

            <button type="submit" class="btn btn-danger">Hapus</button>

          </form>
        </div>
      </div>
    </div>
  </div>
@endsection

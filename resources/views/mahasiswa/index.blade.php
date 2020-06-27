@extends('app')

@section('content')
  <h1 class="h3 mb-2 text-gray-800">Data Mahasiswa</h1>
  <hr>

  @include('partials._messages')

  <div class="card shadow mb-4">
    <div class="card-header py-3">
    	<div class="d-flex">
    		<div class="p-2">
    			<h6 class="font-weight-bold text-primary">Daftar Mahasiswa</h6>
    		</div>
    		<div class="p-2 ml-auto">
	      	<a href="{{ route('mahasiswa.create') }}" class="btn btn-primary btn-sm btn-icon-split">
            <span class="icon text-white-50">
              <i class="fas fa-plus"></i>
            </span>
            <span class="text">Tambah Data</span>
          </a>
    		</div>
    	</div>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>No.</th>
              <th>NIM</th>
              <th>Nama</th>
              <th>Jurusan</th>
              <th>Angkatan</th>
              <th>Kelas</th>
              <th>Kelola</th>
            </tr>
          </thead>
          <tbody>

            @foreach($mahasiswa as $mhs)
            <tr>
            	<td>{{ $loop->iteration }}.</td>
              <td>{{ $mhs->nim }}</td>
              <td>{{ $mhs->nama }}</td>
              <td>
              	@if($mhs->jurusan->kode == 'IF')
              		<span class="badge badge-info">{{ $mhs->jurusan->jurusan }}</span>
              	@elseif($mhs->jurusan->kode == 'SI')
              		<span class="badge badge-success">{{ $mhs->jurusan->jurusan }}</span>
              	@endif
              </td>
              <td>{{ $mhs->angkatan }}</td>
              <td>{{ $mhs->kelas->kelas }}</td>
              <td>
								<a href="{{ route('mahasiswa.show', ['mahasiswa' => $mhs]) }}" class="btn btn-secondary btn-sm btn-icon-split">
                  <span class="icon text-white-50">
                    <i class="fas fa-eye text-white-50"></i>
                  </span>
                  <span class="text">Detail</span>
                </a>
              </td>
            </tr>
            @endforeach

          </tbody>
        </table>
      </div>
    </div>
  </div>
@endsection

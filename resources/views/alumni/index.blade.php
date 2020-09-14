@extends('app')

@section('content')
  <h1 class="h3 mb-2 text-gray-800">Data Alumni</h1>
  <hr>

  @include('partials._messages')

  <div class="card shadow mb-4">
    <div class="card-header py-3">
    	<div class="d-flex">
    		<div class="p-2">
    			<h6 class="font-weight-bold text-primary">Daftar Alumni</h6>
    		</div>
    		<div class="p-2 ml-auto">
	      	<a href="{{ route('alumni.create') }}" class="btn btn-primary btn-sm btn-icon-split">
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
              <th>Tahun Lulus</th>
              <th>Kelola</th>
            </tr>
          </thead>
          <tbody>

            @foreach($alumni as $alm)
            <tr>
            	<td>{{ $loop->iteration }}.</td>
              <td>{{ $alm->nim }}</td>
              <td>{{ $alm->nama }}</td>
              <td>
              	@if($alm->jurusan->kode == 'IF')
              		<span class="badge badge-info">{{ $alm->jurusan->jurusan }}</span>
              	@elseif($alm->jurusan->kode == 'SI')
              		<span class="badge badge-success">{{ $alm->jurusan->jurusan }}</span>
              	@endif
              </td>
              <td>{{ $alm->angkatan }}</td>
              <td>{{ $alm->tahun_lulus }}</td>
              <td>
								<a href="{{ route('alumni.show', ['alumni' => $alm]) }}" class="btn btn-secondary btn-sm btn-icon-split">
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

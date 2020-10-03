@extends('app')

@section('content')
  <h1 class="h3 mb-2 text-gray-800">Data Kuesioner Pembelajaran</h1>
  <hr>

  @include('partials._messages')

  <div class="card shadow mb-4">
    <div class="card-header py-3">
    	<div class="d-flex">
    		<div class="p-2">
    			<h6 class="font-weight-bold text-primary">Daftar Kuesioner</h6>
    		</div>
        @if(Auth::user()->role->role === 'Admin')
        <div class="p-2 ml-auto">
          <a href="{{ route('export.rekap.pembelajaran') }}" class="btn btn-success btn-sm btn-icon-split @if($pembelajaran->count() <= 0) disabled @endif">
            <span class="icon text-white-50">
              <i class="fas fa-file-export"></i>
            </span>
            <span class="text">Export Rekap</span>
          </a>
        </div>
    		<div class="p-2">
	      	<a href="{{ route('pembelajaran.create') }}" class="btn btn-primary btn-sm btn-icon-split">
            <span class="icon text-white-50">
              <i class="fas fa-plus"></i>
            </span>
            <span class="text">Tambah Data</span>
          </a>
        </div>
        @endif
    	</div>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>No.</th>
              <th>Dosen</th>
              <th>Kelas</th>
              <th>Mata Kuliah</th>
              <th>Kelola</th>
            </tr>
          </thead>
          <tbody>

            @foreach($pembelajaran as $kuesioner)
            <tr>
            	<td>{{ $loop->iteration }}.</td>
              <td>{{ $kuesioner->studi->dosen->nama }}</td>
              <td>{{ $kuesioner->studi->kelas->kelas }}</td>
              <td>{{ $kuesioner->studi->matkul->kode . ': ' .$kuesioner->studi->matkul->mata_kuliah }}</td>
              <td>
                @if(Auth::user()->role->role === 'Admin')
								<a href="{{ route('pembelajaran.show', ['pembelajaran' => $kuesioner]) }}" class="btn btn-secondary btn-sm btn-icon-split">
                  <span class="icon text-white-50">
                    <i class="fas fa-eye text-white-50"></i>
                  </span>
                  <span class="text">Detail</span>
                </a>
                @else
                <a href="{{ route('pembelajaran.respons', ['pembelajaran' => $kuesioner]) }}" class="btn btn-secondary btn-sm btn-icon-split">
                  <span class="icon text-white-50">
                    <i class="fas fa-eye text-white-50"></i>
                  </span>
                  <span class="text">Respons</span>
                </a>
                @endif
              </td>
            </tr>
            @endforeach

          </tbody>
        </table>
      </div>
    </div>
  </div>
@endsection

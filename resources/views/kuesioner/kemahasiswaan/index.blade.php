@extends('app')

@section('content')
  <h1 class="h3 mb-2 text-gray-800">Data Kuesioner Layanan Mahasiswa</h1>
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
          <a href="{{ route('export.rekap.kemahasiswaan') }}" class="btn btn-success btn-sm btn-icon-split @if($kemahasiswaan->count() <= 0) disabled @endif">
            <span class="icon text-white-50">
              <i class="fas fa-file-export"></i>
            </span>
            <span class="text">Export Rekap</span>
          </a>
        </div>
        <div class="p-2">
          <a href="{{ route('kemahasiswaan.create') }}" class="btn btn-primary btn-sm btn-icon-split @if($pertanyaanKemahasiswaanCount <= 0) disabled @endif">
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
              <th>Kuesioner</th>
              <th>Tahun</th>
              <th>Periode</th>
              <th>Kelola</th>
            </tr>
          </thead>
          <tbody>

            @foreach($kemahasiswaan as $kuesioner)
            <tr>
            	<td>{{ $loop->iteration }}.</td>
              <td>{{ $kuesioner->kuesioner }}</td>
              <td>{{ $kuesioner->tahun }}</td>
              <td>{{ Carbon\Carbon::parse($kuesioner->awal)->translatedFormat('d F Y') . ' - ' . Carbon\Carbon::parse($kuesioner->akhir)->translatedFormat('d F Y') }}</td>
              <td>
                @if(Auth::user()->role->role === 'Admin')
								<a href="{{ route('kemahasiswaan.show', ['kemahasiswaan' => $kuesioner]) }}" class="btn btn-secondary btn-sm btn-icon-split">
                  <span class="icon text-white-50">
                    <i class="fas fa-eye text-white-50"></i>
                  </span>
                  <span class="text">Detail</span>
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

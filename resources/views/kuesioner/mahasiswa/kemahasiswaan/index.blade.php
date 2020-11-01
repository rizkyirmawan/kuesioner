@extends('app')

@section('content')
  <h1 class="h3 mb-2 text-gray-800">Data Kuesioner Layanan Mahasiswa</h1>
  <hr>

  @include('partials._messages')

  <div class="card shadow mb-4">
    <div class="card-header py-3">
    	<h6 class="font-weight-bold text-primary">Daftar Kuesioner</h6>
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
              <td class="text-center">
                @if($kuesioner->responden->where('user_id', auth()->user()->id)->count() > 0)
                <h4>
                  <span class="badge badge-pill badge-success">
                    <i class="fa fa-check"></i>
                  </span>
                </h4>
                @else
								<a href="{{ route('mahasiswa.kemahasiswaan.show', ['kemahasiswaan' => $kuesioner]) }}" class="btn btn-warning btn-sm btn-icon-split">
                  <span class="icon text-white-50">
                    <i class="fas fa-edit"></i>
                  </span>
                  <span class="text">Tanggapi</span>
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

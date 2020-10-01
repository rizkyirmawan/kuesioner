@extends('app')

@section('content')
  <h1 class="h3 mb-2 text-gray-800">Data Kelas</h1>
  <hr>

  @include('partials._messages')

  <div class="card shadow mb-4">
    <div class="card-header py-3">
    	<div class="d-flex">
    		<div class="p-2">
    			<h6 class="font-weight-bold text-primary">Daftar Kelas</h6>
    		</div>
    		<div class="p-2 ml-auto">
	      	<a href="{{ route('kelas.create') }}" class="btn btn-primary btn-sm btn-icon-split" id="tambah-data">
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
              <th>Kode</th>
              <th>Kelas</th>
              <th>Kelola</th>
            </tr>
          </thead>
          <tbody>

            @foreach($kelas as $kls)
            <tr>
            	<td>{{ $loop->iteration }}.</td>
              <td>{{ $kls->kode }}</td>
              <td>{{ $kls->kelas }}</td>
              <td>
								<a href="{{ route('kelas.show', ['kelas' => $kls]) }}" class="btn btn-secondary btn-sm btn-icon-split">
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

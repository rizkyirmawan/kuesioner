@extends('app')

@section('content')
  <h1 class="h3 mb-2 text-gray-800">Data Tahun Ajaran</h1>
  <hr>

  @include('partials._messages')

  <div class="card shadow mb-4">
    <div class="card-header py-3">
    	<div class="d-flex">
    		<div class="p-2">
    			<h6 class="font-weight-bold text-primary">Daftar Tahun Ajaran</h6>
    		</div>
    		<div class="p-2 ml-auto">
	      	<a href="{{ route('tahunAjaran.create') }}" class="btn btn-primary btn-sm btn-icon-split">
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
              <th>Semester</th>
              <th>Tahun Ajaran</th>
              <th>Status</th>
              <th>Kelola</th>
            </tr>
          </thead>
          <tbody>

            @foreach($tahunAjaran as $tahun)
            <tr>
            	<td>{{ $loop->iteration }}.</td>
              <td>{{ $tahun->semester }}</td>
              <td>{{ $tahun->tahun_ajaran }}</td>
              <td>@if($tahun->aktif === 1) {{ 'Aktif' }} @else {{ 'Tidak Aktif' }} @endif</td>
              <td>
								<a href="#" class="btn btn-success btn-sm btn-icon-split  @if($tahun->aktif === 1) disabled @endif" data-toggle="modal" data-target="#update-{{ $tahun->id }}">
                  <span class="icon text-white-50">
                    <i class="fas fa-check text-white-50"></i>
                  </span>
                  <span class="text">Aktifkan</span>
                </a>

                @include('partials.modal._updateTahunAjaran')

              </td>
            </tr>
            @endforeach

          </tbody>
        </table>
      </div>
    </div>
  </div>
@endsection

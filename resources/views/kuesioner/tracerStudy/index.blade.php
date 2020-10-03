@extends('app')

@section('content')
  <h1 class="h3 mb-2 text-gray-800">Data Kuesioner Tracer Study</h1>
  <hr>

  @include('partials._messages')

  <div class="card shadow mb-4">
    <div class="card-header py-3">
    	<div class="d-flex">
    		<div class="p-2">
    			<h6 class="font-weight-bold text-primary">Daftar Kuesioner</h6>
    		</div>
    		<div class="p-2 ml-auto">
          @if(Auth::user()->role->role === 'Admin')
	      	<a href="#" class="btn btn-primary btn-sm btn-icon-split" data-target="#createIdentitasModal" data-toggle="modal">
            <span class="icon text-white-50">
              <i class="fas fa-plus"></i>
            </span>
            <span class="text">Tambah Data</span>
          </a>
          @endif
    		</div>
    	</div>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>No.</th>
              <th>Tahun Lulus Tertuju</th>
              <th>Kelola</th>
            </tr>
          </thead>
          <tbody>

            @foreach($identitas as $kuesioner)
            <tr>
            	<td>{{ $loop->iteration }}.</td>
              <td>{{ $kuesioner->tahun_lulus }}</td>
              <td>
                @if(Auth::user()->role->role === 'Admin')
								<a href="{{ route('tracerStudy.identitas.show', ['identitas' => $kuesioner]) }}" class="btn btn-secondary btn-sm btn-icon-split">
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

  <div class="modal fade" id="createIdentitasModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tambah Tracer Study</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="{{ route('tracerStudy.identitas.create') }}" method="post">

            @csrf

            <div class="form-group">
              <label for="tahun_lulus">Tahun Lulus Tertuju:</label>
              <select name="tahun_lulus" class="form-control">
                <option selected disabled>Pilih Tahun Lulus</option>
                @foreach($tahunLulus as $tahun)
                <option value="{{ $tahun }}">{{ $tahun }}</option>
                @endforeach
              </select>
            </div>

        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>

            <button type="submit" class="btn btn-primary">Tambahkan</button>

          </form>
        </div>
      </div>
    </div>
  </div>
@endsection

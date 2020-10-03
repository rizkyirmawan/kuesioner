@extends('app')

@section('content')
  <h1 class="h3 mb-2 text-gray-800">Data Mata Kuliah</h1>
  <hr>

  @include('partials._messages')

  <div class="d-flex mb-3">
    <div class="p-2">
      <a href="#import-collapse" data-toggle="collapse" class="btn btn-success btn-sm btn-icon-split">
        <span class="icon text-white-50">
          <i class="fas fa-file-import"></i>
        </span>
        <span class="text">Import KRS</span>
      </a>
    </div>
    <div class="p-2">
      <a href="{{ route('download.blankoKRS') }}" class="btn btn-info btn-sm btn-icon-split">
        <span class="icon text-white-50">
          <i class="fas fa-download"></i>
        </span>
        <span class="text">Blanko KRS</span>
      </a>
    </div>
  </div>

  <div class="row">
    <div class="col-md-4">
      <div class="collapse" id="import-collapse">
        <div class="card card-body mb-3">
          <form action="{{ route('krs.import') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
              <label for="excel" class="text-dark">Import Excel:</label>
              <input type="file" class="form-control-file" name="excel">
            </div>
            <button class="btn btn-sm btn-success" type="submit">Import</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <div class="card shadow mb-4">
    <div class="card-header py-3">
    	<div class="d-flex">
    		<div class="p-2">
    			<h6 class="font-weight-bold text-primary">Daftar Mata Kuliah</h6>
    		</div>
    		<div class="p-2 ml-auto">
	      	<a href="{{ route('matkul.create') }}" class="btn btn-primary btn-sm btn-icon-split">
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
              <th>Mata Kuliah</th>
              <th>Kelola</th>
            </tr>
          </thead>
          <tbody>

            @foreach($mataKuliah as $matkul)
            <tr>
            	<td>{{ $loop->iteration }}.</td>
              <td>{{ $matkul->kode }}</td>
              <td>{{ $matkul->mata_kuliah }}</td>
              <td>
								<a href="{{ route('matkul.show', ['mataKuliah' => $matkul->kode]) }}" class="btn btn-secondary btn-sm btn-icon-split">
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

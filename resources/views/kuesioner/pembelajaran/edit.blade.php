@extends('app')

@section('content')
	<h1 class="h3 mb-2 text-gray-800">Ubah Data Kuesioner Pembelajaran</h1>
  <hr>
	
	<a href="{{ route('pembelajaran.show', ['pembelajaran' => $pembelajaran]) }}" class="btn btn-dark btn-sm btn-icon-split mb-3">
    <span class="icon text-white-50">
      <i class="fas fa-arrow-left"></i>
    </span>
    <span class="text">Kembali</span>
  </a>

  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Form Tambah Data</h6>
    </div>
    <form action="{{ route('pembelajaran.update', ['pembelajaran' => $pembelajaran]) }}" method="post">

		@csrf

		@method('patch')

	    @include('kuesioner.pembelajaran.form')

	    <div class="card-footer">
	    	<div class="d-flex justify-content-end">
	    		<button class="btn btn-primary btn-icon-split" type="submit">
	    			<span class="icon text-white-50">
	    				<i class="fas fa-save"></i>
	    			</span>
	    			<span class="text">Simpan Perubahan</span>
	    		</button>
	    	</div>
	    </div>

    </form>
  </div>
@endsection
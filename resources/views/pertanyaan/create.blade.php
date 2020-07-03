@extends('app')

@section('content')
	<h1 class="h3 mb-2 text-gray-800">Tambah Pertanyaan</h1>
  <hr>
	
	<a href="{{ route('pembelajaran.show', ['pembelajaran' => $pembelajaran]) }}" class="btn btn-dark btn-sm btn-icon-split mb-3">
    <span class="icon text-white-50">
      <i class="fas fa-arrow-left"></i>
    </span>
    <span class="text">Kembali</span>
  </a>

  <div class="card shadow mb-4">
    <div class="card-header py-3">
    	<h6 class="font-weight-bold text-primary">Detail Kuesioner Pembelajaran</h6>
    </div>
    <div class="card-body">
      <div class="text-center">
      	<h4 class="text-dark font-italic text-underline">{{ $pembelajaran->kuesioner }}</h4>
      </div>
      <hr>
      <div class="row">
        
        <div class="col-md-12">
          <table class="table table-bordered">
            <tr>
              <th>Kelas</th>
              <th>Dosen</th>
              <th>Mata Kuliah</th>
            </tr>
            <tr>
              <td>{{ $pembelajaran->studi->kelas->kelas }}</td>
              <td>{{ $pembelajaran->studi->dosen->nama }}</td>
              <td>{{ $pembelajaran->studi->matkul->mata_kuliah }}</td>
            </tr>
          </table>
        </div>

      </div>
    </div>
  </div>

  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Form Tambah Pertanyaan</h6>
    </div>
    <form action="{{ route('pertanyaan.pembelajaran.store', ['pembelajaran' => $pembelajaran]) }}" method="post">
    	
    	<div class="card-body">

			@csrf

		    <div class="form-row">

		    	<div class="col-md-6 mb-3">
		    		<label for="pertanyaan[pertanyaan]" class="text-dark">Pertanyaan:</label>
		    		<input type="text" class="form-control" name="pertanyaan">
		    	</div>

		    	<div class="col-md-6 mb-3">
		    		<label for="tipe" class="text-dark">Tipe Jawaban:</label>
		    		<select name="tipe" class="form-control" id="tipe-select">
		    			<option selected disabled>Pilih Tipe Jawaban</option>
		    			<option value="Text">Teks</option>
		    			<option value="Textarea">Teks Area</option>
		    			<option value="Radio">Pilihan (Satu)</option>
		    			<option value="Checkbox">Pilihan (Ganda)</option>
		    		</select>
		    	</div>

		    	<div class="col-md-12">
		    		<hr>
		    	</div>

		    	<div class="col-md-12" id="pertanyaan-wrapper"></div>

		    </div>

		</div>

	    <div class="card-footer">
	    	<div class="d-flex justify-content-end">
	    		<button class="btn btn-primary btn-icon-split" type="submit">
	    			<span class="icon text-white-50">
	    				<i class="fas fa-save"></i>
	    			</span>
	    			<span class="text">Tambah Pertanyaan</span>
	    		</button>
	    	</div>
	    </div>

    </form>
  </div>
@endsection

@section('scripts')
	<script src="{{ asset('js/pertanyaan.js') }}"></script>
@endsection
<div class="card-body">

	<div class="form-row">

		<div class="col-md-3 mb-3">
			<label for="kode" class="text-dark">Kode:</label>
			<input type="text" name="kode" class="form-control @error('kode') is-invalid @enderror" value="{{ $mataKuliah->kode ?? old('kode') }}">
			@error('kode')
				<small class="form-text text-danger">{{ $message }}</small>
			@enderror
		</div>

		<div class="col-md-5 mb-3">
			<label for="mata_kuliah" class="text-dark">Mata Kuliah:</label>
			<input type="text" name="mata_kuliah" class="form-control @error('mata_kuliah') is-invalid @enderror" value="{{ $mataKuliah->mata_kuliah ?? old('mata_kuliah')  }}">
			@error('mata_kuliah')
				<small class="form-text text-danger">{{ $message }}</small>
			@enderror
		</div>

		<div class="col-md-4 mb-3">
			<div class="form-group">
				<label for="test" class="text-dark">Jurusan:</label>

				@foreach($jurusan as $jrs)
				<div class="form-check" id="test">
				  <input class="form-check-input" name="jurusan[]" type="checkbox" value="{{ $jrs->id }}" id="jurusan-{{ $jrs->id }}" @if($mataKuliah->jurusan->contains($jrs->id)) checked @endif>
				  <label class="form-check-label text-dark" for="jurusan-{{ $jrs->id }}">
				    {{ $jrs->jurusan }}
				  </label>
				</div>
				@endforeach

				@error('jurusan')
					<small class="form-text text-danger">{{ $message }}</small>
				@enderror

			</div>
		</div>

	</div>

</div>
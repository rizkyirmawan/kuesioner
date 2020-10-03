<div class="card-body">

	<div class="form-row">
 
		<input type="hidden" value="{{ $kemahasiswaan->id ?? '' }}" name="id">

		<div class="col-md-12 mb-3">
			<label for="kuesioner" class="text-dark">Judul Kuesioner:</label>
			<input type="text" name="kuesioner" class="form-control @error('kuesioner') is-invalid @enderror" value="{{ old('kuesioner') ?? $kemahasiswaan->kuesioner }}">
			@error('kuesioner')
				<small class="form-text text-danger">{{ $message }}</small>
			@enderror
		</div>

		<div class="col-md-12 mb-3">
			<label for="deskripsi" class="text-dark">Deskripsi:</label>
			<textarea name="deskripsi" rows="5" class="form-control @error('deskripsi') is-invalid @enderror">{{ old('deskripsi') ?? $kemahasiswaan->deskripsi }}</textarea>
			@error('deskripsi')
				<small class="form-text text-danger">{{ $message }}</small>
			@enderror
		</div>

	</div>

</div>
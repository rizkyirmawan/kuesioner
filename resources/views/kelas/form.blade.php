<div class="card-body">

	<div class="form-row">
 
		<input type="hidden" value="{{ $kelas->id ?? '' }}" name="id">

		<div class="col-md-6 mb-3">
			<label for="kode" class="text-dark">Kode:</label>
			<input type="text" name="kode" class="form-control @error('kode') is-invalid @enderror" value="{{ old('kode') ?? $kelas->kode }}">
			@error('kode')
				<small class="form-text text-danger">{{ $message }}</small>
			@enderror
		</div>

		<div class="col-md-6 mb-3">
			<label for="kelas" class="text-dark">Kelas:</label>
			<input type="text" name="kelas" class="form-control @error('kelas') is-invalid @enderror" value="{{ old('kelas') ?? $kelas->kelas }}">
			@error('kelas')
				<small class="form-text text-danger">{{ $message }}</small>
			@enderror
		</div>

	</div>

</div>
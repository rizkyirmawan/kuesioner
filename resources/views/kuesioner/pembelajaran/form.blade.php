<div class="card-body">

	<div class="form-row">
 
		<input type="hidden" value="{{ $pembelajaran->id ?? '' }}" name="id">

		<div class="col-md-6 mb-3">
			<label for="studi" class="text-dark">Matkul & Kelas:</label>
			<select name="studi" class="form-control">
				<option disabled selected>Pilih Matkul & Kelas</option>
				@foreach($studi as $std)
				<option value="{{ $std->id }}" @if($pembelajaran->studi) @if($std->id === $pembelajaran->studi->id) {{ 'selected' }} @endif @endif>{{ $std->matkul->mata_kuliah }} ({{ $std->kelas->kelas }})</option>
				@endforeach
			</select>
			@error('studi')
				<small class="form-text text-danger">{{ $message }}</small>
			@enderror
		</div>

		<div class="col-md-6 mb-3">
			<label for="kuesioner" class="text-dark">Judul Kuesioner:</label>
			<input type="text" name="kuesioner" class="form-control @error('kuesioner') is-invalid @enderror" value="{{ old('kuesioner') ?? $pembelajaran->kuesioner }}">
			@error('kuesioner')
				<small class="form-text text-danger">{{ $message }}</small>
			@enderror
		</div>

		<div class="col-md-12 mb-3">
			<label for="deskripsi" class="text-dark">Deskripsi:</label>
			<textarea name="deskripsi" rows="5" class="form-control @error('deskripsi') is-invalid @enderror">{{ old('deskripsi') ?? $pembelajaran->deskripsi }}</textarea>
			@error('deskripsi')
				<small class="form-text text-danger">{{ $message }}</small>
			@enderror
		</div>

	</div>

</div>
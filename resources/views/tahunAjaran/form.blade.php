<div class="card-body">

	<div class="form-row">
 
		<input type="hidden" value="{{ $tahunAjaran->id ?? '' }}" name="id">

		<div class="col-md-6 mb-3">
			<label for="semester" class="text-dark">Semester:</label>
			<select name="semester" class="form-control @error('semester') is-invalid @enderror">
				<option disabled selected>Pilih Semester</option>
				<option value="Ganjil" @if($tahunAjaran->semester == 'Ganjil') {{ 'selected' }} @endif>Ganjil</option>
				<option value="Genap" @if($tahunAjaran->semester == 'Genap') {{ 'selected' }} @endif>Genap</option>
			</select>
			@error('semester')
				<small class="form-text text-danger">{{ $message }}</small>
			@enderror
		</div>

		<div class="col-md-6 mb-3">
			<label for="tahun_ajaran" class="text-dark">Tahun Ajaran:</label>
			<select name="tahun_ajaran" class="form-control" @error('tahun_ajaran') is-invalid @enderror">
				<option disabled selected>Pilih Tahun Ajaran</option>
				@for($i = Carbon\Carbon::now()->year; $i >= 1970; $i--)
					<option value="{{ $i . '/' . (intval($i) + 1) }}">{{ $i . '/' . (intval($i) + 1) }}</option>
				@endfor
			</select>
			@error('tahun_ajaran')
				<small class="form-text text-danger">{{ $message }}</small>
			@enderror
		</div>

	</div>

</div>
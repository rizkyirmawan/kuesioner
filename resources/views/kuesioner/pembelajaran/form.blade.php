<div class="card-body">

	<div class="form-row">
 
		<input type="hidden" value="{{ $pembelajaran->id ?? '' }}" name="id">

		<div class="col-md-3 mb-3">
			<label for="studi" class="text-dark">Matkul & Kelas:</label>
			<input type="text" class="form-control" name="studi" value="Semua" readonly>
			@error('studi')
				<small class="form-text text-danger">{{ $message }}</small>
			@enderror
		</div>

		<div class="col-md-3 mb-3">
			<label for="kuesioner" class="text-dark">Judul Kuesioner:</label>
			<input type="text" name="kuesioner" class="form-control @error('kuesioner') is-invalid @enderror" value="{{ old('kuesioner') ?? $pembelajaran->kuesioner }}">
			@error('kuesioner')
				<small class="form-text text-danger">{{ $message }}</small>
			@enderror
		</div>

		<div class="col-md-3 mb-3">
			<label for="awal" class="text-dark">Awal Periode:</label>
			<input type="date" id="awal" name="awal" class="form-control @error('awal') is-invalid @enderror" min="{{ date('Y-m-d') }}" value="{{ old('awal') ?? $pembelajaran->awal }}">
			@error('awal')
				<small class="form-text text-danger">{{ $message }}</small>
			@enderror
		</div>

		<div class="col-md-3 mb-3">
			<label for="akhir" class="text-dark">Akhir Periode:</label>
			<input type="date" id="akhir" name="akhir" class="form-control @error('akhir') is-invalid @enderror" value="{{ old('akhir') ?? $pembelajaran->akhir }}">
			@error('akhir')
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

@section('scripts')
<script type="text/javascript">
	const awalInput = document.querySelector('#awal');
	const akhirInput = document.querySelector('#akhir');

	awalInput.addEventListener('change', function() {
		akhirInput.setAttribute('min', this.value);
	});
</script>
@endsection
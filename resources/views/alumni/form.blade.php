<div class="card-body">

	<div class="form-row">

		<input type="hidden" name="id" value="{{ $alumni->user->userable->id ?? '' }}">

		<div class="col-md-4 mb-3">
			<label for="nim" class="text-dark">NIM:</label>
			<input type="text" name="nim" class="form-control @error('nim') is-invalid @enderror" onkeypress="isNumber(event)" maxlength="7" value="{{ old('nim') ?? $alumni->nim }}">
			@error('nim')
				<small class="form-text text-danger">{{ $message }}</small>
			@enderror
		</div>

		<div class="col-md-8 mb-3">
			<label for="nama" class="text-dark">Nama:</label>
			<input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama') ?? $alumni->nama }}">
			@error('nama')
				<small class="form-text text-danger">{{ $message }}</small>
			@enderror
		</div>

		<div class="col-md-5 mb-3">
			<label for="alamat" class="text-dark">Alamat:</label>
			<input type="text" name="alamat" class="form-control @error('alamat') is-invalid @enderror" value="{{ old('alamat') ?? $alumni->alamat }}">
			@error('alamat')
				<small class="form-text text-danger">{{ $message }}</small>
			@enderror
		</div>

		<div class="col-md-4 mb-3">
			<label for="nomor_telepon" class="text-dark">Nomor Telepon:</label>
			<div class="input-group">
				<div class="input-group-prepend">
					<span class="input-group-text">+62</span>
				</div>
				<input type="text" name="nomor_telepon" 
				class="form-control @error('nomor_telepon') is-invalid @enderror" maxlength="11" onkeypress="isNumber(event)" value="{{ old('nomor_telepon') ?? Str::substr($alumni->nomor_telepon, 3) }}">
			</div>
			@error('nomor_telepon')
				<small class="form-text text-danger">{{ $message }}</small>
			@enderror
		</div>

		<div class="col-md-3 mb-3">
			<label for="email" class="text-dark">Email:</label>
			<input type="text" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ $alumni->user->email ?? old('email') }}">
			@error('email')
				<small class="form-text text-danger">{{ $message }}</small>
			@enderror
		</div>

	</div>

	<div class="form-row">

		<div class="col-md-4 mb-3">
			<label for="jurusan" class="text-dark">Jurusan:</label>
			<select name="jurusan" class="form-control @error('jurusan') is-invalid @enderror">
				<option disabled selected>Pilih Jurusan</option>
				@foreach($jurusan as $jurusan)
					<option value="{{ $jurusan->id }}" @if($alumni->jurusan_id == $jurusan->id) {{ 'selected' }}  @endif>{{ $jurusan->jurusan }}</option>
				@endforeach
			</select>
			@error('jurusan')
				<small class="form-text text-danger">{{ $message }}</small>
			@enderror
		</div>

		<div class="col-md-4 mb-3">
			<label for="tahun_lulus" class="text-dark">Tahun Lulus:</label>
			<select name="tahun_lulus" class="form-control @error('tahun_lulus') is-invalid @enderror">
				<option disabled selected>Pilih Tahun Lulus</option>
				@for($i = Carbon\Carbon::now()->year; $i >= 1980; $i--)
					<option value="{{ $i }}" @if($alumni->tahun_lulus == $i) {{ 'selected' }}  @endif>{{ $i }}</option>
				@endfor
			</select>
			@error('tahun_lulus')
				<small class="form-text text-danger">{{ $message }}</small>
			@enderror
		</div>

		<div class="col-md-3 mb-3">
			<label for="foto" class="text-dark">Foto Profil:</label>
			<input type="file" name="foto" class="form-control-file @error('foto') is-invalid @enderror">
			@error('foto')
				<small class="form-text text-danger">{{ $message }}</small>
			@enderror
		</div>

	</div>

</div>
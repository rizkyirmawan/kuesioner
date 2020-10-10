<div class="card-body">

	<div class="form-row">
		
		<div class="col-md-2 mb-3">
			<label for="kode" class="text-dark">Kode:</label>
			<input type="text" name="kode" class="form-control @error('kode') is-invalid @enderror" value="{{ old('kode') ?? $dosen->kode }}" maxlength="3">
			@error('kode')
				<small class="form-text text-danger">{{ $message }}</small>
			@enderror
		</div>

		<div class="col-md-2 mb-3">
			<label for="nidn" class="text-dark">NIDN:</label>
			<input type="text" name="nidn" class="form-control @error('nidn') is-invalid @enderror" onkeypress="isNumber(event)" value="{{ old('nidn') ?? $dosen->nidn }}">
			@error('nidn')
				<small class="form-text text-danger">{{ $message }}</small>
			@enderror
		</div>

		<div class="col-md-3 mb-3">
			<label for="nama" class="text-dark">Nama:</label>
			<input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama') ?? $dosen->nama }}">
			@error('nama')
				<small class="form-text text-danger">{{ $message }}</small>
			@enderror
		</div>

		<div class="col-md-5 mb-3">
			<label for="alamat" class="text-dark">Alamat:</label>
			<input type="text" name="alamat" class="form-control @error('alamat') is-invalid @enderror" value="{{ old('alamat') ?? $dosen->alamat }}">
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
				class="form-control @error('nomor_telepon') is-invalid @enderror" maxlength="11" onkeypress="isNumber(event)" value="{{ old('nomor_telepon') ?? Str::substr($dosen->nomor_telepon, 3) }}">
			</div>
			@error('nomor_telepon')
				<small class="form-text text-danger">{{ $message }}</small>
			@enderror
		</div>

		<div class="col-md-3 mb-3">
			<label for="email" class="text-dark">Email:</label>
			<input type="text" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ $dosen->user->email ?? old('email') }}">
			@error('email')
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
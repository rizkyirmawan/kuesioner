<table>
	<thead>
		<tr>
			<th style="border: 2px solid black;">nim</th>
			<th style="border: 2px solid black;">nama_mahasiswa</th>
			<th style="border: 2px solid black;">alamat</th>
			<th style="border: 2px solid black;">nomor_telepon</th>
			<th style="border: 2px solid black;">email</th>
			<th style="border: 2px solid black;">kelas_program</th>
			<th style="border: 2px solid black;">jurusan</th>
		</tr>
	</thead>
	<tbody>
		@foreach($mahasiswa as $mhs)
		<tr>
			<td>{{ $mhs->nim }}</td>
			<td>{{ $mhs->nama }}</td>
			<td>{{ $mhs->alamat }}</td>
			<td>{{ $mhs->nomor_telepon }}</td>
			<td>{{ $mhs->user->email }}</td>
			<td>
				@if($mhs->kelas->kode == 'REG-A')
					REGULER
				@elseif($mhs->kelas->kode == 'REG-B')
					KARYAWAN
				@else
					EKSEKUTIF
				@endif
			</td>
			<td>
				@if($mhs->jurusan->kode == 'IF')
					TEKNIK INFORMATIKA
				@elseif($mhs->jurusan->kode == 'SI')
					SISTEM INFORMASI
				@endif
			</td>
		</tr>
		@endforeach
	</tbody>
</table>
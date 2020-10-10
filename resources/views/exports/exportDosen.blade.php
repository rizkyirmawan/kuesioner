<table>
	<thead>
		<tr>
			<th style="border: 2px solid black;">kode</th>
			<th style="border: 2px solid black; text-align: left;">nidn</th>
			<th style="border: 2px solid black;">nama_dosen</th>
			<th style="border: 2px solid black;">alamat</th>
			<th style="border: 2px solid black;">nomor_telepon</th>
			<th style="border: 2px solid black;">email</th>
		</tr>
	</thead>
	<tbody>
		@foreach($dosen as $ds)
		<tr>
			<td>{{ $ds->kode }}</td>
			<td>{{ strval($ds->nidn) }}</td>
			<td>{{ $ds->nama }}</td>
			<td>{{ $ds->alamat }}</td>
			<td>{{ $ds->nomor_telepon }}</td>
			<td>{{ $ds->user->email }}</td>
		</tr>
		@endforeach
	</tbody>
</table>
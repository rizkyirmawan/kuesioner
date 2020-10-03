<table>
	<thead>
		<tr>
			<th style="font-weight: bold; border: 2px solid black; text-align: center;">No.</th>
			<th style="font-weight: bold; border: 2px solid black; text-align: center;">Dosen</th>
			<th style="font-weight: bold; border: 2px solid black; text-align: center;">Kelas</th>
			<th style="font-weight: bold; border: 2px solid black; text-align: center;">Mata Kuliah</th>
			<th style="font-weight: bold; border: 2px solid black; text-align: center;">Total Nilai</th>
		</tr>
	</thead>
	<tbody>
		@foreach($pembelajaran as $kuesioner)
		<tr>
			<td style="border: 2px solid black; text-align: center;">{{ $loop->iteration }}</td>
			<td style="border: 2px solid black;">{{ $kuesioner->studi->dosen->nama }}</td>
			<td style="border: 2px solid black;">{{ $kuesioner->studi->kelas->kelas }}</td>
			<td style="border: 2px solid black;">{{ $kuesioner->studi->matkul->kode . ': ' .$kuesioner->studi->matkul->mata_kuliah }}</td>
			<td style="border: 2px solid black;">{{ $kuesioner->respons->sum('jawaban.skor') . ' dari ' . $kuesioner->responden->count() . ' responden.' }}</td>
		</tr>
		@endforeach
	</tbody>
</table>
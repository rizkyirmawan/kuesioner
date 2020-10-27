<table>
	<tr>
		<td style="font-weight: bold; border: 2px solid black;">Kelas</td>
		<td style="border: 2px solid black;">: {{ $pembelajaran->studi->kelas->kelas }}</td>
	</tr>
	<tr>
		<td style="font-weight: bold; border: 2px solid black;">Dosen</td>
		<td style="border: 2px solid black;">: {{ $pembelajaran->studi->dosen->nama }}</td>
	</tr>
	<tr>
		<td style="font-weight: bold; border: 2px solid black;">Mata Kuliah</td>
		<td style="border: 2px solid black;">: {{ $pembelajaran->studi->matkul->mata_kuliah }}</td>
	</tr>
	<tr>
		<td style="font-weight: bold; border: 2px solid black;">Tahun Ajaran</td>
		<td style="border: 2px solid black;">: {{ $pembelajaran->tahunAjaran->semester . ' ' . $pembelajaran->tahunAjaran->tahun_ajaran }}</td>
	</tr>
</table>

<table>
	<thead>
		<tr>
			<th style="font-weight: bold; border: 2px solid black; text-align: center;">No.</th>
			<th style="font-weight: bold; border: 2px solid black; text-align: center;">Pertanyaan</th>
			<th style="font-weight: bold; border: 2px solid black; text-align: center;">Nilai</th>
		</tr>
	</thead>
	<tbody>
		@foreach($pembelajaran->pertanyaan as $pertanyaan)
		<tr>
			<td style="border: 2px solid black; text-align: center;">{{ $loop->iteration }}</td>
			<td style="border: 2px solid black;">{{ $pertanyaan->pertanyaan }}</td>
			<td style="border: 2px solid black; font-weight: bold; text-align: center;">{{ round($pertanyaan->respons->sum('jawaban.skor') / $pertanyaan->respons->count(), 1) }}</td>
		</tr>
		@endforeach
		<tr>
			<td colspan="2" style="font-weight: bold;">Total Nilai</td>
			<td style="font-weight: bold;">{{ $pembelajaran->respons->sum('jawaban.skor') <= 0 ? 0 : round($pembelajaran->respons->sum('jawaban.skor') / $pembelajaran->pertanyaan()->count(), 1) }}</td>
		</tr>
		<tr>
			<td colspan="2" style="font-weight: bold;">Total Responden</td>
			<td style="font-weight: bold;">{{ $pembelajaran->responden->count() }}</td>
		</tr>
	</tbody>
</table>
<table>
	<tr>
		<td style="font-weight: bold; border: 2px solid black;">Kuesioner</td>
		<td style="border: 2px solid black;">: {{ $kemahasiswaan->kuesioner }}</td>
	</tr>
	<tr>
		<td style="font-weight: bold; border: 2px solid black;">Tahun Ajaran</td>
		<td style="border: 2px solid black;">: {{ $kemahasiswaan->tahunAjaran->semester . ' ' . $kemahasiswaan->tahunAjaran->tahun_ajaran }}</td>
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
		@foreach($kemahasiswaan->pertanyaan as $pertanyaan)
		<tr>
			<td style="border: 2px solid black; text-align: center;">{{ $loop->iteration }}</td>
			<td style="border: 2px solid black;">{{ $pertanyaan->pertanyaan }}</td>
			<td style="border: 2px solid black; font-weight: bold; text-align: center;">{{ $pertanyaan->respons->sum('jawaban.skor') }}</td>
		</tr>
		@endforeach
		<tr>
			<td colspan="2" style="font-weight: bold;">Total Nilai</td>
			<td style="font-weight: bold;">{{ $kemahasiswaan->respons->sum('jawaban.skor') . ' dari ' . $kemahasiswaan->responden->count() . ' responden.' }}</td>
		</tr>
	</tbody>
</table>
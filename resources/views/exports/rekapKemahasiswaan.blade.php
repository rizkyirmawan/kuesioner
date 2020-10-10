<table>
	<thead>
		<tr>
			<th style="font-weight: bold; border: 2px solid black; text-align: center;">No.</th>
			<th style="font-weight: bold; border: 2px solid black; text-align: center;">Kuesioner</th>
			<th style="font-weight: bold; border: 2px solid black; text-align: center;">Tahun Ajaran</th>
			<th style="font-weight: bold; border: 2px solid black; text-align: center;">Total Nilai</th>
		</tr>
	</thead>
	<tbody>
		@foreach($kemahasiswaan as $kuesioner)
		<tr>
			<td style="border: 2px solid black; text-align: center;">{{ $loop->iteration }}</td>
			<td style="border: 2px solid black;">{{ $kuesioner->kuesioner }}</td>
			<td style="border: 2px solid black;">{{ $kuesioner->tahunAjaran->semester . ' ' . $kuesioner->tahunAjaran->tahun_ajaran }}</td>
			<td style="border: 2px solid black;">{{ $kuesioner->respons->sum('jawaban.skor') <= 0 ? 0 : round($kuesioner->respons->sum('jawaban.skor') / $kuesioner->pertanyaan()->count(), 1) . ' dari ' . $kuesioner->responden->count() . ' responden.' }}</td>
		</tr>
		@endforeach
	</tbody>
</table>
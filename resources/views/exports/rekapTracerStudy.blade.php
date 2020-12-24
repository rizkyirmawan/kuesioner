<table>
	<thead>
		<tr>
			<td colspan="6" style="text-align: center; font-weight: bold; font-size: 17;">Rekap Kuesioner Tracer Study Alumni Lulusan {{ $identitas->tahun_lulus }}</td>
		</tr>
		<tr>
			<th style="font-weight: bold; border: 2px solid black; text-align: center;">No.</th>
			<th style="font-weight: bold; border: 2px solid black; text-align: center;">Alumni</th>
			<th style="font-weight: bold; border: 2px solid black; text-align: center;">Angkatan</th>
			<th style="font-weight: bold; border: 2px solid black; text-align: center;">Tahun Lulus</th>
			<th style="font-weight: bold; border: 2px solid black; text-align: center;">Nama Perusahaan</th>
			<th style="font-weight: bold; border: 2px solid black; text-align: center;">Total Nilai</th>
		</tr>
	</thead>
	<tbody>
		@foreach($identitas->tracerStudy as $kuesioner)
		<tr>
			<td style="border: 2px solid black; text-align: center;">{{ $loop->iteration }}</td>
			<td style="border: 2px solid black;">{{ $kuesioner->user->userable->nim . ': ' . $kuesioner->user->userable->nama }}</td>
			<td style="border: 2px solid black; text-align: center;">{{ $kuesioner->user->userable->angkatan }}</td>
			<td style="border: 2px solid black; text-align: center;">{{ $kuesioner->user->userable->tahun_lulus }}</td>
			<td style="border: 2px solid black;">{{ $kuesioner->perusahaan . ' (' .$kuesioner->bidang . ')' }}</td>
			<td style="border: 2px solid black; font-weight: bold; text-align: center;">{{ $kuesioner->respons->sum('jawaban.skor') <= 0 ? 0 : round($kuesioner->respons->sum('jawaban.skor') / $kuesioner->responden()->count() / $kuesioner->pertanyaan->where('tipe', '!=', 'Text')->where('tipe', '!=', 'Textarea')->count(), 1) }}</td>
		</tr>
		@endforeach
	</tbody>
</table>
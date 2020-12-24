<table>
	<tr>
		<td style="font-weight: bold; border: 2px solid black;">Alumni</td>
		<td style="border: 2px solid black;">: {{ $tracerStudy->user->userable->nama }}</td>
	</tr>
	<tr>
		<td style="font-weight: bold; border: 2px solid black;">Angkatan</td>
		<td style="border: 2px solid black;">: {{ $tracerStudy->user->userable->angkatan }}</td>
	</tr>
	<tr>
		<td style="font-weight: bold; border: 2px solid black;">Tahun Lulus</td>
		<td style="border: 2px solid black;">: {{ $tracerStudy->user->userable->tahun_lulus }}</td>
	</tr>
	<tr>
		<td style="font-weight: bold; border: 2px solid black;">Perusahaan Terkait</td>
		<td style="border: 2px solid black;">: {{ $tracerStudy->perusahaan . ' (' . $tracerStudy->bidang . ')' }}</td>
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
		@foreach($tracerStudy->pertanyaan->where('tipe', '!=', 'Text')->where('tipe', '!=', 'Textarea') as $pertanyaan)
		<tr>
			<td style="border: 2px solid black; text-align: center;">{{ $loop->iteration }}</td>
			<td style="border: 2px solid black;">{{ $pertanyaan->pertanyaan }}</td>
			<td style="border: 2px solid black; font-weight: bold; text-align: center;">{{ round($pertanyaan->respons->sum('jawaban.skor') / $pertanyaan->respons->count(), 1) }}</td>
		</tr>
		@endforeach
		<tr>
			<td colspan="2" style="font-weight: bold;">Total Nilai</td>
			<td style="font-weight: bold;">{{ $tracerStudy->respons->sum('jawaban.skor') <= 0 ? 0 : round($tracerStudy->respons->sum('jawaban.skor') / $tracerStudy->responden()->count() / $tracerStudy->pertanyaan->where('tipe', '!=', 'Text')->where('tipe', '!=', 'Textarea')->count(), 1) }}</td>
		</tr>
	</tbody>
</table>
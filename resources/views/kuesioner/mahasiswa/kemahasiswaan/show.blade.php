@extends('app')

@section('content')
	<h1 class="h3 mb-2 text-gray-800">Pengisian Kuesioner</h1>
  <hr>
	
	<a href="{{ route('mahasiswa.kemahasiswaan', ['kemahasiswaan' => $kemahasiswaan]) }}" class="btn btn-dark btn-sm btn-icon-split mb-3">
    <span class="icon text-white-50">
      <i class="fas fa-arrow-left"></i>
    </span>
    <span class="text">Kembali</span>
  </a>

  <div class="card shadow mb-4">
    <div class="card-header py-3">
    	<h6 class="font-weight-bold text-primary">Detail Kuesioner Layanan Mahasiswa</h6>
    </div>
    <div class="card-body">
      <div class="text-center">
      	<h4 class="text-dark font-italic text-underline">{{ $kemahasiswaan->kuesioner }}</h4>
      </div>
      <hr>
      <div class="row">
        
        <div class="col-md-12">
          <table class="table table-bordered text-dark text-center">
            <tr>
              <th>Tahun Ajaran</th>
            </tr>
            <tr>
              <td>{{ $kemahasiswaan->tahunAjaran->semester . ' ' . $kemahasiswaan->tahunAjaran->tahun_ajaran }}</td>
            </tr>
          </table>
        </div>

      </div>
    </div>
  </div>

  <form action="{{ route('mahasiswa.kemahasiswaan.store', ['kemahasiswaan' => $kemahasiswaan]) }}" method="post">

    @csrf

    @foreach($kemahasiswaan->pertanyaan as $key => $pertanyaan)
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-dark">{{ $loop->iteration . '. ' . $pertanyaan->pertanyaan }}</h6>
      </div>
      <div class="card-body">
       
        @if($pertanyaan->tipe === 'Radio')
          @php $counter++ @endphp
          <ul class="list-group text-dark">
            @foreach($pertanyaan->jawaban as $jawaban)
            <label for="jawaban-{{ $jawaban->id }}">
              <li class="list-group-item">
                <input type="radio" name="respons[{{ $counter }}][jawaban_id]" id="jawaban-{{ $jawaban->id }}" value="{{ $jawaban->id }}" class="mr-2" required>
                {{ $jawaban->jawaban . ' (Nilai: ' . $jawaban->skor . ')' }}
                <input type="hidden" name="respons[{{ $counter }}][pertanyaan_id]" value="{{ $pertanyaan->id }}">
              </li>
            </label>
            @endforeach
          </ul>
        
        @elseif($pertanyaan->tipe === 'Checkbox')
          <ul class="list-group text-dark">
            @foreach($pertanyaan->jawaban as $jawaban)
            @php $counter++ @endphp
            <label for="jawaban-{{ $jawaban->id }}">
              <li class="list-group-item">
                <input type="checkbox" name="respons[{{ $counter }}][jawaban_id]" id="jawaban-{{ $jawaban->id }}" value="{{ $jawaban->id }}" class="mr-2">
                {{ $jawaban->jawaban . ' (Nilai: ' . $jawaban->skor . ')' }}
                <input type="hidden" name="respons[{{ $counter }}][pertanyaan_id]" value="{{ $pertanyaan->id }}">
              </li>
            </label>
            @endforeach
          </ul>
       
        @elseif($pertanyaan->tipe === 'Text')
          @php $counter++ @endphp
          <input type="text" name="respons[{{ $counter }}][jawaban_teks]" placeholder="Jawaban anda..." class="form-control" required>
          <input type="hidden" name="respons[{{ $counter }}][pertanyaan_id]" value="{{ $pertanyaan->id }}">
        
        @elseif($pertanyaan->tipe === 'Textarea')
          @php $counter++ @endphp
          <textarea rows="5" name="respons[{{ $counter }}][jawaban_teks]" placeholder="Jawaban anda..." class="form-control" required></textarea>
          <input type="hidden" name="respons[{{ $counter }}][pertanyaan_id]" value="{{ $pertanyaan->id }}">
        
        @endif

      </div>
    </div>
    @endforeach

    <div class="d-flex justify-content-end mb-3">
      @if($kemahasiswaan->pertanyaan)
      <button class="btn btn-primary btn-icon-split" type="submit">
        <span class="icon text-white-50">
          <i class="fas fa-check"></i>
        </span>
        <span class="text">Selesai</span>
      </button>
      @else
      <button class="btn btn-danger btn-icon-split disabled" type="submit">
        <span class="icon text-white-50">
          <i class="fas fa-times"></i>
        </span>
        <span class="text">Belum Ada Pertanyaan</span>
      </button>
      @endif
    </div>

  </form>

@endsection
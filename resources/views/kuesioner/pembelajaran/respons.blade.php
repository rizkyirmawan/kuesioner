@extends('app')

@section('content')
  <h1 class="h3 mb-2 text-gray-800">Respons Kuesioner Pembelajaran</h1>
  <hr>

  @include('partials._messages')

  <a href="{{ route('pembelajaran.show', ['pembelajaran' => $pembelajaran]) }}" class="btn btn-dark btn-sm btn-icon-split">
    <span class="icon text-white-50">
      <i class="fas fa-arrow-left"></i>
    </span>
    <span class="text">Kembali</span>
  </a>

  <div class="card shadow mb-3 mt-3">
    <div class="card-header py-3">
      <h6 class="font-weight-bold text-primary">Respons Kuesioner Pembelajaran</h6>
    </div>
    <div class="card-body">
      <div class="text-center">
        <h4 class="text-dark font-italic text-underline">{{ $pembelajaran->kuesioner }}</h4>
      </div>
      <hr>
      <div class="row">
        
        <div class="col-md-12">
          <table class="table table-bordered text-dark">
            <tr>
              <th>Kelas</th>
              <th>Dosen</th>
              <th>Mata Kuliah</th>
            </tr>
            <tr>
              <td>{{ $pembelajaran->studi->kelas->kelas }}</td>
              <td>{{ $pembelajaran->studi->dosen->nama }}</td>
              <td>{{ $pembelajaran->studi->matkul->mata_kuliah }}</td>
            </tr>
          </table>
        </div>

      </div>
    </div>
  </div>

  <div class="row">

    <div class="col-md-10 mx-auto">
      <div class="card shadow mt-3 mb-3">
        <div class="card-header">
          <h6 class="font-weight-bold text-dark">Responden</h6>
        </div>
        <div class="card-body">
          <ul class="list-group text-dark">
            @forelse($uniqueResponden as $responden)
            <li class="list-group-item">{{ $responden->user->userable->nim . ': ' .$responden->user->userable->nama }}</li>
            @empty
            <div class="text-center text-dark">
              <h6>Belum ada responden.</h6>
            </div>
            @endforelse
          </ul>
        </div>
      </div>
    </div>
    
    @foreach($pembelajaran->pertanyaan as $pertanyaan)
    <div class="col-md-10 mx-auto">
      <div class="card shadow mt-3 mb-3">
        <div class="card-header">
          <h6 class="font-weight-bold text-dark">{{ $loop->iteration . '. ' . $pertanyaan->pertanyaan }}</h6>
        </div>
        <div class="card-body">
          @if($pertanyaan->tipe === 'Radio' || $pertanyaan->tipe === 'Checkbox')
            <ul class="list-group text-dark">
              @foreach($pertanyaan->jawaban as $jawaban)
              <li class="list-group-item d-flex justify-content-between">
                <div>{{ $jawaban->jawaban }}</div>
                <div>{{ round($jawaban->respons->count() * 100 / ($pertanyaan->respons->count() ?? 1)) }}%</div>
              </li>
              @endforeach
            </ul>
          @else
            <ul class="list-group text-dark">
              @foreach($pertanyaan->respons as $respons)
              <li class="list-group-item">{{ $respons->jawaban_teks }}</li>
              @endforeach
            </ul>
          @endif
        </div>
      </div>
    </div>
    @endforeach

  </div>
@endsection

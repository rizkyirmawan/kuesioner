@extends('app')

@section('content')
  <h1 class="h3 mb-2 text-gray-800">Respons Kuesioner Pembelajaran</h1>
  <hr>

  @include('partials._messages')
  
  @if(Auth::user()->role->role === 'Admin')
  <a href="{{ route('pembelajaran.show', ['pembelajaran' => $pembelajaran]) }}" class="btn btn-dark btn-sm btn-icon-split">
  @else
  <a href="{{ route('dosen.pembelajaran.index') }}" class="btn btn-dark btn-sm btn-icon-split">
  @endif
    <span class="icon text-white-50">
      <i class="fas fa-arrow-left"></i>
    </span>
    <span class="text">Kembali</span>
  </a>

  <div class="card shadow mb-3 mt-3">
    <div class="card-header py-3">
      <div class="d-flex">
        <div class="mr-auto p-2">
          <h6 class="font-weight-bold text-primary">Respons Kuesioner Pembelajaran</h6>
        </div>
        <div class="p-2">
          <a href="{{ route('export.respons.pembelajaran', ['pembelajaran' => $pembelajaran]) }}" class="btn btn-success btn-sm btn-icon-split">
            <span class="icon text-white-50">
              <i class="fas fa-file-export"></i>
            </span>
            <span class="text">Export Excel</span>
          </a>
        </div>
      </div>
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
              <th>Tahun Ajaran</th>
              <th>Mata Kuliah</th>
              <th>Total Nilai</th>
            </tr>
            <tr>
              <td>{{ $pembelajaran->studi->kelas->kelas }}</td>
              <td>{{ $pembelajaran->studi->dosen->nama }}</td>
              <td>{{ $pembelajaran->tahunAjaran->semester . ' ' . $pembelajaran->tahunAjaran->tahun_ajaran }}</td>
              <td>{{ $pembelajaran->studi->matkul->mata_kuliah }}</td>
              <td>{{ $pembelajaran->respons->sum('jawaban.skor') <= 0 ? 0 : round($pembelajaran->respons->sum('jawaban.skor') / $pembelajaran->responden()->count() / $pembelajaran->pertanyaan()->count(), 1) . ' dari ' . $pembelajaran->responden->count() . ' responden.' }}</td>
            </tr>
          </table>
        </div>

      </div>
    </div>
  </div>

  <div class="tab-content">
    
    @foreach($questions as $chunk)
      <div class="row tab-pane fade @if($loop->iteration === 1) show active @endif" id="list-{{ $loop->iteration }}" role="tabpanel">

        @foreach($chunk as $pertanyaan)
        <div class="col-md-10 mx-auto">
          <div class="card shadow mt-3 mb-3">
            <div class="card-header">
              <h6 class="font-weight-bold text-dark">{{ ($loop->parent->iteration - 1) * 5 + $loop->index + 1 . '. ' . $pertanyaan->pertanyaan }} @if($pertanyaan->tipe === 'Radio' || $pertanyaan->tipe === 'Checkbox') <span class="badge badge-info"> {{ round($pertanyaan->respons->sum('jawaban.skor') / $pertanyaan->respons->count(), 1) }}</span> @endif</h6>
            </div>
            <div class="card-body">
              @if($pertanyaan->tipe === 'Radio' || $pertanyaan->tipe === 'Checkbox')
                <ul class="list-group text-dark">
                  @foreach($pertanyaan->jawaban as $jawaban)
                  <li class="list-group-item d-flex justify-content-between">
                    <div>{{ $jawaban->jawaban . ' (Nilai: ' . $jawaban->skor . ')' }}</div>
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
    @endforeach

  </div>

  <div class="row">
    <div class="col-md-10 mx-auto">
      <div class="d-flex justify-content-end">
        <div class="mb-3">
          <div class="list-group list-group-horizontal" id="list-tab" role="tablist">
            @foreach($questions as $chunk)
            <a class="list-group-item list-group-item-action @if($loop->iteration === 1) active @endif" id="list-{{ $loop->iteration }}-list" data-toggle="list" href="#list-{{ $loop->iteration }}" role="tab" aria-controls="{{ $loop->iteration }}">{{ $loop->iteration }}</a>
            @endforeach
          </div>
        </div>
      </div>   
    </div>
  </div>
@endsection

@extends('app')

@section('content')
  <h1 class="h3 mb-2 text-gray-800">Detail Kuesioner Pembelajaran</h1>
  <hr>

  @include('partials._messages')

  <div class="d-flex mb-2">
    <div class="mr-auto p-2">
      <a href="{{ route('tracerStudy.index') }}" class="btn btn-dark btn-sm btn-icon-split">
        <span class="icon text-white-50">
          <i class="fas fa-arrow-left"></i>
        </span>
        <span class="text">Kembali</span>
      </a>
    </div>
  </div>

  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <div class="d-flex">
        <div class="p-2 mr-auto">
          <h6 class="font-weight-bold text-primary">Detail Kuesioner Tracer Study</h6>
        </div>
      </div>
    </div>
    <div class="card-body">

      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>No.</th>
              <th>Alumni</th>
              <th>Angkatan</th>
              <th>Tahun Lulus</th>
              <th>Nama Perusahaan</th>
              <th>Respons</th>
            </tr>
          </thead>
          <tbody>

            @foreach($identitas->tracerStudy as $kuesioner)
            <tr>
              <td>{{ $loop->iteration }}.</td>
              <td>{{ $kuesioner->user->userable->nama }}</td>
              <td>{{ $kuesioner->user->userable->angkatan }}</td>
              <td>{{ $kuesioner->user->userable->tahun_lulus }}</td>
              <td>{{ $kuesioner->perusahaan }} <span class="badge badge-info">{{ $kuesioner->bidang }}</span></td>
              <td>
                <a href="{{ route('tracerStudy.respons', ['tracerStudy' => $kuesioner->id]) }}" class="btn btn-secondary btn-sm btn-icon-split @if($kuesioner->responden()->count() <= 0) disabled @endif">
                  <span class="icon text-white-50">
                    <i class="fas fa-eye text-white-50"></i>
                  </span>
                  <span class="text">Respons</span>
                </a>
              </td>
            </tr>
            @endforeach

          </tbody>
        </table>
      </div>
    </div>
  </div>
@endsection

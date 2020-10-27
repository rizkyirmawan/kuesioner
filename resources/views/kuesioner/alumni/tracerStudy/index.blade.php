@extends('app')

@section('content')

  @if($identitas)
  <h1 class="h3 mb-2 text-gray-800">Data Kuesioner Tracer Study</h1>
  <hr>

  @include('partials._messages')

  <div class="row">
    <div class="col-md-10 mx-auto">
      <div class="card shadow mb-4">
        <div class="card-header py-3">
    			<h6 class="font-weight-bold text-primary">Kuesioner Tracer Study</h6>
        </div>
        <div class="card-body">

          <table class="table table-bordered text-dark">
            <tr>
              <td class="font-weight-bold">Alumni Tertuju</td>
              <td>: {{ auth()->user()->userable->nim . ': ' . auth()->user()->userable->nama }}</td>
            </tr>
            <tr>
              <td class="font-weight-bold">Angkatan</td>
              <td>: {{ auth()->user()->userable->angkatan }}</td>
            </tr>
            <tr>
              <td class="font-weight-bold">Tahun Lulus</td>
              <td>: {{ auth()->user()->userable->tahun_lulus }}</td>
            </tr>
          </table>

          <div class="d-flex justify-content-end">
            @if(!$tracerStudy)
            <a href="{{ route('alumni.tracerStudy.identitas.create', ['identitas' => $identitas->id]) }}" class="btn btn-warning btn-sm btn-icon-split">
              <span class="icon text-white-50">
                <i class="fas fa-edit text-white-50"></i>
              </span>
              <span class="text">Isi Profil</span>
            </a>
            @else
            <h4>
              <span class="badge badge-pill badge-success">
                <i class="fa fa-check"></i>
              </span>
            </h4>
            @endif
          </div>

        </div>
      </div>
    </div>
  </div>
  @else
  <div class="row">
    <div class="col-md-10 mx-auto p-4">
      <div class="alert alert-warning fade show" role="alert">
        <strong>Oh tidak!</strong> Kuesioner tracer study belum ditemukan.
      </div>
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="font-weight-bold text-primary">Into the Void</h6>
        </div>
        <div class="card-body">
          <div class="text-center p-2">
            <img src="{{ asset('img/undraw_void_3ggu.svg') }}" width="400" class="img-fluid">
          </div>
        </div>
      </div>
    </div>
  </div>
  @endif
@endsection

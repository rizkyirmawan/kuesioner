@extends('app')

@section('content')
  <h1 class="h3 mb-2 text-gray-800">Data Kuesioner Tracer Study</h1>
  <hr>

  @include('partials._messages')

  <div class="card shadow mb-4">
    <div class="card-header py-3">
    	<div class="d-flex">
    		<div class="p-2">
    			<h6 class="font-weight-bold text-primary">Daftar Kuesioner</h6>
    		</div>
    	</div>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>No.</th>
              <th>Angkatan Tertuju</th>
              <th>Kelola</th>
            </tr>
          </thead>
          <tbody>

            @foreach($identitas as $kuesioner)
            <tr>
            	<td>{{ $loop->iteration }}.</td>
              <td>{{ $kuesioner->angkatan }}</td>
              <td>
                @if(!$tracerStudy)
								<a href="{{ route('alumni.tracerStudy.identitas.create', ['identitas' => $kuesioner]) }}" class="btn btn-warning btn-sm btn-icon-split">
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
              </td>
            </tr>
            @endforeach

          </tbody>
        </table>
      </div>
    </div>
  </div>
@endsection

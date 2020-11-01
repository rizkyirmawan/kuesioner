@extends('app')

@section('content')
  <h1 class="h3 mb-2 text-gray-800">Detail Kuesioner Layanan Mahasiswa</h1>
  <hr>

  @include('partials._messages')

  <div class="d-flex mb-2">
    <div class="mr-auto p-2">
      <a href="{{ route('kemahasiswaan.index') }}" class="btn btn-dark btn-sm btn-icon-split">
        <span class="icon text-white-50">
          <i class="fas fa-arrow-left"></i>
        </span>
        <span class="text">Kembali</span>
      </a>
    </div>
    <div class="p-2">
      <a href="{{ route('kemahasiswaan.edit', ['kemahasiswaan' => $kemahasiswaan]) }}" class="btn btn-success btn-sm btn-icon-split">
        <span class="icon text-white-50">
          <i class="fas fa-edit"></i>
        </span>
        <span class="text">Ubah</span>
      </a>
    </div>
    <div class="p-2">
      <a href="#" class="btn btn-danger btn-sm btn-icon-split" data-target="#deleteModal" data-toggle="modal">
        <span class="icon text-white-50">
          <i class="fas fa-trash"></i>
        </span>
        <span class="text">Hapus</span>
      </a>
    </div>
  </div>

  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <div class="d-flex">
        <div class="p-2 mr-auto">
          <h6 class="font-weight-bold text-primary">Detail Kuesioner Layanan Mahasiswa</h6>
        </div>
        <div class="p-2">
          <a href="{{ route('kemahasiswaan.respons', ['kemahasiswaan' => $kemahasiswaan]) }}" class="btn btn-secondary btn-sm btn-icon-split @if($kemahasiswaan->responden->count() <= 0) disabled @endif">
            <span class="icon text-white-50">
              <i class="fas fa-eye"></i>
            </span>
            <span class="text">Respons</span>
          </a>
        </div>
      </div>
    </div>
    <div class="card-body">
      <div class="row">
        
        <div class="col-md-6">
          <table class="table table-bordered text-dark">
            <tr>
              <th>Tahun</th>
              <td>{{ $kemahasiswaan->tahun }}</td>
            </tr>
            <tr>
              <th>Kuesioner</th>
              <td>{{ $kemahasiswaan->kuesioner }}</td>
            </tr>
            <tr>
              <th>Periode</th>
              <td class="text-justify">{{ Carbon\Carbon::parse($kemahasiswaan->awal)->translatedFormat('d F Y') . ' - ' . Carbon\Carbon::parse($kemahasiswaan->akhir)->translatedFormat('d F Y') }}</td>
            </tr>
            <tr>
              <th>Deskripsi</th>
              <td class="text-justify">{{ $kemahasiswaan->deskripsi }}</td>
            </tr>
          </table>
        </div>

        <div class="col-md-6">
          <h5 class="text-dark">Pertanyaan</h5>
          <hr>
          @forelse($kemahasiswaan->pertanyaan as $pertanyaan)
          <button class="btn btn-light btn-block mb-3" type="button" data-toggle="collapse" data-target="#collapse-{{ $pertanyaan->id }}">
            {{ $loop->iteration }}. {{ $pertanyaan->pertanyaan }}
          </button>
          <div class="collapse" id="collapse-{{ $pertanyaan->id }}">
            <div class="card card-body mb-3">

              <div class="d-flex flex-row-reverse mt-2 mb-2">
                <a href="#" class="btn btn-sm btn-danger p2" data-toggle="modal" data-target="#delete-{{ $pertanyaan->id }}">
                  <i class="fa fa-times"></i>
                </a>
                <a href="#" class="btn btn-sm btn-success p2 mr-2"  data-toggle="modal" data-target="#update-{{ $pertanyaan->id }}">
                  <i class="fa fa-edit"></i>
                </a>
              </div>

              @include('partials.modal._updatePertanyaanKemahasiswaan')
              @include('partials.modal._deletePertanyaanKemahasiswaan')

              <span class="badge badge-info mb-2">{{ $pertanyaan->tipe }}</span>
              <ol class="list-group text-dark">
                @foreach($pertanyaan->jawaban as $jawaban)
                <li class="list-group-item">{{ $jawaban->jawaban }}</li>
                @endforeach
              </ol>

              @if($pertanyaan->tipe === 'Text')
              <input class="form-control" type="text" disabled placeholder="Jawaban responden...">
              @elseif($pertanyaan->tipe === 'Textarea')
              <textarea rows="5" class="form-control" disabled placeholder="Jawaban responden..."></textarea>
              @endif

            </div>
          </div>
          @empty
          <div class="text-center">
            <h6 class="text-dark">Kuesioner ini belum memiliki pertanyaan.</h6>
          </div>
          @endforelse
        </div>

      </div>
    </div>
  </div>

  <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Hapus Data</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Hapus data kuesioner?</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
          <form action="{{ route('kemahasiswaan.destroy', ['kemahasiswaan' => $kemahasiswaan]) }}" method="post" class="d-inline">
            
            @method('delete')

            @csrf

            <button type="submit" class="btn btn-danger">Hapus</button>

          </form>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="pertanyaanDefaultModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tambah Pertanyaan Default</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Anda yakin untuk menambahkan pertanyaan default?</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
          <form action="{{ route('kemahasiswaan.default.create', ['kemahasiswaan' => $kemahasiswaan]) }}" method="post" class="d-inline">

            @csrf

            <button type="submit" class="btn btn-primary">Tambahkan</button>

          </form>
        </div>
      </div>
    </div>
  </div>
@endsection

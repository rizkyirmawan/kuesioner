@extends('app')

@section('content')
  <h1 class="h3 mb-2 text-gray-800">Detail Kuesioner Pembelajaran</h1>
  <hr>

  @include('partials._messages')

  <div class="d-flex mb-2">
    <div class="mr-auto p-2">
      <a href="{{ route('pembelajaran.index') }}" class="btn btn-dark btn-sm btn-icon-split">
        <span class="icon text-white-50">
          <i class="fas fa-arrow-left"></i>
        </span>
        <span class="text">Kembali</span>
      </a>
    </div>
    <div class="p-2">
      <a href="{{ route('pembelajaran.edit', ['pembelajaran' => $pembelajaran]) }}" class="btn btn-success btn-sm btn-icon-split">
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
          <h6 class="font-weight-bold text-primary">Detail Kuesioner Pembelajaran</h6>
        </div>
        <div class="p-2">
          <a href="{{ route('pembelajaran.respons', ['pembelajaran' => $pembelajaran]) }}" class="btn btn-secondary btn-sm btn-icon-split @if($pembelajaran->responden->count() <= 0) disabled @endif">
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
              <th>Kelas</th>
              <td>{{ $pembelajaran->studi->kelas->kelas }}</td>
            </tr>
            <tr>
              <th>Matkul</th>
              <td>{{ $pembelajaran->studi->matkul->mata_kuliah }}</td>
            </tr>
            <tr>
              <th>Dosen</th>
              <td>{{ $pembelajaran->studi->dosen->nama }}</td>
            </tr>
            <tr>
              <th>Tahun Ajaran</th>
              <td>{{ $pembelajaran->tahunAjaran->semester . ' ' . $pembelajaran->tahunAjaran->tahun_ajaran }}</td>
            </tr>
            <tr>
              <th>Kuesioner</th>
              <td>{{ $pembelajaran->kuesioner }}</td>
            </tr>
            <tr>
              <th>Deskripsi</th>
              <td class="text-justify">{{ $pembelajaran->deskripsi }}</td>
            </tr>
          </table>
        </div>

        <div class="col-md-6">
          <h5 class="text-dark">Pertanyaan</h5>
          <hr>
          @forelse($pembelajaran->pertanyaan as $pertanyaan)
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

              @include('partials.modal._updatePertanyaanPembelajaran')
              @include('partials.modal._deletePertanyaanPembelajaran')

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
          <form action="{{ route('pembelajaran.destroy', ['pembelajaran' => $pembelajaran]) }}" method="post" class="d-inline">
            
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
          <form action="{{ route('pembelajaran.default.create', ['pembelajaran' => $pembelajaran]) }}" method="post" class="d-inline">

            @csrf

            <button type="submit" class="btn btn-primary">Tambahkan</button>

          </form>
        </div>
      </div>
    </div>
  </div>
@endsection

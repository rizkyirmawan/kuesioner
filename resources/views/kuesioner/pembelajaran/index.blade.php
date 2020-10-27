@extends('app')

@section('content')
  <h1 class="h3 mb-2 text-gray-800">Data Kuesioner Pembelajaran</h1>
  <hr>

  @include('partials._messages')

  @if(Auth::user()->role->role === 'Admin')
  <div class="mb-3">
    <a href="#export-collapse" data-toggle="collapse" class="btn btn-success btn-sm btn-icon-split @if($pembelajaran->count() <= 0) disabled @endif">
      <span class="icon text-white-50">
        <i class="fas fa-file-export"></i>
      </span>
      <span class="text">Export Rekap</span>
    </a>
  </div>

  <div class="row">
    <div class="col-md-6">
      <div class="collapse" id="export-collapse">
        <div class="card card-body mb-3">
          <form action="{{ route('export.rekap.pembelajaran') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-row">

              <div class="col-md-6">
                <label for="excel" class="text-dark">Filter:</label>
                <select class="form-control" id="filter-select">
                  <option disabled selected>Filter Berdasarkan</option>
                  <option value="DS">Dosen</option>
                  <option value="MK">Mata Kuliah</option>
                </select>
              </div>

              <div class="col-md-6 d-none" id="dosen-div">
                <label for="excel" class="text-dark">Dosen:</label>
                <select class="form-control" name="dosen" id="dosen-select">
                  <option disabled selected>Pilih Dosen</option>
                  @foreach($dosenUnik as $dosen)
                  <option value="{{ $dosen['kode'] }}">{{ $dosen['nama'] }}</option>
                  @endforeach
                </select>
              </div>

              <div class="col-md-6 d-none" id="matkul-div">
                <label for="excel" class="text-dark">Mata Kuliah:</label>
                <select class="form-control" name="matkul" id="matkul-select">
                  <option disabled selected>Pilih Mata Kuliah</option>
                  @foreach($matkulUnik as $matkul)
                  <option value="{{ $matkul['kode'] }}">{{ $matkul['mata_kuliah'] }}</option>
                  @endforeach
                </select>
              </div>

            </div>
            <button class="btn btn-sm btn-success mt-3" type="submit">Export</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  @endif

  @if(Auth::user()->role->role === 'Dosen')
    <form action="{{ route('export.rekap.pembelajaran') }}" method="post" enctype="multipart/form-data">
      @csrf
      <div class="mb-3">
        <button type="submit" class="btn btn-success btn-sm btn-icon-split">
          <span class="icon text-white-50">
            <i class="fas fa-file-export"></i>
          </span>
          <span class="text">Export Rekap</span>
        </button>
      </div>
    </form>
  @endif

  <div class="card shadow mb-4">
    <div class="card-header py-3">
    	<div class="d-flex">
    		<div class="p-2">
    			<h6 class="font-weight-bold text-primary">Daftar Kuesioner</h6>
    		</div>
        @if(Auth::user()->role->role === 'Admin')
    		<div class="p-2 ml-auto">
	      	<a href="{{ route('pembelajaran.create') }}" class="btn btn-primary btn-sm btn-icon-split @if($studiCount <= 0) disabled @endif">
            <span class="icon text-white-50">
              <i class="fas fa-plus"></i>
            </span>
            <span class="text">Tambah Data</span>
          </a>
        </div>
        @endif
    	</div>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>No.</th>
              <th>Dosen</th>
              <th>Kelas</th>
              <th>Mata Kuliah</th>
              <th>Kelola</th>
            </tr>
          </thead>
          <tbody>

            @foreach($pembelajaran as $kuesioner)
            <tr>
            	<td>{{ $loop->iteration }}.</td>
              <td>{{ $kuesioner->studi->dosen->nama }}</td>
              <td>{{ $kuesioner->studi->kelas->kelas }}</td>
              <td>{{ $kuesioner->studi->matkul->kode . ': ' .$kuesioner->studi->matkul->mata_kuliah }}</td>
              <td>
                @if(Auth::user()->role->role === 'Admin')
								<a href="{{ route('pembelajaran.show', ['pembelajaran' => $kuesioner]) }}" class="btn btn-secondary btn-sm btn-icon-split">
                  <span class="icon text-white-50">
                    <i class="fas fa-eye text-white-50"></i>
                  </span>
                  <span class="text">Detail</span>
                </a>
                @else
                <a href="{{ route('pembelajaran.respons', ['pembelajaran' => $kuesioner]) }}" class="btn btn-secondary btn-sm btn-icon-split @if($kuesioner->responden->count() <= 0) disabled @endif">
                  <span class="icon text-white-50">
                    <i class="fas fa-eye text-white-50"></i>
                  </span>
                  <span class="text">Respons</span>
                </a>
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

@section('scripts')
<script>
  const filterSelect = document.querySelector('#filter-select');
  const dosenSelect = document.querySelector('#dosen-select');
  const matkulSelect = document.querySelector('#matkul-select');
  const dosenDiv = document.querySelector('#dosen-div');
  const matkulDiv = document.querySelector('#matkul-div');

  filterSelect.addEventListener('change', function() {
    switch(this.value) {
      case 'DS':
        dosenDiv.classList.remove('d-none');
        matkulDiv.classList.add('d-none');
        matkulSelect.selectedIndex = 0;
        break;
      case 'MK':
        matkulDiv.classList.remove('d-none');
        dosenDiv.classList.add('d-none');
        dosenSelect.selectedIndex = 0;
        break;
      default:
        break;
    }
  });
</script>
@endsection

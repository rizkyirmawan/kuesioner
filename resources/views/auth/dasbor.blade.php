@extends('app')

@section('content')
	<!-- Page Heading -->
	<h2 class="text-gray-800">Dasbor</h2>
	<hr>
	
	<div class="row">

		@if(Auth::user()->role->role === 'Admin')
	    <div class="col-xl-3 col-md-6 mb-4">
	      <div class="card border-left-warning shadow h-100 py-2">
	        <div class="card-body">
	          <div class="row no-gutters align-items-center">
	            <div class="col mr-2">
	              <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Tahun Ajaran Aktif</div>
	              <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $tahunAjaranAktif->semester . ' ' . $tahunAjaranAktif->tahun_ajaran }}</div>
	            </div>
	            <div class="col-auto">
	              <i class="fas fa-calendar fa-2x text-gray-300"></i>
	            </div>
	          </div>
	        </div>
	      </div>
	    </div>

	    <div class="col-xl-3 col-md-6 mb-4">
	      <div class="card border-left-primary shadow h-100 py-2">
	        <div class="card-body">
	          <div class="row no-gutters align-items-center">
	            <div class="col mr-2">
	              <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Evaluasi Pembelajaran</div>
	              <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $pembelajaran }} Kuesioner</div>
	            </div>
	            <div class="col-auto">
	              <i class="fas fa-book fa-2x text-gray-300"></i>
	            </div>
	          </div>
	        </div>
	      </div>
	    </div>

	    <div class="col-xl-3 col-md-6 mb-4">
	      <div class="card border-left-success shadow h-100 py-2">
	        <div class="card-body">
	          <div class="row no-gutters align-items-center">
	            <div class="col mr-2">
	              <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Layanan Mahasiswa</div>
	              <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $kemahasiswaan }} Kuesioner</div>
	            </div>
	            <div class="col-auto">
	              <i class="fas fa-user-graduate fa-2x text-gray-300"></i>
	            </div>
	          </div>
	        </div>
	      </div>
	    </div>

	    <div class="col-xl-3 col-md-6 mb-4">
	      <div class="card border-left-info shadow h-100 py-2">
	        <div class="card-body">
	          <div class="row no-gutters align-items-center">
	            <div class="col mr-2">
	              <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Tracer Study</div>
	              <div class="row no-gutters align-items-center">
	                <div class="col-auto">
	                  <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ $identitas }} Kuesioner</div>
	                </div>
	              </div>
	            </div>
	            <div class="col-auto">
	              <i class="fas fa-building fa-2x text-gray-300"></i>
	            </div>
	          </div>
	        </div>
	      </div>
	    </div>
	    @endif

		@if(Auth::user()->role->role === 'Alumni')
	    <div class="col-xl-6 col-md-6 mb-4">
	      <div class="card border-left-primary shadow h-100 py-2">
	        <div class="card-body">
	          <div class="row no-gutters align-items-center">
	            <div class="col mr-2">
	              <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Kuesioner Tracer Study</div>
	              <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $identitasAlumni }} Kuesioner</div>
	            </div>
	            <div class="col-auto">
	              <i class="fas fa-book fa-2x text-gray-300"></i>
	            </div>
	          </div>
	        </div>
	      </div>
	    </div>

	    <div class="col-xl-6 col-md-6 mb-4">
	      <div class="card border-left-info shadow h-100 py-2">
	        <div class="card-body">
	          <div class="row no-gutters align-items-center">
	            <div class="col mr-2">
	              <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Sudah Ditanggapi</div>
	              <div class="row no-gutters align-items-center">
	                <div class="col-auto">
	                  <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ $tracerStudyAlumni }} Kuesioner</div>
	                </div>
	              </div>
	            </div>
	            <div class="col-auto">
	              <i class="fas fa-building fa-2x text-gray-300"></i>
	            </div>
	          </div>
	        </div>
	      </div>
	    </div>
	    @endif

		@if(Auth::user()->role->role === 'Mahasiswa')
	    <div class="col-xl-6 col-md-6 mb-4">
	      <div class="card border-left-primary shadow h-100 py-2">
	        <div class="card-body">
	          <div class="row no-gutters align-items-center">
	            <div class="col mr-2">
	              <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Kuesioner Evaluasi Pembelajaran</div>
	              <div class="h5 mb-0 font-weight-bold text-gray-800">{{ count($pembelajaranMahasiswa) }} Kuesioner</div>
	            </div>
	            <div class="col-auto">
	              <i class="fas fa-book fa-2x text-gray-300"></i>
	            </div>
	          </div>
	        </div>
	      </div>
	    </div>

	    <div class="col-xl-6 col-md-6 mb-4">
	      <div class="card border-left-info shadow h-100 py-2">
	        <div class="card-body">
	          <div class="row no-gutters align-items-center">
	            <div class="col mr-2">
	              <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Kuesioner Layanan Mahasiswa</div>
	              <div class="row no-gutters align-items-center">
	                <div class="col-auto">
	                  <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ $kemahasiswaan }} Kuesioner</div>
	                </div>
	              </div>
	            </div>
	            <div class="col-auto">
	              <i class="fas fa-building fa-2x text-gray-300"></i>
	            </div>
	          </div>
	        </div>
	      </div>
	    </div>
	    @endif

	    @if(Auth::user()->role->role === 'Dosen')
	    <div class="col-xl-6 col-md-6 mb-4">
	      <div class="card border-left-primary shadow h-100 py-2">
	        <div class="card-body">
	          <div class="row no-gutters align-items-center">
	            <div class="col mr-2">
	              <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Kuesioner Evaluasi Pembelajaran</div>
	              <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $pembelajaranDosen }} Kuesioner</div>
	            </div>
	            <div class="col-auto">
	              <i class="fas fa-book fa-2x text-gray-300"></i>
	            </div>
	          </div>
	        </div>
	      </div>
	    </div>

	    <div class="col-xl-6 col-md-6 mb-4">
	      <div class="card border-left-info shadow h-100 py-2">
	        <div class="card-body">
	          <div class="row no-gutters align-items-center">
	            <div class="col mr-2">
	              <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Jumlah Kelas Kuliah Diajar</div>
	              <div class="row no-gutters align-items-center">
	                <div class="col-auto">
	                  <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ $studiDosen }} Kelas</div>
	                </div>
	              </div>
	            </div>
	            <div class="col-auto">
	              <i class="fas fa-school fa-2x text-gray-300"></i>
	            </div>
	          </div>
	        </div>
	      </div>
	    </div>
	    @endif

	</div>
@endsection
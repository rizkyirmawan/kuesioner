@extends('app')

@section('content')

  @include('partials._messages')
  
  @if($tracerStudy->status == 0)
	<h1 class="h3 mb-2 text-gray-800">Pengisian Kuesioner</h1>
  <hr>

  <div class="card shadow mb-4">
    <div class="card-header py-3">
    	<h6 class="font-weight-bold text-primary">Detail Kuesioner Tracer Study</h6>
    </div>
    <div class="card-body">
      <div class="row">
        
        <div class="col-md-12">
          <table class="table table-bordered text-dark">
            <tr>
              <th>Alumni</th>
              <th>Perusahaan Tertuju</th>
              <th>Bidang Perusahaan</th>
            </tr>
            <tr>
              <td>{{ $tracerStudy->user->userable->nama }}</td>
              <td>{{ $tracerStudy->perusahaan }}</td>
              <td>{{ $tracerStudy->bidang }}</td>
            </tr>
          </table>
        </div>

      </div>
    </div>
  </div>

  <form action="{{ route('tracerStudy.store', ['tracerStudy' => $tracerStudy]) }}" method="post">

    @csrf

    <div class="tab-content" id="question-section">

      @foreach($questions as $chunk)
        <div class="tab-pane fade @if($loop->iteration === 1) show active @endif" id="list-{{ $loop->iteration }}" role="tabpanel"">

          @foreach($chunk as $key => $pertanyaan)
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-dark">{{ ($loop->parent->iteration - 1) * 5 + $loop->index + 1 . '. ' . $pertanyaan->pertanyaan }}</h6>
            </div>
            <div class="card-body">
             
              @if($pertanyaan->tipe === 'Radio')
                @php $counter++ @endphp
                <ul class="list-group text-dark">
                  @foreach($pertanyaan->jawaban as $jawaban)
                  <label for="jawaban-{{ $jawaban->id }}">
                    <li class="list-group-item">
                      <input type="radio" name="respons[{{ $counter }}][jawaban_id]" id="jawaban-{{ $jawaban->id }}" value="{{ $jawaban->id }}" class="mr-2" required>
                      {{ $jawaban->jawaban . ' (Nilai: ' . $jawaban->skor . ')'}}
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
          
        </div>
        @endforeach

    </div>

    <div class="d-flex mb-3">
      <div class="mr-auto p-2">
        <div class="list-group list-group-horizontal" id="list-tab" role="tablist">
          @foreach($questions as $chunk)
          <a class="list-group-item list-group-item-action @if($loop->iteration === 1) active @endif" id="list-{{ $loop->iteration }}-list" data-toggle="list" href="#list-{{ $loop->iteration }}" role="tab" aria-controls="{{ $loop->iteration }}">{{ $loop->iteration }}</a>
          @endforeach
        </div>
      </div>
      @if($tracerStudy->pertanyaan)
      <div class="p-2">
        <button class="btn btn-primary btn-icon-split" type="submit">
          <span class="icon text-white-50">
            <i class="fas fa-check"></i>
          </span>
          <span class="text">Selesai</span>
        </button>  
      </div>
      @else
      <div class="p-2">
        <button class="btn btn-danger btn-icon-split disabled" type="submit">
          <span class="icon text-white-50">
            <i class="fas fa-times"></i>
          </span>
          <span class="text">Belum Ada Pertanyaan</span>
        </button>
      </div>
      @endif
    </div>

  </form>
  @else
  <center>
    <img src="{{ asset('img/undraw_super_thank_you_obwk.svg') }}" class="img-fluid mb-4 mt-4" width="600">
  </center>
  @endif

@endsection

@section('scripts')
<script>
  const listTabs = document.querySelectorAll('#list-tab');

  listTabs.forEach(function(item) {
    item.addEventListener('click', function() {
      window.location = '#question-section';
    });
  });
</script>
@endsection
@component('mail::message')
# Dear Pimpinan {{ $tracerStudy->perusahaan }}

Dengan ini, kami ingin mengajak bapak/ibu pimpinan untuk mengisi kuesioner evaluasi Tracer Study berkaitan dengan alumni kami yang bekerja di instansi bapak/ibu atas nama {{ $tracerStudy->user->userable->nama }} guna mengetahui hasil studi selama masa perkuliahan. Silahkan menuju link dibawah untuk mengisi kuesioner dan masukkan kode berikut: <b>{{ $tracerStudy->kode }}</b>.

@component('mail::button', ['url' => route('tracerStudy.auth')])
Menuju Link
@endcomponent

Terima kasih,<br>
STMIK Bandung
@endcomponent

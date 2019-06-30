<h3>Formulir</h3>
<div>Nama Lengkap Pelamar: <input type="text" name="full_name" id="" value="@if(isset($full_name)) {{$full_name}} @endif"></div>
<div>Tanggal Lahir: <input type="date" name="date_of_birth" id="" value="@if(isset($date_of_birth)) {{$date_of_birth}} @endif"></div>
<div>Pendidikan Terakhir: <input type="text" name="education" id="" value="@if(isset($education)) {{$education}} @endif"></div>
<div>Unit Kerja: <input type="text" name="unit" id="" value="@if(isset($unit)) {{$unit}} @endif"></div>
<div>Posisi Yang Dilamar: <input type="text" name="position" id="" value="@if(isset($position)) {{$position}} @endif"></div>
<div>Nama Pewawancara: <input type="text" name="interviewer" id="" value="@if(isset($interviewer)) {{$interviewer}} @endif"></div>
<div>Tanggal Wawancara: <input type="date" name="date_of_interview" id="" value="@if(isset($date_of_interview)) {{$date_of_interview}} @endif"></div>
<h3>Kesimpulan</h3>
<div>Dapat disarankan <input type="radio" name="result" value="PASSED" @if(isset($result) && $result=='PASSED') checked @endif></div>
<div>Dipertimbangkan <input type="radio" name="result" value="RECONSIDERED" @if(isset($result) && $result=='RECONSIDERED') checked @endif></div>
<div>Tidak dapat disarankan <input type="radio" name="result" value="REJECTED" @if(isset($result) && $result=='REJECTED') checked @endif></div>
<h3>Perimbangan Hasil Wawancara</h3>
@for($i=0;$i<10;$i++)
<div>Kompetensi: <input type="text" name="competency[]" value="@if(isset($competencies[$i])) {{$competencies[$i]->competency}} @endif"> | Skor: <input type="number" name="score[]" value="@if(isset($competencies[$i])) {{$competencies[$i]->score}} @endif"> | Bukti Hasil Wawancara: <textarea name="evidence[]" cols="30" rows="1"></textarea></div>
@endfor
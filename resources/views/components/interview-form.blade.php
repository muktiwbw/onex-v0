<h3>Formulir</h3>
<div>Nama Lengkap Pelamar: <input type="text" name="full_name" id=""></div>
<div>Tanggal Lahir: <input type="date" name="date_of_birth" id=""></div>
<div>Pendidikan Terakhir: <input type="text" name="education" id=""></div>
<div>Unit Kerja: <input type="text" name="unit" id=""></div>
<div>Posisi Yang Dilamar: <input type="text" name="position" id=""></div>
<div>Nama Pewawancara: <input type="text" name="interviewer" id=""></div>
<div>Tanggal Wawancara: <input type="date" name="date_of_interview" id=""></div>
<h3>Kesimpulan</h3>
<div>Dapat disarankan <input type="radio" name="result" value="PASSED"></div>
<div>Dipertimbangkan <input type="radio" name="result" value="RECONSIDERED"></div>
<div>Tidak dapat disarankan <input type="radio" name="result" value="REJECTED"></div>
<h3>Perimbangan Hasil Wawancara</h3>
@for($i=0;$i<10;$i++)
<div>Kompetensi: <input type="text" name="competency[]"> | Skor: <input type="text" name="score[]"> | Bukti Hasil Wawancara: <textarea name="evidence" cols="30" rows="1"></textarea></div>
@endfor
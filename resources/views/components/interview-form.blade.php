<div class="row">
    <div class="col-md-4">
        <h3>Formulir</h3>
        <div class="form-group">
            <label>Nama Lengkap Pelamar</label>
            <input class="form-control" type="text" name="full_name" placeholder="Nama Lengkap">
        </div>
        <div class="form-group">
            <label>Tanggal Lahir</label>
            <input class="form-control" type="date" name="date_of_birth">
        </div>
        <div class="form-group">
            <label>Pendidikan Terakhir</label>
            <input class="form-control" type="text" name="education" placeholder="Pendidikan Terakhir">
        </div>
        <div class="form-group">
            <label>Unit Kerja</label>
            <input class="form-control" type="text" name="unit" placeholder="Unit Kerja">
        </div>
        <div class="form-group">
            <label>Posisi Yang Dilamar</label>
            <input class="form-control" type="text" name="position" placeholder="Posisi">
        </div>
        <div class="form-group">
            <label>Nama Pewawancara</label>
            <input class="form-control" type="text" name="interviewer" placeholder="Nama Pewawancara" value="{{Auth::user()->name}}" disabled>
        </div>
        <div class="form-group">
            <label>Tanggal Wawancara</label>
            <input class="form-control" type="date" name="date_of_interview">
        </div>

        <h3>Kesimpulan</h3>
        <div class="form-group">
            <div class="custom-control custom-checkbox ">
                <input type="radio" id="PASSED" name="PASSED" class="custom-control-input" value="PASSED">
                <label class="custom-control-label" for="PASSED">Dapat Disarankan</label>
            </div>
            <div class="custom-control custom-checkbox ">
                <input type="radio" id="RECONSIDERED" name="RECONSIDERED" class="custom-control-input" value="RECONSIDERED">
                <label class="custom-control-label" for="RECONSIDERED">Dipertimbangkan</label>
            </div>
            <div class="custom-control custom-checkbox ">
                <input type="radio" id="REJECTED" name="REJECTED" class="custom-control-input" value="REJECTED">
                <label class="custom-control-label" for="REJECTED">Tidak dapat disarankan</label>
            </div>
        </div>

    </div>
    <div class="col-md-8">
    <h3>Perimbangan Hasil Wawancara</h3>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col" class="text-center">Kompetensi</th>
                        <th scope="col" class="text-center">Skor</th>
                        <th scope="col" class="text-center">Bukti Hasil Wawancara</th>
                    </tr>
                </thead>
                <tbody>
                    @for($i = 0; $i < 10; $i++)
                        <tr>
                            <td>{{ $i+1 }}</td>
                            <td><input class="form-control" type="text" name="competency[]" placeholder="Isi Kompetensi"></td>
                            <td><input class="form-control" type="text" name="score[]" placeholder="Skor"></td>
                            <td><textarea class="form-control" name="evidence" cols="30" rows="1"></textarea></td>
                        </tr>
                    @endfor
                </tbody>
            </table>
        </div>
    </div>
</div>

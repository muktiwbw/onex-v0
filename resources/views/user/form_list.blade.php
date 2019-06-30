@extends('user.main')
@section('content')
    <h1 class="h3 mb-4 text-gray-800">Daftar Penilaian Pelamar</h1>

    <div class="row">
        <div class="col">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <a href="#" class="btn btn-success btn-sm text-white mb-4" title="Buat Penilaian"><i class="fas fa-plus"></i> Tambah Penilaian</a>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable_applicants" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Tanggal Lahir</th>
                                    <!-- <th>No. Hp</th> -->
                                    <th>Unit Kerja</th>
                                    <th>Posisi Yang Dilamar</th>
                                    <th>Tanggal Wawancara</th>
                                    <th>Print Data</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th>Fathur Rachman Saputro</th>
                                    <th>20 desember 1888</th>
                                    <!-- <th>No. Hp</th> -->
                                    <th>Staff</th>
                                    <th>Web Developer</th>
                                    <th>15-03-2020</th>
                                    <th><a href="#">Print Data</a></th>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
              </div>
        </div>
    </div>
@endsection
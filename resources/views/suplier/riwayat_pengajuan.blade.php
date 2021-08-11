<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Pengajuan</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('adminLTE/plugins/fontawesome-free/css/all.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('adminLTE/dist/css/adminlte.min.css')}}">
</head>

<body class="hold-transition sidebar-mini">
  <div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
      </ul>

      <!-- Right navbar links -->
      @include('suplier.setting')
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <img src="{{asset('adminLTE/dist/img/user2-160x160.jpg')}}" class="img-circle elevation-2" alt="User Image">
          </div>
          <div class="info">
            <a href="#" class="d-block">Nama Pengguna</a>
          </div>
        </div>

        <!-- Sidebar Menu -->
        @include('suplier.menu');
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Pengajuan Masuk</h1>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">

          <!-- /.row -->
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Daftar Pengajuan Masuk</h3>

                  <div class="card-tools">
                    <div class="input-group input-group-sm" style="width: 150px;">
                      <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                      <div class="input-group-append">
                        <button type="submit" class="btn btn-default">
                          <i class="fas fa-search"></i>
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                  <table class="table table-hover text-nowrap text-center">
                    <thead>
                      <tr>
                        <th>Nama Pengadaan</th>
                        <th>Gambar</th>
                        <th>Anggaran (IDR)</th>
                        <th>Proposal</th>
                        <th>Anggaran Pengajuan (IDR)</th>
                        <th>Suplier</th>
                        <th>Email</th>
                        <th>Alamat</th>
                        <th>Status Pengajuan</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($pengajuan as $p)
                      <tr>
                        <td>{{$p['nama_pengadaan']}}</td>
                        <td style="width:15%;"><img style="width:70%;" src="{{asset(Storage::url($p['gambar']))}}"></td>
                        <td>{{number_format($p['anggaran'],0,",",".")}}</td>
                        <td><a class="btn btn-primary" href="{{asset(Storage::url($p['proposal']))}}" target="_blank">Lihat Detail</a></td>
                        <td>{{number_format($p['anggaran_pengajuan'],0,",",".")}}</td>
                        <td>{{$p['nama_suplier']}}</td>
                        <td>{{$p['email_suplier']}}</td>
                        <td>{{$p['alamat_suplier']}}</td>
                        <td>
                          @if($p['status_pengajuan'] == 1)
                          Menunggu Konfirmasi
                          @endif
                          @if($p['status_pengajuan'] == 2)
                          Telah Diterima
                          <hr>
                          @if($p['laporan'] == "-")
                          <form method="post" action="/tambahLaporan" enctype="multipart/form-data">
                            {{csrf_field()}}
                            <input type="hidden" name="id_pengajuan" id="id_pengajuan" value="{{$p['id_pengajuan']}}">
                            <label for="laporan" class="btn btn-block btn-outline-info btn-flat">Laporan Pengajuan</label>
                            <input type="file" name="laporan" id="laporan" class="form-control" style="display:none" accept="application/pdf">
                            <button type="submit" class="btn btn-secondary">Upload</button>
                          </form>
                          @else
                          <a href="{{asset(Storage::url($p['laporan']))}}" class="btn btn-warning" target="_blank"><i class="fa fa-eye"></i>Lihat Laporan</a>
                          @endif
                          @endif
                          @if($p['status_pengajuan'] == 3)
                          Telah Selesai
                          @endif
                          @if($p['status_pengajuan'] == 0)
                          Ditolak
                          @endif
                        </td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
            </div>
          </div>

        </div><!-- /.container-fluid -->
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    @include('parsial.footer');
    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
  </div>
  <!-- ./wrapper -->

  <!-- jQuery -->
  <script src="{{asset('adminLTE/plugins/jquery/jquery.min.js')}}"></script>
  <!-- Bootstrap 4 -->
  <script src="{{asset('adminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <!-- AdminLTE App -->
  <script src="{{asset('adminLTE/dist/js/adminlte.min.js')}}"></script>
  <!-- SweetAlert2 -->
  <script src="{{asset('adminLTE/plugins/sweetalert2/sweetalert2.min.js')}}"></script>
  <!-- Toastr -->
  <script src="{{asset('adminLTE/plugins/toastr/toastr.min.js')}}"></script>
 >
<script>
  $(document).on("click", ".konfirmasi", function(event) {
      event.preventDefault();
      const url = $(this).attr('href');

      var answer = window.confirm("Yakin akan memproses data?");
      if (answer) {
        window.location.href = url;
      } else {

      }

    });

    $(function() {
      var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
      });
      @if(\Session::has('berhasil'))
      Toast.fire({
        icon: 'success',
        title: '{{Session::get('berhasil')}}'
      })
      @endif
      @if(\Session::has('gagal'))
      Toast.fire({
        icon: 'error',
        title: '{{Session::get('gagal')}}'
      })
      @endif
      @if(count($errors) > 0)
      Toast.fire({
        icon: 'error',
        title: '<ul>@foreach($errors->all() as $error)<li>{{$error}}</li>@endforeach</ul>'
      })
      @endif
    });
</script>
</body>

</html>
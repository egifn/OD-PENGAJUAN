@section('js')
<script type="text/javascript">
    

</script>
@stop

@extends('layouts.admin')

@section('title')
    <title>Ubah Username & Password</title>
@endsection

@section('content')


    
<main class="main">
     <!-- HIDE SIDEBAR -->
     <style type="text/css">
        .sidebar {
            left: -300px;
        }

        .toggle-sidebar #main,
        .toggle-sidebar #footer {
            margin-left: 0;
        }

        main,
        #footer {
            margin-left: 0px !important;
        }

        .sidebar-lg-show.sidebar-fixed .app-footer {
            margin-left:  0px !important;
        }

    </style>
    <!-- END HIDE SIDEBAR -->

    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item active">Ubah Username & Password</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
           
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-accent-primary">
                            <div class="card-header">
                                <h4 class="card-title">Ubah Username & Password</h4>
                            </div>
                            <div class="card-body">
                                <br>
                                <div class="row">
                                    <div class="col-md-12 mb-2">
                                        <h4 style="text-align: center;">Perubahan pada akun anda berhasil diubah.</h4>
                                        <h4 style="text-align: center;">Tekan tombol keluar, dan login kembali dengan menggunakan akun yang baru.</h4> 
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    
                                    <div class="col-md-12 mb-2">
                                        <h4 style="text-align: center;"><a class="btn btn-success btn" href="{{ route('logout') }}" onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                                            K e l u a r
                                        </a></h4>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
           
        </div>
    </div>
</main>




@endsection

@section('script')



@endsection





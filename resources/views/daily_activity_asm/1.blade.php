@extends('layouts.admin')

@section('title', 'List Activity')

@section('style')
<style>
    .nav-tabs .nav-link.active {
        font-weight: bold;
        background-color: #f8f9fa;
        border-color: #dee2e6 #dee2e6 #f8f9fa;
    }
    .table-responsive {
        margin-top: 15px;
    }
    .breadcrumb {
        padding: 0.75rem 1rem;
        background-color: #f8f9fa;
    }
</style>
@endsection

@section('content')
<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Activity</li>
        <li class="breadcrumb-item active">List Activity</li>
    </ol>

    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-md-12">
                    <ul class="nav nav-tabs" id="activityTabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="som-tab" data-toggle="tab" href="#som" role="tab" aria-controls="som" aria-selected="true">
                                SOM
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="ssd-tab" data-toggle="tab" href="#ssd" role="tab" aria-controls="ssd" aria-selected="false">
                                SSD
                            </a>
                        </li>
                    </ul>
                    <div class="card card-accent-primary">
                        <div class="card-body">
                            <!-- Tab Navigation -->

                            <!-- Create Activity Button -->
                            {{-- <div class="text-right mb-1">
                                <a href="{{ route('daily_activity.index') }}" class="btn btn-primary btn-sm">
                                    Buat Activity
                                </a>
                            </div> --}}

                            <!-- Session Messages -->
                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible fade show">
                                    {{ session('success') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger alert-dismissible fade show">
                                    {{ session('error') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif

                            <!-- Tab Content -->
                            <div class="tab-content" id="activityTabsContent">
                                <!-- SOM Tab -->
                                <div class="tab-pane fade show active" id="som" role="tabpanel" aria-labelledby="som-tab">
                                    <form action="{{ route('pengajuan/cari.cari') }}" method="get" class="mb-3">
                                        <div class="row justify-content-between">
                                            <div class="col-md-1">
                                                <div class="text-right mb-1">
                                                    <a href="{{ route('daily_activity.index') }}" class="btn btn-primary btn-sm">
                                                        Buat Activity
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="input-group">
                                                    <input type="text" id="tanggal" name="tanggal" 
                                                           class="form-control" 
                                                           value="{{ request()->tanggal }}"
                                                           placeholder="Pilih tanggal...">
                                                    <div class="input-group-append">
                                                        <button class="btn btn-outline-secondary" type="submit">
                                                            <i class="fa fa-search"></i> Cari
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>

                                    <div class="table-responsive">
                                        <table id="datatabel-som" class="table table-bordered table-hover table-sm">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th width="5%">No</th>
                                                    <th width="20%">Tanggal</th>
                                                    <th>Instruksi</th>
                                                    <th width="15%">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($data_som as $val)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $val->tanggal }}</td>
                                                    <td>{{ $val->instruksi }}</td>
                                                    <td class="text-center">
                                                        <a href="{{ route('daily_activity_asm/view.view', $val->id) }}" 
                                                           class="btn btn-sm btn-primary">
                                                            <i class="fa fa-eye"></i> Jawab
                                                        </a>
                                                    </td>
                                                </tr>
                                                @empty
                                                <tr>
                                                    <td colspan="4" class="text-center py-3">Tidak ada data SOM</td>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- SSD Tab -->
                                <div class="tab-pane fade" id="ssd" role="tabpanel" aria-labelledby="ssd-tab">
                                    <form action="{{ route('pengajuan/cari.cari') }}" method="get" class="mb-3">
                                        <div class="row justify-content-end">
                                            <div class="col-md-4">
                                                <div class="input-group">
                                                    <input type="text" id="tanggal_ssd" name="tanggal_ssd" 
                                                           class="form-control" 
                                                           value="{{ request()->tanggal_ssd }}"
                                                           placeholder="Pilih tanggal...">
                                                    <div class="input-group-append">
                                                        <button class="btn btn-outline-secondary" type="submit">
                                                            <i class="fa fa-search"></i> Cari
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>

                                    <div class="table-responsive">
                                        <table id="datatabel-ssd" class="table table-bordered table-hover table-sm">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th width="5%">No</th>
                                                    <th width="20%">Tanggal</th>
                                                    <th>Challenge</th>
                                                    <th width="15%">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($data_ssd as $val)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $val->tanggal }}</td>
                                                    <td>{{ $val->challenge }}</td>
                                                    <td class="text-center">
                                                        <a href="{{ route('daily_activity_asm/view.view', $val->id) }}" 
                                                           class="btn btn-sm btn-primary">
                                                            <i class="fa fa-eye"></i> Jawab
                                                        </a>
                                                    </td>
                                                </tr>
                                                @empty
                                                <tr>
                                                    <td colspan="4" class="text-center py-3">Tidak ada data SSD</td>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
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

@section('js')
<!-- Date Range Picker -->
<script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

<script>
    $(document).ready(function() {
        // Tab functionality
        $('#activityTabs a').on('click', function(e) {
            e.preventDefault();
            $(this).tab('show');
        });
        
        // Save active tab
        $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
            localStorage.setItem('lastTab', $(e.target).attr('href'));
        });
        
        // Load last active tab
        var lastTab = localStorage.getItem('lastTab');
        if (lastTab) {
            $('[href="' + lastTab + '"]').tab('show');
        }

        // Date range picker initialization
        $('#tanggal, #tanggal_ssd').daterangepicker({
            locale: {
                format: 'YYYY-MM-DD',
                applyLabel: 'Pilih',
                cancelLabel: 'Batal',
                fromLabel: 'Dari',
                toLabel: 'Sampai',
                customRangeLabel: 'Custom',
                daysOfWeek: ['Mg', 'Sn', 'Sl', 'Rb', 'Km', 'Jm', 'Sb'],
                monthNames: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 
                            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
                firstDay: 1
            },
            opens: 'right',
            autoUpdateInput: false
        });

        // Update input field when dates are selected
        $('#tanggal, #tanggal_ssd').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
        });

        // Clear input field when dates are cleared
        $('#tanggal, #tanggal_ssd').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });
    });
</script>
@endsection
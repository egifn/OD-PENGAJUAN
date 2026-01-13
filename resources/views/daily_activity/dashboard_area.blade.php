@extends('layouts.admin')

@section('title') 
    <title>Dashboard</title>
@endsection

@section('content')
<main class="main">
  <ol class="breadcrumb">
    <li class="breadcrumb-item">Home</li>
    <li class="breadcrumb-item">Activity</li>
    <li class="breadcrumb-item active">Dashboard Area DOM</li>
  </ol>

  <div class="container-fluid">
      <div class="animated fadeIn">
        <h2>Dashboard</h2>
      <!-- Filter -->
      <div class="row mb-3">
        <div class="col-md-4">
          <label>Pilih Area</label>
          <select id="areaSelect" class="form-control">
            <option value="">-- Pilih Area --</option>
            @foreach($areas as $a)
              <option value="{{ $a->id }}">{{ $a->area_name }}</option>
            @endforeach
          </select>
        </div>
      </div>

      <!-- Ringkasan -->
      <div id="areaSummary" class="row mb-3 d-none">
        <div class="col-md-4">
          <div class="card text-white bg-info">
            <div class="card-body text-center">
              <div class="text-value" id="totalInstruksi">0</div>
              <div>Total Instruksi</div>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card text-white bg-success">
            <div class="card-body text-center">
              <div class="text-value" id="totalTerjawab">0</div>
              <div>Terjawab</div>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card text-white bg-danger">
            <div class="card-body text-center">
              <div class="text-value" id="totalBelum">0</div>
              <div>Belum Terjawab</div>
            </div>
          </div>
        </div>
      </div>

      <!-- Depo Cards -->
      <div id="depoCards" class="row"></div>
    </div>
  </div>
</main>
@endsection

@section('js')
<script>
  $('#areaSelect').change(function () {
    const areaId = $(this).val();
    if (!areaId) {
      $('#areaSummary').addClass('d-none');
      $('#depoCards').empty();
      return;
    }

    $.ajax({
      url: "{{ route('daily_activity.dashboard_area.data') }}",
      type: "POST",
      data: { _token: '{{ csrf_token() }}', area_id: areaId },
      success: function (res) {
        // Tampilkan ringkasan
        $('#totalInstruksi').text(res.total_instruksi);
        $('#totalTerjawab').text(res.total_terjawab);
        $('#totalBelum').text(res.total_belum);
        $('#areaSummary').removeClass('d-none');

        // Render depo cards
        let html = '';
        res.depo_list.forEach(d => {
          html += `
            <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
              <div class="card h-100 shadow-sm">
                <div class="card-header bg-primary text-white">
                  <strong>${d.nama_depo}</strong>
                </div>
                <div class="card-body">
                  <ul class="list-unstyled mb-0">
                    <li><strong>Instruksi:</strong> ${d.instruksi}</li>
                    <li><strong>Terjawab:</strong> ${d.terjawab}</li>
                    <li><strong>Belum:</strong> ${d.belum_terjawab}</li>
                  </ul>
                </div>
              </div>
            </div>`;
        });
        $('#depoCards').html(html);
      },
      error: function () {
        alert('Gagal memuat data.');
      }
    });
  });
</script>
@endsection
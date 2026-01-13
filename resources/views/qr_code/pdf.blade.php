<style>
    @page { margin: 20px 1px 20px 45px; }
    body { margin: 0px; }
</style>
<div style="width: 100%">
    @php
    $no=1;
    @endphp
    @foreach ($qr_data as $data)
        @if($no++ % 2 == 0)
        <img style=" margin: 23px 34px 23px 5px;" src="data:image/png;base64, {!! base64_encode(QrCode::format('svg')->size(137)->generate($data->id)) !!} ">
        @else
        <img style=" margin: 23px 5px 23px 34px;" src="data:image/png;base64, {!! base64_encode(QrCode::format('svg')->size(137)->generate($data->id)) !!} ">
        @endif
    @endforeach
</div>
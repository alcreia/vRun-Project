@extends('layout.main')

@section('title')
    Registration |
@endsection

@section('content')

<div class="container py-4">
    <h1 class="text-center">Pembayaran Lomba</h1>
    <hr>
    <div class="container py-4">
        <h3>Pastikan data yang diisi telah benar!</h3>
        <table class="table">
            <tr>
                <th scope="row">Nama</th>
                <td>{{Auth::user()->name}}</td>
            </tr>
            <tr>
                <th scope="row">Jenis Kelamin</th>
                <td>{{Auth::user()->gender == 'L' ? "Laki-laki" : "Perempuan"}}</td>
            </tr>
            <tr>
                <th scope="row">Tanggal Lahir</th>
                <td>{{Carbon\Carbon::parse(Auth::user()->dateOfBirth)->format('j F Y')}}</td>
            </tr>
            <tr>
                <th scope="row">Angkatan</th>
                <td>{{Auth::user()->angkatan}}</td>
            </tr>
            <tr>
                <th scope="row">Email</th>
                <td>{{Auth::user()->email}}</td>
            </tr>
            <tr>
                <th scope="row">Nomor Telepon</th>
                <td>{{Auth::user()->phone}}</td>
            </tr>
            <tr>
                <th scope="row">Alamat</th>
                <td>{{Auth::user()->alamat}}</td>
            </tr>
            <tr>
                <th scope="row">Jenis Lomba</th>
                <td>{{Auth::user()->raceType == 'P' ? "Personal (3.33km)" : "Angkatan (300km)"}}</td>
            </tr>
        </table>
        <div class="row justify-content-end">
            <button id="pay-button" class="btn btn-primary btn-lg">>> Lanjut ke pembayaran</button>
        </div>
    </div>
</div>

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{env('MIDTRANS_CLIENT_ID')}}"></script>
<script type="text/javascript">
    document.getElementById('pay-button').onclick = function(){
        // SnapToken acquired from previous step
        snap.pay('<?=$snapToken ?? ''?>', {
            // Optional
            onSuccess: function (result) {
                location.reload();
            },
            // Optional
            onPending: function (result) {
                location.reload();
            },
            // Optional
            onError: function (result) {
                location.reload();
            },
        });
    };
</script>

@endsection

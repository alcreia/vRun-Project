@extends('layout.main')

@section('title')
    Registration |
@endsection

@section('content')

<div class="container py-4">
    <h1 class="text-center">Pembayaran Lomba</h1>
    <hr>

    <div class="container py-4" id="payPrev">
        <h3>Pastikan data yang diisi telah benar!</h3>
        <table class="table">
            <tr>
                <th scope="row">Nama</th>
                <td>{{$user->name}}</td>
            </tr>
            <tr>
                <th scope="row">Jenis Kelamin</th>
                <td>{{$user->gender == 'L' ? "Laki-laki" : "Perempuan"}}</td>
            </tr>
            <tr>
                <th scope="row">Usia</th>
                <td>{{$user->age}}</td>
            </tr>
            <tr>
                <th scope="row">Angkatan</th>
                <td>{{$user->angkatan}}</td>
            </tr>
            <tr>
                <th scope="row">Email</th>
                <td>{{Auth::user()->email}}</td>
            </tr>
            <tr>
                <th scope="row">Nomor Telepon</th>
                <td>{{$user->phone}}</td>
            </tr>
            
            <tr>
                <th scope="row">Alamat</th>
                <td>{{$user->alamat}}</td>
            </tr>
        </table>
        <div class="row justify-content-end">
            <button id="next-button" class="btn btn-primary btn-lg">>> Lanjut ke pembayaran</button>
        </div>
    </div>

    <div class="container py-4" style="display: none" id="payNext">
        <table class="table">
            <tr>
                <th scope="row">Jenis Lomba</th>
                <td>{{$raceType}}</td>
            </tr>
            <tr>
                <th scope="row">Biaya Lomba</th>
                <td>Rp {{number_format($racePrice)}}</td>
            </tr>
            <tr>
                <th scope="row">Jersey</th>
                <td>{{$jersey ?? "--"}}</td>
            </tr>
            <tr>
                <th scope="row">Biaya Jersey</th>
                <td>Rp {{number_format($jerseyPrice)}}</td>
            </tr>
            <tr>
                <th scope="row">Donasi Celeb Runner</th>
                <td>Rp {{number_format($donatePrice)}}</td>
            </tr>
        </table>
        <div class="row">
            <div class="col-md-6">
                <button id="prev-button" class="btn btn-primary btn-lg">Kembali</button>
            </div>
            <div class="col-md-6">
                <button id="pay-upload-button" class="btn btn-primary btn-lg">Upload Bukti Transfer</button>
                <button id="pay-midtrans-button" class="btn btn-primary btn-lg">Bayar Langsung</button>
            </div>
        </div>
    </div>
</div>

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{env('MIDTRANS_CLIENT_ID')}}"></script>

<script type="text/javascript">
    $(document).ready(function(){
        $('#next-button').click(function() {
            $('#payPrev').hide();
            $('#payNext').show(250);
        });
        
        $('#prev-button').click(function() {
            $('#payNext').hide();
            $('#payPrev').show(250);
        });
    });

    var payButton = document.getElementById('pay-midtrans-button');
    payButton.addEventListener('click', function () {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                snap.pay(this.responseText);
            }
        };
        xhttp.open("GET", "/payment/snap", true);
        xhttp.send();
    });
    
</script>
@endsection

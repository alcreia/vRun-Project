@extends('layout.main')

@section('title')
Registration |
@endsection

@section('content')

<div class="container py-4">
    <h1 class="text-center"> Registrasi Lomba Virtual Run </h1>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('register') }}" method="POST" class="px-5">
        @csrf
        <div class="form-group my-2">
            <label for="raceTypeSelect">Pilih kategori lomba</label>
            <select class="form-control" name="raceType" id="raceTypeSelect" required>
                <option value hidden>--- Pilih salah satu ---</option>
                @foreach ($category as $cat)
                    <option value={{$cat->id}} {{ old('raceType') == $cat->id ? 'selected' : '' }}>{{$cat->type}} (Rp {{number_format($cat->price)}})</option>    
                @endforeach
            </select>
        </div>
        <hr class="my-4">
        <div class="form-group">
            <label for="nameInput">Nama</label>
            <input type="text" class="form-control" id="nameInput" name="name" required value={{old('name')}}>
        </div>

        <div class="form-row my-2">
            <div class="form-group col-md-6">
                <label for="ageInput">Usia</label>
                <input type="text" class="form-control" id="ageInput" name="age" required value={{old('age')}}>
            </div>
            <div class="form-group col-md-6">
                <label for="genderInput">Jenis Kelamin</label>
                <select class="form-control" name="gender" id="genderInput">
                    <option value selected hidden>--- Pilih salah satu ---</option>
                    <option value="L" {{ old('gender') == "L" ? 'selected' : '' }}>Laki-laki</option>
                    <option value="P" {{ old('gender') == "P" ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>
        </div>
        <hr class="my-4">
        <div class="form-group">
            <fieldset>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="alumni" id="alumni_n" value=0>
                    <label class="form-check-label" for="alumni_n">Umum</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="alumni" id="alumni_y" value=1>
                    <label class="form-check-label" for="alumni_y">Alumni SMAN 3</label>
                </div>
            </fieldset>
        </div>
        <div class="form-group" id="angkatan-input" style="display: none">
            <label for="angkatanInput">Angkatan</label>
            <select name="angkatan" id="angkatanInput" class="form-control">
                <option value="Umum" selected hidden>--- Pilih salah satu ---</option>
                @for ($year = 2020; $year >=1953; $year--)
                <option value="{{$year}}" {{ old('angkatan') == $year ? 'selected' : '' }}>{{$year}}</option>
                @endfor
            </select>
        </div>

        <hr class="my-4">
        <div class="form-row my-2">
            <div class="form-group col-md-6">
                <label for="emailInput">Email</label>
                <input type="email" class="form-control" id="emailInput" name="email" required value={{old('email')}}>
            </div>

            <div class="form-group col-md-6">
                <label for="phoneInput">Nomor HP</label>
                <input type="tel" class="form-control" id="phoneInput" name="phone" required value={{old('phone')}}>
            </div>
        </div>

        <div class="form-row my-2">
            <div class="form-group col-md-6">
                <label for="passwordInput">Password</label>
                <input type="password" class="form-control" id="passwordInput" name="password" required>
                <small id="passwordHelpBlock" class="form-text text-muted">
                    Minimal 8 huruf
                </small>
            </div>

            <div class="form-group col-md-6">
                <label for="password-confirm">Konfirmasi Password</label>
                <input type="password" class="form-control" id="password-confirm" name="password_confirmation" required>
            </div>
        </div>

        <div class="form-group my-2">
            <label for="alamatInput">Alamat</label>
            <textarea class="form-control" id="alamatInput" name="alamat" rows="3" required
                value={{old('alamat')}}></textarea>
        </div>

        <hr class="my-4">
        <div class="form-group">
            <fieldset>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="buy_jersey" id="buy_y" value=1>
                    <label class="form-check-label" for="buy_y">Beli Jersey</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="buy_jersey" id="buy_n" value=0>
                    <label class="form-check-label" for="buy_n">Tidak Beli Jersey</label>
                </div>
            </fieldset>
        </div>
        <div class="form-group" id="jersey-input" style="display: none">
            <label for="shirtInput">Ukuran Jersey</label>
            <select class="form-control" name="jersey" id="shirtInput">
                <option value selected hidden>--- Pilih salah satu ---</option>
                @foreach ($jersey as $j)
                    <option value={{$j->size}} {{ old('shirt') == $j->size ? 'selected' : '' }}>{{$j->size}} (Rp {{number_format($j->price)}})</option>    
                @endforeach
            </select>
        </div>

        <div class="form-group" id="donation-input">
            <label for="donation">Donasi Untuk Celeb Runner?</label>
            <select class="form-control" name="donation" id="donation">
                <option value selected>Tidak ada</option>
                @foreach ($donations as $don)
                    <option value={{$don->id}} {{ old('donation') == $don->id ? 'selected' : '' }}>{{$don->celeb_name}} (Rp {{number_format($don->price)}} / km)
                    </option>    
                @endforeach
            </select>
        </div>


        <div class="form-check my-2">
            <input type="checkbox" class="form-check-input" value="" id="agreeHealth">
            <label for="agreeHealth"><a href="#" data-toggle="modal" data-target="#healthAgreementModal">Saya sudah
                    membaca dan menyetujui pernyataan kesehatan berikut ini</a></label>
        </div>

        <div class="form-group my-5 row justify-content-end">
            <button type="submit" class="btn btn-primary btn-lg">>> Lanjut ke Pembayaran</button>
        </div>
    </form>

    <div class="modal fade" id="healthAgreementModal" tabindex="-1" role="dialog" aria-labelledby="healthModalTitle"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="healthModalTitle">Pernyataan Kesehatan Peserta</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur ut est hendrerit sem commodo
                        finibus in et eros. Nam imperdiet velit quis fermentum pulvinar. Fusce convallis lacus ut felis
                        efficitur lobortis. Sed faucibus nec tortor sit amet dictum. Donec odio felis, aliquam ut nisi
                        vitae, tincidunt finibus nisl. Aenean finibus turpis at tortor condimentum tempus. Pellentesque
                        tristique elementum sollicitudin. Aliquam dui mauris, viverra quis risus et, bibendum vulputate
                        nulla. Sed euismod semper tincidunt. Donec viverra a dui quis tincidunt. Pellentesque eget felis
                        blandit, varius nibh non, pellentesque urna. Nullam scelerisque dignissim pulvinar. Suspendisse
                        ultrices convallis augue venenatis fermentum.
                        <br>
                        Duis sagittis rhoncus pulvinar. Cras et massa sit amet ligula scelerisque commodo eget ac quam.
                        Cras blandit ante ligula, vehicula viverra est sodales in. Praesent porttitor tortor turpis, eu
                        mattis orci pellentesque non. In hendrerit rutrum elit, id fermentum lectus rutrum eget.
                        Maecenas sit amet nisi quam. Duis a purus nisi. Vestibulum purus massa, posuere eget condimentum
                        a, molestie eget neque. Proin accumsan in felis id consectetur. Etiam malesuada tellus metus,
                        non interdum arcu hendrerit vitae.
                        <br>
                        Vestibulum a sem in tellus semper egestas. Cras at mauris vitae neque luctus rhoncus. Aliquam eu
                        velit eros. Aenean nulla orci, posuere eget diam sed, maximus dapibus tellus. Mauris vitae diam
                        eros. Aliquam tincidunt mollis eros. Suspendisse potenti. Sed fermentum viverra purus, ut
                        pellentesque nulla vehicula at. Sed nulla purus, tincidunt faucibus auctor eget, semper eu
                        mauris. Vestibulum leo neque, efficitur interdum tempor quis, commodo sit amet sapien.
                        <br>
                        Integer lobortis id mi ut venenatis. Sed finibus vehicula quam, suscipit eleifend quam aliquam
                        eu. Curabitur at rhoncus lectus. Nulla a ultrices ex, maximus tempor lectus. Orci varius natoque
                        penatibus et magnis dis parturient montes, nascetur ridiculus mus. Etiam sed condimentum urna,
                        ut facilisis dui. Vivamus mattis felis in maximus semper. Sed vel viverra diam. Phasellus a
                        scelerisque ipsum, in consectetur dui. Sed eget magna venenatis, molestie ligula quis, aliquet
                        justo. Morbi et sagittis diam.
                        <br>
                        Donec pretium nulla sed mi semper, quis lobortis lacus varius. Integer egestas auctor dictum.
                        Cras sit amet nunc id eros tempor ultricies eget vitae purus. Class aptent taciti sociosqu ad
                        litora torquent per conubia nostra, per inceptos himenaeos. Morbi a lectus enim. Integer semper
                        enim at mi mattis, quis finibus est suscipit. Etiam porttitor justo ac dui suscipit vulputate.
                        Phasellus venenatis sit amet risus vitae cursus. Nullam eleifend nibh velit, mollis placerat
                        metus semper non. Nulla iaculis luctus vulputate. Quisque tristique metus a massa pharetra
                        commodo id non velit. Sed iaculis vehicula nisi, sit amet dictum eros blandit vel. Morbi
                        suscipit nibh eget nulla posuere, vel sollicitudin libero iaculis. Nullam eu lacus dui. Aenean
                        dignissim porta gravida.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(function () {
        $('input[name="alumni"]').click(function () {
            if ($('#alumni_y').is(':checked')) {
                $('#angkatan-input').show(500);
                $('#angkatanInput').prop('selectedIndex', 0);
            } else {
                $('#angkatan-input').hide(500);
            };
        });
    });
    $(function () {
        $('input[name="buy_jersey"]').click(function () {
            if ($('#buy_y').is(':checked')) {
                $('#jersey-input').show(500);
                $('#shirtInput').prop('selectedIndex', 0);
            } else {
                $('#jersey-input').hide(500);
            };
        });
    });

</script>


@endsection

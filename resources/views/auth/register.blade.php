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
                <option>--- Pilih salah satu ---</option>
                <option value="P" {{ old('raceType') == "P" ? 'selected' : '' }}>Personal (3,33km)</option>
                <option value="A" {{ old('raceType') == "A" ? 'selected' : '' }}>Angkatan (300km)</option>
            </select>
        </div>
        <hr class="my-4">
        <div class="form-row my-2">
            <div class="form-group col-md-6">
                <label for="firstNameInput">Nama</label>
                <input type="text" class="form-control" id="firstNameInput" name="firstName" required value={{old('firstName')}}>
            </div>

            <div class="form-group col-md-6">
                <label for="lastNameInput">Nama Belakang</label>
                <input type="text" class="form-control" id="lastNameInput" name="lastName" required value={{old('lastName')}}>
            </div>
        </div>

        <div class="form-row my-2">
            <div class="form-group col-md-4">
                <label for="genderInput">Jenis Kelamin</label>
                <select class="form-control" name="gender" id="genderInput">
                    <option>--- Pilih salah satu ---</option>
                    <option value="L" {{ old('gender') == "L" ? 'selected' : '' }}>Laki-laki</option>
                    <option value="P" {{ old('gender') == "P" ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>

            <div class="form-group col-md-4">
                <label for="dobInput">Tanggal Lahir</label>
                <input type="date" class="form-control" id="dobInput" name="dateOfBirth" required value={{old('dateOfBirth')}}>
            </div>

            <div class="form-group col-md-4">
                <label for="angkatanInput">Angkatan</label>
                <select name="angkatan" id="angkatanInput" class="form-control">
                    <option>--- Pilih salah satu ---</option>
                    @for ($year = 2020; $year >=1953; $year--)
                        <option value="{{$year}}" {{ old('angkatan') == $year ? 'selected' : '' }}>{{$year}}</option>
                    @endfor
                </select>
            </div>
        </div>

        <div class="form-row my-2">
            <div class="form-group col-md-6">
                <label for="bloodInput">Golongan Darah</label>
                <select class="form-control" name="blood" id="bloodInput">
                    <option>--- Pilih salah satu ---</option>
                    <option value="A+" {{ old('blood') == "A+" ? 'selected' : '' }}>A+</option>
                    <option value="A-" {{ old('blood') == "A-" ? 'selected' : '' }}>A-</option>
                    <option value="B+" {{ old('blood') == "B+" ? 'selected' : '' }}>B+</option>
                    <option value="B-" {{ old('blood') == "B-" ? 'selected' : '' }}>B-</option>
                    <option value="O+" {{ old('blood') == "O+" ? 'selected' : '' }}>O+</option>
                    <option value="O-" {{ old('blood') == "O-" ? 'selected' : '' }}>O-</option>
                    <option value="AB+" {{ old('blood') == "AB+" ? 'selected' : '' }}>AB+</option>
                    <option value="AB-" {{ old('blood') == "AB-" ? 'selected' : '' }}>AB-</option>
                </select>
            </div>

            <div class="form-group col-md-6">
                <label for="shirtInput">Ukuran Jersey</label>
                <select class="form-control" name="shirt" id="shirtInput">
                    <option>--- Pilih salah satu ---</option>
                    <option value="XS" {{ old('shirt') == "XS" ? 'selected' : '' }}>XS</option>
                    <option value="S" {{ old('shirt') == "S" ? 'selected' : '' }}>S</option>
                    <option value="M" {{ old('shirt') == "M" ? 'selected' : '' }}>M</option>
                    <option value="L" {{ old('shirt') == "L" ? 'selected' : '' }}>L</option>
                    <option value="XL" {{ old('shirt') == "XL" ? 'selected' : '' }}>XL</option>
                    <option value="XXL" {{ old('shirt') == "XXL" ? 'selected' : '' }}>XXL</option>
                </select>
            </div>
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
                <label for="passwordValidate">Konfirmasi Password</label>
                <input type="password" class="form-control" id="password-confirm" name="password_confirmation" required>
            </div>
        </div>

        <div class="form-group my-2">
            <label for="alamatInput">Alamat</label>
            <textarea class="form-control" id="alamatInput" name="alamat" rows="3" required value={{old('alamat')}}></textarea>
        </div>

        <div class="form-check my-2">
            <input type="checkbox" class="form-check-input" value="" id="agreeHealth">
            <label for="agreeHealth"><a href="#" data-toggle="modal" data-target="#healthAgreementModal">Saya sudah membaca dan menyetujui pernyataan kesehatan berikut ini</a></label>
        </div>

        <div class="form-group my-5 row justify-content-end">
            <button type="submit" class="btn btn-primary btn-lg">>> Lanjut ke Pembayaran</button>
        </div>

    </form>

    <div class="modal fade" id="healthAgreementModal" tabindex="-1" role="dialog" aria-labelledby="healthModalTitle" aria-hidden="true">
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
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur ut est hendrerit sem commodo finibus in et eros. Nam imperdiet velit quis fermentum pulvinar. Fusce convallis lacus ut felis efficitur lobortis. Sed faucibus nec tortor sit amet dictum. Donec odio felis, aliquam ut nisi vitae, tincidunt finibus nisl. Aenean finibus turpis at tortor condimentum tempus. Pellentesque tristique elementum sollicitudin. Aliquam dui mauris, viverra quis risus et, bibendum vulputate nulla. Sed euismod semper tincidunt. Donec viverra a dui quis tincidunt. Pellentesque eget felis blandit, varius nibh non, pellentesque urna. Nullam scelerisque dignissim pulvinar. Suspendisse ultrices convallis augue venenatis fermentum.
                    <br>
                    Duis sagittis rhoncus pulvinar. Cras et massa sit amet ligula scelerisque commodo eget ac quam. Cras blandit ante ligula, vehicula viverra est sodales in. Praesent porttitor tortor turpis, eu mattis orci pellentesque non. In hendrerit rutrum elit, id fermentum lectus rutrum eget. Maecenas sit amet nisi quam. Duis a purus nisi. Vestibulum purus massa, posuere eget condimentum a, molestie eget neque. Proin accumsan in felis id consectetur. Etiam malesuada tellus metus, non interdum arcu hendrerit vitae.
                    <br>
                    Vestibulum a sem in tellus semper egestas. Cras at mauris vitae neque luctus rhoncus. Aliquam eu velit eros. Aenean nulla orci, posuere eget diam sed, maximus dapibus tellus. Mauris vitae diam eros. Aliquam tincidunt mollis eros. Suspendisse potenti. Sed fermentum viverra purus, ut pellentesque nulla vehicula at. Sed nulla purus, tincidunt faucibus auctor eget, semper eu mauris. Vestibulum leo neque, efficitur interdum tempor quis, commodo sit amet sapien.
                    <br>
                    Integer lobortis id mi ut venenatis. Sed finibus vehicula quam, suscipit eleifend quam aliquam eu. Curabitur at rhoncus lectus. Nulla a ultrices ex, maximus tempor lectus. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Etiam sed condimentum urna, ut facilisis dui. Vivamus mattis felis in maximus semper. Sed vel viverra diam. Phasellus a scelerisque ipsum, in consectetur dui. Sed eget magna venenatis, molestie ligula quis, aliquet justo. Morbi et sagittis diam.
                    <br>
                    Donec pretium nulla sed mi semper, quis lobortis lacus varius. Integer egestas auctor dictum. Cras sit amet nunc id eros tempor ultricies eget vitae purus. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Morbi a lectus enim. Integer semper enim at mi mattis, quis finibus est suscipit. Etiam porttitor justo ac dui suscipit vulputate. Phasellus venenatis sit amet risus vitae cursus. Nullam eleifend nibh velit, mollis placerat metus semper non. Nulla iaculis luctus vulputate. Quisque tristique metus a massa pharetra commodo id non velit. Sed iaculis vehicula nisi, sit amet dictum eros blandit vel. Morbi suscipit nibh eget nulla posuere, vel sollicitudin libero iaculis. Nullam eu lacus dui. Aenean dignissim porta gravida.
                </p>
            </div>
          </div>
        </div>
      </div>
</div>

@endsection

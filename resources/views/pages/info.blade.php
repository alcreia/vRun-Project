@extends('layout.main')

@section('title')
    About |
@endsection

@section('content')

<div class='container'>
    <section class="px-5 py-5 mx-auto col-md-8">
        <h1 class="text-center">Informasi Lomba Virtual Run</h1>
        <p class="text-justify my-4">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec quis lectus at nulla venenatis consectetur. In auctor sagittis felis, et consequat augue dapibus a. Nam risus ante, luctus sed tellus id, condimentum mollis sem. Morbi enim felis, fringilla vitae aliquam sollicitudin, posuere nec nisl. Etiam quis dolor maximus, tempor erat condimentum, vestibulum orci. In at fringilla leo. In hendrerit urna eget neque consequat, at accumsan turpis tempor. Integeer interdum tristique ipsum nec egestas. Sed ex enim, posuere id velit sit amet, maximus ornare sem. In a arcu nec lacus iaculis pretium et vel metus.
        </p>
        @if ($message = Session::get('success'))
            <div class="alert alert-success alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>
                    {{ $message }}
            </div>
        @endif
        <div class="justify-content-center">
        @guest
            <a role="button" class="btn btn-danger btn-lg btn-block" href="/register">Daftar Sekarang!</a>
        @else
            @if(DB::table('participants')->where('user_id', Auth::id())->first())
                <h3>Progres Anda</h3>
                <p class="huge-text text-center">{{DB::table('participants')->where('user_id', Auth::id())->value('jarak')}}km / 3.00km</p>
                <a role="button" class="btn btn-danger btn-lg btn-block" href="#" data-toggle="modal" data-target="#fileUpload">
                    <p>Upload hasil anda!</p>
                </a>
            @else
                <a role="button" class="btn btn-danger btn-lg btn-block" href="/payment">Lanjutkan Pembayaran Anda!</a>
            @endif
        @endguest
        </div>
    </section>
    <hr>
    <section class="px-5 py-5 mx-auto col-md-10">
        <h2 class="text-center">Kategori Lomba Virtual Run</h2>
        <div class="row">
            <div class="col-md-5 info-category">
                <p class="huge-text text-center">3km</p>
                <h3 class="text-center">Personal</h3>
                <p class="text-justify">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec quis lectus at nulla venenatis consectetur. In auctor sagittis felis, et consequat augue dapibus a. Nam risus ante, luctus sed tellus id, condimentum mollis sem. Morbi enim felis, fringilla vitae aliquam sollicitudin, posuere nec nisl.
                </p>
            </div>
            <div class="col-md-2"></div>
            <div class="col-md-5 info-category">
                <p class="huge-text text-center">300km</p>
                <h3 class="text-center">Angkatan</h3>
                <p class="text-justify">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec quis lectus at nulla venenatis consectetur. In auctor sagittis felis, et consequat augue dapibus a. Nam risus ante, luctus sed tellus id, condimentum mollis sem. Morbi enim felis, fringilla vitae aliquam sollicitudin, posuere nec nisl.
                </p>
            </div>
        </div>
    </section>
</div>

<div class="modal fade" id="fileUpload" tabindex="-1" role="dialog" aria-labelledby="fileUploadText" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal" role="document">
        <div class="modal-content">
            <div class="modal-body" id="comingSoonText">
                <p>
                    Upload progres lari anda!
                </p>
                <form action="/upload" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="custom-file py-4">
                        <input type="file" class="custom-file-input" id="customFile" name="image">
                        <label class="custom-file-label" for="customFile">Choose file</label>
                    </div>
                     <button type="submit" class="btn btn-primary">Upload</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        bsCustomFileInput.init()
    });
</script>

@endsection


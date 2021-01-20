@extends('layout.main')

@section('title')
About |
@endsection

@section('content')

<div class='container'>
    <section class="px-5 py-5 mx-auto col-md-8">
        <h1 class="text-center">Informasi Lomba Virtual Run</h1>
        <p class="text-justify my-4 ">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec quis lectus at nulla venenatis consectetur.
            In auctor sagittis felis, et consequat augue dapibus a. Nam risus ante, luctus sed tellus id, condimentum
            mollis sem. Morbi enim felis, fringilla vitae aliquam sollicitudin, posuere nec nisl. Etiam quis dolor
            maximus, tempor erat condimentum, vestibulum orci. In at fringilla leo. In hendrerit urna eget neque
            consequat, at accumsan turpis tempor. Integeer interdum tristique ipsum nec egestas. Sed ex enim, posuere id
            velit sit amet, maximus ornare sem. In a arcu nec lacus iaculis pretium et vel metus.
        </p>
        @if ($message = Session::get('success'))
        <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
            {{ $message }}
        </div>
        @endif
        <div class="justify-content-center">

            @guest
            <a role="button" class="btn btn-danger btn-lg px-5 py-3" href="/register">Daftar Sekarang!</a>
            @else
            @if(DB::table('participants')->where('user_id', Auth::id())->first())
            <h3 class="text-center">Progres Anda untuk Kategori
                {{DB::table('participants')->where('user_id', Auth::id())->value('raceType')}}x3km</h3>
            <p class="huge-text text-center">
                {{DB::table('participants')->where('user_id', Auth::id())->value('jarak') ?? "0.00"}}km /
                {{DB::table('participants')->where('user_id', Auth::id())->value('raceType') * 3}}.00km</p>
            @elseif(DB::table('user_data')->where('user_id', Auth::id())->first())
            <a role="button" class="btn btn-danger btn-lg" href="/payment">Lanjutkan Pembayaran Anda!</a>
            @else
            <a role="button" class="btn btn-danger btn-lg px-5 py-3" href="/race">Daftar Untuk Lomba</a>
            @endif
            <div class="row justify-content-center">
                <div class="col-8">
                <a role="button" class="btn btn-danger btn-block" id="uploadButton" href="/race/upload">
                    <p>Upload hasil anda!</p>
                </a>
                </div>
            </div>
            @endguest

        </div>
    </section>
    <hr>
    <section class="px-5 py-5 mx-auto col-md-10">
        <h2 class="text-center">Kategori Lomba Virtual Run</h2>
        <div class="row py-2">
            <div class="col-md-4 info-category">
                <p class="huge-text text-center" id="rType"><span>1</span> x 3km</p>
            </div>
            <div class="col-md-8 info-category">
                <p class="text-justify ">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec quis lectus at nulla venenatis
                    consectetur. In auctor sagittis felis, et consequat augue dapibus a. Nam risus ante, luctus sed
                    tellus id, condimentum mollis sem. Morbi enim felis, fringilla vitae aliquam sollicitudin, posuere
                    nec nisl.
                </p>
            </div>
        </div>
    </section>
</div>

<script>

    var text = ["2", "3", "4", "5", "6", "7", "1"];
    var counter = 0;
    var elem = $("#rType span");

    function change() {
        $(elem).fadeOut('fast', function () {
            $(elem).text(text[counter++]);

            if (counter >= text.length) {
                counter = 0;
            }

            $(elem).fadeIn('fast');
        });
    };

    setInterval(change, 2000);

</script>

@endsection

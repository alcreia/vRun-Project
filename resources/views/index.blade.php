@extends('layout.main')

@section('content')

<div class="container-fluid">
    <div class="main-content-index row justify-content-center align-items-center">
        <section class="px-5 py-5 mx-auto col-md-6">
            <h1 class="text-center">Virtual Run Event  2020<br> Reuni Akbar SMAN 3 Bandung</h1>
            <p class="text-justify">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec quis lectus at nulla venenatis consectetur. In auctor sagittis felis, et consequat augue dapibus a. Nam risus ante, luctus sed tellus id, condimentum mollis sem. Morbi enim felis, fringilla vitae aliquam sollicitudin, posuere nec nisl. Etiam quis dolor maximus, tempor erat condimentum, vestibulum orci. In at fringilla leo. In hendrerit urna eget neque consequat, at accumsan turpis tempor. Integeer interdum tristique ipsum nec egestas. Sed ex enim, posuere id velit sit amet, maximus ornare sem. In a arcu nec lacus iaculis pretium et vel metus.
            </p>
            <div class="d-flex flex-row justify-content-center">
                <a href="/info"><button class="btn btn-outline-dark btn-lg">Info Lebih Lanjut</button></a>
            </div>
        </section>
    </div>
    <div class="py-4 border-top border-bottom row">
        <div class=" col-md-6">
            <section class="main-about-index">
                <h3 class="text-center">Tentang acara ini</h3>
                <div class="row justify-content-center py-4">
                    <div class="col-8">
                        <p class="text-justify">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec quis lectus at nulla venenatis consectetur. In auctor sagittis felis, et consequat augue dapibus a. Nam risus ante, luctus sed tellus id, condimentum mollis sem. Morbi enim felis, fringilla vitae aliquam sollicitudin, posuere nec nisl. Etiam quis dolor maximus, tempor erat condimentum, vestibulum orci. In at fringilla leo. In hendrerit urna eget neque consequat, at accumsan turpis tempor. Integeer interdum tristique ipsum nec egestas. Sed ex enim, posuere id velit sit amet, maximus ornare sem. In a arcu nec lacus iaculis pretium et vel metus.
                        </p>
                    </div>
                </div>
            </section>
        </div>
        <div class=" col-md-6">
            <section class="main-video-index">
                <div class="justify-content-center py-4">
                    <div class="embed-responsive embed-responsive-16by9 px-4">
                        <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/uD4izuDMUQA" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
@endsection


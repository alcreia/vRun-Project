@extends('layout.main')

@section('title')
    Results |
@endsection

@section('content')

<div class="container py-4">
    <h1 class="text-center"> Statistik Perlombaan </h1>
    <hr>

    <div class="row py-4">
        <div class="col-md-6">
            <p class="huge-text text-center">{{DB::table('participants')->count()}}</p>
            <h2 class="text-center">Total Peserta Lomba</h2>
        </div>
        <div class="col-md-6"></div>
    </div>

    <hr>

    <div class="row py-4">
        <div class="col-md-6"></div>
        <div class="col-md-6">
            <p class="huge-text text-center">{{DB::table('participants')->sum('jarak')}} km</p>
            <h2 class="text-center">Total Jarak yang Ditempuh Peserta</h2>
        </div>
    </div>

    <hr>

    <div class="row py-4">
        <div class="col-md-6">
            <p class="huge-text text-center">{{DB::table('participants')
                    ->where('raceType', '=', 'P')
                    ->where('jarak', '>=', 3)
                    ->count()
            }}</p>
            <h2 class="text-center">Peserta yang Menyelesaikan Lomba</h2>
        </div>
        <div class="col-md-6"></div>
    </div>

    <hr>

    <div class="row py-4">
        <div class="col-md-6"></div>
        <div class="col-md-6">
            <p class="huge-text text-center">
                @php
                    $array = DB::table('participants')
                                ->where('raceType', '=', 'A')
                                ->select('angkatan', DB::raw('sum(jarak) as sum'))
                                ->groupBy('angkatan')
                                ->get();

                    $array = $array->pluck('sum');
                    $count = 0;
                    foreach($array as $sum) {
                        if($sum >= 100) {
                            $count++;
                        }
                    }
                    echo $count;
                @endphp
            </p>
            <h2 class="text-center">Angkatan yang Menyelesaikan Lomba</h2>
        </div>
    </div>

</div>

@endsection


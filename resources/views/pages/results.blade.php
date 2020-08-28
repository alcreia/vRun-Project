@extends('layout.main')

@section('title')
    Results |
@endsection

@section('content')

<div class="container py-4">
    <h1 class="text-center"> Statistik Perlombaan </h1>

    <div class="row px-5">
        <canvas id="myChart" width="200" height="100"></canvas>
    </div>

    <div class="row py-4">
        <div class="col-md-6">
            <p class="huge-text text-center">{{$count}}</p>
            <h2 class="text-center">Total Peserta Lomba</h2>
        </div>
        <div class="col-md-6"></div>
    </div>

    <hr>

    <div class="row py-4">
        <div class="col-md-6"></div>
        <div class="col-md-6">
            <p class="huge-text text-center">{{$dist}} km</p>
            <h2 class="text-center">Total Jarak yang Ditempuh Peserta</h2>
        </div>
    </div>

    <hr>

    <div class="row py-4">
        <div class="col-md-6">
            <p class="huge-text text-center">{{$success_count}}</p>
            <h2 class="text-center">Peserta yang Menyelesaikan Lomba</h2>
        </div>
        <div class="col-md-6"></div>
    </div>

    <hr>
</div>

<script>

    var label = new Array();
    var dataset = new Array();

    function showGraph() {
        $.get('/results/get_data',function(response){
            label = response.AxisLabels;
            dataset = response.DataSets;

            var ctx = document.getElementById("myChart").getContext('2d');
            var chart = new Chart(ctx,{
                type: 'bar',
                data: {
                    labels: label,
                    datasets: [{
                        label: 'Peserta',
                        backgroundColor:'#1f1e33',
                        data: dataset,
                    }],
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero:true
                            }
                        }]
                    }
                }
            });
        });

    };

    $(document).ready(function() {
        showGraph();
    });
    
</script>

@endsection


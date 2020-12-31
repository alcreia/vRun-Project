@extends('layout.main')

@section('title')
Upload Strava Activity |
@endsection

@section('content')

<div class="container py-4">

<h2>Upload Aktivitas Strava</h2>

<table class="table table-bordered table-hover my-4">
    <thead>
        <tr>
            <th class="col-3">Tanggal</th>
            <th class="col-5">Nama</th>
            <th class="col-2">Jarak</th>
            <th class="col-2">Pengaturan</th>
        </tr>
    </thead>
    <tbody>
        @foreach($activity as $a)
        <tr>
            <td id="activity-date">{{date('l, d F Y, H:i',strtotime($a->start_date_local))}}</td>
            <td id="activity-name">{{$a->name}}</td>
            <td id="activity-distance">{{($a->distance)}}m</td>
            <td id="activity-action"><a href="/strava/submit/{{$a->id}}" class="btn btn-danger">Pilih</a></td>
        </tr>
        @endforeach
    </tbody>
</table>

{{$activity->links()}}   
</div> 

@endsection
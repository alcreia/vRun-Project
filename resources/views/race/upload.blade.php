@extends('layout.main')

@section('title')
    Upload Hasil |
@endsection

@section('content')
    <div class="container p-4">
        <h1 class="text-center">Upload Hasil Anda!</h1>

        @if(DB::table('user_strava')->where('user_id',Auth::user()->id)->first())
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
        @else
        <div class="row justify-content-center">
            <a role="button" class="btn btn-danger btn-block col-6" href="/strava/connect">
                <p>Hubungkan dengan Strava</p>
            </a>
        </div>
        @endif

        <hr>
        <h2>Upload Manual </h2>
        <div>
            <form action="/upload" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="distanceInput">Jarak lari (km)</label>
                    <input type="number" step="any" class="form-control" id="distanceInput" placeholder="0.00"
                        name="distance">
                </div>
                <hr>
                <div class="custom-file py-4">
                    <input type="file" class="custom-file-input" id="customFile" name="image">
                    <label class="custom-file-label" for="customFile">Screenshot Aktivitas</label>
                </div>
                <button type="submit" class="btn btn-primary my-4">Upload</button>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            bsCustomFileInput.init();
        });
    </script>
@endsection
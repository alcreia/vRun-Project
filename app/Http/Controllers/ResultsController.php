<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ResultsController extends Controller
{
    //
    public function index()
    {
        $count = DB::table('participants')->count();
        $dist = DB::table('participants')->sum('jarak');
        $success = DB::table('participants')->get();
        $rank = DB::table('participants')->orderBy('jarak','desc')->take(10)->get();
        $success_count = 0;
        foreach($success as $s) {
            if($s->jarak >= ($s->raceType * 3)) {
                $success_count++;
            }
        };

        return view('pages.results',compact('count','dist','success_count','rank'));
    }

    public function chartData() {
        $labels = DB::table('participants')->orderBy('angkatan','desc')->pluck('angkatan');

        $data = [];

        foreach($labels as $lb){
            $count = DB::table('participants')->where('angkatan',$lb)->count();
            array_push($data,$count);
        };
        $object = array("AxisLabels"=>$labels, "DataSets"=>$data);

        return response()->json($object, 200);
    }
}

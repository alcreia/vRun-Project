<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Strava;
use Carbon\Carbon;

class InfoController extends Controller
{
    //
    public function index() {
        return view('pages.info');
    }

    public function stravaAuth() {
        return Strava::authenticate($scope='profile:read_all,activity:read_all');
    }
    
    public function stravaGetToken(Request $request) {
        
        $data = Http::post('https://www.strava.com/oauth/token',[
            'client_id' => env('CT_STRAVA_CLIENT_ID'),
            'client_secret' => env('CT_STRAVA_CLIENT_SECRET'),
            'code' => $request->code,
            'grant_type' => 'authorization_code'
        ]);

        $token = json_decode($data->body());

        DB::table('user_strava')->insert([
            'user_id' => Auth::user()->id,
            'access_token' => $token->access_token,
            'refresh_token' => $token->refresh_token, 
            'expired_at' => Carbon::parse($token->expires_at)->format('Y-m-d H:i:s'),
        ]);   

        return redirect('/info');
    }

    public function stravaSubmitActivity($id) {
        $user = DB::table('user_strava')->where('user_id',Auth::user()->id)->first();
        $activity = Strava::activity($user->access_token, $id);
        $dist = DB::table('participants')->where('user_id',$user->user_id)->value('jarak');

        DB::table('participants')->where('user_id',$user->user_id)->update([
            'jarak' => $dist + ($activity->distance / 1000),
            'submit_at' => Carbon::now(),
        ]);

        return redirect('/info');
    }
}

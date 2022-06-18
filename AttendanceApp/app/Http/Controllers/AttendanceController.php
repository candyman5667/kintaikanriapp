<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Attendance;
use Carbon\carbon;
use App\Http\Request\AttendanceRequest;

class AttendanceController extends Controller
{
    public function index()
    {
        return view('attendance');
    }

    public function start_stamp()
    {
        $userId = Auth::id();
        $today = Carbon::today();
        $checkTime =
        Attendance::where('user_id', $userId)
        ->whereDate('created_at' , $today)->first();

        if ($checkTime) {
            return  'すでに出勤してます.';
        }

        //１.現在の時間の取得
        $datetime = Carbon::now(); 
        
        //2.データベースの保存
        //ユーザーの情報とどのテーブルに保存するか？
        $user = [
            'user_id' => $userId,
            'punch_in' => $datetime,
        ];

        Attendance::create($user);

        //3.どのページに遷移するか
        return back()->with('message', '勤務を開始しました');
    }

    public function end_stamp()
    {
        $userId = Auth::id();
        $datetime = Carbon::now();
        $today = Carbon::today();
        $checktime = Attendance::where('user_id', $userId)
        ->whereDate('created_at', $today)->first();
        if ($checktime == null) {
            return '出勤していません。';
        }
        //dd($checktime);

        Attendance::where('user_id' , $userId)
        ->whereDate('created_at' , $today)
        ->update([
            'punch_out' => $datetime,
        ]);

        return back()->with('message', 'お疲れ様でした。'); 
    }
}


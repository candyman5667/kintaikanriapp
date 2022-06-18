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
        $user = Auth::user();
        $userId = Auth::id();
        $today = Carbon::today();
        $checkTime =
            Attendance::where('user_id', $userId)
            ->whereDate('created_at', $today)->first();

        if (!$checkTime) {
            $msg = "出勤していません。";
            return view('attendance',[
                'test_blade' => $msg,
            ]);
        }
        $msg = "出勤しています。";
        return view('attendance', [
            'test_blade' => $msg,
        ]);
    }

    //出勤機能
    public function start_stamp()
    {
        $userId = Auth::id();
        $today = Carbon::today();
        $checkTime =
        Attendance::where('user_id', $userId)
        ->whereDate('created_at' , $today)->first();

        if ($checkTime) {
            return  redirect('/');
        }

        //１.現在の時間の取得
        $dateTime = Carbon::now(); 
        
        //2.データベースの保存
        //ユーザーの情報とどのテーブルに保存するか？
        $user = [
            'user_id' => $userId,
            'punch_in' => $dateTime,
        ];

        Attendance::create($user);
    }

    //退勤機能
    public function end_stamp()
    {
        $userId = Auth::id();
        $dateTime = Carbon::now();
        $today = Carbon::today();
        $checkTime = Attendance::where('user_id', $userId)
        ->whereDate('created_at', $today)->first();
        if ($checkTime == null) {
            return '出勤していません。';
        }
        //dd($checktime);

        Attendance::where('user_id' , $userId)
        ->whereDate('created_at' , $today)
        ->update([
            'punch_out' => $dateTime,
        ]);
    }
}


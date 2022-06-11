<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Attendance;

class AttendanceController extends Controller
{
    public function index()
    {
        return view('attendance');
    }

    public function start_stamp()
    {
        //１.現在の時間の取得
        //$datetime = Carbon::now();
        $userId = Auth::id();
        //dd($userId);

        //2.データベースの保存
        //ユーザーの情報とどのテーブルに保存するか？
        $user = [
            'user_id' => $userId,
            'punch_in' => $datetime,
        ];

        Attendance::create($user);

        //3.どのページに遷移するか
    return redirect('/');
    }

    public function end_stamp()
    {
        $userId = Auth::id();
       // $datetime = Carbon::now();

        $user = [
            'user_id' => $userId,
            'punch_out' => $datetime,
        ];

        Attendance::create($user);

        return redirect('/');
    }
}


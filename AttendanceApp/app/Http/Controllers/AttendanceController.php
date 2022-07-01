<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Attendance;
use App\Models\Rest;
use Carbon\carbon;
use App\Http\Request\AttendanceRequest;

class AttendanceController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $userId = Auth::id();
        $today = Carbon::today();
        $checkTime = Attendance::where('user_id', $userId)->whereDate('created_at', $today)->first();
        // return view('attendance')->with([
        //     "is_attendance_start" => false,
        //     "is_attendance_end" => false,
        //     "is_rest_start" => false,
        //     "is_rest_end" => false,
        // ]);
        if (!$checkTime) {
            $msg = "出勤していません。";
            return view('attendance',)->with([
                "is_attendance_start" => true,
                "is_attendance_end" => true,
                "is_rest_start" => true,
                "is_rest_end" => true,
            ]);
        }

        if ($checkTime->punch_out) {
            return view('attendance')->with([
                "is_attendance_start" => true,
                "is_attendance_end" => true,
                "is_rest_start" => true,
                "is_rest_end" => true,
            ]);
        }

        $attendanceId = $checkTime->id;
        $rest = Rest::where('attendance_id', $attendanceId)->first();
        //$restがnullではない時に実行
        if (!is_null($rest)) {
            if (is_null($rest->rest_end)) {
                return view('attendance')->with([
                    "is_attendance_start" => true,
                    "is_attendance_end" => true,
                    "is_rest_start" => true,
                    "is_rest_end" => true,
                ]);
            }

            return view('attendance')->with([
                "is_attendance_start" => true,
                "is_attendance_end" => true,
                "is_rest_start" => true,
                "is_rest_end" => true,
            ]);
        }
        return view('attendance')->with([
            "is_attendance_start" => true,
            "is_attendance_end" => true,
            "is_rest_start" => true,
            "is_rest_end" => true,
        ]);
    }

    //出勤機能
    public function start_stamp()
    {
        $userId = Auth::id();
        $today = Carbon::today();
        $checkTime =
            Attendance::where('user_id', $userId)
            ->whereDate('created_at', $today)->first();

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
            $coment = "出勤中";
        }

        Attendance::where('user_id', $userId)
            ->whereDate('created_at', $today)
            ->update([
                'punch_out' => $dateTime,
            ]);
    }

    public function signout()
    {
        Auth::logout();
        return redirect('/');
    }
}
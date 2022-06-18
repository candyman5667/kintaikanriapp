<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rest;
use App\Models\Attendance;
use Carbon\carbon;

class RestController extends Controller
{
    //休憩開始機能
    public function rest_in()
    {
        $attendanceId = Attendance::id();
        $today = Carbon::today();
        $checkTime =
            Attendance::where('attendance_id', $attendanceId)
            ->whereDate('created_at', $today)->first();

        if ($checkTime) {
            return  redirect('/');
        }

        //１.現在の時間の取得
        $dateTime = Carbon::now();

        //2.データベースの保存
        //ユーザーの情報とどのテーブルに保存するか？
        $rest = [
            'attencance_id' => $attendanceId,
            'rest_in' => $dateTime,
        ];

        Rest::create($rest);
    }
}
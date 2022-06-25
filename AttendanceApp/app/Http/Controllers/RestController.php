<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rest;
use App\Models\Attendance;
use Illuminate\Support\Facades\Auth;
use Carbon\carbon;

class RestController extends Controller
{
    //休憩開始機能
    public function rest_in()
    {
        //出勤データを取り出す
        //どんなデータが必要なのか？
        //休憩対象のデータを取り出す
        //その日のデータかつ利用ユーザーに当てはまるデータ
        //user_idとその日のデータ

        $userID = Auth::id();
        $today = Carbon::today();
        $attendance = Attendance::where('user_id' ,$userID)->whereDate('created_at',$today)->first();

        //１.現在の時間の取得
        $dateTime = Carbon::now();

        //2.データベースの保存
        //ユーザーの情報とどのテーブルに保存するか？
        $rest = [
            'attencance_id' => $attendance->id,
            'rest_start' => $dateTime,
        ];
        //dd($rest);
        Rest::create($rest);
        return redirect('/');
    }

    //休憩終了機能
    public function rest_out()
    {
        $userId = Auth::id();
        $today = Carbon::today();
        $attendance = Attendance::where('user_id', $userId)->whereDate('created_at', $today)->first();

        //現在の時間の取得
        $dateTime = Carbon::now();

        $restStart = Rest::where('attendance_id', $attendance->id)->first();

        $calc = $dateTime->diffInSeconds($restStart->rest_start);

        //dd(setTime($calc));

        Rest::where('attendance_id', $attendance->id)
            ->whereDate('rest_start', $today)
            ->update([
                'rest_end' => $dateTime,
                'rest_total' => $calc,
            ]);
        return redirect('/');
    }
}
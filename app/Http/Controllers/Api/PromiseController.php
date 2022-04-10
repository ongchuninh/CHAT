<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Promise;
use App\Http\Controllers\Controller;
use Validator;

class PromiseController extends Controller
{
    public function getTotal()
    {
        $total = Promise::count('id');
        return response()->json([
            'message'  =>    'get total user promise success',
            'total'    =>     $total,
        ], 200);
    }
    public function addPromise(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'         => 'required|email|unique:promise',
            'phone'         => 'required|numeric|min:10|unique:promise',
        ], [
            'email.required' => 'Trường email không được bỏ trống',
            'email.email' => 'Trường email sai định dạng',
            'email.unique' => 'Email này đã được đăng ký',

            'phone.required' => 'Trường Số điện thoại không được bỏ trống',
            'phone.numeric' => 'Trường Số điện thoại sai định dạng',
            'phone.min' => 'Trường Số điện thoại sai định dạng',
            'phone.unique' => 'Số điện thoại này đã được đăng ký',
        ]);

        if (self::checkIp($request->ip())) {
            return response()->json([
                'message'  => 'Bạn chỉ có thể đăng ký 3 tài khoản trong ngày!',
                'status'   => 0
            ], 200);
        }

        if ($validator->fails()) {
            return response()->json([
                'message'  => $validator->errors()->first(),
                'status'   => 0
            ], 200);
        }

        $message = 'Chúc mừng bạn đã Báo danh nhận quà thành công cùng Tiên Vực ! <br/> Giftcode sẽ được gửi đến bạn trong ngày ra mắt qua SMS và Email đã đăng ký ! <br/> Hãy chia sẻ để bạn bè cùng tham gia sự kiện này và theo dõi Fanpage bạn nhé !';
        $status = 1;

        $insert = Promise::create([
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'ip'    => $request->ip()
        ]);

        if (!$insert) {
            $message = "Lỗi hệ thống! Vui lòng thử lại sau!";
            $status = 0;
        }

        return response()->json([
            'message'  =>  $message,
            'total'    =>  Promise::count('id'),
            'status'   =>  $status
        ], 200);
    }
    public function checkIp($ip)
    {
        $count_ip = Promise::where('ip', 'like', $ip)->whereDate('created_at', date('Y-m-d'))->count('id');
        return $count_ip > 2;
    }
}

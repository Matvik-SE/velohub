<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class MailingController extends Controller
{
    public function subscribe(Request $request)
    {
        $this->validateForm($request);

        if (DB::table('mailing')->where('email', $request->email)->exists()) {
            return back()->with('notify', 'Вы уже подписаны на рассылку!');
        }

        DB::table('mailing')->insert(['email' => $request->email]);

        return back()->with('notify', 'Спасибо за подписку!');
    }

    public function unsubscribe(Request $request)
    {
        $this->validateForm($request);

        if (DB::table('mailing')->where('email', $request->email)->where('key', $request->key)->doesntExist()) {
            return response('Такого адреса нет в нашей рассылке!');
        }

        DB::table('mailing')->where('email', $request->email)->where('key', $request->key)->delete();

        return response('');
    }

    private function validateForm(Request $request)
    {
        $validator = Validator::make($request->all(), ['email' => 'required|email']);

        if ($validator->fails()) {
            return back()->with('notify', 'Некорректный формат E-mail!')->withInput();
        }
    }

}

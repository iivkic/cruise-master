<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;

class CookieController extends Controller
{

    public function index(Request $request){
        session(['show_cookie_consent' => false]);
        if($request->get('accept_all') == 'false'){
            session(['use_analytics' => false]);
        }else{
            session(['use_analytics' => true]);
        }
        return response('Success', 200);
    }
}


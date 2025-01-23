<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use TimeHunter\LaravelGoogleReCaptchaV3\Validations\GoogleReCaptchaV3ValidationRule;

class ContactController extends Controller
{

    public function index(){

        $page_info=[
            "meta_title"=>"Contact Us | Small Ship Adriatic Cruises | Sail Croatia",
            "meta_description"=>"Contact us & bool now, we are here to take you on a cruise of your life! My Croatia Cruise.",
            "url"=>url()->current(),
            "image"=>asset("/images/home-bg.png"),
        ];

        return view('contact.index', compact('page_info'));
    }

    public function sendMail(Request $request){
        $month = date("Y-m");


        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'subject' => 'required',
            'message' => 'required|min:3|max:1000',
            'g-recaptcha-response' => [new GoogleReCaptchaV3ValidationRule('contact_us')]
        ]);

        if ($validator->fails()) {
            return response()->json(['response' => "error", "validator" => $validator->errors()]);
        }

        $mail_array = array(
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'phone' => $request->get('phone'),
//            'country' => $request->get('country'),
            'user_message' => $request->get('message'),
            'date' => $request->get('dep_date'),
            'duration' => $request->get('duration'),
            'pax' => $request->get('pax'),
            'cabins' => $request->get('cabins'),
            'subject'=>$request->get('subject')
        );
        Mail::send('contact.template', $mail_array,
            function($message) use ($mail_array)
            {
//                $message->bcc(['nikolina@ch.hr'])->from('nikolina@ch.hr', "MyCroatiaCruise Web")->to('nikolina@ch.hr', 'Croatia Holidays')
//                    ->replyTo($mail_array['email'], $mail_array['name'])->subject('MyCroatiaCruise | '. $mail_array['subject']  . ' | '.date("d.m.Y H:i"));
              $message->bcc(['info@ch.hr'])->from('info@ch.hr', "MyCroatiaCruise Web")->to('info@ch.hr', 'Croatia Holidays')
                    ->replyTo($mail_array['email'], $mail_array['name'])->subject('MyCroatiaCruise | '. $mail_array['subject']  . ' | '.date("d.m.Y H:i"));
            });
        return response()->json(['response' => "success"]);
    }
}

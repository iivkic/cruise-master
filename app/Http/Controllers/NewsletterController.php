<?php


namespace App\Http\Controllers;


use App\Newsletter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use TimeHunter\LaravelGoogleReCaptchaV3\Validations\GoogleReCaptchaV3ValidationRule;

class NewsletterController extends Controller
{
    public function index(Request $request){
        $month = date("Y-m");
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
//            'g-recaptcha-response' => [new GoogleReCaptchaV3ValidationRule('contact_us')]
        ]);

        if ($validator->fails()) {
            return response()->json(['response' => "error", "validator" => $validator->errors()]);
        }

        $duplicate = Newsletter::where('email', '=', $request->get('email'))->get();
        if(count($duplicate) != 0){
            return response()->json(['response' => "error", "message" => "This email is already on the subscription list!"]);
        }else{
            $n=new Newsletter(
                ['email' => $request->get('email')]
            );
            $n->save();
        }

        $mail_array = array(
            'email' => $request->get('email'),
        );
        Mail::send('newsletter.template', $mail_array,
            function($message) use ($mail_array)
            {
                $message->from('newsletter@mycroatiacruise.com', "MyCroatiaCruise")->to('info@ch.hr', 'Admin')->replyTo($mail_array['email'])->subject('Newsletter subscription | ' .$mail_array['email']);
            });
        return response()->json(['response' => "success", "message" => "Thank you for subscribing!"]);
    }
}

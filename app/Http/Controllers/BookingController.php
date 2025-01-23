<?php


namespace App\Http\Controllers;


use App\ExcursionDeparture;
use App\MccExcursion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use TimeHunter\LaravelGoogleReCaptchaV3\Validations\GoogleReCaptchaV3ValidationRule;

class BookingController extends Controller
{
    public function step1(Request $request){
        $departure = ExcursionDeparture::with("excursion.translations","excursion.images3","excursion.ship.translations","excursion.start","excursion.finish","excursion.header_image")->getPrices()->where("id", $request->get("id"))->firstOrFail();
        return view('booking.step-1')->with(compact(['departure']));
    }

    public function step2(Request $request){


        $col = collect($request->get("number"))->filter(function ($item, $key) {
            return $item > 0;
        });

        $mail = $request->get("email");
        $excursion = MccExcursion::with("translations","departures","images3","ship.translations","start","finish","header_image")->whereHas("prices", function ($q) use ($col) {
            $q->whereIn("excursion_prices.id", $col->keys());
        })->getPrices(false, false, $col->keys())->first();



        $excursion->prices = $excursion->prices->unique('id')->map(function ($item, $key) use ($col) {
            $item->people = $col[$item->id];
            $item->total = $col[$item->id] * $item->real_price;
            return $item;
        });


        $numberOfTravelers=array_sum($request->get("number"));


        $countries=DB::table('countries')->get();

        return view('booking.step-2')->with(compact( ["excursion", "col", "countries", "numberOfTravelers"]));
    }

    public function step3(Request $request){
        $excursion = json_decode($request->get('excursion'));
        $departure = ExcursionDeparture::with("excursion.translations","excursion.images3","excursion.ship.translations","excursion.start","excursion.finish")->where("excursion_id", $excursion->main_excursion_id)->firstOrFail();
        $mail_array = array(
            'firstName' => $request->get('first-name'),
            'lastName' => $request->get('last-name'),
            'title' => $request->get('title'),
            'email' => $request->get('email'),
            'phone' => $request->get('phone'),
            'country' => $request->get('country'),
            'user_message' => $request->get('message'),
            'subject' => $request->get('subject'),
            'excursion'=>json_decode($request->get('excursion')),
            'supplementPerCabin'=>json_decode($request->get('supplementPerCabin')),
            'totalSupplement'=>$request->get('totalSupplement'),
            'departure'=>$departure,
        );
//        dd($mail_array);
//        return view('booking.sender-template', $mail_array);
        Mail::send('booking.template', $mail_array,
            function($message) use ($mail_array)
            {

                $message->bcc(config('mail.bcc'))->from('info@ch.hr', "MyCroatiaCruise Web")->to('info@ch.hr', 'Croatia Holidays')
                    ->replyTo($mail_array['email'], $mail_array['firstName'])->subject('MyCroatiaCruise | New Inquiry  | '.date_to_user($mail_array['excursion']->prices[0]->date).' | MS '.$mail_array['excursion']->ship->name. ' | ' .date("d.m.Y H:i"));

            });
        Mail::send('booking.sender-template', $mail_array,
            function($message) use ($mail_array)
            {
//                $message->from('nikolina@ch.hr')->to('nikolina@ch.hr');
                $message->from('noreply@ch.hr', "MyCroatiaCruise")->to($mail_array['email'], 'Croatia Holidays')
                    ->replyTo($mail_array['email'], $mail_array['firstName'])->subject('MyCroatiaCruise | Inquiry');

            });
        return view("booking.step-3")->with(["excursion"=>$mail_array["excursion"]],["departure"=>$mail_array["departure"]]);
    }
    public function checkInquiry(Request $request){
        $validator = Validator::make($request->all(), [
            'title'=> 'required',
            'first-name' => 'required',
            'last-name' => 'required',
            'email' => 'required|email',
            'g-recaptcha-response' => [new GoogleReCaptchaV3ValidationRule('contact_us')]
        ]);

        if ($validator->fails()) {
            return response()->json(['response' => "error", "validator" => $validator->errors()]);
//            return redirect()->back()->withErrors($validator)->withInput();
        }


        return response()->json(['response' => "success"]);
    }

    public function sendInquiry(Request $request){


    }
}

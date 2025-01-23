<?php

namespace App\Http\Controllers;


use App\Category;
use App\MccDestination;
use App\MccExcursion;
use App\Ship;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use niklasravnsborg\LaravelPdf\Facades\Pdf;
use TimeHunter\LaravelGoogleReCaptchaV3\Validations\GoogleReCaptchaV3ValidationRule;


class CruiseController extends Controller
{
    public function index(Request $request)
    {



        $usesRecaptcha=false;

        $page = "cruises";
        $page_info = [
            "meta_title" => "Adriatic Cruises | Small Ship Cruises in Croatia | Croatia Cruise",
            "meta_description" => "Book your small ship cruise to discover Croatia's beautiful Adriatic Coast on board our luxury ships!",
            "url" => route('cruises.index'),
            "image" => asset("assets/ship-search-bg.jpg"),
        ];
        $month = $request->get("month") ?: date("Y-m");

        //postavljeno da se prikaže peti mjesec 2024, kada se bude prebalo vratiti da se prikazuje trenutni mjesec samo zakomentirati redak
        $month = $request->get("month") ?: "2025-05";

        $month=substr($month, 0, 7);
        $month.="-01";
        $date = Carbon::createFromFormat("Y-m-d", $month);
        $count = [];
        $temp = [];
        if($date->month > 10){
            $date->setYear($date->year+1);
        }
        if ((!$request->has("month") || $request->get("month")=='') && ($date->month < 5 || $date->month > 9)) {
            $date->setMonth(5);
            $date->setYear(2023);
        };
        //allowed-filters in allowed, apply them check ajax check page return

        $destinations = MccDestination::where("online", 1)->orderBy("name")->get();
        $ships = Ship::where("online", 1)->orderByTranslation("name")->get();
        $starting_ports = MccDestination::whereHas("start_cruise")->orderBy("ports_order")->get();
        $ending_ports = MccDestination::whereHas("finish_cruise")->orderBy("ports_order")->get();
        $blogs = $this->getBlogs();

        $allowed_filters = [
            ["name" => "price_range",
                "selector" => "#price-range",
                "type" => "range",
                "confirmation" => false,
                "expendable" => false,
                "encoded" => true,
                "multiple" => true

            ], [
                "name" => "duration",
                "selector" => "input[name=duration]",
                "type" => "checkbox",
                "confirmation" => false,
                "expendable" => true,
                "encoded" => true,
                "multiple" => true
            ], [

                "name" => "start",
                "selector" => "input[name=start]",
                "type" => "radio",
                "confirmation" => false,
                "expendable" => true,
                "encoded" => false,
                "multiple" => false

            ], [

                "name" => "finish",
                "selector" => "input[name=finish]",
                "type" => "radio",
                "confirmation" => false,
                "expendable" => true,
                "encoded" => false,
                "multiple" => false
            ], [

                "name" => "destinations",
                "selector" => "input[name=destinations]",
                "type" => "checkbox",
                "confirmation" => true,
                "expendable" => false,
                "encoded" => true,
                "multiple" => true

            ],

            [

                "name" => "ships",
                "selector" => "input[name=ships]",
                "type" => "checkbox",
                "confirmation" => true,
                "expendable" => false,
                "encoded" => true,
                "multiple" => true
            ],
            [

                "name" => "recommended",
                "selector" => "input[name=recommended]",
                "type" => "hidden",
                "confirmation" => true,
                "expendable" => false,
                "encoded" => true,
                "multiple" => false
            ]];
        $month = $date;
        $date3 = Carbon::createFromFormat("Y-m", $date->format('Y-m'));
        $date3 = $date3->add(1, 'year')->setMonth(12);
        $excDate = $date;
        $shipDate = $date;
        $output_filters = ["filters" => [], "month" => $month];
        $excursions = MccExcursion::where("online", 1)->with(["translations", "duration",  "ship.translations","start.translations","finish.translations", "destinations.translations"])->getPrices($date)->orderby("recommended", "desc");
        $lmd = MccExcursion::where('last_minute_deal', 1)->count();

            if(count($excursions->get()) != 0) {
                foreach ($allowed_filters as $filter) {

                    $filter2 = [];
                    $filter2["name"] = $filter["name"];
                    $filter2["selector"] = $filter["selector"];
                    $filter2["type"] = $filter["type"];
                    $filter2["confirmation"] = $filter["confirmation"];
                    $filter2["expendable"] = $filter["expendable"];
                    if ($request->has($filter["name"])) {
                        $value = $request->get($filter["name"]);
                        if ($filter["encoded"]) $value = rawurldecode($value);
                        if ($filter["multiple"]) $value = explode((isset($filter["delimiter"]) ? $filter["delimiter"] : ","), $value);
                        $filter2["value"] = $value;

                        if ($filter["name"] == "recommended"){
                            $excursions = $excursions->where("online", 1)->where('recommended', 1);
                            break;
                        }

                        if ($filter["name"] == "destinations") {
                            foreach ($value as $v)
                                $excursions = $excursions->whereHas("destinations", function ($q) use ($v) {
                                    return $q->where("mcc_destinations.id", $v);
                                });

//                            do {
//
//                                $val = powerSet($value);
//                                $excursions = MccExcursion::where("online", 1)->with(["translations", "duration", "header_image", "ship.translations", "start.translations", "finish.translations", "destinations.translations"])->getPrices($excDate);
//                                foreach ($value as $v)
//                                    $excursions = $excursions->whereHas("destinations", function ($q) use ($v) {
//                                        return $q->where("mcc_destinations.id", $v);
//                                    });
//                                $i = 0;
////                                foreach ($val as $arr) {
////                                    $excursions = MccExcursion::where("online", 1)->with(["translations", "duration", "header_image", "ship.translations", "start.translations", "finish.translations", "destinations.translations"])->getPrices($excDate);
////                                    foreach ($arr as $v) {
////                                        $tempEx = $excursions;
////                                        $tempEx = $tempEx->whereHas("destinations", function ($q) use ($v) {
////
////                                            return $q->where("mcc_destinations.id", $v);
////                                        });
////                                        if (count($tempEx->get()) != 0) {
////                                            $count[$i][] = $v;
////                                            echo $i . '-' . $v . '  ';
////                                        }
////                                    }
////                                    if (count($tempEx->get()) != 0) {
////                                        $temp[] = $tempEx;
////                                    }
////                                    $i++;
////                                }
//                                if (count($excursions->get()) == 0) {
//                                    $excDate = $excDate->add(1, 'month');
//                                    $month = $excDate;
//                                }
//                                if ($excDate->equalTo($date3)) {
//                                    break;
//                                }
//                                if ($excDate->month > $date->month) {
//                                    $date = $excDate;
//                                    $output_filters["month"] = $month;
//                                }
//
//                            } while (count($excursions->get()) == 0);
//                            $excursions = end($temp);
//                            usort($count, function ($a, $b) {
//                                return count($b) <=> count($a);
//                            });
//                            $filter2["value"] = $count[0];
//                            $count = $count[0];
                        }
                        if ($filter["name"] == "start") {
                            $excursions = $excursions->whereHas("start", function ($q) use ($value) {
                                return $q->where("mcc_destinations.id", $value);
                            });
                        }
                        if ($filter["name"] == "finish") {
                            $excursions = $excursions->whereHas("finish", function ($q) use ($value) {
                                return $q->where("mcc_destinations.id", $value);
                            });
                        }

                        if ($filter["name"] == "trip") {
                            if ($value == "round") {
                                $excursions = $excursions->whereColumn("start_id", "finish_id");
                            } else {
                                $excursions = $excursions->whereColumn("start_id", "<>", "finish_id");
                            }

                        }

                        if ($filter["name"] == "ships") {
                         //   $excursions = $excursions->whereIn("id", $value);

                            $excursions = $excursions->whereHas("ship.category", function ($q) use ($value) {
                                return $q->whereIn("id", $value);
                            });
//                            if(count($excursions->get())==0){
//                                $no_ships=true;
////                                $shipDate = $shipDate->add(1, 'month');
//                                $excursions = MccExcursion::where("recommended", 1)->with(["translations", "duration", "header_image",  "ship.translations","start.translations","finish.translations", "destinations.translations"])->getPrices($shipDate);
//
//                                while(count($excursions->get()) == 0){
//                                    $shipDate = $shipDate->add(1, 'month');
//                                    $excursions = MccExcursion::where("recommended", 1)->with(["translations", "duration", "header_image",  "ship.translations","start.translations","finish.translations", "destinations.translations"])->getPrices($shipDate);
//                                }
//
//
//
//                            }else{
//                                $no_ships=false;
//                            }
//                            do{
//                                $excursions = MccExcursion::where("online", 1)->with(["translations", "duration", "header_image",  "ship.translations","start.translations","finish.translations", "destinations.translations"])->getPrices($shipDate);
//                                $excursions = $excursions->whereHas("ship", function ($q) use ($value) {
//                                    return $q->whereIn("id", $value);
//                                });
//                                if(count($excursions->get()) == 0) {
//                                    $shipDate = $shipDate->add(1, 'month');
//                                    $month = $shipDate;
//                                }
//                                if($shipDate->equalTo($date3)){
//                                    break;
//                                }
//                                if($shipDate->month > $date->month){
//                                    $date = $shipDate;
//                                    $output_filters["month"] = $month;
//                                }
//                            }while(count($excursions->get()) == 0);
                        }
                        if ($filter["name"] == "duration") {

                            $excursions = $excursions->whereHas("duration", function ($q) use ($value) {
                                return $q->whereIn("duration", $value);
                            });
                        }

                        if ($filter["name"] == "price_range") {

                            $excursions = $excursions->with(["departures" => function ($q) use ($date, $value) {
                                $q->getPrices($date, $value);
                            }
                            ])->whereHas("departures", function ($q) use ($date, $value) {
                                $q->getPrices($date, $value);
                            })->getPrices($date, $value);
                        }
                    }
                    $output_filters["filters"][] = $filter2;
                }


                if (!$request->has("price_range")) {
                    $excursions = $excursions->whereHas("departures", function ($q) use ($date) {
                        return $q->getPrices($date);
                    })->with(["departures" => function ($q) use ($date) {
                        return $q->getPrices($date);
                    }
                    ]);
                }
            }

        $excursions = $excursions->paginate(10);
        if ($request->ajax()) {
            if ($request->has("page"))
                return ["html" => view('ajax.cruises')->with(compact(["destinations", "month", "date", "page","excursions"]))->render(), "trips" => ["filtered_ids" => $count, "total" => $excursions->total(), "current_page" => $excursions->currentPage(), "last_page" => $excursions->lastPage()]];
            return ["filter"=>true, "html" => view('ajax.filter_cruise')->with(compact(["destinations", "month", "date", "page","excursions"]))->render(), "trips" => ["filtered_ids" => $count, "total" => $excursions->total(), "current_page" => $excursions->currentPage(), "last_page" => $excursions->lastPage()]];
        }
        $m=date_format($month, 'm Y');
        session()->put('month', $m);
        $categories = Category::where('active',1)->get();

        return view('cruises.index')->with(compact(["usesRecaptcha", "page_info", "destinations", "ships", "excursions", "categories","month", "page", "blogs", "starting_ports", "output_filters","ending_ports", "lmd"]));
    }




    public function download($slug)
    {
            $cruise = MccExcursion::whereTranslation("slug", $slug)->where('online', 1)->first();
            if (!$cruise) abort(404);


            $page_info = [
                "meta_title" => $cruise->meta_title,
                "meta_description" => $cruise->meta_description,
                "url" => url()->current(),
                "image" => asset($cruise->ship->header_image->url),
            ];

            $pdf = PDF::loadView('cruises.download', ["cruise" => $cruise], ['debug' => true,
                'allow_output_buffering' => false], ["author" => "My Croatia Cruise"]);
            return $pdf->stream("My Croatia Cruise - " . $cruise->name . '.pdf');

        }


    public function show($slug)
    {
        $test=MccExcursion::whereTranslation("slug", $slug)->where('online', 1)->first();
        $usesRecaptcha=true;
        if($test){
            $id=$test->id;
        }
        else {
            $slugParts=explode("-", $slug);
            $oldID=$slugParts[sizeof($slugParts)-1];
            if(is_numeric($oldID)){
               $test=MccExcursion::with(['translations'])->where('old_id', $oldID)->where('online', 1)->first();
               if($test){
                   return redirect(route('cruises.show', ["slug"=>$test->slug]), 301);
               }
               else{

                   abort(404);
               }
            }
            else {
                abort(404);
            }
        }


        $cruise = MccExcursion::with(["main_excursion", "start","finish","duration", "translations", "category", "itineraries.translations", "itineraries.days.translations", "itineraries.days.meals", "itineraries.days.destinations.header_image", "itineraries.days.destinations.translations",  "images", "destinations.translations", "ship.translations", "departures" => function ($q) {
            $q->getPrices();
        }])->getPrices()->where("id", $id)->first();

        if(!$cruise){
            $cruise = MccExcursion::with(["main_excursion", "start","finish","duration", "translations", "category", "itineraries.translations", "itineraries.days.translations", "itineraries.days.meals", "itineraries.days.destinations.header_image", "itineraries.days.destinations.translations", "images", "destinations.translations", "ship.translations"])->where("id", $id)->where("year", ">=", date("Y"))->first();
        }

//       $siblings = MccExcursion::where("online", 1)->whereNotNull('sibling_id')->where('sibling_id', $cruise->sibling_id)->orderBy('year')->orderBy('id')->get();
        if(!$cruise){

            $cruise = MccExcursion::with(["duration", "translations", "category", "itineraries.translations", "itineraries.days.translations", "itineraries.days.meals", "itineraries.days.destinations.header_image", "itineraries.days.destinations.translations",  "images", "destinations.translations", "ship.translations", "departures" => function ($q) {
                $q->getPrices();
            }])->getPrices()->where("old_slug", $slug)->first();

            if($cruise){
                if($cruise->online==1)
                    return redirect(route("cruises.show",$cruise->slug),301);
                return redirect($cruise->redirect_url?:route("home"),301);
            }
//            abort(404);
            return redirect(route("home"), 301);
        }
        $page_info=[
            "meta_title"=>$cruise->meta_title,
            "meta_description"=>$cruise->meta_description,
            "url"=>url()->current(),
            "image"=>asset($cruise->ship->header_image->url),
        ];
        $cruises=MccExcursion::where("online",1)->where("start_id",$cruise->start_id)->where('id', '!=', $cruise->id)->orderByDesc("popular")->getPrices()->with(["translations", "duration",  "ship.translations"])->limit(6)->get();
        $blogs = $this->getBlogs();
         //   if($_SERVER["REMOTE_ADDR"]=="78.134.247.156") dd($cruise);

        if(!$cruise->departures->where("date",">",now())->min("date")){
            $minMonth="04-2022";
        }
        else{
            $minMonth=$cruise->departures->where("date",">",now())->min("date")->format("m Y");
        }

        if(session()->get('month')<$minMonth){
            $firstMonth=$minMonth;
        }
        else{
            foreach ($cruise->departures as $departure) {
                if (session()->get('month') == $departure->date->format('m Y')){
                    $firstMonth=session()->get('month');
                    break;
                }
                else{
                    $firstMonth=$minMonth;
                }
            }
        }

//        session()->put('month', $firstMonth);

        $countries=DB::table('countries')->get();
        return view('cruises.show')->with(compact("usesRecaptcha","cruise", "cruises", "blogs", "page_info", "countries", "firstMonth"));
    }

    public function bookingCabin()
    {
        $header = $this->cruiseBreadcrumbs();
        $month = date("Y-m");
        return view('cruises/booking.cabin')->with(compact([ "header"]));
    }

    public function bookingInfo()
    {
        $header = $this->cruiseBreadcrumbs();
        $month = date("Y-m");
        return view('cruises/booking.info')->with(compact([ "header"]));
    }

    public function cruiseBreadcrumbs()
    {
        return $header = (object)["tabs" =>
            [(object)[
                "number" => 1, "title" => "Select cabin"
            ],
                (object)[
                    "number" => 2, "title" => "Group Info"
                ],
            ]
        ];
    }

    public function sendMail(Request $request)
    {
        $month = date("Y-m");
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'email|required',
            'pax' => 'required',
            'dep_date' => 'required',
            'g-recaptcha-response' => [new GoogleReCaptchaV3ValidationRule('contact_us')]
        ]);

        if ($validator->fails()) {
            return response()->json(['response' => "error", "validator" => $validator->errors()]);
        }

        $mail_array = array(
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'phone' => $request->get('phone'),
            'country' => $request->get('country'),
            'pax' => $request->get('pax'),
            'date' => $request->get('dep_date'),
            'subject' => $request->get('subject'),
            'user_message' => $request->get('message'),
            'slug' => $request->get('slug')
        );
//        dd($mail_array);
//        return view('cruises.template', $mail_array);

        Mail::send('cruises.template', $mail_array,
            function ($message) use ($mail_array) {
                $message->bcc(config('mail.bcc'))->from('info@ch.hr', "MyCroatiaCruise Web")->to('info@ch.hr', 'Croatia Holidays')
                    ->replyTo($mail_array['email'], $mail_array['name'])->subject('MyCroatiaCruise | New cruise inquiry '.$mail_array['subject'].' | '.date("d.m.Y H:i"));
//                $message->bcc(config('mail.bcc'))->from('info@ch.hr', "MyCroatiaCruise Web")->to('marija@ch.hr', 'Croatia Holidays')
//                    ->replyTo($mail_array['email'], $mail_array['name'])->subject('MyCroatiaCruise | New inquiry | '. date_to_user($mail_array['date']).' | '.$mail_array['subject'].' | '.date("d.m.Y H:i"));
            });
        return response()->json(['response' => "success"]);
    }

    public function lmd(Request $request){
        $page = "special offer deals";
        $page_info = [
            "meta_title" => "Croatia Cruise | Special Offer Deals | Cruising Croatia",
            "meta_description" => "Find out more about the best online Croatia Cruise deals. Use the opportunity for stunning Special offer for cruising the Adriatic Coast with Small Ship Cruises.",
            "url" => route('cruises.lmd'),
            "image" => asset("assets/ship-search-bg.jpg"),
        ];
        $count = [];
        $temp = [];
        $blogs = $this->getBlogs();

//        \DB::enableQueryLog();
//        //neko dohvacanje podataka, npr ta metoda za EBD
//        MccExcursion::where("online", 1)->where('last_minute_deal', 1)->with(["translations", "duration", "header_image",  "ship.translations","start.translations","finish.translations", "destinations.translations"])->get();
//        $query = \DB::getQueryLog();
//        dd(end($query));

        $excursions = MccExcursion::where("online", 1)->where('last_minute_deal', 1)->with(["translations", "duration",   "ship.translations","start.translations","finish.translations", "destinations.translations"])->orderby("recommended", "desc")->getPrices();
        $excursions = $excursions->whereHas("departures", function ($q) {
            return $q->getPrices();
        })->with(["departures" => function ($q) {
            return $q->getPrices();
        }
        ]);

        $excursions = $excursions->paginate(10);
        if ($request->ajax()) {
            if ($request->has("page"))
                return ["html" => view('ajax.cruises')->with(compact(["page","excursions"]))->render(), "trips" => ["total" => $excursions->total(), "current_page" => $excursions->currentPage(), "last_page" => $excursions->lastPage()]];
            return ["html" => view('ajax.filter_cruise')->with(compact(["page","excursions"]))->render(), "trips" => ["total" => $excursions->total(), "current_page" => $excursions->currentPage(), "last_page" => $excursions->lastPage()]];
        }

        return view('cruises.last-minute')->with(compact(["page_info", "excursions", "page", "blogs"]));
    }

    public function cruiseAndStay(Request $request){
        $page = "cruise and stay";
        $page_info = [
            "meta_title" => "Croatia Cruise | Cruise and Stay | Cruising Croatia",
            "meta_description" => "Find out more about the best online Croatia Cruise deals. Use the opportunity for stunning Cruise and Stay offers for cruising the Adriatic Coast with Small Ship Cruises.",
            "url" => route('cruises.cruiseAndStay'),
            "image" => asset("assets/ship-search-bg.jpg"),
        ];
        $count = [];
        $temp = [];
        $blogs = $this->getBlogs();

//        \DB::enableQueryLog();
//        //neko dohvacanje podataka, npr ta metoda za EBD
//        MccExcursion::where("online", 1)->where('last_minute_deal', 1)->with(["translations", "duration", "header_image",  "ship.translations","start.translations","finish.translations", "destinations.translations"])->get();
//        $query = \DB::getQueryLog();
//        dd(end($query));

        $excursions = MccExcursion::where("online", 1)->where('cruise_and_stay', 1)->with(["translations", "duration","ship.translations","start.translations","finish.translations", "destinations.translations"])->getPrices();
        $excursions = $excursions->whereHas("departures", function ($q) {
            return $q->getPrices();
        })->with(["departures" => function ($q) {
            return $q->getPrices();
        }
        ]);

        $excursions = $excursions->paginate(10);
        if ($request->ajax()) {
            if ($request->has("page"))
                return ["html" => view('ajax.cruises')->with(compact(["page","excursions"]))->render(), "trips" => ["total" => $excursions->total(), "current_page" => $excursions->currentPage(), "last_page" => $excursions->lastPage()]];
            return ["html" => view('ajax.filter_cruise')->with(compact(["page","excursions"]))->render(), "trips" => ["total" => $excursions->total(), "current_page" => $excursions->currentPage(), "last_page" => $excursions->lastPage()]];
        }

        return view('cruises.cruise-and-stay')->with(compact(["page_info", "excursions", "page", "blogs"]));
    }

    public function googleDynamicCsv(){

        $fileName = 'google-dynamic.csv';
        $date=date('Y-m-d');
        $year=date('Y');
//        dd($date);
        $excursions = MccExcursion::where("online", 1)->with(["translations", "duration", "departures", "prices", "ship.translations","start.translations","finish.translations", "destinations.translations"])
            ->whereHas("departures", function ($q) use ($date){
                return $q->where('date', '>', $date);
            })
            ->where('year','>=', $year)
            ->orderby("recommended", "desc")
            ->get();
//        dd($excursions);
        $tasks = [
            []
        ];
//        dd($tasks);

        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $columns = array('ID', 'Item title', 'Final URL', 'Image URL', 'Item description', 'Item category', 'Price', 'Sale price');

        $callback = function() use($excursions, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($excursions as $e) {
                $row['ID']  = $e->id;
                $row['Item title']    = $e->translations[0]->name;
                $row['Final URL']    = 'https://www.mycroatiacruise.com/adriatic-cruises-croatia/'.$e->translations[0]->slug;
                $row['Image URL']  = 'https://www.mycroatiacruise.com'.$e->ship->header_image->url;
                $row['Item description']  = str_replace(array('<p>', '</p>'), '', $e->translations[0]->cruise_description);
                $row['Item category']  = $e->ship->category->name;
                $row['Price']  = $e->getMinPriceAttribute()->price.' EUR';
                $row['Sale price']  = '';

                fputcsv($file, array($row['ID'], $row['Item title'], $row['Final URL'], $row['Image URL'], $row['Item description'], $row['Item category'], $row['Price'], $row['Sale price']));
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);



//        $date=date("Y-m-d");
//        $d=Carbon::createFromFormat("Y-m-d", $date);
////        dd($d);
////        $date = Carbon::createFromFormat("Y-m-d", $month);
//
//        $excursions = MccExcursion::where("online", 1)->with(["translations", "duration", "departures", "prices", "ship.translations","start.translations","finish.translations", "destinations.translations"])->orderby("recommended", "desc")->get();
////        dd($excursions[0]);
//        return view('cruises.google-dynamic-csv')->with(compact(['excursions']));


    }
}

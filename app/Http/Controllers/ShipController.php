<?php


namespace App\Http\Controllers;


use App\MccExcursion;
use App\Ship;
use Illuminate\Support\Carbon;


class ShipController extends Controller
{
    public function index(){
        $month = date("Y-m");

        //postavljeno da se prikaže peti mjesec 2024, kada se bude prebalo vratiti da se prikazuje trenutni mjesec samo zakomentirati redak
//        $month="2024-05";

        $month=substr($month, 0, 7);
        $date = Carbon::createFromFormat("Y-m", $month);

        if($date->month >= 9){
            $date->setYear($date->year+1);
            $date->setMonth(5);

        }
        if ($date->month < 5 || $date->month > 9) {
            $date->setMonth(5);
        };
        $month = $date;
        $page_info=[
            "meta_title"=>"Small Cruise Ships in Croatia | Croatia Cruise",
            "meta_description"=>"Our fleet of modern and luxurious cruise ships provides a unique way to explore the Adriatic Sea. Book now for an unforgettable small ship cruise in Croatia.",
            "url"=>url()->current(),
            "image"=>asset("/images/home-bg.png"),
        ];
        $page = "ships";


        $ships=Ship::where("online",1)->with(["header_image","images","translations","category"])
            ->where('charter', '!=', 1)
            ->orderByTranslation('name')
            ->get();
//        dd($ships);


//        $filters = ["all"=>"0", "adventure"=>"1", "deluxe"=>"2", "luxury"=>"3","gullets"=>"6"];
        $filters = ["all"=>"0", "deluxe superior"=>"3", "deluxe"=>"2",  "premium superior"=>"7", "gulets"=>"6"];
        $blogs = $this->getBlogs();
        return view('ships.index')->with(compact(["ships","page", "month","filters",  "blogs","page_info"]));
    }

    public function show($slug){


        $ship=Ship::with("translations","header_image","images","category","features")->whereTranslation("slug",$slug)->where("online",1)->first();
        if(!$ship){

            $ship=Ship::where("old_slug",$slug)->first();

                if($ship){
                    if($ship->online==1)
                        return redirect(route("ships.show",$ship->slug),301);
                    return redirect($ship->redirect_url?:route("home"),301);
                }
                abort(404);
        }

        $page_info=[
            "meta_title"=>$ship->meta_title,
            "meta_description"=>$ship->meta_description,
            "url"=>url()->current(),
            "image"=>asset($ship->header_image->url),
        ];

        $cruises=MccExcursion::where("ch_ship_id",$ship->id)->where("online",1)->with(["header_image","duration","destinations","start","finish"])->orderByDesc("recommended")->limit(12)->getPrices()->get();
        $blogs = $this->getBlogs();
        return view('ships.show')->with(compact(["ship", "cruises", "blogs", "page_info"]));
    }
}

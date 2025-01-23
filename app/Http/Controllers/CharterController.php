<?php

namespace App\Http\Controllers;

use App\Ship;

class CharterController extends Controller
{
     public function index(){

            $page_info=[
                "meta_title"=>"Small Cruise Ships in Croatia | Croatia Cruise",
                "meta_description"=>"The best small ship cruises on the Adriatic. With a fleet of more than 60 ships in different categories, the cruise line caters to all ages and budgets.",
                "url"=>url()->current(),
                "image"=>asset("/images/home-bg.png"),
            ];
            $page = "charters";


//            $ships=Ship::where("online",1)->with(["header_image","images","translations","category"])->orderByTranslation('name')->get();
            $ships=Ship::where("online", 1)->with(["header_image","images","translations","category", "main_ship"])
                ->whereHas('main_ship', function ($q){
                    return $q->where('charter', '>', 0);
                })
                ->orderByTranslation('name')
                ->get();


            $blogs = $this->getBlogs();
         $filters = ["all"=>"0", "gulets"=>"6", "luxury sailing yacht"=>"9", "mini cruisers"=>"10", "motor yachts"=>"11" ];

         return view('charters.index')->with(compact(["ships","page","filters", "blogs","page_info"]));
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
//        dd($ship);

//        $cruises=MccExcursion::where("ch_ship_id",$ship->id)->where("online",1)->with(["header_image","duration","destinations","start","finish"])->orderByDesc("recommended")->limit(12)->getPrices()->get();
        $blogs = $this->getBlogs();
//        return view('ships.show')->with(compact(["ship", "blogs", "page_info"]));

        return view('charters.show')->with(compact(["ship", "blogs", "page_info"]));
    }
}
?>

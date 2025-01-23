<?php


namespace App\Http\Controllers;


use App\MccDestination;

class StartingPortController extends Controller
{
    public function index(){

        $page = "starting_ports";
        $ports=MccDestination::whereHas("start_cruise")->with("translations")->where("online",1)->get();
        $page_info=[
            "meta_title"=>"Cruise Ports | Croatia Cruise",
            "meta_description"=>"Our cruises start from ".$ports->count()." different ports in Croatia - Dubrovnik Omiš, Split and Opatija. Choose your starting port and we will show you the list of all our cruises that start from chosen location.",
            "url"=>url()->current(),
            "image"=>asset("/images/home-bg.png"),
        ];
        $cruises=$this->getRecommendedCruises();
        $blogs = $this->getBlogs();
        return view('ports.index')->with(compact(["ports", "page", "cruises",  "blogs","page_info"]));
    }
}

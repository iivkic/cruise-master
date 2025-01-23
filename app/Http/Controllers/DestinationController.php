<?php


namespace App\Http\Controllers;


use App\MccDestination;
use App\MccExcursion;

class DestinationController extends Controller
{
    public function index(){
        $page_info=[
            "meta_title"=>"Adriatic Cruises | Croatia Cruises | Croatia Cruise",
            "meta_description"=>"Sail Croatia's stunning coast with My Croatia Cruise. Discover the wonders of Croatia while cruising on one of our small ship cruises!",
            "url"=>url()->current(),
            "image"=>asset("/images/home-bg.png"),
        ];
        $page = "destinations";
        $destinations=MccDestination::where("online",1)->with("translations","header_image")->orderBy("name")->get();
        $blogs = $this->getBlogs();
        return view('destinations.index')->with(compact(["destinations", "page", "blogs","page_info"]));
    }

    public function oldSlug($slug){
        return redirect(route('destinations.show', ["slug"=>$slug]), 301);
    }

    public function show($slug){

        $destination=MccDestination::with("translations","header_image","images")->whereTranslation("slug",$slug)->where("online",1)->first();
        if(!$destination){

            $destination=MccDestination::where("old_slug",$slug)->first();

            if($destination){
                if($destination->online==1)
                    return redirect(route("destinations.show",$destination->slug),301);
                return redirect($destination->redirect_url?:route("home"),301);
            }
            abort(404);
        }
//        dd($destination);

        $page_info=[
            "meta_title"=>$destination->meta_title,
            "meta_description"=>$destination->meta_description,
            "url"=>url()->current(),
            "image"=>asset($destination->header_image->url),
        ];


        $cruises = MccExcursion::whereHas("destinations",function($q)use($destination){$q->where("mcc_destination_id",$destination->id);})->whereHas('ship')->with("translations","header_image","destinations")->where("online",1)->getPrices()->orderByDesc("recommended")->limit(12)->get();
        $blogs = $this->getBlogs();
        return view('destinations.show')->with(compact(["page_info","cruises", "blogs","destination"]));
    }
}

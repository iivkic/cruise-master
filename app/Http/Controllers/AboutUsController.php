<?php


namespace App\Http\Controllers;


use Illuminate\Support\Facades\File;

class AboutUsController extends Controller
{
    public function index(){

        $page = "about-us";
        $page_info=[
            "meta_title"=>"About Us | Croatia Cruise",
            "meta_description"=>"My Croatia Cruise acts as an online marketplace platform for Adriatic
        Cruises under the umbrella of Croatia Holidays Ltd",
            "url"=>url()->current(),
            "image"=>asset("/images/home-bg.png"),
        ];
        $cruises=$this->getRecommendedCruises();
        $blogs = $this->getBlogs();
        return view('about')->with(compact(["page", "cruises",  "blogs","page_info"]));
    }
    public function faq(){

        $page = "faq";
        $json = file_get_contents(public_path('faq.json'));
        $faq =json_decode($json, true);
        $page_info=[
            "meta_title"=>"Frequently asked questions | Croatia Cruise",
            "meta_description"=>"Find answers to the most frequently asked questions about our small ship cruises in Croatia",
            "url"=>url()->current(),
            "image"=>asset("/images/home-bg.png"),
        ];
        $cruises=$this->getRecommendedCruises();
        $blogs = $this->getBlogs();
        return view('faq')->with(compact(["page", "cruises",  "blogs","page_info", "faq"]));
    }
}

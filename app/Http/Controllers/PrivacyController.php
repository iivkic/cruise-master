<?php


namespace App\Http\Controllers;


class PrivacyController extends Controller
{
    public function index(){

        $page = "privacy-policy";
        $page_info=[
            "meta_title"=>"Privacy Policy | Croatia Cruise",
            "meta_description"=>"Our GDPR compliant privacy policy ensures the safety of your personal information",
            "url"=>url()->current(),
            "image"=>asset("/images/home-bg.png"),
        ];
        $cruises=$this->getRecommendedCruises();
        $blogs = $this->getBlogs();
        return view('privacy')->with(compact(["page", "cruises",  "blogs","page_info"]));
    }
}

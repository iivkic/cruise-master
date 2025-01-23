<?php


namespace App\Http\Controllers;


class TermsController extends Controller
{
    public function index(){

        $page = "terms-and-conditions";
        $page_info=[
            "meta_title"=>"Terms and Conditions | Croatia Cruise",
            "meta_description"=>"Read our full terms and conditions, but do not hesitate to contact us for any further questions",
            "url"=>url()->current(),
            "image"=>asset("/images/home-bg.png"),
        ];
        $cruises=$this->getRecommendedCruises();
        $blogs = $this->getBlogs();
        return view('terms')->with(compact(["page", "cruises",  "blogs","page_info"]));
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CovidController extends Controller
{
    public function index(){

        $page = "covid";
        $page_info=[
            "meta_title"=>"Covid-19 | Croatia Cruise",
            "meta_description"=>"Due to the official restrictions of the Government of Croatia related to COVID-19",
            "url"=>url()->current(),
            "image"=>asset("/images/home-bg.png"),
        ];
        $cruises=$this->getRecommendedCruises();
        $blogs = $this->getBlogs();
        return view('covid')->with(compact(["page", "cruises",  "blogs","page_info"]));
    }
}

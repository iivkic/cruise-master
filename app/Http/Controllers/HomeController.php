<?php

namespace App\Http\Controllers;

use App\MccExcursion;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Request;


class HomeController extends Controller
{
    public function index(){


        $page_info=[
            "meta_title"=>"Croatia Cruises 2025 | Book Your Dream Holiday",
            "meta_description"=>"Embark on a Croatia cruise adventure. Discover hidden gems along the coastline on our small ship cruise. Book your unforgettable Croatia cruise today!",
            "url"=>url()->current(),
            "image"=>asset("/images/home-bg.png"),
        ];
        $page="home";


        $cruises= $this->getRecommendedCruises();
        $blogs = $this->getBlogs();
        $lmd_images = MccExcursion::where('last_minute_deal', 1)->with('header_image')->limit(3)->inRandomOrder()->get();
        $lmd = MccExcursion::where('last_minute_deal', 1)->count();
        $usesRecaptcha=false;
        return view('welcome')->with(compact(['page','page_info','cruises', 'blogs', 'lmd', 'lmd_images','usesRecaptcha']));
    }
    public function remove(){
        $index=Request::get("wishlist");
        $wishlist=session()->get("wishlist",[]);
        array_splice($wishlist,$index,1);
        if($index==-1) $wishlist=[];
        session()->put("wishlist",$wishlist);
        return view("ajax.wishlist");
    }
    public function addToWishlist(){
        $index=Request::get("index");
        $excursion=MccExcursion::with(["header_image","ship.translations","start","finish"])->find($index);
        $wishlist=session()->get("wishlist",[]);
        $wishlist[$excursion->id]=$excursion;
        session()->put("wishlist",$wishlist);
        return view("ajax.wishlist");
    }
    public function setCurrency(){
        $data=Request::get("currency");
        $currency=Controller::getCurrencies()[$data];
        session()->put("currency",$currency);
        return $currency;
    }
    public function setView(){
        $data=Request::get("detailed");
        session()->put("detailed_view",$data);
        return "Success change view!";
    }
}

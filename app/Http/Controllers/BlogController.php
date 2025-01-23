<?php


namespace App\Http\Controllers;


use App\Blog;

class BlogController extends Controller
{
    public function index(){
        $page_info=[
            "meta_title"=>"Cruise Blog | Croatia Cruise",
            "meta_description"=>"Read more about cruises in Croatia and why it will be your best choice to book one straight away. A lot of useful information on Adriatic cruises.",
            "url"=>url()->current(),
            "image"=>asset("/images/home-bg.png"),
        ];
        $page = "blogs";
        $popular = $this->getBlogs();
        $blogs= Blog::with("header_image","translations")->where("online",1)->orderBy("created_at","desc")->get();
        $cruises=$this->getRecommendedCruises();
        return view('blogs.index')->with(compact(["cruises", "page_info", "blogs","popular"]));
    }

    public function show($slug){
        $blog = Blog::with(["header_image","translations"])->whereTranslation("slug",$slug)->where("online",1)->first();
        if(!$blog){
            abort(404);
        }

        $page_info=[
            "meta_title"=>$blog->meta_title,
            "meta_description"=>$blog->meta_description,
            "url"=>url()->current(),
            "image"=>asset($blog->header_image->url),
        ];
        $page = "blog";
        $cruises=$this->getRecommendedCruises();
        $blogs= Blog::where("id","<>",$blog->id)->with("header_image")->where("online",1)->limit(3)->get();

        return view('blogs.show')->with(compact(["cruises", "blog", "blogs","page_info"]));
    }
}

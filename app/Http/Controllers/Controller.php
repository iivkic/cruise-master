<?php

namespace App\Http\Controllers;

use App\Blog;
use App\MccExcursion;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        if(!session()->has('show_cookie_consent')) {
            session()->put("show_cookie_consent", true);
        }
        if(!session()->has('use_analytics')) {
            session()->put("use_analytics", true);
        }
    }


    public static function getCurrencies()
    {
        $today = date("Y-m-d");
        $fileName = "tecaj/$today.json";
//       $fileName="tecaj/2022-10-21.json";
        $today = null;
        if (!is_file(public_path($fileName))) {
            $curl = curl_init();
            curl_setopt_array($curl, [
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_URL => 'https://api.hnb.hr/tecajn-eur/v3'
            ]);
            $result = curl_exec($curl);
            if ($result) {
                $today = json_decode($result, true);
                $result=[];
                foreach ($today as $c) {
                    $c["name"]=show_currency_name($c["valuta"]);
                    $result[$c["valuta"]] = $c;
                }
                $today = $result;
                $handle = fopen(public_path($fileName), "w");
                $result=json_encode($today);
                fwrite($handle, $result);
                fclose($handle);
                $today = json_decode(file_get_contents(public_path($fileName)), true);
            }


        } else {
            $today = json_decode(file_get_contents(public_path($fileName)), true);
        }
//        $fileName = "tecaj/" . date("Y-m-d", strtotime("yesterday")) . ".json";
//        $yesterday = is_file($fileName)?json_decode(file_get_contents($fileName), true):$today;
        $today["EUR"]=["broj_tecajnice" => "1",
            "datum_primjene" => "2023-01-01",
            "drzava" => "Hrvatska",
            "drzava_iso" => "HR",
            "sifra_valute" => "978",
            "valuta" => "EUR",
            "kupovni_tecaj" => "1",
            "srednji_tecaj" => "1",
            "prodajni_tecaj" => "1",
            "name"=>"Euro Member Countries"
        ];
        return $today;
    }

    public function getBlogs(){
        $blogs=Blog::where("online",1)->with("translations")->orderBy("created_at","desc")->limit(3)->get();
        return $blogs;
    }

    public function getRecommendedCruises(){
        $recommended = MccExcursion::with(["header_image","duration","destinations","start","finish"])->where("online",1)->where('recommended', 1)->orderByDesc('id')->limit(12)->getPrices()->get();
        return $recommended;
    }

}

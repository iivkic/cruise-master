<?php

namespace App\Providers;

use App\ExcursionDeparture;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if(App::environment('production')) {
            $this->app->bind('path.public', function () {
                return base_path('public_html');
            });
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        $month = date("Y-m");
        $month=substr($month, 0, 7);
        $date = Carbon::createFromFormat("Y-m", $month);
        if($date->month >= 9){
            $date->setYear($date->year+1);
            $date->setMonth(5);

        }
        if ($date->month < 5 || $date->month > 9) {
            $date->setMonth(5);
        };

        $month = $date;
        $currency=HomeController::getCurrencies();
        $departures=ExcursionDeparture::whereHas("excursion",function($q){$q->where("online",1);})->where("date",">",now())->where("date","not like","%-01-01%")->select("date")->distinct()->orderBy("date")->get();
        View::share('departures', $departures);
        View::share('currencies', $currency);
        View::share('month', $month);
        date_default_timezone_set('Europe/Zagreb');
        \Blade::directive('svg', function($arguments) {
            // Funky madness to accept multiple arguments into the directive
            list($path, $class) = array_pad(explode(',', trim($arguments, "() ")), 2, '');
            $path = trim($path, "' ");
            $class = trim($class, "' ");

            // Create the dom document as per the other answers
            $svg = new \DOMDocument();
            $svg->load(public_path($path));
            $svg->documentElement->setAttribute("class", $class);
            $output = $svg->saveXML($svg->documentElement);

            return $output;
        });
    }
}

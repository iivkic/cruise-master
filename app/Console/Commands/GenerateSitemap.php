<?php

namespace App\Console\Commands;
use App\Blog;
use App\MccDestination;
use App\MccExcursion;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class GenerateSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate the sitemap';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $endDate=$initialDate=Carbon::create(2020, 5, 12);

        $cruises=MccExcursion::with(['translations'])->where('online', 1)->get();
        $sitemap=Sitemap::create();

        $newestSearchDate=$initialDate;

        foreach ($cruises as $cruise){
            $cruiseTimestamp=$cruise->updated_at;
            $sitemap->add(Url::create(route('cruises.show', ["slug"=>$cruise->slug]))->setPriority(0.6)
            ->setLastModificationDate($cruiseTimestamp));

            if($cruiseTimestamp->gt($newestSearchDate)) {
                $newestSearchDate=$cruiseTimestamp;
            }
        }

        if($newestSearchDate->gt($endDate)){
            $endDate=$newestSearchDate;
        }

        $sitemap->add(Url::create(route('cruises.index'))->setPriority(1)->setLastModificationDate($newestSearchDate));


        $blogs=Blog::with(['translations'])->where('online', 1)->get();
        $newestBlogDate=$initialDate;

        foreach ($blogs as $blog){
            $blogTimestamp=$blog->updated_at;

            $sitemap->add(Url::create(route('blogs.show', ["slug"=>$blog->slug]))
                ->setPriority(0.6)->setLastModificationDate($blogTimestamp));

            if($blogTimestamp->gt($newestBlogDate)){
                $newestBlogDate=$blogTimestamp;
            }
        }
        $sitemap->add(Url::create(route('blogs.index'))->setPriority(1)->setLastModificationDate($newestBlogDate));
        if($newestBlogDate->gt($endDate)){
            $endDate=$newestBlogDate;
        }


        $ports=MccDestination::with(['translations'])->where('online', 1)->get();
        $newestPortDate=$initialDate;

        foreach ($ports as $port){
            $portTimestamp=$port->updated_at;

            $sitemap->add(Url::create(route('destinations.show', ["slug"=>$port->slug]))
                ->setPriority(0.6)->setLastModificationDate($portTimestamp));

            if($portTimestamp->gt($newestPortDate)){
                $newestPortDate=$portTimestamp;
            }
        }
        $sitemap->add(Url::create(route('destinations.index'))->setPriority(1)->setLastModificationDate($newestBlogDate));
        if($newestPortDate->gt($endDate)){
            $endDate=$newestPortDate;
        }


        $sitemap->add(Url::create(route('ports.index'))->setPriority(1)->setLastModificationDate($initialDate));

        $sitemap->add(Url::create(route('contact'))->setPriority(1)->setLastModificationDate($initialDate));
        $sitemap->add(Url::create(route('about-us'))->setPriority(0.8)->setLastModificationDate($initialDate));
        $sitemap->add(Url::create(route('terms'))->setPriority(0.6)->setLastModificationDate($initialDate));
        $sitemap->add(Url::create(route('privacy'))->setPriority(0.6)->setLastModificationDate($initialDate));

        $sitemap->add(Url::create('/')->setPriority(1)->setLastModificationDate($initialDate))
            ->writeToFile(public_path('sitemap.xml'));


    }
}

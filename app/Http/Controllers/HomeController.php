<?php

namespace App\Http\Controllers;

use App\Mail\MyCustomMail;
use App\Models\Cities;
use App\Models\Page;
use App\Models\PageTranslation;
use App\Models\Council;
use App\Models\Complain;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
     public function sendEmail()
      {
       $subject = '';
       $title = '';
     $content = '';

      Mail::to('sekangms13@gmail.com')->send(new MyCustomMail($subject, $title, $content));
     echo 'Email sent successfully';

        // You can also use the `cc`, `bcc`, and `from` methods to add more recipients or specify the sender.
       }
    public function index()
    {

        return view('theme.home');
    }
    public function cities()
    {
        $cities = Cities::all();
        return redirect()->to('karbon-rapor-kurumsal', compact('cities'));
    }

    public function index_old()
    {

        $locale = app()->getLocale();


        $home_carrer = getComponent('home_career');
        $home_history = getComponent('home_history');
        $home_tv = getComponent('home_tv');
        $ugmcevapliyor = getComponent('ugmcevapliyor');

           $service_carousel =  cache()->tags(['pages'])->remember('service_carousel_'.$locale, 60*60*24, function () {
         return Page::where('parent_id', 88)->limit(8)->orderBy('id', 'desc')->get();
         });
        $birbilenesorudk = cache()->tags(['pages'])->remember('birbilenesorudk_'.$locale, 60*60*24, function () {
            return Page::where('parent_id', 112)->whereTranslation('status',1)->orderBy('id', 'desc')->limit(12)->get();
        });

        $faq = cache()->tags(['pages'])->remember('faq_'.$locale, 60*60*24, function () {
            return PageTranslation::where('status', 1)
                ->where('locale', app()->getLocale())
                ->whereHas('page', function ($query) {
                    $query->where('parent_id', '708');
                })->orderBy('sort_order', 'asc')->limit(6)->get();
        });

        $sliders = cache()->tags(['pages'])->remember('sliders_'.$locale, 60*60*24, function () {
            return PageTranslation::where('status', 1)
                ->where('locale', app()->getLocale())
                ->whereHas('page', function ($query) {
                    $query->where('parent_id', '93');
                })->orderBy('sort_order', 'asc')->get();
        });

        $circular = cache()->tags(['pages'])->remember('circular_'.$locale, 60*60*24, function () {
            return Page::where('parent_id', 109)->whereTranslation('status',1)->orderBy('id', 'desc')->limit(6)->get();
        });

        $gundemguncel_items = cache()->tags(['pages'])->remember('gundemguncel_items_'.$locale, 60*60*24, function () {
            return PageTranslation::where('status', 1)->where('locale',app()->getLocale())
                ->whereHas('page', function ($query)  {
                    $query->where('parent_id', 13170);
                })->orderBy('id', 'desc')->limit(3)->get();
        });

        $gundemguncel = cache()->tags(['pages'])->remember('gundemguncel_'.$locale, 60*60*24, function () {
            return Page::where('id', 13170)->whereTranslation('status',1)->first();
        });

        $sonhabeler = cache()->tags(['pages'])->remember('sonhaberler_'.$locale, 60*60*24, function () {
            return PageTranslation::where('status', 1)->where('locale',app()->getLocale())
                ->whereHas('page', function ($query)  {
                    $query->where('parent_id', 734);
                })->orderBy('id', 'desc')->limit(5)->get();
        });

        $sonmedya = cache()->tags(['pages'])->remember('sonmedya'.$locale, 60*60*24, function () {
            return PageTranslation::where('status', 1)->where('locale',app()->getLocale())
                ->whereHas('page', function ($query)  {
                    $query->where('parent_id', 13826);
                })->orderBy('id', 'desc')->limit(5)->get();
        });


        return view('theme.home', compact(
            'home_carrer',
            'home_history',
            'service_carousel',
            'birbilenesorudk',
            'faq',
            'sliders',
            'circular',
            'gundemguncel',
            'gundemguncel_items',
            'home_tv',
            'sonhabeler',
            'sonmedya',
            'ugmcevapliyor'
        ));
    }
}

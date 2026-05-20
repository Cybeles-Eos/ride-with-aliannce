<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Http\Traits\SystemSettingTrait;

class FrontTemplateProvider extends ServiceProvider
{
    use SystemSettingTrait;

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer(['front.layouts.base', 'errors.layouts.base', 'errors.site_restricted'], function ($view) {
            /*global variables*/
            $seo_meta = $this->getSeoMeta();
            $system_settings = $this->getSystemSettings();
            $logged_user = auth()->user();
            $logged_in = auth()->check();
            /*global variables*/

            $front_template = $this->getFrontConfig($seo_meta);
            $front_primary_nav = $this->getFrontNav();

            $view->with(compact(
                'system_settings',
                'logged_user',
                'logged_in',
                'front_template',
                'front_primary_nav'
            ));
        });
    }

    private function getFrontNav()
    {
        return [
            [
                'name' => 'Home',
                'url' => url('/'),
                'never_active' => true,
            ],
            [
                'name' => 'About',
                'sub' => [
                    [
                        'name' => 'About Us',
                        'url' => url('/about-us')
                    ]
                ]
            ],
            [
                'name' => 'Contact Us',
                'url' => url('/contact-us')
            ]
        ];
    }

    private function getFrontConfig($seo_meta)
    {
        return [
            'name' => $seo_meta['name'],
            'version' => '1.0',
            'author' => $seo_meta['author'],
            'robots' => $seo_meta['robots'],
            'title' => $seo_meta['title'],
            'description' => $seo_meta['description'],
            // true             for a boxed layout
            // false            for a full width layout
            'boxed' => false,
            'active_page' => url()->current() /*basename($_SERVER['PHP_SELF'])*/
        ];
    }
}

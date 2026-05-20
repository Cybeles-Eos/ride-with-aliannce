<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Http\Traits\SystemSettingTrait;

class AdminTemplateProvider extends ServiceProvider
{
    use SystemSettingTrait;

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer(['admin.layouts.base', 'admin.layouts.auth', ], function ($view) {
            /*global variables*/
            $seo_meta = $this->getSeoMeta();
            $system_settings = $this->getSystemSettings();
            $logged_user = auth()->user();
            $logged_in = auth()->check();
            /*global variables*/

            $admin_primary_nav = $this->getAdminNav();
            $admin_template = $this->getAdminConfig($seo_meta);

            $view->with(compact(
                'admin_template',
                'system_settings',
                'logged_user',
                'logged_in',
                'admin_primary_nav'
            ));
        });
    }

    private function getAdminNav()
    {
        $navigation = [
            [
                'name' => 'Dashboard',
                'url' => url('admin/dashboard'),
                'icon' => 'fa fa-dashboard'
            ],
            [
                'name' => 'Front-end Site',
                'url' => url('/'),
                'never_active' => true,
                'icon' => 'fa fa-paper-plane-o'
            ],
        ];

        if (auth()->check()) {
            if ($this->hasCrudAccessFor('Page')) {
                array_push($navigation, [
                    'name' => 'Pages',
                    'url' => url('admin/pages'),
                    'icon' => 'fa fa-archive'
                ]);
            }

            if ($this->hasCrudAccessFor('Home Slide')) {
                array_push($navigation, [
                    'name' => 'Home Slides',
                    'url' => url('admin/home_slides'),
                    'icon' => 'fa fa-sliders'
                ]);
            }

            if (auth()->user()->can('Read Contact')) {
                array_push($navigation, [
                    'name' => 'Contacts',
                    'url' => url('admin/contacts'),
                    'icon' => 'fa fa-phone'
                ]);
            }

            if ($this->hasCrudAccessFor('Product')) {
                array_push($navigation, [
                    'name' => 'Products',
                    'url' => url('admin/products'),
                    'icon' => 'fa fa-shopping-basket'
                ]);
            }

            if ($this->hasCrudAccessFor('Product Category')) {
                array_push($navigation, [
                    'name' => 'Product Categories',
                    'url' => url('admin/product_categories'),
                    'icon' => 'fa fa-shopping-basket'
                ]);
            }

            // CMS Management Section
            $cms_management_tab = [];
            
            // Section Templates
            if ($this->hasCrudAccessFor('Section Template') || auth()->user()->can('manage cms')) {
                array_push($cms_management_tab, [
                    'name' => 'Section Templates',
                    'url' => url('admin/section-templates'),
                    'icon' => 'fa fa-puzzle-piece'
                ]);
            }
            
            // Media Library
            if ($this->hasCrudAccessFor('Media') || auth()->user()->can('manage cms')) {
                array_push($cms_management_tab, [
                    'name' => 'Media Library',
                    'url' => url('admin/media'),
                    'icon' => 'fa fa-file-image-o'
                ]);
            }
            
            // Add CMS Management menu if user has access to any CMS components
            if (!empty($cms_management_tab)) {
                array_push($navigation, [
                    'name' => 'CMS Management',
                    'icon' => 'fa fa-cogs',
                    'sub' => $cms_management_tab
                ]);
            }

            if ($this->hasCrudAccessFor('User') || $this->hasCrudAccessFor('Permission') || $this->hasCrudAccessFor('Permission Group') || $this->hasCrudAccessFor('Role')) {
                $user_management_tab = [];

                if ($this->hasCrudAccessFor('User')) {
                    array_push($user_management_tab, [
                        'name' => 'Users',
                        'url' => url('admin/users'),
                    ]);
                }


                if ($this->hasCrudAccessFor('Permission')) {
                    array_push($user_management_tab, [
                        'name' => 'Permissions',
                        'url' => url('admin/permissions'),
                    ]);
                }

                if ($this->hasCrudAccessFor('Permission Group')) {
                    array_push($user_management_tab, [
                        'name' => 'Permission Groups',
                        'url' => url('admin/permission_groups'),
                    ]);
                }

                if ($this->hasCrudAccessFor('Role')) {
                    array_push($user_management_tab, [
                        'name' => 'Roles',
                        'url' => url('admin/roles'),
                    ]);
                }

                array_push($navigation, [
                    'name' => 'User Management',
                    'icon' => 'fa fa-users',
                    'sub' => $user_management_tab
                ]);
            }

            if ($this->hasCrudAccessFor('System Setting')) {
                array_push($navigation, [
                    'name' => 'System Settings',
                    'url' => url('admin/system_settings'),
                    'icon' => 'fa fa-gears'
                ]);
            }
        }

        return $navigation;
    }

    private function hasCrudAccessFor($module)
    {
        return auth()->user()->hasAnyPermission([
            "Create {$module}",
            "Read {$module}",
            "Update {$module}",
            "Delete {$module}",
        ]);
    }

    private function getAdminConfig($seo_meta)
    {

        $string = $seo_meta['name'];
        $words = explode(' ', $string);
        $first_word = $words[0] ?? '';

        return [
            'name' => $seo_meta['name'],
            'name_acronym'  =>  $first_word,
            'version' => '1.0',
            'author' => $seo_meta['author'],
            'robots' => $seo_meta['robots'],
            'title' => $seo_meta['title'],
            'description' => $seo_meta['description'],
            // true                     enable page preloader
            // false                    disable page preloader
            'page_preloader' => true,
            // true                     enable main menu auto scrolling when opening a submenu
            // false                    disable main menu auto scrolling when opening a submenu
            'menu_scroll' => true,
            // 'navbar-default'         for a light header
            // 'navbar-inverse'         for a dark header
            'header_navbar' => 'navbar-inverse',
            // ''                       empty for a static layout
            // 'navbar-fixed-top'       for a top fixed header / fixed sidebars
            // 'navbar-fixed-bottom'    for a bottom fixed header / fixed sidebars
            'header' => 'navbar-fixed-top',
            // ''                                               for a full main and alternative sidebar hidden by default (> 991px)
            // 'sidebar-visible-lg'                             for a full main sidebar visible by default (> 991px)
            // 'sidebar-partial'                                for a partial main sidebar which opens on mouse hover, hidden by default (> 991px)
            // 'sidebar-partial sidebar-visible-lg'             for a partial main sidebar which opens on mouse hover, visible by default (> 991px)
            // 'sidebar-mini sidebar-visible-lg-mini'           for a mini main sidebar with a flyout menu, enabled by default (> 991px + Best with static layout)
            // 'sidebar-mini sidebar-visible-lg'                for a mini main sidebar with a flyout menu, disabled by default (> 991px + Best with static layout)
            // 'sidebar-alt-visible-lg'                         for a full alternative sidebar visible by default (> 991px)
            // 'sidebar-alt-partial'                            for a partial alternative sidebar which opens on mouse hover, hidden by default (> 991px)
            // 'sidebar-alt-partial sidebar-alt-visible-lg'     for a partial alternative sidebar which opens on mouse hover, visible by default (> 991px)
            // 'sidebar-partial sidebar-alt-partial'            for both sidebars partial which open on mouse hover, hidden by default (> 991px)
            // 'sidebar-no-animations'                          add this as extra for disabling sidebar animations on large screens (> 991px) - Better performance with heavy pages!
            'sidebar' => 'sidebar-visible-lg sidebar-mini sidebar-no-animations',
            // ''                       empty for a static footer
            // 'footer-fixed'           for a fixed footer
            'footer' => '',
            // ''                       empty for default style
            // 'style-alt'              for an alternative main style (affects main page background as well as blocks style)
            'main_style' => '',
            // ''                           Disable cookies (best for setting an active color theme from the next variable)
            // 'enable-cookies'             Enables cookies for remembering active color theme when changed from the sidebar links (the next color theme variable will be ignored)
            'cookies' => '',
            // 'night', 'amethyst', 'modern', 'autumn', 'flatie', 'spring', 'fancy', 'fire', 'coral', 'lake',
            // 'forest', 'waterlily', 'emerald', 'blackberry' or '' leave empty for the Default Blue theme
            'theme' => 'flatie',
            // ''                       for default content in header
            // 'horizontal-menu'        for a horizontal menu in header
            // This option is just used for feature demostration and you can remove it if you like. You can keep or alter header's content in page_head.blade.php
            'header_content' => '',
            'active_page' => url()->current() /*basename($_SERVER['PHP_SELF'])*/
        ];
    }
}

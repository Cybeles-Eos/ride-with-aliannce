<div id="sidebar">
    <div id="sidebar-scroll">
        <div class="sidebar-content">
            <a href="{{ url('admin/dashboard') }}" class="sidebar-brand">
                <i class="gi gi-flash"></i>
                <span class="sidebar-nav-mini-hide"><strong>{{ $admin_template['name_acronym'] }}</strong></span>
            </a>
            <div class="sidebar-section sidebar-user clearfix sidebar-nav-mini-hide">
                <div class="sidebar-user-avatar">
                    <a href="javascript:void(0)">
                        @if (auth()->user()->profile_image != '')
                            <img src="{{ asset(auth()->user()->profile_image) }}" alt="avatar">
                        @else
                            <img src="{{asset('public/images/placeholders/avatars/avatar2.jpg')}}" alt="avatar">
                        @endif
                    </a>
                </div>
                <div class="sidebar-user-name">{{$logged_user->first_name}}</div>
                <div class="sidebar-user-links">
                    <a href="{{ url('/admin/logout') }}" data-toggle="tooltip" data-placement="bottom" title="Logout" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                        <i class="gi gi-exit"></i>
                    </a>
                </div>
            </div>
            <ul class="sidebar-section sidebar-themes clearfix sidebar-nav-mini-hide">
                <li>
                    <a href="javascript:void(0)" class="themed-background-dark-night themed-border-night"
                       data-theme="{{ asset('public/css/themes/night.css') }}"
                       data-toggle="tooltip" title="Night"></a>
                </li>
                <li>
                    <a href="javascript:void(0)" class="themed-background-dark-amethyst themed-border-amethyst"
                       data-theme="{{ asset('public/css/themes/amethyst.css') }}"
                       data-toggle="tooltip" title="Amethyst"></a>
                </li>
                <li>
                    <a href="javascript:void(0)" class="themed-background-dark-modern themed-border-modern"
                       data-theme="{{ asset('public/css/themes/modern.css') }}"
                       data-toggle="tooltip" title="Modern"></a>
                </li>
                <li>
                    <a href="javascript:void(0)" class="themed-background-dark-autumn themed-border-autumn"
                       data-theme="{{ asset('public/css/themes/autumn.css') }}"
                       data-toggle="tooltip" title="Autumn"></a>
                </li>
                <li class="active">
                    <a href="javascript:void(0)" class="themed-background-dark-flatie themed-border-flatie"
                       data-theme="{{ asset('public/css/themes/flatie.css') }}"
                       data-toggle="tooltip" title="Flatie"></a>
                </li>
                <li>
                    <a href="javascript:void(0)" class="themed-background-dark-spring themed-border-spring"
                       data-theme="{{ asset('public/css/themes/spring.css') }}"
                       data-toggle="tooltip" title="Spring"></a>
                </li>
                <li>
                    <a href="javascript:void(0)" class="themed-background-dark-fancy themed-border-fancy"
                       data-theme="{{ asset('public/css/themes/fancy.css') }}"
                       data-toggle="tooltip" title="Fancy"></a>
                </li>
                <li>
                    <a href="javascript:void(0)" class="themed-background-dark-fire themed-border-fire"
                       data-theme="{{ asset('public/css/themes/fire.css') }}"
                       data-toggle="tooltip" title="Fire"></a>
                </li>
                <li>
                    <a href="javascript:void(0)" class="themed-background-dark-coral themed-border-coral"
                       data-theme="{{ asset('public/css/themes/coral.css') }}"
                       data-toggle="tooltip" title="Coral"></a>
                </li>
                <li>
                    <a href="javascript:void(0)" class="themed-background-dark-lake themed-border-lake"
                       data-theme="{{ asset('public/css/themes/lake.css') }}"
                       data-toggle="tooltip" title="Lake"></a>
                </li>
                <li>
                    <a href="javascript:void(0)" class="themed-background-dark-forest themed-border-forest"
                       data-theme="{{ asset('public/css/themes/forest.css') }}"
                       data-toggle="tooltip" title="Forest"></a>
                </li>
                <li>
                    <a href="javascript:void(0)"
                       class="themed-background-dark-waterlily themed-border-waterlily"
                       data-theme="{{ asset('public/css/themes/waterlily.css') }}"
                       data-toggle="tooltip" title="Waterlily"></a>
                </li>
                <li>
                    <a href="javascript:void(0)" class="themed-background-dark-emerald themed-border-emerald"
                       data-theme="{{ asset('public/css/themes/emerald.css') }}"
                       data-toggle="tooltip" title="Emerald"></a>
                </li>
                <li>
                    <a href="javascript:void(0)"
                       class="themed-background-dark-blackberry themed-border-blackberry"
                       data-theme="{{ asset('public/css/themes/blackberry.css') }}"
                       data-toggle="tooltip" title="Blackberry"></a>
                </li>
            </ul>
        @if ($admin_primary_nav)
            <!-- Sidebar Navigation -->
                <ul class="sidebar-nav">

                    <!-- END User Info -->
                    <!-- Ln 129 -->

                    @foreach( $admin_primary_nav as $key => $link )
                        <?php
                        $link_class = '';
                        $li_active = '';
                        $menu_link = '';

                        // Get 1st level link's vital info
                        $url = (isset($link['url']) && $link['url']) ? $link['url'] : '#';
                        $active = (isset($link['url']) && (strpos($admin_template['active_page'], $link['url']) !== FALSE) && (!isset($link['never_active']))) ? ' active' : '';
                        $never_active = isset($link['never_active']) ? ' target="_blank"' : '';
                        $icon = (isset($link['icon']) && $link['icon']) ? '<i class="' . $link['icon'] . ' sidebar-nav-icon"></i>' : '';

                        // Check if the link has a submenu
                        if (isset($link['sub']) && $link['sub']) :
                            // Since it has a submenu, we need to check if we have to add the class active
                            // to its parent li element (only if a 2nd or 3rd level link is active)
                            foreach ($link['sub'] as $sub_link) :
                                if (isset($sub_link['url'])) :
                                    if (strpos($admin_template['active_page'], $sub_link['url']) !== FALSE) :
                                        $li_active = ' class="active"';
                                        break;
                                    endif;
                                    if ((strpos($admin_template['active_page'], 'options') !== FALSE) && ($sub_link['name'] == 'Product Options Entries')
                                        || (strpos($admin_template['active_page'], 'quote_options') !== FALSE) && ($sub_link['name'] == 'Quote Options Entries'))
                                        :
                                        $li_active = ' class="active"';
                                        break;
                                    endif;
                                endif;

                                // 3rd level links
                                if (isset($sub_link['sub']) && $sub_link['sub']) :
                                    foreach ($sub_link['sub'] as $sub2_link) :
                                        if (strpos($admin_template['active_page'], $sub2_link['url']) !== FALSE) :
                                            $li_active = ' class="active"';
                                            break;
                                        endif;
                                    endforeach;
                                endif;
                            endforeach;

                            $menu_link = 'sidebar-nav-menu';
                        endif;

                        // Create the class attribute for our link
                        if ($menu_link || $active) :
                            $link_class = ' class="' . $menu_link . $active . '"';
                        endif;
                        ?>
                        @if ($url == 'header')
                            <li class="sidebar-header">
                                @if (isset($link['opt']) && $link['opt'])
                                    <span class="sidebar-header-options clearfix">{!! $link['opt'] !!}</span>
                                @endif
                                <span class="sidebar-header-title">{!! $link['name'] !!}</span>
                            </li>
                        @else
                            <li{!! $li_active !!}>
                                <a href="{!! $url !!}" {!! $link_class !!} {!! $never_active !!}>
                                    @if (isset($link['sub']) && $link['sub'])
                                        <i class="fa fa-angle-left sidebar-nav-indicator sidebar-nav-mini-hide"></i>
                                    @endif
                                    {!! $icon !!}
                                    <span class="sidebar-nav-mini-hide">{!! $link['name'] !!}</span>
                                </a>
                                @if (isset($link['sub']) && $link['sub'])
                                    <ul>
                                        @foreach ($link['sub'] as $sub_link)
                                            <?php
                                            $link_class = '';
                                            $li_active = '';
                                            $submenu_link = '';

                                            // Get 2nd level link's vital info
                                            $url = (isset($sub_link['url']) && $sub_link['url']) ? $sub_link['url'] : '#';
                                            $active = (isset($sub_link['url']) && (strpos($admin_template['active_page'], $sub_link['url']) !== FALSE) && (!isset($sub_link['never_active'])))
                                            || (strpos($admin_template['active_page'], 'options') !== FALSE && $sub_link['name'] == 'Product Options Entries' && $sub_link['name'] != 'Quote Options Entries' && strpos($admin_template['active_page'], 'quote_options') == FALSE)
                                            || (strpos($admin_template['active_page'], 'quote_options') !== FALSE && $sub_link['name'] == 'Quote Options Entries')
                                                ? ' active' : '';

                                            // Check if the link has a submenu
                                            if (isset($sub_link['sub']) && $sub_link['sub']) :
                                                // Since it has a submenu, we need to check if we have to add the class active
                                                // to its parent li element (only if a 3rd level link is active)
                                                foreach ($sub_link['sub'] as $sub2_link) :
                                                    if (isset($sub2_link['url'])) :
                                                        if (strpos($admin_template['active_page'], $sub2_link['url']) !== FALSE) :
                                                            $li_active = ' class="active"';
                                                            break;
                                                        endif;
                                                    endif;
                                                endforeach;

                                                $submenu_link = 'sidebar-nav-submenu';
                                            endif;

                                            if ($submenu_link || $active) :
                                                $link_class = ' class="' . $submenu_link . $active . '"';
                                            endif;
                                            ?>
                                            <li{!! $li_active !!}>
                                                <a href="{!! $url !!}" {!! $link_class !!}>
                                                    @if (isset($sub_link['sub']) && $sub_link['sub'])
                                                        <i class="fa fa-angle-left sidebar-nav-indicator"></i>
                                                    @endif
                                                    {!! $sub_link['name'] !!}
                                                </a>
                                                @if (isset($sub_link['sub']) && $sub_link['sub'])
                                                    <ul>
                                                        <?php
                                                        foreach ($sub_link['sub'] as $sub2_link) :
                                                        // Get 3rd level link's vital info
                                                        $url = (isset($sub2_link['url']) && $sub2_link['url']) ? $sub2_link['url'] : '#';
                                                        $active = (isset($sub2_link['url']) && (strpos($admin_template['active_page'], $sub2_link['url']) !== FALSE) && (!isset($sub2_link['never_active']))) ? ' class="active"' : '';
                                                        ?>
                                                        <li>
                                                            <a href="{!! $url !!}"{!! $active !!}>{!! $sub2_link['name'] !!}</a>
                                                        </li>
                                                        <?php endforeach; ?>
                                                    </ul>
                                                @endif
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </li>
                        @endif
                    @endforeach
                </ul>
                <!-- END Sidebar Navigation -->
            @endif
        </div>
    </div>
</div>
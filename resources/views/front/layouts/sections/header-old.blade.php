<header>

    {{-- FOR DESKTOP MENU  --}}
    <div class="main-nagivation-desktop container">
        <div class="main-nagivation-desktop__wrapper--row row">
            <div class="col-lg-4">
                <a href="{{ url('/') }}">
                    <img src="{{ asset('public/images/header/logo.jpg') }}" alt="logo">
                </a>
            </div>
            <div class="col-lg-8">
                <nav class="navbar-bar">
                    <ul class="navbar-bar__wrapper">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/') }}">Home <span class="sr-only">(current)</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('contact-us') }}">Contact Us</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('about-us') }}">About Us</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle"
                               href="{{ route('customer.login') }}" {{--data-toggle="dropdown"--}}>
                                Login
                            </a>
                            <div class="dropdown-menu">
                                <ul class="sub-menu">
                                    <li>
                                        <a class="nav-link" href="{{ route('customer.register') }}"> Register</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" {{--data-toggle="dropdown"--}}>
                                Dropdown
                            </a>
                            <div class="dropdown-menu">
                                <ul class="sub-menu">
                                    <li>
                                        <a class="nav-link" href="#"> Sub menu 1</a>
                                    </li>
                                    <li>
                                        <a class="nav-link" href="#"> Sub menu 1</a>
                                    </li>
                                    <li>
                                        <a class="nav-link" href="#"> Sub menu 1</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </nav>
            </div>
            <!-- ending of row  -->
        </div>
        <!-- ending of container  -->
    </div>


    {{-- FOR MOBILE MENU  --}}
    <div class="main-nagivation-mobile">
        <div class="main-nagivation-mobile__wrapper container">
            <div class="main-nagivation-mobile__wrapper--row">

                <div class="col-md-12">
                <!-- {{-- MOBILE HEADER --}} -->
                    <div class="mobile-header__wrapper">

                        <div class="mobile-logo">
                            <a href="{{ url('/') }}">
                                <img src="{{ asset('public/images/header/logo.jpg') }}" alt="logo">
                            </a>
                        </div>


                        <div class="mobile-header__wrapper--item d-inline-block align-top">
                            <div class="mob-burger-menu">
                                <div class="bar1"></div>
                                <div class="bar2"></div>
                                <div class="bar3"></div>
                            </div>
                            <div class="mob-nav-menu">
                                <a href="javascript:void()" class="btn btn--close-menu"> <i class="fa fa-times"
                                                                                            aria-hidden="true"></i> </a>
                                <ul>
                                    <!-- **************************************** -->
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ url('/') }}">Home <span
                                                    class="sr-only">(current)</span></a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ url('contact-us') }}">Contact Us</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ url('about-us') }}">About Us</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('customer.login') }}">
                                            Login
                                        </a>

                                        <div class="icon-button icon-button__open">
                                            <i class="fa fa-plus" aria-hidden="true"></i>
                                        </div>
                                        <div class="icon-button icon-button__close">
                                            <i class="fa fa-angle-down" aria-hidden="true"></i>
                                        </div>

                                        <ul class="sub-menu no-mega-sub">
                                            <li>
                                                <a href="{{ route('customer.register') }}"> Register</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link " href="#">
                                            Dropdown
                                        </a>

                                        <div class="icon-button icon-button__open">
                                            <i class="fa fa-plus" aria-hidden="true"></i>
                                        </div>
                                        <div class="icon-button icon-button__close">
                                            <i class="fa fa-angle-down" aria-hidden="true"></i>
                                        </div>

                                        <ul class="sub-menu no-mega-sub">
                                            <li>
                                                <a href="#"> Sub menu 1</a>
                                            </li>
                                            <li>
                                                <a href="#"> Sub menu 1</a>
                                            </li>
                                            <li>
                                                <a href="#"> Sub menu 1</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <!-- **************************************** -->

                                </ul>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>

</header>


<section class="search-box">
    <div class="search-box__button"></div>
    <div class="search-box__wrapper container">
        <div class="row">
            <div class="col-md-12">
                <form class="search-form" action="{{ url('/') }}" method="GET">
                    <div class="form-group">
                        <a class="nav-link " type="submit" href="javascript:void(0)">
                            <i class="fa fa-search"></i>
                        </a>
                        <input type="text" name="keyword" id="keyword" placeholder="Search Keyword">

                        {{-- <input type="text" name="keyword" id="keyword" placeholder="Search Keyword"
                                   value="{{ !empty($search_params) && isset($search_params['keyword']) ? $search_params['keyword'] : '' }}"
                        spellcheck="false"> --}}
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
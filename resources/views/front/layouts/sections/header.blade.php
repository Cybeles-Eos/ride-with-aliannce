<header>

    {{-- FOR DESKTOP MENU  --}}
    <div class="main-nagivation-desktop container">
        <div class="main-nagivation-desktop__wrapper--row row">
            <div class="col-lg-2 main-nagivation-desktop__wrapper--logo">
                <a href="{{ url('/') }}">
                    <img src="{{ asset('public/images/header/logo.jpg') }}" alt="GNF logo">
                </a>
            </div>
            <div class="col-lg-8 main-nagivation-desktop__wrapper--menu">
                <nav class="navbar-bar">
                    <ul class="navbar-bar__wrapper">
                        {{-- <li class="nav-item">
                            <a class="nav-link" href="{{ url('/') }}">Home <span class="sr-only">(current)</span></a>
                        </li> --}}
                        <li class="nav-item dropdown mm-menu">
                            <a class="nav-link dropdown-toggle" href="javascript:void(0)" {{--data-toggle="dropdown"--}}>
                                Our Research
                            </a>
                            <div class="dropdown-menu mm-menu">
                                <ul class="sub-menu mega-menu">
                                    <li>
                                        <a class="nav-link" href="javascript:void(0)">
                                            <div class="img-holder"><img src="{{ asset('public/images/mm-img.jpg') }}" alt="Mega Menu Image"></div>
                                            <span>1</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="nav-link" href="javascript:void(0)">
                                            <div class="img-holder"><img src="{{ asset('public/images/mm-img.jpg') }}" alt="Mega Menu Image"></div>
                                            <span>2</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="nav-link" href="javascript:void(0)">
                                            <div class="img-holder"><img src="{{ asset('public/images/mm-img.jpg') }}" alt="Mega Menu Image"></div>
                                            <span>3</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item dropdown mm-menu">
                            <a class="nav-link dropdown-toggle" href="javascript:void(0)" {{--data-toggle="dropdown"--}}>
                                Products
                            </a>
                            <div class="dropdown-menu mm-menu">
                                <ul class="sub-menu mega-menu">
                                    <li>
                                        <a class="nav-link" href="javascript:void(0)">
                                            <div class="img-holder"><img src="{{ asset('public/images/mm-img.jpg') }}" alt="Mega Menu Image"></div>
                                            <span>1</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="nav-link" href="javascript:void(0)">
                                            <div class="img-holder"><img src="{{ asset('public/images/mm-img.jpg') }}" alt="Mega Menu Image"></div>
                                            <span>2</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="nav-link" href="javascript:void(0)">
                                            <div class="img-holder"><img src="{{ asset('public/images/mm-img.jpg') }}" alt="Mega Menu Image"></div>
                                            <span>3</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="javascript:void(0)">Products</a>
                        </li>
                        <li class="nav-item dropdown mm-menu">
                            <a class="nav-link dropdown-toggle" href="javascript:void(0)" {{--data-toggle="dropdown"--}}>
                                About Us
                            </a>
                            <div class="dropdown-menu mm-menu">
                                <ul class="sub-menu mega-menu">
                                    <li>
                                        <a class="nav-link" href="javascript:void(0)">
                                            <div class="img-holder"><img src="{{ asset('public/images/mm-img.jpg') }}" alt="Mega Menu Image"></div>
                                            <span>1</span>
                                        </a>
                                    </li>
                                    {{-- <li>
                                        <a class="nav-link" href="{{ url('contact-us') }}">
                                            <div class="img-holder"><img src="{{ asset('public/images/mm-img.jpg') }}" alt="Mega Menu Image"></div>
                                            <span>Contact Us</span>
                                        </a>
                                    </li> --}}
                                    <li>
                                        <a class="nav-link" href="javascript:void(0)">
                                            <div class="img-holder"><img src="{{ asset('public/images/mm-img.jpg') }}" alt="Mega Menu Image"></div>
                                            <span>2</span>
                                        </a>
                                    </li>
                                    
                                    {{-- <li>
                                        <a class="nav-link" href="{{ url('gallery') }}">
                                            <div class="img-holder"><img src="{{ asset('public/images/mm-img.jpg') }}" alt="Mega Menu Image"></div>
                                            <span>Gallery</span>
                                        </a>
                                    </li> --}}
                                    
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="javascript:void(0)">Contact Us</a>
                        </li>                        
                    </ul>
                </nav>
            </div>
            <div class="col-lg-2 main-nagivation-desktop__wrapper--menu-secondary text-right">
                <div class="nav-secondary">
                    <ul>
                        <li><a href="#" class="btn--search"><i class="fas fa-search"></i></a></li>
                        <li><a href="//www.novartis.com/" target="_blank"><i class="fas fa-phone text-white"></i></a></li>
                    </ul>
                </div>
            </div>
            <!-- ending of row  -->
        </div>
        <!-- ending of container  -->
    </div>

    <div class="search-wrap">
        <form  action="{{url('search')}}">
            <label for="search-input"></label>
            <input type="text" id="search-input" placeholder="Search..." name="keywords">
            <button type="submit" class="btn btn--primary">submit</button>
            <span class="close">X</span>
        </form>
    </div>


    {{-- FOR MOBILE MENU  --}}
    <nav class="mobile navbar navbar-expand-xl navbar-light" id="main_navbar">
        <a class="navbar-brand" href="{{ url('/') }}">
            <img src="{{ asset('public/images/header/logo.jpg') }}" alt="GNF logo">
        </a>
        <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <!-- <span class="navbar-toggler-icon"></span> -->
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="{{ url('/') }}">Home <span class="sr-only">(current)</span></a>
                </li>   

                
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="{{url('our-research')}}" id="navbarDropdown" role="button" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        Our Research
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li>
                            <a class="dropdown-item" href="javascript:void(0)">1</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="javascript:void(0)">2</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="javascript:void(0)">3</a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="javascript:void(0)" id="navbarDropdown" role="button" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        Our Enabling Technology
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li>
                            <a class="dropdown-item" href="javascript:void(0)">1</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="javascript:void(0)">2</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="javascript:void(0)">3</a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="javascript:void(0)">Products</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="javascript:void(0)" id="navbarDropdown" role="button" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        About Us
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li>
                            <a class="dropdown-item" href="javascript:void(0)">1</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="javascript:void(0)">2</a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="javascript:void(0)">Contact Us</a>
                </li>
            </ul>
            <div class="search-wrap text-center">
                <form  action="{{url('search')}}">
                    <label for="search-input"></label>
                    <input type="text" id="search-input" placeholder="Search..." name="keywords">
                    <button type="submit" class="btn btn--primary">submit</button>
                    {{-- <span class="close">X</span> --}}
                </form>
            </div>
        </div>
    </nav>


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
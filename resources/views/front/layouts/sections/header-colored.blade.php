<header class="colored">

    {{-- FOR DESKTOP MENU  --}}
    <div class="main-nagivation-desktop main-nagivation-desktop--colored container">
        <div class="main-nagivation-desktop__wrapper--row row">
            <div class="col-lg-2 main-nagivation-desktop__wrapper--logo">
                <a href="{{ url('/') }}">
                    <img src="{{ asset('public/images/gnf-colored.png') }}" alt="GNF logo">
                </a>
            </div>
            <div class="col-lg-8 main-nagivation-desktop__wrapper--menu">
                <nav class="navbar-bar">
                    <ul class="navbar-bar__wrapper">
                        {{-- <li class="nav-item">
                            <a class="nav-link" href="{{ url('/') }}">Home <span class="sr-only">(current)</span></a>
                        </li> --}}
                        <li class="nav-item dropdown mm-menu">
                            <a class="nav-link dropdown-toggle" href="{{url('our-research')}}" {{--data-toggle="dropdown"--}}>
                                Our Research
                            </a>
                            <div class="dropdown-menu mm-menu">
                                <ul class="sub-menu mega-menu">
                                    {{-- @foreach(\App\Models\Research::get() as $research)
                                        <li>
                                            <a class="nav-link" href="{{url('our-research/'.$research->slug)}}">
                                                <div class="img-holder"><img src="{{ asset($research->file) }}" alt="Mega Menu Image" width="218" height="135"></div>
                                                <span>{{$research->name}}</span>
                                            </a>
                                        </li>
                                    @endforeach --}}

                                    <li>
                                        <a class="nav-link" href="{{url('our-research')}}">
                                            <div class="img-holder"><img src="{{ asset('public/images/mm-gallery.jpg') }}" alt="Mega Menu Image"></div>
                                            <span>Departments</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="nav-link" href="{{ url('stories') }}">
                                            <div class="img-holder"><img src="{{ asset('public/images/mm-stories.jpg') }}" alt="Mega Menu Image"></div>
                                            <span>Stories</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="nav-link" href="{{ url('publications') }}">
                                            <div class="img-holder"><img src="{{ asset('public/images/mm-pub.jpg') }}" alt="Mega Menu Image"></div>
                                            <span>Publications</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item dropdown mm-menu">
                            <a class="nav-link dropdown-toggle" href="{{url('technology')}}" {{--data-toggle="dropdown"--}}>
                                Our Enabling Technology
                            </a>
                            <div class="dropdown-menu mm-menu">
                                <ul class="sub-menu mega-menu">
                                    <li>
                                        <a class="nav-link" href="{{url('data-sciences')}}">
                                            <div class="img-holder"><img src="{{ asset('public/images/mm-science.jpg') }}" alt="Mega Menu Image"></div>
                                            <span>Data Sciences / Bioinformatics</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="nav-link" href="{{url('engineering')}}">
                                            <div class="img-holder"><img src="{{ asset('public/images/mm-engg.jpg') }}" alt="Mega Menu Image"></div>
                                            <span>Engineering / Automation</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="nav-link" href="{{url('genomics')}}">
                                            <div class="img-holder"><img src="{{ asset('public/images/mm-genomics.jpg') }}" alt="Mega Menu Image"></div>
                                            <span>Genomic Technologies</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('gnf-systems') }}">GNF Systems</a>
                        </li>
                        {{-- <li class="nav-item dropdown mm-menu">
                            <a class="nav-link dropdown-toggle" href="{{ url('gnf-systems') }}">
                                GNF Systems
                            </a>
                            <div class="dropdown-menu mm-menu">
                                <ul class="sub-menu mega-menu">
                                    <li>
                                        <a class="nav-link" href="javascript:void(0)">
                                            <div class="img-holder"><img src="{{ asset('public/uploads/research_image/gen-med-biology-dept-1576559340.jpg') }}" alt="Mega Menu Image"></div>
                                            <span>About</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="nav-link" href="{{ url('products') }}">
                                            <div class="img-holder"><img src="{{ asset('public/uploads/research_image/trad-research-dept-1576559571.jpg') }}" alt="Mega Menu Image"></div>
                                            <span>Platforms</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="nav-link" href="{{ url('products') }}">
                                            <div class="img-holder"><img src="{{ asset('public/uploads/research_image/discovery-chem-dept-1576559490.jpg') }}" alt="Mega Menu Image"></div>
                                            <span>Devices</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li> --}}
                        <li class="nav-item dropdown mm-menu">
                            <a class="nav-link dropdown-toggle" href="{{ url('about-us') }}" {{--data-toggle="dropdown"--}}>
                                About Us
                            </a>
                            <div class="dropdown-menu mm-menu">
                                <ul class="sub-menu mega-menu">
                                    <li>
                                        <a class="nav-link" href="{{ url('about-us') }}">
                                            <div class="img-holder"><img src="{{ asset('public/images/mm-img1.jpg') }}" alt="Mega Menu Image"></div>
                                            <span>About GNF</span>
                                        </a>
                                    </li>
                                    {{-- <li>
                                        <a class="nav-link" href="{{ url('contact-us') }}">
                                            <div class="img-holder"><img src="{{ asset('public/images/mm-img3.jpg') }}" alt="Mega Menu Image"></div>
                                            <span>Contact Us</span>
                                        </a>
                                    </li> --}}
                                    <li>
                                        <a class="nav-link" href="{{ url('leadership-team') }}">
                                            <div class="img-holder"><img src="{{ asset('public/images/mm-img2.jpg') }}" alt="Mega Menu Image"></div>
                                            <span>Leadership</span>
                                        </a>
                                    </li>
                                    
                                    {{-- <li>
                                        <a class="nav-link" href="{{ url('gallery') }}">
                                            <div class="img-holder"><img src="{{ asset('public/images/mm-gallery.jpg') }}" alt="Mega Menu Image"></div>
                                            <span>Gallery</span>
                                        </a>
                                    </li> --}}
                                    
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('careers') }}">Careers</a>
                        </li>                        
                    </ul>
                </nav>
            </div>
            <div class="col-lg-2 main-nagivation-desktop__wrapper--menu-secondary text-right">
                <div class="nav-secondary">
                    <ul>
                        <li><a href="#" class="btn--search"><i class="fas fa-search"></i></a></li>
                        <li><a href="//www.novartis.com/" target="_blank"><img src="{{ asset('public/images/novartis-logo-colored.png') }}" alt="Novartis"></a></li>
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
            <img src="{{ asset('public/images/GNFlogo-wht.png') }}" alt="GNF logo">
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
                        {{-- @foreach(\App\Models\Research::get() as $research)
                            <li>
                                <a class="dropdown-item" href="{{url('our-research/'.$research->slug)}}">{{$research->name}}</a>
                            </li>
                        @endforeach --}}

                        <li>
                            <a class="dropdown-item" href="{{url('our-research')}}">Departments</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ url('stories') }}">Stories</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ url('publications') }}">Publications</a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="{{url('technology')}}" id="navbarDropdown" role="button" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        Our Enabling Technology
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li>
                            <a class="dropdown-item" href="{{url('data-sciences')}}">Data Sciences / Bioinformatics</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{url('engineering')}}">Engineering / Automation</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{url('genomics')}}">Genomic Technologies</a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('gnf-systems') }}">GNF Systems</a>
                </li>
                
                {{-- <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="{{ url('gnf-systems') }}" id="navbarDropdown" role="button" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        GNF Systems
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li>
                            <a class="dropdown-item" href="javascript:void(0)">About</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ url('products') }}">Platforms</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ url('products') }}">Devices</a>
                        </li>
                    </ul>
                </li> --}}
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="{{ url('gnf-systems') }}" id="navbarDropdown" role="button" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        About Us
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li>
                            <a class="dropdown-item" href="{{ url('about-us') }}">About GNF</a>
                        </li>
                        {{-- <li>
                            <a class="dropdown-item" href="{{ url('contact-us') }}">Contact Us</a>
                        </li> --}}
                        <li>
                            <a class="dropdown-item" href="{{ url('leadership-team') }}">Leadership</a>
                        </li>
                        {{-- <li>
                            <a class="dropdown-item" href="{{ url('stories') }}">Our Stories</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ url('gallery') }}">Gallery</a>
                        </li> --}}
                    </ul>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ url('careers') }}">Careers</a>
                </li>
                <li class="nav-item">
                    <a href="//www.novartis.com/" target="_blank"><img src="{{ asset('public/images/novartis-icon.png') }}" alt="Novartis"></a>
                </li>
                <!-- <li class="nav-item">
                    <a class="nav-link disabled" href="#">Disabled</a>
                </li> -->
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
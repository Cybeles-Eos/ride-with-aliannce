<section class="banner">
    <div class="banner__slick">

        @foreach(\App\Models\HomeSlide::get() as $home_slide)
            <div class="banner__item image-background">
                <img src="{{ url('public/images/banner.jpg') }}">
                <div class="banner__content container">
                    <div class="banner__content--row row">
                        <div class="col-lg-8">
                            <div class="banner__content text-left">
                                <div class="banner__content__text">
                                    {!! $home_slide->content !!}
                                </div>
                                <div class="banner__content__cta padding--top1em">
                                    <a href="{{$home_slide->button_link}}" class="btn btn--secondary">{{$home_slide->button_label}}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

    </div>
    <a href="#main" class="vertical btn--scroll-down">SCROLL</a>
</section>
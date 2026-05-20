<section class="banner image-bg">
    <img src="{!! !empty($item) && !empty($item->page_sections()->where('section', 'banner_image')->first()) ?
    asset($item->page_sections()->where('section', 'banner_image')->first()->content) :
    asset('public/images/mc_full_bg.png') !!}">
    <div class="sub-banner__wrapper container ">
        <div class="sub-banner__wrapper--row row mx-auto">
            <div class="col-md-6 sub-banner__content sub-banner__items">
                {{-- <h1>{{ !empty($item) ? isset($item->name) ? $item->name : '' : '' }}</h1> --}}

                <h1>{!! !empty($item) ? isset($item->name) ? $item->name : '' : '' !!}</h1>
                <p>
                    {!! !empty($item) && !empty($item->page_sections()->where('section', 'banner_description')->first()) ?
                    nl2br($item->page_sections()->where('section', 'banner_description')->first()->content) : '' !!}</p>
            </div>
            <div class="col-md-6 sub-banner__content sub-banner__items">
            </div>
        </div>
    </div>
</section>
<section class="page page--about-us">
    @include('front.layouts.sections.header')
    @include('front.pages.custom-page.sections.banner')
    <main class="main-content">
        {{-- individual section  --}}
        <section class="section-name">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 section-name__item">
                        {!! !empty($item) && !empty($item->page_sections()->where('section', 'content')->first()) ?
                            nl2br($item->page_sections()->where('section', 'content')->first()->content) : '' !!}
                    </div>
                </div>
            </div> {{-- end of default-content--row --}}
        </section> {{-- end of default-content --}}
    </main>
    @include('front.layouts.sections.footer')
</section>
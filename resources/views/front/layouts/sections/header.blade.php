<header class="site-header header-style-2">
    <div class="global-size global-padding header-s-main">
        <a href="{{url('/')}}" class="header-s-logo">
            <img src="{{ asset('public/images/logo-rwa.png') }}" alt="rwa-logo">
            <div>
                <p>RIDEWITH ALLIANCE</p>
                <span>DISPATCH</span>
            </div>
        </a>


        <div class="header-s-links">
            <ul>
                <li>
                    <a href="#" class="header-s-link">
                        About Us
                    </a>
                </li>
                <li>
                    <a href="#" class="header-s-link">
                        Our Services
                        {{-- <svg width="8" height="5" viewBox="0 0 8 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0.75 0.75L3.875 4.08333L7 0.75" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg> --}}
                    </a>
                </li>
                <li>
                    <a href="#" class="header-s-link">
                        Who We Serve
                        <svg width="8" height="5" viewBox="0 0 8 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0.75 0.75L3.875 4.08333L7 0.75" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </a>
                </li>
                <li>
                    <a href="#" class="header-s-link">
                        Contact Us
                    </a>
                </li>
            </ul>
        </div>
        
        <div class="header-s-cta">
            <a href="#" class="btn--link btn--link-c">
                <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g clip-path="url(#clip0_4938_80204)">
                     <path d="M4.02158 1C4.36691 1 5.7482 4.10791 5.7482 4.45324C5.7482 5.14388 4.71223 5.83453 4.36691 6.52518C4.02158 7.21583 4.71223 7.90647 5.40288 8.59712C5.67223 8.86647 6.78417 9.97842 7.47482 9.63309C8.16547 9.28777 8.85612 8.2518 9.54676 8.2518C9.89209 8.2518 13 9.63309 13 9.97842C13 11.3597 11.964 12.3957 10.9281 12.741C9.89209 13.0863 9.20144 13.0863 7.82014 12.741C6.43885 12.3957 5.40288 12.0504 3.67626 10.3237C1.94964 8.59712 1.60432 7.56115 1.25899 6.17986C0.913669 4.79856 0.913669 4.10791 1.25899 3.07194C1.60432 2.03597 2.64029 1 4.02158 1Z" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
                    </g>
                    <defs>
                    <clipPath id="clip0_4938_80204">
                    <rect width="14" height="14" fill="white"/>
                    </clipPath>
                    </defs>
                </svg>
                630-601-2727
            </a>
            <a href="#" class="btn--navbtn">
                Book A Ride
            </a>
        </div>
    </div>


</header>


{{-- Mobile Header --}}
<header class="header-mobile">
    <div class="header-mobile__inner">
        <a href="{{ url('/') }}" class="header-mobile__logo">
            <img src="{{ asset('public/images/logo-rwa.png') }}" alt="rwa-logo">
            <div class="header-mobile__logo-text">
                <p>RIDEWITH ALLIANCE</p>
                <span>DISPATCH</span>
            </div>
        </a>

        <button class="header-mobile__toggle" type="button" aria-label="Open menu">
            <span></span>
            <span></span>
        </button>
    </div>

    <div class="header-mobile__menu">
        <div class="header-mobile__menu-head">
            <a href="{{ url('/') }}" class="header-mobile__logo">
                <img src="{{ asset('public/images/logo-rwa.png') }}" alt="rwa-logo">
                <div class="header-mobile__logo-text">
                    <p>RIDEWITH ALLIANCE</p>
                    <span>DISPATCH</span>
                </div>
            </a>

            <button class="header-mobile__close" type="button" aria-label="Close menu">
                <span></span>
                <span></span>
            </button>
        </div>

        <nav class="header-mobile__nav">
            <a href="#" class="header-mobile__link is-active">Home</a>
            <a href="#" class="header-mobile__link">About Us</a>
            <a href="#" class="header-mobile__link">Our Services</a>

            <div class="header-mobile__dropdown">
                <button class="header-mobile__dropdown-btn" type="button">
                    Who We Serve
                    <svg width="10" height="6" viewBox="0 0 10 6" fill="none">
                        <path d="M1 1L5 5L9 1" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>

                <div class="header-mobile__dropdown-menu">
                    <a href="#" class="header-mobile__dropdown-link">Seniors</a>
                    <a href="#" class="header-mobile__dropdown-link">Disabled Riders</a>
                    <a href="#" class="header-mobile__dropdown-link">Medical Patients</a>
                    <a href="#" class="header-mobile__dropdown-link">Healthcare Facilities</a>
                </div>
            </div>

            <a href="#" class="header-mobile__link">Contact Us</a>
        </nav>

        <div class="header-mobile__cta">
            <a href="tel:6306012727" class="header-mobile__phone">
                630-601-2727
            </a>

            <a href="#" class="header-mobile__button">
                Book A Ride
            </a>
        </div>
    </div>
</header>

@push('extrascripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const menu = document.querySelector('.header-mobile__menu');
    const openBtn = document.querySelector('.header-mobile__toggle');
    const closeBtn = document.querySelector('.header-mobile__close');
    const dropdownBtn = document.querySelector('.header-mobile__dropdown-btn');
    const dropdownMenu = document.querySelector('.header-mobile__dropdown-menu');

    if (!menu || !openBtn || !closeBtn) return;

    openBtn.addEventListener('click', function () {
        menu.classList.add('is-open');
        document.body.style.overflow = 'hidden';
    });

    closeBtn.addEventListener('click', function () {
        menu.classList.remove('is-open');
        document.body.style.overflow = '';
    });

    if (dropdownBtn && dropdownMenu) {
        dropdownBtn.addEventListener('click', function () {
            dropdownBtn.classList.toggle('is-open');
            dropdownMenu.classList.toggle('is-open');
        });
    }

    window.addEventListener('resize', function () {
        if (window.innerWidth > 992) {
            menu.classList.remove('is-open');
            document.body.style.overflow = '';
        }
    });
});
</script>
@endpush
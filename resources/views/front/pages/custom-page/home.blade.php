@include('front.layouts.sections.header')
<main class="page--homepage">
    {{-- global-size global-padding --}}
    <section class="section__hero">
        <div class="global-size global-padding section__hero--main">
            <div class="section__hero--main--highlights">
                <span class="highlight">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M6.51987 2.594C6.89587 2.274 7.08387 2.114 7.27987 2.02C7.50436 1.91265 7.75003 1.85693 7.99887 1.85693C8.2477 1.85693 8.49338 1.91265 8.71787 2.02C8.91454 2.11333 9.10254 2.27333 9.47787 2.594C9.62787 2.722 9.70254 2.78533 9.78254 2.83867C9.96574 2.96145 10.1715 3.04665 10.3879 3.08933C10.4819 3.108 10.5799 3.116 10.7759 3.132C11.2685 3.17067 11.5145 3.19067 11.7199 3.26333C11.9544 3.3461 12.1674 3.4803 12.3434 3.65611C12.5193 3.83191 12.6536 4.04486 12.7365 4.27933C12.8092 4.48533 12.8285 4.73133 12.8679 5.22333C12.8832 5.41933 12.8912 5.51733 12.9099 5.612C12.9525 5.828 13.0379 6.034 13.1605 6.21667C13.2139 6.29667 13.2779 6.37133 13.4052 6.52133C13.7252 6.89733 13.8859 7.08533 13.9799 7.28133C14.0872 7.50582 14.1429 7.7515 14.1429 8.00033C14.1429 8.24917 14.0872 8.49484 13.9799 8.71933C13.8865 8.91533 13.7259 9.10333 13.4052 9.47933C13.3178 9.57602 13.2361 9.67775 13.1605 9.784C13.0378 9.967 12.9526 10.1725 12.9099 10.3887C12.8912 10.4833 12.8832 10.5813 12.8679 10.7773C12.8285 11.2693 12.8092 11.516 12.7365 11.7213C12.6536 11.9558 12.5193 12.1688 12.3434 12.3446C12.1674 12.5204 11.9544 12.6546 11.7199 12.7373C11.5145 12.8107 11.2685 12.83 10.7759 12.8687C10.5799 12.8847 10.4825 12.8927 10.3879 12.9113C10.1715 12.954 9.96574 13.0392 9.78254 13.162C9.67651 13.2375 9.575 13.3192 9.47853 13.4067C9.10253 13.7267 8.91454 13.8867 8.71854 13.9807C8.49405 14.088 8.24837 14.1437 7.99953 14.1437C7.7507 14.1437 7.50502 14.088 7.28053 13.9807C7.08387 13.8873 6.89587 13.7273 6.52053 13.4067C6.42385 13.3192 6.32212 13.2375 6.21587 13.162C6.03266 13.0392 5.82691 12.954 5.61053 12.9113C5.48215 12.8895 5.35259 12.8753 5.22253 12.8687C4.72987 12.83 4.48387 12.81 4.27853 12.7373C4.044 12.6546 3.83097 12.5204 3.65505 12.3446C3.47913 12.1688 3.34479 11.9558 3.26187 11.7213C3.1892 11.516 3.16987 11.2693 3.13053 10.7773C3.12415 10.6471 3.11013 10.5173 3.08853 10.3887C3.04577 10.1725 2.96057 9.967 2.83787 9.784C2.78453 9.704 2.72053 9.62933 2.5932 9.47933C2.2732 9.10333 2.11253 8.91533 2.01853 8.71933C1.91119 8.49484 1.85547 8.24917 1.85547 8.00033C1.85547 7.7515 1.91119 7.50582 2.01853 7.28133C2.11253 7.08533 2.27253 6.89733 2.5932 6.52133C2.72053 6.37133 2.78453 6.29667 2.83787 6.21667C2.96057 6.03366 3.04577 5.82814 3.08853 5.612C3.1072 5.51733 3.1152 5.41933 3.13053 5.22333C3.16987 4.73133 3.1892 4.48533 3.26187 4.27933C3.34486 4.04479 3.4793 3.8318 3.65534 3.65599C3.83138 3.48018 4.04455 3.34601 4.2792 3.26333C4.48453 3.19067 4.73053 3.17067 5.2232 3.132C5.4192 3.116 5.51653 3.108 5.6112 3.08933C5.82758 3.04665 6.03333 2.96145 6.21653 2.83867C6.29653 2.78533 6.37053 2.722 6.51987 2.594Z" stroke="white" stroke-width="1.2"/>
                    <path d="M5.66406 8.33447L6.9974 9.66781L10.3307 6.33447" stroke="white" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Trained & Vetted Drivers
                </span>
                <span class="highlight">No Hidden Fees</span>
                <span class="highlight">20+ Years in Operation</span>
            </div>
            <h1>Trusted NEMT Rides Across Greater Chicagoland</h1>
            <p>Alliance Taxi / Alliance Dispatch provides safe, door-to-door non-emergency medical transportation for seniors, disabled riders, and medically dependent passengers.</p>
            <div class="section__hero--main--cta">
                <a href="{{ url('contact-us') }}" class="btn--primary">
                    Book Your Ride Today
                    <div class="btn--primary--icon">
                        <div>
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M18.0921 7.25872C19.1337 6.21706 18.6587 5.00039 18.0921 4.40872L15.5921 1.90872C14.5421 0.867055 13.3337 1.34206 12.7421 1.90872L11.3254 3.33372H9.16706C7.58372 3.33372 6.66706 4.16706 6.20039 5.12539L2.50039 8.82539V12.1587L1.90872 12.7421C0.867055 13.7921 1.34206 15.0004 1.90872 15.5921L4.40872 18.0921C4.85872 18.5421 5.34206 18.7087 5.80039 18.7087C6.39206 18.7087 6.93372 18.4171 7.25872 18.0921L9.50872 15.8337H12.5004C13.9171 15.8337 14.6337 14.9504 14.8921 14.0837C15.8337 13.8337 16.3504 13.1171 16.5587 12.4171C17.8504 12.0837 18.3337 10.8587 18.3337 10.0004V7.50039H17.8421L18.0921 7.25872ZM16.6671 10.0004C16.6671 10.3754 16.5087 10.8337 15.8337 10.8337H15.0004V11.6671C15.0004 12.0421 14.8421 12.5004 14.1671 12.5004H13.3337V13.3337C13.3337 13.7087 13.1754 14.1671 12.5004 14.1671H8.82539L6.09206 16.9004C5.83372 17.1421 5.68372 17.0004 5.59206 16.9087L3.10039 14.4254C2.85872 14.1671 3.00039 14.0171 3.09206 13.9254L4.16706 12.8421V9.50872L5.83372 7.84206V9.16706C5.83372 10.1754 6.50039 11.6671 8.33372 11.6671C10.1671 11.6671 10.8337 10.1754 10.8337 9.16706H16.6671V10.0004ZM16.9087 6.07539L15.4921 7.50039H9.16706V9.16706C9.16706 9.54206 9.00872 10.0004 8.33372 10.0004C7.65872 10.0004 7.50039 9.54206 7.50039 9.16706V6.66706C7.50039 6.28372 7.64206 5.00039 9.16706 5.00039H12.0087L13.9087 3.10039C14.1671 2.85872 14.3171 3.00039 14.4087 3.09206L16.9004 5.57539C17.1421 5.83372 17.0004 5.98372 16.9087 6.07539Z" fill="#212121"/>
                            </svg>

                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M18.0921 7.25872C19.1337 6.21706 18.6587 5.00039 18.0921 4.40872L15.5921 1.90872C14.5421 0.867055 13.3337 1.34206 12.7421 1.90872L11.3254 3.33372H9.16706C7.58372 3.33372 6.66706 4.16706 6.20039 5.12539L2.50039 8.82539V12.1587L1.90872 12.7421C0.867055 13.7921 1.34206 15.0004 1.90872 15.5921L4.40872 18.0921C4.85872 18.5421 5.34206 18.7087 5.80039 18.7087C6.39206 18.7087 6.93372 18.4171 7.25872 18.0921L9.50872 15.8337H12.5004C13.9171 15.8337 14.6337 14.9504 14.8921 14.0837C15.8337 13.8337 16.3504 13.1171 16.5587 12.4171C17.8504 12.0837 18.3337 10.8587 18.3337 10.0004V7.50039H17.8421L18.0921 7.25872ZM16.6671 10.0004C16.6671 10.3754 16.5087 10.8337 15.8337 10.8337H15.0004V11.6671C15.0004 12.0421 14.8421 12.5004 14.1671 12.5004H13.3337V13.3337C13.3337 13.7087 13.1754 14.1671 12.5004 14.1671H8.82539L6.09206 16.9004C5.83372 17.1421 5.68372 17.0004 5.59206 16.9087L3.10039 14.4254C2.85872 14.1671 3.00039 14.0171 3.09206 13.9254L4.16706 12.8421V9.50872L5.83372 7.84206V9.16706C5.83372 10.1754 6.50039 11.6671 8.33372 11.6671C10.1671 11.6671 10.8337 10.1754 10.8337 9.16706H16.6671V10.0004ZM16.9087 6.07539L15.4921 7.50039H9.16706V9.16706C9.16706 9.54206 9.00872 10.0004 8.33372 10.0004C7.65872 10.0004 7.50039 9.54206 7.50039 9.16706V6.66706C7.50039 6.28372 7.64206 5.00039 9.16706 5.00039H12.0087L13.9087 3.10039C14.1671 2.85872 14.3171 3.00039 14.4087 3.09206L16.9004 5.57539C17.1421 5.83372 17.0004 5.98372 16.9087 6.07539Z" fill="#212121"/>
                            </svg>
                        </div>
                    </div>
                </a>
                <a href="#" class="btn--link">
                    Call (630) 601-2727
                </a>
            </div>
        </div>
        <a href="#" class="home-hero-arrow">
            <div class="home-hero-arrow--div">
                <svg width="18" height="10" viewBox="0 0 18 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M1.10156 1.1001L8.60156 8.1001L16.1016 1.1001" stroke="black" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
        </a>
    </section>

    <section class="section__about">
        <div class="global-size global-padding section__about--main">
            <span class="section__about--label">Who We Serve</span>
            <h2>Transportation Support for Riders Who Need More</h2>
            <p class="section__about--paragraph">Alliance Taxi / Alliance Dispatch provides safe, door-to-door non-emergency medical transportation for seniors, disabled riders, and medically dependent passengers.</p>
        
            <div class="section__about--lists">

                <div class="section__about--card">
                    <div>
                        <div class="section__about--card--head">
                            <div class="section__about--card--head__icon"> 
                                <svg width="22" height="27" viewBox="0 0 22 27" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10.8984 10.8999C13.6599 10.8999 15.8984 8.66133 15.8984 5.8999C15.8984 3.13848 13.6599 0.899902 10.8984 0.899902C8.13701 0.899902 5.89844 3.13848 5.89844 5.8999C5.89844 8.66133 8.13701 10.8999 10.8984 10.8999Z" stroke="#373634" stroke-width="1.8"/>
                                    <path d="M20.8984 20.2749C20.8984 23.3812 20.8984 25.8999 10.8984 25.8999C0.898438 25.8999 0.898438 23.3812 0.898438 20.2749C0.898438 17.1687 5.37594 14.6499 10.8984 14.6499C16.4209 14.6499 20.8984 17.1687 20.8984 20.2749Z" stroke="#373634" stroke-width="1.8"/>
                                </svg>
                            </div>
                            <small>Individuals & Families</small>
                            <p>Individuals</p>
                        </div>
                        <p class="section__about--card--description">Safe, reliable rides for passengers with mobility needs. Our trained drivers assist with walkers, wheelchairs, canes, and door-to-door support for every trip.</p>
                    </div>

                    <a href="#" class="section__about--card--book-ride">Book A Ride →</a>
                </div>
                <div class="section__about--card">
                    <div>
                        <div class="section__about--card--head">
                            <div class="section__about--card--head__icon"> 
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M15.7498 5.25V2C15.7498 1.31875 15.1798 0.7525 14.4998 0.75H9.49979C8.81854 0.75 8.24729 1.32 8.24979 2V5.25M8.89979 15.75C6.02479 15.4363 3.62104 14.8687 1.09854 13.25M15.261 15.75C18.1385 15.4363 20.3785 14.8687 22.901 13.25M7.38479 23.25H16.6148C21.2523 23.25 22.0835 21.4388 22.326 19.2338L23.191 10.2337C23.5035 7.48875 22.6948 5.25 17.7685 5.25H6.23104C1.30479 5.25 0.497286 7.48875 0.808536 10.2337L1.67354 19.2338C1.91604 21.4388 2.74729 23.25 7.38479 23.25ZM13.6385 13.8737H10.5135C8.44729 13.8762 8.27729 17.6238 10.5135 17.6238H13.6385C15.8685 17.6238 15.7385 13.8737 13.6385 13.8737Z" stroke="#373735" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </div>
                            <small>Law Firms, Case Managers & Corporate</small>
                            <p>Business</p>
                        </div>
                        <p class="section__about--card--description">Dedicated NEMT support for law firms, case managers, employers and corporate teams coordinating reliable transportation for clients, patients or staff.</p>
                    </div>
                    <a href="#" class="section__about--card--book-ride">Book A Ride →</a>
                </div>
                <div class="section__about--card">
                    <div>
                        <div class="section__about--card--head">
                            <div class="section__about--card--head__icon"> 
                                <svg width="27" height="22" viewBox="0 0 27 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M20.75 20.75L25.53 15.97C25.6707 15.8295 25.7498 15.6388 25.75 15.44V8.875C25.75 8.37772 25.5525 7.90081 25.2008 7.54917C24.8492 7.19754 24.3723 7 23.875 7C23.3777 7 22.9008 7.19754 22.5492 7.54917C22.1975 7.90081 22 8.37772 22 8.875V14.5" stroke="#373735" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M20.75 15.75L21.8225 14.6775C21.8791 14.6214 21.9239 14.5546 21.9544 14.481C21.9848 14.4074 22.0004 14.3284 22 14.2487C21.9991 14.1365 21.9674 14.0266 21.9083 13.9312C21.8493 13.8357 21.7651 13.7584 21.665 13.7075L21.1112 13.4313C20.6421 13.1967 20.1111 13.1156 19.5933 13.1995C19.0756 13.2834 18.5973 13.528 18.2262 13.8988L17.1075 15.0175C16.6386 15.4862 16.3751 16.122 16.375 16.785V20.75M5.75 20.75L0.97 15.97C0.829308 15.8295 0.750175 15.6388 0.75 15.44V8.875C0.75 8.37772 0.947544 7.90081 1.29917 7.54917C1.65081 7.19754 2.12772 7 2.625 7C3.12228 7 3.59919 7.19754 3.95083 7.54917C4.30246 7.90081 4.5 8.37772 4.5 8.875V14.5" stroke="#373735" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M5.75 15.75L4.6775 14.6775C4.5655 14.5627 4.50195 14.4091 4.5 14.2487C4.5 14.02 4.63 13.8113 4.835 13.7075L5.38875 13.4313C5.85789 13.1967 6.38892 13.1156 6.90668 13.1995C7.42444 13.2834 7.9027 13.528 8.27375 13.8988L9.3925 15.0175C9.86137 15.4862 10.1249 16.122 10.125 16.785V20.75M15.3337 10.75H11.1663V7.83375H8.25V3.66625H11.1663V0.75H15.3337V3.66625H18.25V7.83375H15.3337V10.75Z" stroke="#373735" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </div>
                            <small>SNFs, Hospitals & Clinics</small>
                            <p>Healthcare Facilities</p>
                        </div>
                        <p class="section__about--card--description">Dependable transportation for clinics, hospitals, SNFs, and care teams. We help patients arrive safely for appointments, discharges, therapy, and follow-up visits.</p>
                    </div>
                    <a href="#" class="section__about--card--book-ride">Book A Ride →</a>
                </div>
                <div class="section__about--card">
                    <div>
                        <div class="section__about--card--head">
                            <div class="section__about--card--head__icon"> 
                                <svg width="27" height="25" viewBox="0 0 27 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M20 5.93945C20 5.69081 19.9012 5.45236 19.7254 5.27654C19.5496 5.10073 19.3111 5.00195 19.0625 5.00195C18.8139 5.00195 18.5754 5.10073 18.3996 5.27654C18.2238 5.45236 18.125 5.69081 18.125 5.93945V7.50195H16.5625C16.3139 7.50195 16.0754 7.60073 15.8996 7.77654C15.7238 7.95236 15.625 8.19081 15.625 8.43945C15.625 8.68809 15.7238 8.92655 15.8996 9.10237C16.0754 9.27818 16.3139 9.37695 16.5625 9.37695H18.125V10.9395C18.125 11.1881 18.2238 11.4265 18.3996 11.6024C18.5754 11.7782 18.8139 11.877 19.0625 11.877C19.3111 11.877 19.5496 11.7782 19.7254 11.6024C19.9012 11.4265 20 11.1881 20 10.9395V9.37695H21.5625C21.8111 9.37695 22.0496 9.27818 22.2254 9.10237C22.4012 8.92655 22.5 8.68809 22.5 8.43945C22.5 8.19081 22.4012 7.95236 22.2254 7.77654C22.0496 7.60073 21.8111 7.50195 21.5625 7.50195H20V5.93945Z" fill="#373735"/>
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M26.875 8.83686C26.875 4.67936 25.0225 1.57686 22.1375 0.448113C19.4687 -0.598137 16.265 0.184363 13.4375 2.83061C10.61 0.184363 7.40625 -0.598137 4.7375 0.448113C1.8525 1.57686 0 4.67936 0 8.83561C0 11.4844 1.4125 14.0894 3.17125 16.3319C4.94875 18.5981 7.18375 20.6269 9.04875 22.1406L9.21625 22.2781C10.7163 23.4969 11.8013 24.3781 13.4375 24.3781C15.075 24.3781 16.1575 23.4969 17.6588 22.2781L17.8263 22.1406C19.6912 20.6281 21.9262 18.5981 23.7037 16.3319C25.4625 14.0894 26.875 11.4844 26.875 8.83686ZM14.1225 4.79811C16.7625 1.97436 19.4987 1.42811 21.455 2.19311C23.415 2.96061 25 5.20561 25 8.83686C25 10.8506 23.9 13.0419 22.2275 15.1744C20.5725 17.2869 18.4575 19.2144 16.645 20.6856C14.9038 22.0981 14.3413 22.5019 13.4375 22.5019C12.5337 22.5019 11.9712 22.0981 10.23 20.6844C8.4175 19.2144 6.3025 17.2856 4.6475 15.1756C2.97375 13.0419 1.875 10.8506 1.875 8.83686C1.875 5.20561 3.46 2.96186 5.42 2.19311C7.37625 1.42811 10.1125 1.97436 12.7525 4.79811C12.8402 4.89198 12.9463 4.96682 13.0641 5.01798C13.1819 5.06915 13.309 5.09555 13.4375 5.09555C13.566 5.09555 13.6931 5.06915 13.8109 5.01798C13.9287 4.96682 14.0348 4.89198 14.1225 4.79811Z" fill="#373735"/>
                                </svg>
                            </div>
                            <small>Medicare, Medicaid & Managed Care</small>
                            <p>MCOs & Health Plans</p>
                        </div>
                        <p class="section__about--card--description">Credentialed NEMT support for members who need safe, consistent rides. We serve ambulatory, wheelchair, senior, and medically dependent passengers.</p>
                    </div>
                    <a href="#" class="section__about--card--book-ride">Book A Ride →</a>
                </div>

            </div>
        </div>
    </section>

    <section class="section__most-requested">
        <div class="global-size global-padding section__most-requested--main">
            <div class="section__most-requested--details">
                <span class="section--label">Most Requested</span>
                <h2>Transportation Support for Riders Who Need More</h2>
                <p class="section__most-requested--details--paragraph">Our most requested rides support everyday medical needs, recurring appointments, and mobility assistance with professional drivers and clear scheduling.</p>
                <div class="global-btns-con">
                    <a href="#" class="btn btn--main">View Our Services</a>
                    <a href="#" class="btn btn--secondary btn-txt-dark">Request A Quote</a>
                </div>
                <div class="global-testimonials">
                    <div class="global-testimonials--image">
                        <svg width="20" height="14" viewBox="0 0 20 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M17.6217 1.45021C17.9571 0.785122 17.4737 0 16.7288 0H14.7334C14.3558 0 14.0104 0.212653 13.8404 0.549788L11.4012 5.38763C11.3308 5.52726 11.2941 5.68146 11.2941 5.83784V13C11.2941 13.5523 11.7418 14 12.2941 14H18.7647C19.317 14 19.7647 13.5523 19.7647 13V6.6C19.7647 6.04772 19.317 5.6 18.7647 5.6H17.1535C16.4087 5.6 15.9253 4.81488 16.2606 4.14979L17.6217 1.45021ZM6.32762 1.45021C6.66296 0.785122 6.17955 0 5.4347 0H3.43925C3.06168 0 2.71631 0.212653 2.54633 0.549787L0.107079 5.38763C0.0366749 5.52726 0 5.68146 0 5.83784V13C0 13.5523 0.447715 14 1 14H7.47059C8.02287 14 8.47059 13.5523 8.47059 13V6.6C8.47059 6.04772 8.02287 5.6 7.47059 5.6H5.85942C5.11457 5.6 4.63115 4.81488 4.96649 4.14979L6.32762 1.45021Z" fill="#FDB932"/>
                        </svg>
                        <img src="{{ asset('public/images/testimonial-image.png') }}" alt="testimonial-image">
                    </div>
                    <div class="global-testimonials--detail">
                        <h5>Gabriel V.</h5>
                        <p>Alliance made transportation simple for my father. The driver was patient, arrived on time, and helped him safely from the door to the vehicle.</p>
                    </div>
                </div>
            </div>
            <div class="section__most-requested--lists">


                <div class="section__most-requested--card">
                    <div class="section__most-requested--card--icon">
                        <svg width="17" height="21" viewBox="0 0 17 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M8.23307 8.23324C10.2581 8.23324 11.8997 6.59161 11.8997 4.56657C11.8997 2.54152 10.2581 0.899902 8.23307 0.899902C6.20803 0.899902 4.56641 2.54152 4.56641 4.56657C4.56641 6.59161 6.20803 8.23324 8.23307 8.23324Z" stroke="white" stroke-width="1.8"/>
                        <path d="M15.5651 15.1089C15.5651 17.3868 15.5651 19.2339 8.23177 19.2339C0.898438 19.2339 0.898438 17.3868 0.898438 15.1089C0.898438 12.831 4.18194 10.9839 8.23177 10.9839C12.2816 10.9839 15.5651 12.831 15.5651 15.1089Z" stroke="white" stroke-width="1.8"/>
                        </svg>
                    </div>
                    <div class="section__most-requested--card--detail">
                        <h5 class="section--card-title">Doctor Appointment Rides</h5>
                        <p>Dependable transportation to primary care, specialists, imaging centers, and follow-up visits.</p>
                        <small class="gcol gcol--cyan">Most Booked</small>
                    </div>
                </div>
                <div class="section__most-requested--card">
                    <div class="section__most-requested--card--icon">
                        <svg width="17" height="21" viewBox="0 0 17 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M8.23307 8.23324C10.2581 8.23324 11.8997 6.59161 11.8997 4.56657C11.8997 2.54152 10.2581 0.899902 8.23307 0.899902C6.20803 0.899902 4.56641 2.54152 4.56641 4.56657C4.56641 6.59161 6.20803 8.23324 8.23307 8.23324Z" stroke="white" stroke-width="1.8"/>
                        <path d="M15.5651 15.1089C15.5651 17.3868 15.5651 19.2339 8.23177 19.2339C0.898438 19.2339 0.898438 17.3868 0.898438 15.1089C0.898438 12.831 4.18194 10.9839 8.23177 10.9839C12.2816 10.9839 15.5651 12.831 15.5651 15.1089Z" stroke="white" stroke-width="1.8"/>
                        </svg>
                    </div>
                    <div class="section__most-requested--card--detail">
                        <h5 class="section--card-title">Dialysis Transportation</h5>
                        <p>Recurring ride support for riders who need consistent weekly transportation to dialysis care.</p>
                        <small class="gcol gcol--indigo">Recurring Care</small>
                    </div>
                </div>
                <div class="section__most-requested--card">
                    <div class="section__most-requested--card--icon">
                        <svg width="17" height="21" viewBox="0 0 17 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M8.23307 8.23324C10.2581 8.23324 11.8997 6.59161 11.8997 4.56657C11.8997 2.54152 10.2581 0.899902 8.23307 0.899902C6.20803 0.899902 4.56641 2.54152 4.56641 4.56657C4.56641 6.59161 6.20803 8.23324 8.23307 8.23324Z" stroke="white" stroke-width="1.8"/>
                        <path d="M15.5651 15.1089C15.5651 17.3868 15.5651 19.2339 8.23177 19.2339C0.898438 19.2339 0.898438 17.3868 0.898438 15.1089C0.898438 12.831 4.18194 10.9839 8.23177 10.9839C12.2816 10.9839 15.5651 12.831 15.5651 15.1089Z" stroke="white" stroke-width="1.8"/>
                        </svg>
                    </div>
                    <div class="section__most-requested--card--detail">
                        <h5 class="section--card-title">Therapy & Rehabilitation Trips</h5>
                        <p>Transportation for physical therapy, occupational therapy, rehab visits, and mobility recovery.</p>
                        <small class="gcol gcol--yellow">Recovery Support</small>
                    </div>
                </div>
                <div class="section__most-requested--card">
                    <div class="section__most-requested--card--icon">
                        <svg width="17" height="21" viewBox="0 0 17 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M8.23307 8.23324C10.2581 8.23324 11.8997 6.59161 11.8997 4.56657C11.8997 2.54152 10.2581 0.899902 8.23307 0.899902C6.20803 0.899902 4.56641 2.54152 4.56641 4.56657C4.56641 6.59161 6.20803 8.23324 8.23307 8.23324Z" stroke="white" stroke-width="1.8"/>
                        <path d="M15.5651 15.1089C15.5651 17.3868 15.5651 19.2339 8.23177 19.2339C0.898438 19.2339 0.898438 17.3868 0.898438 15.1089C0.898438 12.831 4.18194 10.9839 8.23177 10.9839C12.2816 10.9839 15.5651 12.831 15.5651 15.1089Z" stroke="white" stroke-width="1.8"/>
                        </svg>
                    </div>
                    <div class="section__most-requested--card--detail">
                        <h5 class="section--card-title">Hospital Discharge Rides</h5>
                        <p>Assisted rides home from hospitals, clinics, and care facilities when emergency transport is not needed.</p>
                        <small class="gcol gcol--red">Post-Discharge</small>
                    </div>
                </div>
                <div class="section__most-requested--card">
                    <div class="section__most-requested--card--icon">
                        <svg width="17" height="21" viewBox="0 0 17 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M8.23307 8.23324C10.2581 8.23324 11.8997 6.59161 11.8997 4.56657C11.8997 2.54152 10.2581 0.899902 8.23307 0.899902C6.20803 0.899902 4.56641 2.54152 4.56641 4.56657C4.56641 6.59161 6.20803 8.23324 8.23307 8.23324Z" stroke="white" stroke-width="1.8"/>
                        <path d="M15.5651 15.1089C15.5651 17.3868 15.5651 19.2339 8.23177 19.2339C0.898438 19.2339 0.898438 17.3868 0.898438 15.1089C0.898438 12.831 4.18194 10.9839 8.23177 10.9839C12.2816 10.9839 15.5651 12.831 15.5651 15.1089Z" stroke="white" stroke-width="1.8"/>
                        </svg>
                    </div>
                    <div class="section__most-requested--card--detail">
                        <h5 class="section--card-title">Wheelchair Transportation</h5>
                        <p>Driver-assisted transportation for wheelchair users who need safe loading, securement, and drop-off.</p>
                        <small class="gcol gcol--green">Accessibility Ready</small>
                    </div>
                </div>
                <div class="section__most-requested--card">
                    <div class="section__most-requested--card--icon">
                        <svg width="17" height="21" viewBox="0 0 17 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M8.23307 8.23324C10.2581 8.23324 11.8997 6.59161 11.8997 4.56657C11.8997 2.54152 10.2581 0.899902 8.23307 0.899902C6.20803 0.899902 4.56641 2.54152 4.56641 4.56657C4.56641 6.59161 6.20803 8.23324 8.23307 8.23324Z" stroke="white" stroke-width="1.8"/>
                        <path d="M15.5651 15.1089C15.5651 17.3868 15.5651 19.2339 8.23177 19.2339C0.898438 19.2339 0.898438 17.3868 0.898438 15.1089C0.898438 12.831 4.18194 10.9839 8.23177 10.9839C12.2816 10.9839 15.5651 12.831 15.5651 15.1089Z" stroke="white" stroke-width="1.8"/>
                        </svg>
                    </div>
                    <div class="section__most-requested--card--detail">
                        <h5 class="section--card-title">Senior Errand Support</h5>
                        <p>Helpful rides for essential errands, pharmacy stops, groceries, and everyday mobility needs.</p>
                        <small class="gcol gcol--blue">Daily Assistance</small>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section class="section__why-us global-size global-padding">
        <span class="section--label">Why Ride With Alliance</span>
        <h2>Why Families and Riders Choose Alliance First</h2>
        <p class="section__why-us--paragraph">Unlike app-based rideshares, Alliance focuses on medically sensitive riders who need trained drivers, patient assistance, and dependable door-to-door service.</p>
        <div class="section__why-us--stats">
            <p>
                <svg width="10" height="9" viewBox="0 0 10 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M4.99994 7.43606L2.34048 8.95402C2.26233 8.99049 2.1898 9.00527 2.12289 8.99834C2.05646 8.99096 1.99174 8.96926 1.92874 8.93325C1.86524 8.89631 1.81738 8.84415 1.78514 8.77674C1.75291 8.70934 1.74998 8.6357 1.77635 8.55583L2.48407 5.70966L0.14331 3.79144C0.0773731 3.74065 0.0339035 3.67994 0.0129013 3.60931C-0.00810085 3.53867 -0.0034608 3.47104 0.0268214 3.40641C0.0571036 3.34177 0.0973984 3.28868 0.147706 3.24713C0.198502 3.20697 0.266881 3.17973 0.352843 3.16542L3.44163 2.91058L4.64608 0.215368C4.67929 0.139193 4.72715 0.0842541 4.78967 0.0505525C4.85219 0.0168508 4.92228 0 4.99994 0C5.0776 0 5.14793 0.0168508 5.21094 0.0505525C5.27394 0.0842541 5.32156 0.139193 5.3538 0.215368L6.55825 2.91058L9.6463 3.16542C9.73275 3.17927 9.80137 3.20674 9.85217 3.24782C9.90297 3.28845 9.94351 3.34131 9.97379 3.40641C10.0036 3.47104 10.008 3.53867 9.98697 3.60931C9.96597 3.67994 9.9225 3.74065 9.85657 3.79144L7.5158 5.70966L8.22353 8.55583C8.25088 8.63478 8.24819 8.70819 8.21547 8.77605C8.18274 8.84391 8.13463 8.89608 8.07114 8.93256C8.00862 8.96949 7.9439 8.99142 7.87699 8.99834C7.81056 9.00527 7.73828 8.99049 7.66013 8.95402L4.99994 7.43606Z" fill="#FDB932"/>
                </svg>
                4.9 ratings
            </p>
            <div></div>
            <p>20+ Years in Operation</p>
            <div></div>
            <p>99% on-time</p>
        </div>
        <div class="section__why-us--lists">
            <div class="section__why-us--lists--card">
                <h5 class="section--card-title">Trained Driver Support</h5>
                <p>Drivers are prepared to assist riders with mobility aids, careful transfers, and respectful passenger support.</p>
            </div>
            <div class="section__why-us--lists--card">
                <h5 class="section--card-title">Door-to-Door Care</h5>
                <p>We do more than pull up to the curb. We help riders safely reach the vehicle and destination entrance.</p>
            </div>
            <div class="section__why-us--lists--card">
                <h5 class="section--card-title">Clear, Fair Pricing</h5>
                <p>No doc fee. No hidden fees. Riders know what to expect before the ride is confirmed.</p>
            </div>
        </div>
        <a href="#" class="btn btn--main">View Our Services</a>
    </section>

    <section class="section__what-set-us"> 
        <img src="{{ asset('public/images/navy-vector-bg.svg') }}" class="swsu-vector" alt="What Sets Us Apart">
        <div class="section__what-set-us--main">
            <span class="section--label">What Sets Us Apart</span>
            <h2>Professional Standards That Set Us Apart</h2>
            <p class="section__what-set-us--main__paragraph">Our difference is built on safety, accountability, and compassion, with every driver screened, trained, and held to a higher service standard.</p>
            <div class="section__what-set-us--main__lists">

                <div class="section__what-set-us--main__lists--card">
                    <div>
                        <img src="{{ asset('public/images/wsua-image-1.png') }}" alt="icon">
                    </div>
                    <h5 class="section--card-title">Rigorous Vetting</h5>
                    <p>Every driver completes a criminal background check and screening process before joining the Alliance team.</p> 
                </div> 
                <div class="section__what-set-us--main__lists--card">
                    <div>
                        <img src="{{ asset('public/images/wsua-image-2.png') }}" alt="icon">
                    </div>
                    <h5 class="section--card-title">Compassionate Transportation</h5>
                    <p>We assist riders with patience, dignity, and respect, providing a calm and supportive ride experience.</p> 
                </div> 
                <div class="section__what-set-us--main__lists--card">
                    <div>
                        <img src="{{ asset('public/images/wsua-image-3.png') }}" alt="icon">
                    </div>
                    <h5 class="section--card-title">Commercial Compliance</h5>
                    <p>Our livery-plated vehicles and commercial fleet insurance help protect riders on every trip.</p> 
                </div> 
            
            </div>
            <a href="#" class="btn btn--main">Learn More</a>
        </div>
    </section>

    <section class="section__services">
        <div class="section__services--main global-size global-padding">
            <span class="section--label">Our Services</span>
            <h2>Popular RWA Services</h2>
            <p class="section__services--main__paragraph">All rides include trained drivers, door-to-door assistance, commercial compliance, and clear upfront pricing with no hidden fees.</p>
        
            <div class="section__services--lists">

                <div class="section__services--lists__card">
                    <div class="section__services--lists__card__img">
                        <img src="{{ asset('public/images/service-1.png') }}" alt="Service Image">
                    </div>
                    <div class="section__services--lists__card__detail">
                        <h5 class="section__card-title">Wheelchair Transport</h5>
                        <p>Every driver completes a criminal background check and screening process before joining the Alliance team.</p>
                    </div>
                    <div class="section__services--lists__card__actions">
                        <a href="#" class="section__services--lists__card__actions--primary">Learn More</a>
                        <a href="#" class="section__services--lists__card__actions--secondary">
                            <svg width="12" height="10" viewBox="0 0 12 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M5.75 1.20337C6.5481 0.742583 7.45343 0.5 8.375 0.5C9.29657 0.5 10.2019 0.742583 11 1.20337V8.7867C10.2019 8.32592 9.29657 8.08333 8.375 8.08333C7.45343 8.08333 6.5481 8.32592 5.75 8.7867C4.9519 8.32592 4.04657 8.08333 3.125 8.08333C2.20343 8.08333 1.2981 8.32592 0.5 8.7867V1.20337C1.2981 0.742583 2.20343 0.5 3.125 0.5C4.04657 0.5 4.9519 0.742583 5.75 1.20337ZM5.75 8.7867V1.20337" stroke="#373737" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            Book your ride!
                        </a>
                    </div> 
                </div>
                <div class="section__services--lists__card">
                    <div class="section__services--lists__card__img">
                        <img src="{{ asset('public/images/service-2.png') }}" alt="Service Image">
                    </div>
                    <div class="section__services--lists__card__detail">
                        <h5 class="section__card-title">Dialysis Transport</h5>
                        <p>Every driver completes a criminal background check and screening process before joining the Alliance team.</p>
                    </div>
                    <div class="section__services--lists__card__actions">
                        <a href="#" class="section__services--lists__card__actions--primary">Learn More</a>
                        <a href="#" class="section__services--lists__card__actions--secondary">
                            <svg width="12" height="10" viewBox="0 0 12 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M5.75 1.20337C6.5481 0.742583 7.45343 0.5 8.375 0.5C9.29657 0.5 10.2019 0.742583 11 1.20337V8.7867C10.2019 8.32592 9.29657 8.08333 8.375 8.08333C7.45343 8.08333 6.5481 8.32592 5.75 8.7867C4.9519 8.32592 4.04657 8.08333 3.125 8.08333C2.20343 8.08333 1.2981 8.32592 0.5 8.7867V1.20337C1.2981 0.742583 2.20343 0.5 3.125 0.5C4.04657 0.5 4.9519 0.742583 5.75 1.20337ZM5.75 8.7867V1.20337" stroke="#373737" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            Book your ride!
                        </a>
                    </div> 
                </div>
                <div class="section__services--lists__card">
                    <div class="section__services--lists__card__img">
                        <img src="{{ asset('public/images/service-4.png') }}" alt="Service Image">
                    </div>
                    <div class="section__services--lists__card__detail">
                        <h5 class="section__card-title">Hospital Discharge</h5>
                        <p>Every driver completes a criminal background check and screening process before joining the Alliance team.</p>
                    </div>
                    <div class="section__services--lists__card__actions">
                        <a href="#" class="section__services--lists__card__actions--primary">Learn More</a>
                        <a href="#" class="section__services--lists__card__actions--secondary">
                            <svg width="12" height="10" viewBox="0 0 12 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M5.75 1.20337C6.5481 0.742583 7.45343 0.5 8.375 0.5C9.29657 0.5 10.2019 0.742583 11 1.20337V8.7867C10.2019 8.32592 9.29657 8.08333 8.375 8.08333C7.45343 8.08333 6.5481 8.32592 5.75 8.7867C4.9519 8.32592 4.04657 8.08333 3.125 8.08333C2.20343 8.08333 1.2981 8.32592 0.5 8.7867V1.20337C1.2981 0.742583 2.20343 0.5 3.125 0.5C4.04657 0.5 4.9519 0.742583 5.75 1.20337ZM5.75 8.7867V1.20337" stroke="#373737" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            Book your ride!
                        </a>
                    </div> 
                </div>
                <div class="section__services--lists__card">
                    <div class="section__services--lists__card__img">
                        <img src="{{ asset('public/images/service-4.png') }}" alt="Service Image">
                    </div>
                    <div class="section__services--lists__card__detail">
                        <h5 class="section__card-title">Stretcher Transport</h5>
                        <p>Every driver completes a criminal background check and screening process before joining the Alliance team.</p>
                    </div>
                    <div class="section__services--lists__card__actions">
                        <a href="#" class="section__services--lists__card__actions--primary">Learn More</a>
                        <a href="#" class="section__services--lists__card__actions--secondary">
                            <svg width="12" height="10" viewBox="0 0 12 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M5.75 1.20337C6.5481 0.742583 7.45343 0.5 8.375 0.5C9.29657 0.5 10.2019 0.742583 11 1.20337V8.7867C10.2019 8.32592 9.29657 8.08333 8.375 8.08333C7.45343 8.08333 6.5481 8.32592 5.75 8.7867C4.9519 8.32592 4.04657 8.08333 3.125 8.08333C2.20343 8.08333 1.2981 8.32592 0.5 8.7867V1.20337C1.2981 0.742583 2.20343 0.5 3.125 0.5C4.04657 0.5 4.9519 0.742583 5.75 1.20337ZM5.75 8.7867V1.20337" stroke="#373737" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            Book your ride!
                        </a>
                    </div> 
                </div>
                <div class="section__services--lists__card">
                    <div class="section__services--lists__card__img">
                        <img src="{{ asset('public/images/service-5.png') }}" alt="Service Image">
                    </div>
                    <div class="section__services--lists__card__detail">
                        <h5 class="section__card-title">Senior Transport</h5>
                        <p>Every driver completes a criminal background check and screening process before joining the Alliance team.</p>
                    </div>
                    <div class="section__services--lists__card__actions">
                        <a href="#" class="section__services--lists__card__actions--primary">Learn More</a>
                        <a href="#" class="section__services--lists__card__actions--secondary">
                            <svg width="12" height="10" viewBox="0 0 12 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M5.75 1.20337C6.5481 0.742583 7.45343 0.5 8.375 0.5C9.29657 0.5 10.2019 0.742583 11 1.20337V8.7867C10.2019 8.32592 9.29657 8.08333 8.375 8.08333C7.45343 8.08333 6.5481 8.32592 5.75 8.7867C4.9519 8.32592 4.04657 8.08333 3.125 8.08333C2.20343 8.08333 1.2981 8.32592 0.5 8.7867V1.20337C1.2981 0.742583 2.20343 0.5 3.125 0.5C4.04657 0.5 4.9519 0.742583 5.75 1.20337ZM5.75 8.7867V1.20337" stroke="#373737" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            Book your ride!
                        </a>
                    </div> 
                </div>
                <div class="section__services--lists__card">
                    <div class="section__services--lists__card__img">
                        <img src="{{ asset('public/images/service-6.png') }}" alt="Service Image">
                    </div>
                    <div class="section__services--lists__card__detail">
                        <h5 class="section__card-title">Long-Distance Medical</h5>
                        <p>Every driver completes a criminal background check and screening process before joining the Alliance team.</p>
                    </div>
                    <div class="section__services--lists__card__actions">
                        <a href="#" class="section__services--lists__card__actions--primary">Learn More</a>
                        <a href="#" class="section__services--lists__card__actions--secondary">
                            <svg width="12" height="10" viewBox="0 0 12 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M5.75 1.20337C6.5481 0.742583 7.45343 0.5 8.375 0.5C9.29657 0.5 10.2019 0.742583 11 1.20337V8.7867C10.2019 8.32592 9.29657 8.08333 8.375 8.08333C7.45343 8.08333 6.5481 8.32592 5.75 8.7867C4.9519 8.32592 4.04657 8.08333 3.125 8.08333C2.20343 8.08333 1.2981 8.32592 0.5 8.7867V1.20337C1.2981 0.742583 2.20343 0.5 3.125 0.5C4.04657 0.5 4.9519 0.742583 5.75 1.20337ZM5.75 8.7867V1.20337" stroke="#373737" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            Book your ride!
                        </a>
                    </div> 
                </div>

            </div>
        </div>
    </section>

    <section class="section__care-levels">
        <img src="{{ asset('public/images/vector-full.svg') }}" class="section__care-levels--vec" alt="vector">
        <div class="section__care-levels--main global-size global-padding">
            <div class="section__care-levels--main--detail">
                <span class="section--label">Care Levels</span>
                <h2>Care Levels Matched to Each Rider’s Needs</h2>
                <p class="section__care-levels--main--detail__paragraph">Not every rider needs the same level of help, so Alliance supports different assistance levels based on mobility, safety, and trip requirements.</p>
                <a href="#" class="btn btn--main">Learn More</a>
                <div class="global-testimonials ">
                    <div class="global-testimonials--image">
                        <svg width="20" height="14" viewBox="0 0 20 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M17.6217 1.45021C17.9571 0.785122 17.4737 0 16.7288 0H14.7334C14.3558 0 14.0104 0.212653 13.8404 0.549788L11.4012 5.38763C11.3308 5.52726 11.2941 5.68146 11.2941 5.83784V13C11.2941 13.5523 11.7418 14 12.2941 14H18.7647C19.317 14 19.7647 13.5523 19.7647 13V6.6C19.7647 6.04772 19.317 5.6 18.7647 5.6H17.1535C16.4087 5.6 15.9253 4.81488 16.2606 4.14979L17.6217 1.45021ZM6.32762 1.45021C6.66296 0.785122 6.17955 0 5.4347 0H3.43925C3.06168 0 2.71631 0.212653 2.54633 0.549787L0.107079 5.38763C0.0366749 5.52726 0 5.68146 0 5.83784V13C0 13.5523 0.447715 14 1 14H7.47059C8.02287 14 8.47059 13.5523 8.47059 13V6.6C8.47059 6.04772 8.02287 5.6 7.47059 5.6H5.85942C5.11457 5.6 4.63115 4.81488 4.96649 4.14979L6.32762 1.45021Z" fill="#FFFFFF"/>
                        </svg>
                        <img src="{{ asset('public/images/testimonial-image.png') }}" alt="testimonial-image">
                    </div>
                    <div class="global-testimonials--detail">
                        <h5 style="color: #fff">Gabriel V.</h5>
                        <p style="color: #fff; font-weight: 300;" class="global-testimonials-care-levels">Alliance made transportation simple for my father. The driver was patient, arrived on time, and helped him safely from the door to the vehicle.</p>
                    </div>
                </div>
            </div>
            <div class="section__care-levels--main--img">
                <img src="{{asset('public/images/care-levels-img.png')}}" alt="">
            </div>
            <div class="section__care-levels--main--list">
                <div class="section__care-levels--main--list__card">
                    <h5>Curb-to-Curb</h5>
                    <p>For riders who can safely meet the driver at pickup and enter the destination independently.</p>
                </div>
                <div class="section__care-levels--main--list__card">
                    <h5>Curb-to-Curb</h5>
                    <p>For riders who can safely meet the driver at pickup and enter the destination independently.</p>
                </div>
                <div class="section__care-levels--main--list__card">
                    <h5>Curb-to-Curb</h5>
                    <p>For riders who can safely meet the driver at pickup and enter the destination independently.</p>
                </div>
                <div class="section__care-levels--main--list__card">
                    <h5>Curb-to-Curb</h5>
                    <p>For riders who can safely meet the driver at pickup and enter the destination independently.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="section__trip-options"> 
        <div class="section__trip-options--main global-size global-padding">
            <span class="section--label">Trip Options</span>
            <h2>Flexible Trip Options for Medical and Daily Rides</h2>
            <p class="section__trip-options--main__paragraph">Whether the ride is planned once, needed weekly, or scheduled for a return pickup, our dispatch team helps coordinate the right trip option.</p>
        
            <div class="section__trip-options--main--contents">
                <div class="section__trip-options--main--contents--img">
                    <img src="{{ asset('public/images/trips-options.png') }}" alt="Trip Options Banner Image">
                </div>
                <div class="section__trip-options--main--contents--lists">
                    <div class="section__trip-options--main--contents--lists__card">
                        <svg width="44" height="45" viewBox="0 0 44 45" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect width="44" height="45" rx="22" fill="#FDB932"/>
                            <path d="M30.5 32H16.5C15.7044 32 14.9413 31.6839 14.3787 31.1213C13.8161 30.5587 13.5 29.7956 13.5 29C13.5 28.2044 13.8161 27.4413 14.3787 26.8787C14.9413 26.3161 15.7044 26 16.5 26H30.5V32ZM30.5 32V13H16.5C15.7044 13 14.9413 13.3161 14.3787 13.8787C13.8161 14.4413 13.5 15.2044 13.5 16V28M21.5 17H26.5" stroke="white" stroke-width="1.5" stroke-linecap="square"/>
                        </svg>
                        <div>
                            <h4>One-Way Trips</h4>
                            <p>For riders who can safely meet the driver at pickup and enter the destination independently.</p>
                        </div>
                    </div>
                    <div class="section__trip-options--main--contents--lists__card">
                        <svg width="44" height="45" viewBox="0 0 44 45" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect width="44" height="45" rx="22" fill="#FDB932"/>
                            <path d="M30.5 32H16.5C15.7044 32 14.9413 31.6839 14.3787 31.1213C13.8161 30.5587 13.5 29.7956 13.5 29C13.5 28.2044 13.8161 27.4413 14.3787 26.8787C14.9413 26.3161 15.7044 26 16.5 26H30.5V32ZM30.5 32V13H16.5C15.7044 13 14.9413 13.3161 14.3787 13.8787C13.8161 14.4413 13.5 15.2044 13.5 16V28M21.5 17H26.5" stroke="white" stroke-width="1.5" stroke-linecap="square"/>
                        </svg>
                        <div>
                            <h4>Round Trips</h4>
                            <p>For riders who can safely meet the driver at pickup and enter the destination independently.</p>
                        </div>
                    </div>
                    <div class="section__trip-options--main--contents--lists__card">
                        <svg width="44" height="45" viewBox="0 0 44 45" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect width="44" height="45" rx="22" fill="#FDB932"/>
                            <path d="M30.5 32H16.5C15.7044 32 14.9413 31.6839 14.3787 31.1213C13.8161 30.5587 13.5 29.7956 13.5 29C13.5 28.2044 13.8161 27.4413 14.3787 26.8787C14.9413 26.3161 15.7044 26 16.5 26H30.5V32ZM30.5 32V13H16.5C15.7044 13 14.9413 13.3161 14.3787 13.8787C13.8161 14.4413 13.5 15.2044 13.5 16V28M21.5 17H26.5" stroke="white" stroke-width="1.5" stroke-linecap="square"/>
                        </svg>
                        <div>
                            <h4>Recurring Trips</h4>
                            <p>For riders who can safely meet the driver at pickup and enter the destination independently.</p>
                        </div>
                    </div>
                    <div class="section__trip-options--main--contents--lists__card">
                        <svg width="44" height="45" viewBox="0 0 44 45" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect width="44" height="45" rx="22" fill="#FDB932"/>
                            <path d="M30.5 32H16.5C15.7044 32 14.9413 31.6839 14.3787 31.1213C13.8161 30.5587 13.5 29.7956 13.5 29C13.5 28.2044 13.8161 27.4413 14.3787 26.8787C14.9413 26.3161 15.7044 26 16.5 26H30.5V32ZM30.5 32V13H16.5C15.7044 13 14.9413 13.3161 14.3787 13.8787C13.8161 14.4413 13.5 15.2044 13.5 16V28M21.5 17H26.5" stroke="white" stroke-width="1.5" stroke-linecap="square"/>
                        </svg>
                        <div>
                            <h4>Wait-and-Return Trips</h4>
                            <p>For riders who can safely meet the driver at pickup and enter the destination independently.</p>
                        </div>
                    </div>
                    {{-- <br> --}}
                    <a href="#" class="btn btn--dark">
                        <svg width="12" height="10" viewBox="0 0 12 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M6 1.26391C6.83611 0.763464 7.78455 0.5 8.75 0.5C9.71545 0.5 10.6639 0.763464 11.5 1.26391V9.5C10.6639 8.99955 9.71545 8.73609 8.75 8.73609C7.78455 8.73609 6.83611 8.99955 6 9.5C5.16389 8.99955 4.21545 8.73609 3.25 8.73609C2.28455 8.73609 1.33611 8.99955 0.5 9.5V1.26391C1.33611 0.763464 2.28455 0.5 3.25 0.5C4.21545 0.5 5.16389 0.763464 6 1.26391ZM6 9.5V1.26391" stroke="#050505" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        Book Your Ride Now!</a>
                </div>
            </div>
        </div>
    </section>


    <div style="height: 40rem;"></div>
</main>
@include('front.layouts.sections.footer')
@push('extrascripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const header = document.querySelector('.site-header');
    const hero = document.querySelector('.section__hero');

    if (!header || !hero) return;

    function updateHeaderStyle() {
        const heroHeight = hero.offsetHeight;
        const scrollY = window.scrollY;

        if (scrollY >= heroHeight - 80) {
            header.classList.remove('header-style-2');
            header.classList.add('header-style-1');
        } else {
            header.classList.remove('header-style-1');
            header.classList.add('header-style-2');
        }
    }

    updateHeaderStyle();

    window.addEventListener('scroll', updateHeaderStyle);
    window.addEventListener('resize', updateHeaderStyle);
});
</script>
@endpush
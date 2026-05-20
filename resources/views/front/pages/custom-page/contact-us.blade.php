<section class="page page--contact-us">
    @include('front.layouts.sections.header')
    @include('front.pages.custom-page.sections.banner')
    <main class="main-content">
        {{-- individual section  --}}
        <section class="section-name">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 section-name__item">
                        <div class="contact-form">
                            {{  Form::open([
                                'method' => 'POST',
                                'id' => 'create-contact',
                                'route' => ['contact.store'],
                                'class' => '',
                                ])
                            }}
                            <ul class="form-box row">
                                <div class="col-md-6 form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                    <label for="name">Name</label>
                                    <input id="name" type="text" class="form-control " name="name">
                                    @if($errors->has('name'))
                                        <span class="help-block animation-slideDown">{{ $errors->first('name') }}</span>
                                    @endif
                                </div>
                                <div class="col-md-6 form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                    <label for="email">Email</label>
                                    <input id="email" type="text" class="form-control " name="email">
                                    @if($errors->has('email'))
                                        <span class="help-block animation-slideDown">{{ $errors->first('email') }}</span>
                                    @endif
                                </div>
                                <div class="col-md-12 form-group{{ $errors->has('subject') ? ' has-error' : '' }}">
                                    <label for="subject">Subject</label>
                                    <input id="subject" type="text" class="form-control " name="subject">
                                    @if($errors->has('subject'))
                                        <span class="help-block animation-slideDown">{{ $errors->first('subject') }}</span>
                                    @endif
                                </div>
                                <div class="col-md-12 form-group {{ $errors->has('message') ? ' has-error' : '' }}">
                                    <label for="message">Message</label>
                                    <textarea id="message" name="message" class="form-control"></textarea>
                                    @if($errors->has('message'))
                                        <span class="help-block animation-slideDown">{{ $errors->first('message') }}</span>
                                    @endif
                                </div>
                                <div
                                        class="col-md-12 form-group {{ $errors->has('g-recaptcha-response') ? ' has-error' : '' }}">
                                    {!! NoCaptcha::display() !!}
                                    @if($errors->has('g-recaptcha-response'))
                                        <span
                                                class="help-block animation-slideDown">{{ $errors->first('g-recaptcha-response') }}</span>
                                    @endif
                                </div>
                                <div class="col-md-12 form-group">
                                    <button type="submit" class="btn btn-primary">SUBMIT MESSAGE</button>
                                </div>
                            </ul>
                            {{ Form::close() }}
                        </div>
                    </div>
                </div>
            </div> {{-- end of default-content--row --}}
        </section> {{-- end of default-content --}}
    </main>
    @include('front.layouts.sections.footer')
</section>
@push('extrascripts')
{!! NoCaptcha::renderJs() !!}
<script type="text/javascript" src="{{ asset('public/js/libraries/contacts.js') }}"></script>
@endpush
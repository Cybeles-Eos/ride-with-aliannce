@extends('admin.layouts.base')

@section('content')
    <ul class="breadcrumb breadcrumb-top">
        <li><a href="{{ route('admin.faqs.index') }}">FAQ's</a></li>
        <li><span href="javascript:void(0)">View FAQ</span></li>
    </ul>
    <div class="content-header">
        <div class="header-section">
            <h1>{{ $faq->FAQQuestion }}</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2">
            <div class="block block-alt-noborder">
                <article>
                    <h3 class="sub-header text-center"><strong> {{ $faq->FAQCreatedDate->format('F d, Y') }} </strong>
                        <div class="btn-group btn-group-xs pull-right">

                                <a href="{{ route('admin.faqs.edit', $faq->FAQID) }}"
                                   data-toggle="tooltip"
                                   title=""
                                   class="btn btn-default"
                                   data-original-title="Edit"><i class="fa fa-pencil"></i> Edit</a>

                                <a href="javascript:void(0)" data-toggle="tooltip"
                                   title=""
                                   class="btn btn-xs btn-danger delete-faq-btn"
                                   data-original-title="Delete"
                                   data-faq-id="{{ $faq->id }}"
                                   data-faq-route="{{ route('admin.faqs.delete', $faq->id) }}">
                                    <i class="fa fa-times"> Delete</i>
                                </a>

                        </div>
                    </h3>

                    <p>{!! $faq->FAQAnswer !!}</p>
                </article>
            </div>
        </div>
    </div>
@endsection

@push('extrascripts')
    <script type="text/javascript" src="{{ asset('public/js/libraries/faqs.js') }}"></script>
@endpush
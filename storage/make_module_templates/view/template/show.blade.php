@extends('admin.layouts.base')

@section('content')
    <ul class="breadcrumb breadcrumb-top">
        <li><a href="{{ route('admin.template_snake_case_plural.index') }}">DefaultTemplatePlural</a></li>
        <li><span href="javascript:void(0)">View DefaultTemplate</span></li>
    </ul>
    <div class="content-header">
        <div class="header-section">
            <h1>{{ $template_snake_case->name }}</h1>
            <h5>{{ $template_snake_case->slug }}</h5>
        </div>
    </div>
    <div class="row">
        <div class="col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2">
            <div class="block block-alt-noborder">
                <article>
                    <h3 class="sub-header text-center"><strong> {{ $template_snake_case->created_at->format('F d, Y') }} </strong>
                        <div class="btn-group btn-group-xs pull-right">
                            @if (auth()->user()->can('Update DefaultTemplate'))
                                <a href="{{ route('admin.template_snake_case_plural.edit', $template_snake_case->id) }}"
                                   data-toggle="tooltip"
                                   title=""
                                   class="btn btn-default"
                                   data-original-title="Edit"><i class="fa fa-pencil"></i> Edit</a>
                            @endif
                            @if (auth()->user()->can('Delete DefaultTemplate'))
                                <a href="javascript:void(0)" data-toggle="tooltip"
                                   title=""
                                   class="btn btn-xs btn-danger delete-template_snake_case-btn"
                                   data-original-title="Delete"
                                   data-template_snake_case-id="{{ $template_snake_case->id }}"
                                   data-template_snake_case-route="{{ route('admin.template_snake_case_plural.delete', $template_snake_case->id) }}">
                                    <i class="fa fa-times"> Delete</i>
                                </a>
                            @endif
                        </div>
                    </h3>

                    <img src="{{ asset($template_snake_case->banner_image) }}" alt="{{ $template_snake_case->banner_image }}" class="img-responsive center-block" style="max-width: 100px;">

                    <p>{!! $template_snake_case->content !!}</p>
                </article>
            </div>
        </div>
    </div>
@endsection

@push('extrascripts')
    <script type="text/javascript" src="{{ asset('public/js/libraries/template_snake_case_plural.js') }}"></script>
@endpush
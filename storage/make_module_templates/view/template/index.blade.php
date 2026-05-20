@extends('admin.layouts.base')

@section('content')
    @if (auth()->user()->can('Create DefaultTemplate'))
        <div class="row text-center">
            <div class="col-sm-12 col-lg-12">
                <a href="{{ route('admin.template_snake_case_plural.create') }}" class="widget widget-hover-effect2">
                    <div class="widget-extra themed-background">
                        <h4 class="widget-content-light">
                            <strong>Add New</strong>
                            DefaultTemplate
                        </h4>
                    </div>
                    <div class="widget-extra-full">
                        <span class="h2 text-primary animation-expandOpen">
                            <i class="fa fa-plus"></i>
                        </span>
                    </div>
                </a>
            </div>
        </div>
    @endif
    <div class="block full">
        <div class="block-title">
            <h2>
                <i class="fa fa-newspaper-o sidebar-nav-icon"></i>
                <strong>DefaultTemplatePlural</strong>
            </h2>
        </div>
        <div class="alert alert-info alert-dismissable template_snake_case-empty {{$template_snake_case_plural->count() == 0 ? '' : 'johnCena' }}">
            <i class="fa fa-info-circle"></i> No DefaultTemplatePlural found.
        </div>
        <div class="table-responsive {{$template_snake_case_plural->count() == 0 ? 'johnCena' : '' }}">
            <table id="template_snake_case_plural-table" class="table table-bordered table-striped table-vcenter">
                <thead>
                <tr role="row">
                    <th class="text-center">
                        ID
                    </th>
                    <th class="text-center">
                        Name
                    </th>
                    <th class="text-left">
                        Slug
                    </th>
                    <th class="text-left">
                        Content
                    </th>
                    <th class="text-center">
                        Date Created
                    </th>
                    <th class="text-center">
                        Action
                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach($template_snake_case_plural as $template_snake_case)
                    <tr data-template_snake_case-id="{{$template_snake_case->id}}">
                        <td class="text-center"><strong>{{ $template_snake_case->id }}</strong></td>
                        <td class="text-center"><strong>{{ $template_snake_case->name }}</strong></td>
                        <td class="text-left">
                            @if($template_snake_case->slug && $template_snake_case->slug != '')
                                <a target="_blank" href="{{ add_http($template_snake_case->slug) }}">{{ add_http($template_snake_case->slug) }}</a>
                            @endif
                        </td>
                        <td class="text-left">{!! str_limit(strip_tags($template_snake_case->content), 50) !!}</td>
                        <td class="text-center">{{ $template_snake_case->created_at->format('F d, Y') }}</td>
                        <td class="text-center">
                            <div class="btn-group btn-group-xs">
                                @if (auth()->user()->can('Read DefaultTemplate'))
                                    <a href="{{ route('admin.template_snake_case_plural.show', $template_snake_case->id) }}"
                                       data-toggle="tooltip"
                                       title=""
                                       class="btn btn-default"
                                       data-original-title="View"><i class="fa fa-eye"></i></a>
                                @endif
                                @if (auth()->user()->can('Update DefaultTemplate'))
                                    <a href="{{ route('admin.template_snake_case_plural.edit', $template_snake_case->id) }}"
                                       data-toggle="tooltip"
                                       title=""
                                       class="btn btn-default"
                                       data-original-title="Edit"><i class="fa fa-pencil"></i></a>
                                @endif
                                @if (auth()->user()->can('Delete DefaultTemplate'))
                                    <a href="javascript:void(0)" data-toggle="tooltip"
                                       title=""
                                       class="btn btn-xs btn-danger delete-template_snake_case-btn"
                                       data-original-title="Delete"
                                       data-template_snake_case-id="{{ $template_snake_case->id }}"
                                       data-template_snake_case-route="{{ route('admin.template_snake_case_plural.delete', $template_snake_case->id) }}">
                                        <i class="fa fa-times"></i>
                                    </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('extrascripts')
    <script type="text/javascript" src="{{ asset('public/js/libraries/template_snake_case_plural.js') }}"></script>
@endpush
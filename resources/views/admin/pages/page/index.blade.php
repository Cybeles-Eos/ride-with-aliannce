@extends('admin.layouts.base')

@section('content')
    @if (auth()->user()->can('Create Page'))
        <div class="row text-center">
            <div class="col-sm-12 col-lg-12">
                <a href="{{ route('admin.pages.create') }}" class="widget widget-hover-effect2">
                    <div class="widget-extra themed-background">
                        <h4 class="widget-content-light"><strong>Add New</strong> Page</h4>
                    </div>
                    <div class="widget-extra-full"><span class="h2 text-primary animation-expandOpen"><i
                                    class="fa fa-plus"></i></span></div>
                </a>
            </div>
        </div>
    @endif
    <div class="block full">
        <div class="block-title">
            <h2><i class="fa fa-archive sidebar-nav-icon"></i>&nbsp;<strong>Pages</strong></h2>
        </div>
        <div class="alert alert-info alert-dismissable page-empty {{$pages->count() == 0 ? '' : 'johnCena' }}">
            <i class="fa fa-info-circle"></i> No pages found.
        </div>
        <div class="table-responsive {{$pages->count() == 0 ? 'johnCena' : '' }}">
            <table id="pages-table"
                   class="table table-bordered table-striped table-vcenter">
                <thead>
                <tr role="row">
                    <th class="text-center">
                        ID
                    </th>
                    <th class="text-left">
                        Name
                    </th>
                    <th class="text-left">
                        Slug
                    </th>
                    {{--<th class="text-left">--}}
                    {{--Type--}}
                    {{--</th>--}}
                    <th class="text-center">
                        Action
                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach($pages as $page)
                    <tr data-page-template-id="{{$page->id}}">
                        <td class="text-center">{{ $page->id }}</td>
                        <td class="text-left">{{ $page->name }}</td>
                        <td class="text-left"><a href="{{ url($page->slug) }}" target="_blank">{{ url($page->slug) }}</a></td>
                        {{--<td class="text-left">{{ $page->page_type->name }}</td>--}}
                        <td class="text-center">
                            <div class="btn-group btn-group-xs">
                                @if (auth()->user()->can('Update Page'))
                                    <a href="{{ route('admin.pages.edit', $page->id) }}"
                                       data-toggle="tooltip"
                                       title=""
                                       class="btn btn-default"
                                       data-original-title="Edit"><i class="fa fa-pencil"></i></a>
                                @endif
                                @if (auth()->user()->can('Delete Page'))
                                    <a href="javascript:void(0)" data-toggle="tooltip"
                                       title=""
                                       class="btn btn-xs btn-danger delete-page-btn"
                                       data-original-title="Delete"
                                       data-page-id="{{ $page->id }}"
                                       data-page-route="{{ route('admin.pages.destroy', $page->id) }}">
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
<script type="text/javascript" src="{{ asset('public/js/libraries/pages.js') }}"></script>
@endpush
@extends('admin.layouts.base')

@section('content')
    @if (auth()->user()->can('Create Home Slide'))
        <div class="row text-center">
            <div class="col-sm-12 col-lg-12">
                <a href="{{ route('admin.home_slides.create') }}" class="widget widget-hover-effect2">
                    <div class="widget-extra themed-background">
                        <h4 class="widget-content-light">
                            <strong>Add New</strong>
                            Home Slide
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
                <i class="fa fa-sliders sidebar-nav-icon"></i>
                <strong>Home Slides</strong>
            </h2>
        </div>
        <div class="alert alert-info alert-dismissable home_slide-empty {{$home_slides->count() == 0 ? '' : 'johnCena' }}">
            <i class="fa fa-info-circle"></i> No Home Slides found.
        </div>
        <div class="table-responsive {{$home_slides->count() == 0 ? 'johnCena' : '' }}">
            <table id="home_slides-table" class="table table-bordered table-striped table-vcenter">
                <thead>
                <tr role="row">
                    <th class="text-center">
                        ID
                    </th>
                    <th class="text-center">
                        Background Image
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
                @foreach($home_slides as $home_slide)
                    <tr data-home_slide-id="{{$home_slide->id}}">
                        <td class="text-center"><strong>{{ $home_slide->id }}</strong></td>
                        <td class="text-center">
                            {{--<a href="{{ asset($home_slide->background_image) }}" class="zoom img-thumbnail" style="cursor: default !important;" data-toggle="lightbox-image">--}}
                            <img src="{{ asset($home_slide->background_image) }}" alt="{{ asset($home_slide->background_image) }}"
                                 class="img-responsive img-thumbnail center-block" style="max-width: 100px;">
                            {{--</a>--}}
                        </td>
                        <td class="text-left">{!! str_limit($home_slide->content, 50) !!}</td>
                        <td class="text-center">{{ $home_slide->created_at->format('F d, Y') }}</td>
                        <td class="text-center">
                            <div class="btn-group btn-group-xs">
                                @if (auth()->user()->can('Update Home Slide'))
                                    <a href="{{ route('admin.home_slides.edit', $home_slide->id) }}"
                                       data-toggle="tooltip"
                                       title=""
                                       class="btn btn-default"
                                       data-original-title="Edit"><i class="fa fa-pencil"></i></a>
                                @endif
                                @if (auth()->user()->can('Delete Home Slide'))
                                    <a href="javascript:void(0)" data-toggle="tooltip"
                                       title=""
                                       class="btn btn-xs btn-danger delete-home_slide-btn"
                                       data-original-title="Delete"
                                       data-home_slide-id="{{ $home_slide->id }}"
                                       data-home_slide-route="{{ route('admin.home_slides.delete', $home_slide->id) }}">
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
<script type="text/javascript" src="{{ asset('public/js/libraries/home_slides.js') }}"></script>
@endpush
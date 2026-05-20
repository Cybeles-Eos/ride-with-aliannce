@extends('admin.layouts.base')

@section('content')

        <div class="row text-center">
            <div class="col-sm-12 col-lg-12">
                <a href="{{ route('admin.faq_types.create') }}" class="widget widget-hover-effect2">
                    <div class="widget-extra themed-background">
                        <h4 class="widget-content-light">
                            <strong>Add New</strong>
                            FAQ Type
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

    <div class="block full">
        <div class="block-title">
            <h2>
                <i class="fa fa-newspaper-o sidebar-nav-icon"></i>
                <strong>FAQ Type's</strong>
            </h2>
        </div>
        <div class="alert alert-info alert-dismissable press-empty {{$faq_types->count() == 0 ? '' : 'johnCena' }}">
            <i class="fa fa-info-circle"></i> No FAQ's types found.
        </div>
        <div class="table-responsive {{$faq_types->count() == 0 ? 'johnCena' : '' }}">
            <table id="faqs-table" class="table table-bordered table-striped table-vcenter">
                <thead>
                <tr role="row">
                    <th class="text-center">
                        ID
                    </th>
                    <th class="text-left">
                        Name
                    </th>
                    <th class="text-center">
                        Action
                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach($faq_types as $faq_type)
                    <tr data-faq-type-id="{{$faq_type->FAQTypeID}}">
                        <td class="text-center"><strong>{{ $faq_type->FAQTypeID }}</strong></td>
                        <td class="text-center"><strong>{{ $faq_type->FAQTypeName }}</strong></td>
                        <td class="text-center">
                            <div class="btn-group btn-group-xs">

                                    <a href="{{ route('admin.faqs.index', $faq_type->FAQTypeID) }}"
                                       data-toggle="tooltip"
                                       title=""
                                       class="btn btn-default"
                                       data-original-title="FAQ's"><i class="fa fa-archive"></i></a>

                                    <a href="{{ route('admin.faq_types.show', $faq_type->FAQTypeID) }}"
                                       data-toggle="tooltip"
                                       title=""
                                       class="btn btn-default"
                                       data-original-title="View"><i class="fa fa-eye"></i></a>
                                    <a href="{{ route('admin.faq_types.edit', $faq_type->FAQTypeID) }}"
                                       data-toggle="tooltip"
                                       title=""
                                       class="btn btn-default"
                                       data-original-title="Edit"><i class="fa fa-pencil"></i></a>
                                    <a href="javascript:void(0)" data-toggle="tooltip"
                                       title=""
                                       class="btn btn-xs btn-danger delete-faq-type-btn"
                                       data-original-title="Delete"
                                       data-faq-type-id="{{ $faq_type->id }}"
                                       data-faq-type-route="{{ route('admin.faq_types.delete', $faq_type->FAQTypeID) }}">
                                        <i class="fa fa-times"></i>
                                    </a>

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
    <script type="text/javascript" src="{{ asset('public/js/libraries/faq_types.js') }}"></script>
@endpush
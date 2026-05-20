@extends('admin.layouts.base')

@section('content')
        <div class="row text-center">
            <div class="col-sm-12 col-lg-12">
               <a href="{{ route('admin.faqs.create',$id) }}" class="widget widget-hover-effect2">
                    <div class="widget-extra themed-background">
                        <h4 class="widget-content-light">
                            <strong>Add New</strong>
                            FAQ
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
                <strong>FAQ's</strong>
            </h2>
        </div>
        <div class="alert alert-info alert-dismissable press-empty {{$faqs->count() == 0 ? '' : 'johnCena' }}">
            <i class="fa fa-info-circle"></i> No FAQ's found.
        </div>
        <div class="table-responsive {{$faqs->count() == 0 ? 'johnCena' : '' }}">
            <table id="faqs-table" class="table table-bordered table-striped table-vcenter">
                <thead>
                <tr role="row">
                    <th class="text-center">
                        ID
                    </th>
                    <th class="text-left">
                        Question
                    </th>
                    <th class="text-left">
                        Answer
                    </th>
                    <th class="text-center">
                        Action
                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach($faqs as $faq)
                    <tr data-faq-id="{{$faq->id}}">
                        <td class="text-center"><strong>{{ $faq->FAQID }}</strong></td>
                        <td class="text-center"><strong>{{ $faq->FAQQuestion }}</strong></td>
                        <td class="text-center">{{ $faq->FAQAnswer }}</td>
                        <td class="text-center">
                            <div class="btn-group btn-group-xs">
                                   <a href="{{ route('admin.faqs.show', $faq->FAQID) }}"
                                       data-toggle="tooltip"
                                       title=""
                                       class="btn btn-default"
                                       data-original-title="View"><i class="fa fa-eye"></i></a>
                                <a href="{{ route('admin.faqs.edit', $faq->FAQID) }}"
                                       data-toggle="tooltip"
                                       title=""
                                       class="btn btn-default"
                                       data-original-title="Edit"><i class="fa fa-pencil"></i></a>
                                    <a href="javascript:void(0)" data-toggle="tooltip"
                                       title=""
                                       class="btn btn-xs btn-danger delete-faq-btn"
                                       data-original-title="Delete"
                                       data-faq-id="{{ $faq->id }}"
                                       data-faq-route="{{ route('admin.faqs.delete', $faq->FAQID) }}">
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
    <script type="text/javascript" src="{{ asset('public/js/libraries/faqs.js') }}"></script>
@endpush
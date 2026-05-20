@extends('admin.layouts.base')

@section('content')

       {{-- <div class="row text-center">
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
        </div>--}}

    <div class="block full">
        <div class="block-title">
            <h2>
                <i class="fa fa-newspaper-o sidebar-nav-icon"></i>
                <strong>Locations</strong>
            </h2>
        </div>
        <div class="alert alert-info alert-dismissable press-empty {{$locations->count() == 0 ? '' : 'johnCena' }}">
            <i class="fa fa-info-circle"></i> No locations found.
        </div>
        <div class="table-responsive {{$locations->count() == 0 ? 'johnCena' : '' }}">
            <table id="locations-table" class="table table-bordered table-striped table-vcenter">
                <thead>
                <tr role="row">
                    <th class="text-center">
                        ID
                    </th>
                    <th class="text-left">
                        Name
                    </th>
                    <th class="text-left">
                        City
                    </th>
                    <th class="text-left">
                        State
                    </th>
                    <th class="text-left">
                        ZIP
                    </th>
                    <th class="text-left">
                        Country
                    </th>
                    <th class="text-left">
                        Enabled
                    </th>
                    <th class="text-center">
                        Action
                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach($locations as $item)
                    <tr data-faq-type-id="{{$item->LocationID}}">
                        <td class="text-center">{{ $item->LocationID }}</td>
                        <td class="text-center"><strong>{{ $item->LocationDisplayName }}</strong></td>
                        <td class="text-center">{{ $item->LocationCity }}</td>
                        <td class="text-center">{{ $item->LocationState }}</td>
                        <td class="text-center">{{ $item->LocationZip }}</td>
                        <td class="text-center">{{ $item->LocationCountry }}</td>
                        <td class="text-center"><strong>{{ ($item->LocationEnabled == 1) ? 'Yes' : 'No'}}</strong></td>
                        <td class="text-center">
                            <div class="btn-group btn-group-xs">
                                <a href="{{ route('admin.events.index', $item->LocationID) }}"
                                   data-toggle="tooltip"
                                   title=""
                                   class="btn btn-default"
                                   data-original-title="Events"><i class="fa fa-archive"></i></a>
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
    <script type="text/javascript" src="{{ asset('public/js/libraries/locations.js') }}"></script>
@endpush
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
                <strong>Programs</strong>
            </h2>
        </div>
        <div class="alert alert-info alert-dismissable press-empty {{$programs->count() == 0 ? '' : 'johnCena' }}">
            <i class="fa fa-info-circle"></i> No programs found.
        </div>
        <div class="table-responsive {{$programs->count() == 0 ? 'johnCena' : '' }}">
            <table id="events-table" class="table table-bordered table-striped table-vcenter">
                <thead>
                <tr role="row">
                    <th class="text-center">
                        ID
                    </th>
                    <th class="text-left">
                        Name
                    </th>
                    <th class="text-left">
                        Type
                    </th>
                    <th class="text-left">
                        Prices
                    </th>
                    <th class="text-left">
                        Enabled
                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach($programs as $item)
                    <tr data-faq-type-id="{{$item->ProgramID}}">
                        <td class="text-center">{{ $item->ProgramID }}</td>
                        <td class="text-center"><strong>{{ $item->ProgramDisplayName }}</strong></td>
                        <td class="text-center">{{ $item->program_type->ProgramTypeDisplayName }}</td>
                        <td class="text-center">
                            <span>{{ date('F d, Y', strtotime($item->program_price->ProgramPriceStartDate1)).' to '. date('F d, Y', strtotime($item->program_price->ProgramPriceEndDate1)) }}</span> - <span>$<strong>{{$item->program_price->ProgramPrice1}}</strong></span>
                            </br>
                            <span>{{ date('F d, Y', strtotime($item->program_price->ProgramPriceStartDate2)).' to '. date('F d, Y', strtotime($item->program_price->ProgramPriceEndDate2)) }}</span> - <span>$<strong>{{$item->program_price->ProgramPrice1}}</strong></span>
                            </br>
                            <span>{{ date('F d, Y', strtotime($item->program_price->ProgramPriceStartDate3)).' to '. date('F d, Y', strtotime($item->program_price->ProgramPriceEndDate3)) }}</span> - <span>$<strong>{{$item->program_price->ProgramPrice1}}</strong></span>
                            </br>
                            <span>{{ date('F d, Y', strtotime($item->program_price->ProgramPriceStartDate4)).' to '. date('F d, Y', strtotime($item->program_price->ProgramPriceEndDate4)) }}</span> - <span>$<strong>{{$item->program_price->ProgramPrice1}}</strong></span>
                            </br>
                            <span>{{ date('F d, Y', strtotime($item->program_price->ProgramPriceStartDate5)).' to '. date('F d, Y', strtotime($item->program_price->ProgramPriceEndDate5)) }}</span> - <span>$<strong>{{$item->program_price->ProgramPrice1}}</strong></span>
                        </td>
                        <td class="text-center"><strong>{{ ($item->ProgramEnabled == 1) ? 'Yes' : 'No'}}</strong></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('extrascripts')
    <script type="text/javascript" src="{{ asset('public/js/libraries/events.js') }}"></script>
@endpush
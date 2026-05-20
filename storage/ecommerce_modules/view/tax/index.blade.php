@extends('admin.layouts.base')

@section('content')
    <div class="block full">
        <div class="block-title">
            <h2>
                <i class="fa fa-percent sidebar-nav-icon"></i>
                <strong>Taxes</strong>
            </h2>
        </div>
        <div class="alert alert-info alert-dismissable tax-empty {{$states->count() == 0 ? '' : 'johnCena' }}">
            <i class="fa fa-info-circle"></i> No States found.
        </div>
        <div class="table-responsive {{$states->count() == 0 ? 'johnCena' : '' }}">
            <table id="taxes-table" class="table table-bordered table-striped table-vcenter">
                <thead>
                <tr role="row">
                    <th class="text-left">
                        State
                    </th>
                    <th class="text-left">
                        Country
                    </th>
                    <th class="text-left">
                        Tax
                    </th>
                    <th class="text-center">
                        Action
                    </th>
                </tr>
                </thead>
                <tbody>
                {{--@foreach($states as $state)--}}
                    {{--<tr data-tax-id="{{$state->id}}">--}}
                        {{--<td class="text-left">{{ $state->name }}</td>--}}
                        {{--<td class="text-left">{{ !empty($state->country) ? $state->country->name : '' }}</td>--}}
                        {{--<td class="text-left">{{ $state->tax }}</td>--}}
                        {{--<td class="text-center">--}}
                            {{--<div class="btn-group btn-group-xs">--}}
                                {{--@if (auth()->user()->can('Update Tax'))--}}
                                    {{--<a href="{{ route('admin.taxes.edit', $state->id) }}"--}}
                                       {{--data-toggle="tooltip"--}}
                                       {{--title=""--}}
                                       {{--class="btn btn-default"--}}
                                       {{--data-original-title="Edit"><i class="fa fa-pencil"></i></a>--}}
                                {{--@endif--}}
                            {{--</div>--}}
                        {{--</td>--}}
                    {{--</tr>--}}
                {{--@endforeach--}}
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('extrascripts')
<script>
    var oCountries = {!! $countries !!}
</script>
    <script type="text/javascript" src="{{ asset('public/js/libraries/taxes.js') }}"></script>
@endpush
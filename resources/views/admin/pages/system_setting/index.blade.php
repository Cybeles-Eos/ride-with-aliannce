@extends('admin.layouts.base')

@section('content')
    @if (auth()->user()->can('Create System Setting'))
        <div class="row text-center">
            <div class="col-sm-12 col-lg-12">
                <a href="{{ route('admin.system_settings.create') }}" class="widget widget-hover-effect2">
                    <div class="widget-extra themed-background">
                        <h4 class="widget-content-light"><strong>Add New</strong> System Setting</h4>
                    </div>
                    <div class="widget-extra-full"><span class="h2 text-primary animation-expandOpen"><i
                                    class="fa fa-plus"></i></span></div>
                </a>
            </div>
        </div>
    @endif
    <div class="block full">
        <div class="block-title">
            <h2><i class="fa fa-gears sidebar-nav-icon"></i>&nbsp;<strong>System Settings</strong></h2>
        </div>
        <div class="alert alert-info alert-dismissable system-setting-empty {{$system_settings->count() == 0 ? '' : 'johnCena' }}">
            <i class="fa fa-info-circle"></i> No system settings found.
        </div>
        <div class="table-responsive {{$system_settings->count() == 0 ? 'johnCena' : '' }}">
            <table id="system-settings-table"
                   class="table table-bordered table-striped table-vcenter">
                <thead>
                <tr role="row">
                    <th class="text-center">
                        Code
                    </th>
                    <th class="text-left">
                        Name
                    </th>
                    <th class="text-center hidden-xs">
                        Value
                    </th>
                    <th class="text-center">
                        Action
                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach($system_settings as $system_setting)
                    <tr data-system-setting-template-id="{{$system_setting->id}}">
                        <td class="text-center"><strong>{{ $system_setting->code }}</strong></td>
                        <td class="text-left">{{ $system_setting->name }}</td>
                        <td class="text-center hidden-xs">{{ str_limit(strip_tags($system_setting->value), 100) }}</td>
                        <td class="text-center">
                            <div class="btn-group btn-group-xs">
                                @if (auth()->user()->can('Update System Setting'))
                                    <a href="{{ route('admin.system_settings.edit', $system_setting->id) }}"
                                       data-toggle="tooltip"
                                       title=""
                                       class="btn btn-default"
                                       data-original-title="Edit"><i class="fa fa-pencil"></i></a>
                                @endif
                                @if (auth()->user()->can('Delete System Setting'))
                                    <a href="javascript:void(0)" data-toggle="tooltip"
                                       title=""
                                       class="btn btn-xs btn-danger delete-system-setting-btn"
                                       data-original-title="Delete"
                                       data-system-setting-id="{{ $system_setting->id }}"
                                       data-system-setting-route="{{ route('admin.system_settings.delete', $system_setting->id) }}">
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
    <script type="text/javascript" src="{{ asset('public/js/libraries/system_settings.js') }}"></script>
@endpush
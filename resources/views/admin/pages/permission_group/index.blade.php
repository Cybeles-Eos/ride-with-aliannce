@extends('admin.layouts.base')

@section('content')
    @if (auth()->user()->can('Create Permission Group'))
        <div class="row text-center">
            <div class="col-sm-12 col-lg-12">
                <a href="{{ route('admin.permission_groups.create') }}" class="widget widget-hover-effect2">
                    <div class="widget-extra themed-background">
                        <h4 class="widget-content-light"><strong>Add New</strong> Permission Group</h4>
                    </div>
                    <div class="widget-extra-full"><span class="h2 text-primary animation-expandOpen"><i
                                    class="fa fa-plus"></i></span></div>
                </a>
            </div>
        </div>
    @endif
    <div class="block full">
        <div class="block-title">
            <h2><i class="fa fa-users sidebar-nav-icon"></i>&nbsp;<strong>Permission Groups</strong></h2>
        </div>
        <div class="alert alert-info alert-dismissable permission-group-empty {{$permission_groups->count() == 0 ? '' : 'johnCena' }}">
            <i class="fa fa-info-circle"></i> No permission groups found.
        </div>
        <div class="table-responsive {{$permission_groups->count() == 0 ? 'johnCena' : '' }}">
            <table id="permission-groups-table"
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
                        Permissions
                    </th>
                    <th class="text-center">
                        Action
                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach($permission_groups as $permission_group)
                    <tr data-permission-group-template-id="{{$permission_group->id}}">
                        <td class="text-center"><strong>{{ $permission_group->id }}</strong></td>
                        <td class="text-left">{{ $permission_group->name }}</td>
                        <td class="text-left">{{ $permission_group->permissions->pluck('name')->implode(', ') }}</td>
                        <td class="text-center">
                            <div class="btn-group btn-group-xs">
                                @if (auth()->user()->can('Update Permission Group'))
                                    <a href="{{ route('admin.permission_groups.edit', $permission_group->id) }}"
                                       data-toggle="tooltip"
                                       title=""
                                       class="btn btn-default"
                                       data-original-title="Edit"><i class="fa fa-pencil"></i></a>
                                @endif
                                @if (auth()->user()->can('Delete Permission Group'))
                                    <a href="javascript:void(0)" data-toggle="tooltip"
                                       title=""
                                       class="btn btn-xs btn-danger delete-permission-group-btn"
                                       data-original-title="Delete"
                                       data-permission-group-id="{{ $permission_group->id }}"
                                       data-permission-group-route="{{ route('admin.permission_groups.delete', $permission_group->id) }}">
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
    <script type="text/javascript" src="{{ asset('public/js/libraries/permission_groups.js') }}"></script>
@endpush
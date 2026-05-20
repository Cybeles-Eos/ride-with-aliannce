@extends('admin.layouts.base')

@section('content')
    @if (auth()->user()->can('Create User'))
        <div class="row text-center">
            <div class="col-sm-12 col-lg-12">
                <a href="{{ route('admin.users.create') }}" class="widget widget-hover-effect2">
                    <div class="widget-extra themed-background">
                        <h4 class="widget-content-light"><strong>Add New</strong> User</h4>
                    </div>
                    <div class="widget-extra-full"><span class="h2 text-primary animation-expandOpen"><i
                                    class="fa fa-plus"></i></span></div>
                </a>
            </div>
        </div>
    @endif
    <div class="block full">
        <div class="block-title">
            <h2><i class="fa fa-users sidebar-nav-icon"></i>&nbsp;<strong>Users</strong></h2>
        </div>
        <div class="alert alert-info alert-dismissable user-empty {{$users->count() == 0 ? '' : 'johnCena' }}">
            <i class="fa fa-info-circle"></i> No users found.
        </div>
        <div class="table-responsive {{$users->count() == 0 ? 'johnCena' : '' }}">
            <table id="users-table"
                   class="table table-bordered table-striped table-vcenter">
                <thead>
                <tr role="row">
                    <th class="text-left">
                        Name
                    </th>
                    <th class="text-left">
                        Username
                    </th>
                    <th class="text-left">
                        Email
                    </th>
                    <th class="text-left">
                        User Roles
                    </th>
                    <th class="text-center">
                        Action
                    </th>
                </tr>
                </thead>
                <tbody>
                <!--
                @foreach($users as $user)
                    <tr data-user-template-id="{{$user->id}}">
                        <td class="text-left"><strong>{{ $user->first_name.' '.$user->last_name }}</strong></td>
                        <td class="text-left">{{ $user->user_name    }}</td>
                        <td class="text-left">{{ $user->email }}</td>
                        <td class="text-left">{{ $user->roles()->pluck('name')->implode(', ') }}</td>
                        <td class="text-center">
                            <div class="btn-group btn-group-xs">
                                @if (auth()->user()->can('Read User'))
                                    <a href="{{ route('admin.users.show', $user->id) }}"
                                       data-toggle="tooltip"
                                       title=""
                                       class="btn btn-default"
                                       data-original-title="View"><i class="fa fa-eye"></i></a>
                                @endif
                                @if (auth()->user()->can('Update User'))
                                    <a href="{{ route('admin.users.edit', $user->id) }}"
                                       data-toggle="tooltip"
                                       title=""
                                       class="btn btn-default"
                                       data-original-title="Edit"><i class="fa fa-pencil"></i></a>
                                @endif
                                @if (auth()->user()->can('Delete User'))
                                    <a href="javascript:void(0)" data-toggle="tooltip"
                                       title=""
                                       class="btn btn-xs btn-danger delete-user-btn"
                                       data-original-title="Delete"
                                       data-user-id="{{ $user->id }}"
                                       data-user-route="{{ route('admin.users.delete', $user->id) }}">
                                        <i class="fa fa-times"></i>
                                    </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
                -->
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('extrascripts')
    <script type="text/javascript" src="{{ asset('public/js/libraries/users.js') }}"></script>
@endpush
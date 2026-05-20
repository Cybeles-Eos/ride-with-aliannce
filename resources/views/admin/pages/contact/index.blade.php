@extends('admin.layouts.base')

@section('content')
    <div class="block full">
        <div class="block-title">
            <h2>
                <i class="fa fa-phone sidebar-nav-icon"></i>
                <strong>Contacts</strong>
            </h2>
        </div>
        <div class="alert alert-info alert-dismissable contact-empty {{$contacts->count() == 0 ? '' : 'johnCena' }}">
            <i class="fa fa-info-circle"></i> No Contacts found.
        </div>
        <div class="table-responsive {{$contacts->count() == 0 ? 'johnCena' : '' }}">
            <table id="contacts-table" class="table table-bordered table-striped table-vcenter">
                <thead>
                <tr role="row">
                    <th class="text-center">
                        ID
                    </th>
                    <th class="text-center">
                        Name
                    </th>
                    <th class="text-left">
                        Email
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
                @foreach($contacts as $contact)
                    <tr data-contact-id="{{$contact->id}}">
                        <td class="text-center"><strong>{{ $contact->id }}</strong></td>
                        <td class="text-center"><strong>{{ $contact->name }}</strong></td>
                        <td class="text-center"><strong>{{ $contact->email }}</strong></td>
                        <td class="text-center">{{ $contact->created_at->format('F d, Y') }}</td>
                        <td class="text-center">
                            <div class="btn-group btn-group-xs">
                                @if (auth()->user()->can('Read Contact'))
                                    <a href="{{ route('admin.contacts.show', $contact->id) }}"
                                       data-toggle="tooltip"
                                       title=""
                                       class="btn btn-default"
                                       data-original-title="View"><i class="fa fa-eye"></i></a>
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
    <script type="text/javascript" src="{{ asset('public/js/libraries/contacts.js') }}"></script>
@endpush
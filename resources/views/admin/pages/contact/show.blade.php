@extends('admin.layouts.base')

@section('content')
    <ul class="breadcrumb breadcrumb-top">
        <li><a href="{{ route('admin.contacts.index') }}">Contacts</a></li>
        <li><span href="javascript:void(0)">View Contact</span></li>
    </ul>
    <div class="row">
        <div class="col-lg-12">
            <div class="block">
                <div class="block-title">
                    <h2><i class="fa fa-phone"></i> <strong>Contact</strong> Info</h2>
                </div>
                <table class="table table-borderless table-striped table-vcenter">
                    <tbody>
                    <tr>
                        <td style="width: 30%" class="text-right"><strong>Date</strong></td>
                        <td style="width: 70%">{{ $contact->created_at->format('F d, Y h:i:s A') }}</td>
                    </tr>
                    <tr>
                        <td style="width: 30%" class="text-right"><strong>Name</strong></td>
                        <td style="width: 70%">{{ $contact->name }}</td>
                    </tr>

                    <tr>
                        <td style="width: 30%" class="text-right"><strong>Subject</strong></td>
                        <td style="width: 70%">{{ $contact->subject }}</td>
                    </tr>
                    <tr>
                        <td style="width: 30%" class="text-right"><strong>Email</strong></td>
                        <td style="width: 70%">{{ $contact->email }}</td>
                    </tr>
                    {{--<tr>--}}
                        {{--<td style="width: 30%" class="text-right"><strong>Company</strong></td>--}}
                        {{--<td style="width: 70%">{{ $contact->company }}</td>--}}
                    {{--</tr>--}}
                    {{--<tr>--}}
                        {{--<td style="width: 30%" class="text-right"><strong>Phone</strong></td>--}}
                        {{--<td style="width: 70%">{{ $contact->phone }}</td>--}}
                    {{--</tr>--}}
                    <tr>
                        <td style="width: 30%" class="text-right"><strong>Message</strong></td>
                        <td style="width: 70%">{!! $contact->message !!}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('extrascripts')
    <script type="text/javascript" src="{{ asset('public/js/libraries/contacts.js') }}"></script>
@endpush
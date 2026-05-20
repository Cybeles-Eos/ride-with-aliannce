@extends('admin.layouts.base')

@section('content')
    <ul class="breadcrumb breadcrumb-top">
        <li><a href="{{ route('admin.faqs.index', $faq->FAQTypeID) }}">FAQ's</a></li>
        <li><span href="javascript:void(0)">Edit FAQ</span></li>
    </ul>
    <div class="row">
        {{  Form::open([
            'method' => 'PUT',
            'id' => 'edit-press',
            'route' => ['admin.faqs.update', $faq->FAQID],
            'class' => 'form-horizontal ',
            'files' => TRUE
            ])
        }}
        <div class="col-md-12">
            <div class="block">
                <div class="block-title">
                    <h2><i class="fa fa-pencil"></i> <strong>Edit FAQ "{{$faq->FAQQuestion}}"</strong></h2>
                </div>

                <div class="form-group{{ $errors->has('FAQQuestion') ? ' has-error' : '' }}">
                    <label class="col-md-3 control-label" for="FAQQuestion">Question</label>

                    <div class="col-md-9">
                    <textarea id="news_content" name="FAQQuestion" rows="9" class="form-control"
                              placeholder="Enter FAQ question..">{!! Request::old('FAQQuestion') ? : $faq->FAQQuestion !!}</textarea>
                        @if($errors->has('FAQQuestion'))
                            <span class="help-block animation-slideDown">{{ $errors->first('FAQQuestion') }}</span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('FAQAnswer') ? ' has-error' : '' }}">
                    <label class="col-md-3 control-label" for="FAQAnswer">Answer</label>

                    <div class="col-md-9">
                    <textarea id="news_content" name="FAQAnswer" rows="9" class="form-control"
                              placeholder="Enter FAQ answer..">{!! Request::old('FAQAnswer') ? : $faq->FAQAnswer !!}</textarea>
                        @if($errors->has('FAQAnswer'))
                            <span class="help-block animation-slideDown">{{ $errors->first('FAQAnswer') }}</span>
                        @endif
                    </div>
                </div>


                <div class="form-group{{ $errors->has('FAQVideoTag') ? ' has-error' : '' }}">
                    <label class="col-md-3 control-label" for="FAQVideoTag">Video Tag</label>

                    <div class="col-md-9">
                        <input type="text" class="form-control" id="FAQVideoTag" name="FAQVideoTag"
                               value="{{  Request::old('FAQVideoTag') ? : $faq->FAQVideoTag }}"
                               placeholder="Enter Faq video tag..">
                        @if($errors->has('FAQVideoTag'))
                            <span class="help-block animation-slideDown">{{ $errors->first('FAQVideoTag') }}</span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">Is Enabled?</label>

                    <div class="col-md-9">
                        <label class="switch switch-primary">
                            <input type="checkbox" id="FAQEnabled" name="FAQEnabled"
                                   value="1" {{ Request::old('FAQEnabled') ? : ($faq->FAQEnabled ? 'checked' : '') }}>
                            <span></span>
                        </label>
                    </div>
                </div>

                <div class="form-group form-actions">
                    <div class="col-md-9 col-md-offset-3">
                        <a href="{{ route('admin.faqs.index', $faq->FAQTypeID) }}" class="btn btn-sm btn-warning">Cancel</a>
                        <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-floppy-o"></i> Save
                        </button>
                    </div>
                </div>
            </div>
        </div>
        {{ Form::close() }}
    </div>
@endsection

@push('extrascripts')
    <script type="text/javascript" src="{{ asset('public/js/ckeditor/ckeditor.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/js/libraries/faqs.js') }}"></script>
@endpush
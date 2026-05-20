@extends('admin.layouts.base')

@section('content')
    <ul class="breadcrumb breadcrumb-top">
        <li><a href="{{ route('admin.pages.index') }}">Pages</a></li>
        <li><span href="javascript:void(0)">Edit Page</span></li>
    </ul>
    <div class="row">
        {{  Form::open([
            'method' => 'PUT',
            'id' => 'edit-page',
            'route' => ['admin.pages.update', $page->id],
            'class' => 'form-horizontal ',
            'files' => TRUE,
            ])
        }}
        <div class="col-md-12">
            <div class="block">
                <div class="block-title">
                    <h2><i class="fa fa-pencil"></i> <strong>Edit Page "{{$page->name}}"</strong></h2>
                </div>
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <h4 style="border-left: 3px solid #61dbd5; padding-left: 8px; margin-bottom: 20px;">Page Details</h4>
                    </div>
                </div>
                <div id="section-page" style="margin-bottom: 50px;">
                    @include('admin.components.text', ['field' => 'name', 'label' => 'Name', 'value' => Request::old('name') ?: $page->name])
                    @include('admin.components.text', ['field' => 'slug', 'label' => 'Slug', 'value' => Request::old('slug') ?: $page->slug])

                    @if($page->id != 1)
                        @include('admin.components.attachment', ['field' => 'banner_image', 'label' => 'Banner Image', 'value' => $page->attachment])
                    @endif

                    @if($page->content != '---')
                        @include('admin.components.editor', ['field' => 'content', 'label' => 'Content', 'value' => $page->content])
                    @else
                        <input type="hidden" name="content" value="{{ $page->content }}">
                    @endif

                    <div class="row">
                        <div class="col-md-8 col-md-offset-2">
                            <div class="form-group">
                                <label class="col-md-2 control-label">Is Active?</label>

                                <div class="col-md-10">
                                    <label class="switch switch-primary">
                                        <input type="checkbox" id="is_active" name="is_active"
                                               value="1" {{ Request::old('is_active') ? : ($page->is_active ? 'checked' : '') }}>
                                        <span></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @include('admin.pages.page.page_sections')

                <div class="form-group form-actions">
                    <div class="col-md-9 col-md-offset-3">
                        <a href="{{ route('admin.pages.index') }}" class="btn btn-sm btn-warning">Cancel</a>
                        <button id="btnSave" type="submit" class="btn btn-sm btn-primary"><i class="fa fa-floppy-o"></i> Save</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            @include('admin.pages.page.meta_fields',['seo_meta_fields'=>$page->seoMeta])
        </div>
        {{ Form::close() }}
    </div>
@endsection

@push('extrascripts')
<script type="text/javascript" src="{{ asset('public/js/ckeditor/ckeditor.js') }}"></script>
<script type="text/javascript" src="{{ asset('public/js/libraries/pages.js') }}"></script>
<script>
    $('input[type=file].async').each(function (i, el) {
        var $self = $(this);
        $(el).on('change', function (e) {
            if (e.target.files.length === 0)
                return;

            var formData = new FormData();
            formData.append('image', e.target.files[0]);
            formData.append('_token', '{{ csrf_token() }}');

            $.ajax({
                type: 'POST',
                url: '{{ route('admin.upload') }}',
                data: formData,
                contentType: false,
                cache: false,
                processData: false,
                success: function (response) {
                    if (response.status) {
                        $self.siblings('input[type=hidden].fld').val(response.data.id);
                    }
                }
            });
        });
    });

    var sections = {!! json_encode($page->sections) !!}.map(function (section) {
        if (section.type === 3)
            section.value = JSON.parse(section.value);
        return section;
    });

    $('#btnSave').on('click', function (e) {
        e.preventDefault();
        
        console.log('=== FORM SUBMISSION STARTED ===');
        
        // Log all section template inputs before submission
        var sectionInputs = {};
        $('input[name^="section_"], textarea[name^="section_"]').each(function() {
            var name = $(this).attr('name');
            var value = $(this).val();
            sectionInputs[name] = value;
            console.log('Section input:', name, '=', value, 'Type:', $(this).attr('type'));
        });
        
        console.log('All section template inputs:', sectionInputs);
        console.log('Total section inputs found:', Object.keys(sectionInputs).length);

        sections.filter(function (section) {
            return section.type === 3;
        }).forEach(function (section) {
            section.value.data = $(`#section-${section.id}`).children('.form-field').map(function (i, el) {
                return $(el).find('.form-group').toArray().reduce(function (item, fg) {
                    var field = $(fg).find('input.fld');

                    if (field.length > 0) {
                        item[$(field).data('name')] = $(field).val();
                    } else if (field.length === 0) {
                        field = $(fg).find('textarea.fld');

                        if (field.length > 0) {
                            var editor = CKEDITOR.instances[field.attr('id')];

                            if (editor) {
                                item[$(field).data('name')] = editor.getData();
                            } else {
                                item[$(field).data('name')] = $(field).val();
                            }
                        }
                    }

                    return item;
                }, {});
            }).toArray();
            $(`input[name=${section.alias}]`).val(JSON.stringify(section.value));
        });
        
        console.log('=== SUBMITTING FORM NOW ===');

        $('form#edit-page').submit();
    });
</script>
@endpush
<?php

namespace App\Http\Controllers;

use App\Http\Traits\SystemSettingTrait;
use App\Models\Attachment;
use App\Models\Page;
use App\Models\PageSection;
use App\Models\PageType;
use App\Models\SectionTemplate;
use App\Repositories\PageRepository;
use App\Repositories\SeoMetaRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Str;

/**
 * Class PageController
 * @package App\Http\Controllers
 */
class PageController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Pages Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles pages in front end and page module in admin.
    |
    */

    use SystemSettingTrait;

    /*
    |--------------------------------------------------------------------------
    | Front
    |--------------------------------------------------------------------------
    */

    /**
     * Create a new controller instance.
     *
     * @param Page $page_model
     * @param PageType $page_type_model
     * @param SeoMetaRepository $seo_meta_repository
     * @param PageRepository $page_repository
     * @param PageSection $page_section_model
     */
    public function __construct(Page $page_model,
                                PageType $page_type_model,
                                SeoMetaRepository $seo_meta_repository,
                                PageRepository $page_repository,
                                PageSection $page_section_model

    )
    {
        /*
         * Model namespace
         * using $this->role_model can also access $this->role_model->where('id', 1)->get();
         * */
        $this->page_model = $page_model;
        $this->page_type_model = $page_type_model;
        $this->page_section_model = $page_section_model;

        /*
         * Repository namespace
         * this class may include methods that can be used by other controllers, like getting of posts with other data (related tables).
         * */
        $this->seo_meta_repository = $seo_meta_repository;
        $this->page_repository = $page_repository;
    }

    /**
     * Show the application home page.
     *
     * @return \Illuminate\Http\Response
     */
    public function home()
    {
        return view('front.pages.home');
    }

    /**
     * Display the specified resource.
     *
     * @param  string $slug
     * @param  string $product_slug
     *
     * @return \Illuminate\Http\Response
     */
    public function showPages($slug = '')
    {
        $page = $category = $product = $categories = $section_services = [];

        if ($slug == '') {
            /* home */
            $page = $this->page_repository->getActivePageBySlug('home');
            if (empty($page)) {
                return view('front.pages.home');
            } else {
                $seo_meta = $this->getSeoMeta($page);
            }
        } else {
            $page = $this->page_repository->getActivePageBySlug($slug);

            /* if not in pages */
            if (empty($page)) {
                abort('404', '404');
            } else {
                $seo_meta = $this->getSeoMeta($page);
            }
        }

        return view('front.pages.custom-pages-index', compact('page', 'seo_meta'));
    }

    /*
    |--------------------------------------------------------------------------
    | Admin
    |--------------------------------------------------------------------------
    */
    /**
     * Show the application pages.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!auth()->user()->hasPermissionTo('Read Page')) {
            abort('401', '401');
        }

        $pages = $this->page_model->get();

        return view('admin.pages.page.index', compact('pages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!auth()->user()->hasPermissionTo('Create Page')) {
            abort('401', '401');
        }

        $page_types = $this->page_type_model->get();

        return view('admin.pages.page.create', compact('page_types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!auth()->user()->hasPermissionTo('Create Page')) {
            abort('401', '401');
        }

        $this->validate($request, [
            'name' => 'required|unique:pages',
            'slug' => 'required|unique:pages',
            'banner_image' => 'mimes:jpg,jpeg,png',
        ]);

        $input = $request->all();
        $input['is_active'] = isset($input['is_active']) ? 1 : 0;
        /* if slug is hidden, generate slug automatically */
//        $input['slug'] = str_slug($input['name']);

        /* seo meta */
        $input['seo_meta_id'] = isset($input['seo_meta_id']) ? $input['seo_meta_id'] : 0;
        $seo_inputs = $request->only(['meta_title', 'meta_keywords', 'meta_description', 'seo_meta_id']);
        $seo_meta = $this->seo_meta_repository->updateOrCreate($seo_inputs);
        $input['seo_meta_id'] = $seo_meta->id;
        /* seo meta */

        $page = $this->page_model->create($input);

        if ($request->hasFile('banner_image'))
            $page->attach($request->file('banner_image'));

        return redirect()->route('admin.pages.index')
            ->with('flash_message', [
                'title' => '',
                'message' => 'Page ' . $page->title . ' successfully added.',
                'type' => 'success'
            ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!auth()->user()->hasPermissionTo('Update Page')) {
            abort('401', '401');
        }

        $page = $this->page_model->findOrFail($id);
        $page_types = $this->page_type_model->get();
        
        // Get available section templates
        $availableTemplates = SectionTemplate::where('is_active', true)
            ->orderBy('category')
            ->orderBy('name')
            ->get();

        return view('admin.pages.page.edit', compact('page', 'page_types', 'availableTemplates'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (!auth()->user()->hasPermissionTo('Update Page')) {
            abort('401', '401');
        }

        $this->validate($request, [
            'name' => 'required|unique:pages,name,' . $id,
            'slug' => 'required|unique:pages,slug,' . $id,
        ]);

        $page = $this->page_model->findOrFail($id);
        $input = $request->all();
        $input['is_active'] = isset($input['is_active']) ? 1 : 0;
        /* if slug is hidden, generate slug automatically */
//        $input['slug'] = str_slug($input['name']);

        /* seo meta */
        $input['seo_meta_id'] = isset($input['seo_meta_id']) ? $input['seo_meta_id'] : 0;
        $seo_inputs = $request->only(['meta_title', 'meta_keywords', 'meta_description', 'seo_meta_id']);
        $seo_meta = $this->seo_meta_repository->updateOrCreate($seo_inputs);
        $input['seo_meta_id'] = $seo_meta->id;
        /* seo meta */

        if ($request->hasFile('banner_image'))
            $page->attach($request->file('banner_image'));

        $page->fill($input)->save();

        // Handle legacy sections
        foreach ($page->sections as $section) {
            if ($section->isAttachment) {
                $page->attach($request->file($section->alias));
            } else {
                $section->value = $request->input($section->alias);
                $section->save();
            }
        }
        
        // Handle new section template fields
        $this->processSectionTemplateFields($request, $page);

        return redirect()->route('admin.pages.index')
            ->with('flash_message', [
                'title' => '',
                'message' => 'Page ' . $page->title . ' successfully updated.',
                'type' => 'success'
            ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!auth()->user()->hasPermissionTo('Delete Page')) {
            abort('401', '401');
        }

        $page = $this->page_model->findOrFail($id);
        $page->delete();

        $response = array(
            'status' => FALSE,
            'data' => array(),
            'message' => array(),
        );

        $response['message'][] = 'Page successfully deleted.';
        $response['data']['id'] = $id;
        $response['status'] = TRUE;

        return json_encode($response);
    }

    public function upload(Request $request)
    {
        if (!$request->hasFile('image'))
            return response()->json([
                'status' => false,
                'message' => 'No file provided',
                'data' => []
            ]);

        $file = $request->file('image');

        $attachment = new Attachment();
        $attachment->alias = str_random() . '.' . $file->getClientOriginalExtension();
        $attachment->folder = 'Form';
        $attachment->mime = $file->getClientMimeType();
        $attachment->name = $file->getClientOriginalName();
        $attachment->extension = $file->getClientOriginalExtension();
        $attachment->save();

        $file->move(public_path('storage/Form'), $attachment->alias);

        return response()->json([
            'status' => true,
            'message' => 'Image successfully uploaded',
            'data' => $attachment
        ]);
    }


    /**
     * upload image ckeditor
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return string
     */
    public function ckEditorImageUpload(Request $request)
    {
//        $CKEditor = $request->get('CKEditor');
        $funcNum = $request->get('CKEditorFuncNum');
        $message = $url = '';
        if ($request->hasFile('upload')) {
            $file = $request->file('upload');
            if ($file->isValid()) {
//                $filename = $file->getClientOriginalName();
                $filename = uniqid() . time();
                $extension = $file->getClientOriginalExtension();

                $file->move(public_path() . '/uploads/ckeditor/', $filename . '.' . $extension);
                $url = asset('/public/uploads/ckeditor/' . $filename . '.' . $extension);

                /* save image path to browser list */
                $image_json = file_get_contents(public_path() . '/uploads/ckeditor/image_list.json');
                $image_data = json_decode($image_json, true);

                if (!is_array($image_data)) {
                    $image_data = [];
                }

                array_push($image_data, ["image" => $url]);
                $new_image_json = json_encode($image_data);
                file_put_contents(public_path() . '/uploads/ckeditor/image_list.json', $new_image_json);
            } else {
                $message = 'An error occured while uploading the file.';
            }
        } else {
            $message = 'No file uploaded.';
        }
        return '<script>window.parent.CKEDITOR.tools.callFunction(' . $funcNum . ', "' . $url . '", "' . $message . '")</script>';
    }

    /**
     * Attach a section template to a page
     */
    public function attachSection(Request $request, $pageId)
    {
        try {
            $page = $this->page_model->findOrFail($pageId);
            $template = SectionTemplate::findOrFail($request->template_id);
            
            // Create new section instance
            $section = new \App\Models\Section([
                'name' => $request->name,
                'alias' => str_slug($request->name),
                'section_template_id' => $template->id,
                'type' => 'template',
                'value' => '',
                'is_active' => true
            ]);
            $section->save();
            
            // Attach section to page (assuming you have the relationship set up)
            // This may need adjustment based on your exact relationship structure
            if (method_exists($page, 'sections')) {
                $page->sections()->attach($section->id, [
                    'sort_order' => $page->sections()->count(),
                    'is_active' => true
                ]);
            }
            
            return response()->json([
                'success' => true, 
                'message' => 'Section added successfully',
                'section' => $section
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false, 
                'message' => 'Error adding section: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Detach a section from a page
     */
    public function detachSection(Request $request, $pageId)
    {
        try {
            $page = $this->page_model->findOrFail($pageId);
            
            if (method_exists($page, 'sections')) {
                $page->sections()->detach($request->section_id);
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Section removed successfully'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error removing section: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Process section template fields and save their data
     */
    private function processSectionTemplateFields(Request $request, $page)
    {
        // Get all form inputs
        $allInputs = $request->all();
        $sectionData = [];
        
        \Log::info('=== Processing Section Template Fields START ===', [
            'page_id' => $page->id,
            'page_name' => $page->name,
            'user_id' => auth()->id(),
            'section_inputs' => array_filter($allInputs, function($key) {
                return strpos($key, 'section_') === 0;
            }, ARRAY_FILTER_USE_KEY)
        ]);
        
        // Build field type map to identify image fields
        $sectionFields = [];
        $page->load('sections.template.fields.fieldType');
        
        foreach ($page->sections as $section) {
            if ($section->template && $section->template->fields) {
                foreach ($section->template->fields as $field) {
                    $sectionFields[$section->id][$field->alias] = $field;
                }
            }
        }
        
        \Log::info('Sections with Templates', [
            'sections' => $page->sections->map(function($s) {
                return [
                    'id' => $s->id,
                    'name' => $s->name,
                    'section_template_id' => $s->section_template_id,
                    'has_template' => $s->template ? true : false,
                    'field_count' => $s->template ? $s->template->fields->count() : 0,
                    'fields' => $s->template ? $s->template->fields->pluck('alias', 'id')->toArray() : []
                ];
            })
        ]);
        
        // Extract section template fields (format: section_{sectionId}_{fieldAlias})
        foreach ($allInputs as $inputName => $inputValue) {
            if (strpos($inputName, 'section_') === 0) {
                // Parse the input name: section_123_title -> sectionId=123, fieldAlias=title
                $parts = explode('_', $inputName, 3);
                if (count($parts) === 3) {
                    $sectionId = $parts[1];
                    $fieldAlias = $parts[2];
                    
                    // Check if this is an image field
                    $isImageField = false;
                    if (isset($sectionFields[$sectionId][$fieldAlias])) {
                        $field = $sectionFields[$sectionId][$fieldAlias];
                        $isImageField = ($field->fieldType && $field->fieldType->component === 'image');
                    }
                    
                    // For image fields, allow '0' (no image selected) but convert to null
                    // For other fields, skip if empty or '0'
                    if ($isImageField) {
                        if ($inputValue !== null && $inputValue !== '') {
                            $sectionData[$sectionId][$fieldAlias] = $inputValue == '0' ? null : $inputValue;
                        }
                    } else {
                        if ($inputValue !== null && $inputValue !== '' && $inputValue != '0') {
                            $sectionData[$sectionId][$fieldAlias] = $inputValue;
                        }
                    }
                }
            }
        }
        
        \Log::info('Extracted Section Data from Inputs', [
            'section_data' => $sectionData,
            'sections_found' => array_keys($sectionData),
            'total_fields' => array_sum(array_map('count', $sectionData))
        ]);
        
        // Handle file uploads for section template fields
        foreach ($_FILES as $inputName => $fileData) {
            if (strpos($inputName, 'section_') === 0 && $request->hasFile($inputName)) {
                // Parse the input name: section_123_image -> sectionId=123, fieldAlias=image
                $parts = explode('_', $inputName, 3);
                if (count($parts) === 3) {
                    $sectionId = $parts[1];
                    $fieldAlias = $parts[2];
                    
                    // Get the uploaded file
                    $file = $request->file($inputName);
                    if ($file && $file->isValid()) {
                        // Use the existing attachment system
                        $attachment = $page->attach($file);
                        if ($attachment) {
                            // Store the attachment ID in section data
                            $sectionData[$sectionId][$fieldAlias] = $attachment->id;
                        }
                    }
                }
            }
        }
        
        // Save data for each section
        foreach ($sectionData as $sectionId => $fields) {
            $section = \App\Models\Section::find($sectionId);
            
            \Log::info('Processing Section for Save', [
                'section_id' => $sectionId,
                'section_found' => $section ? true : false,
                'has_template_id' => $section && $section->section_template_id ? true : false,
                'fields_to_save' => $fields
            ]);
            
            if ($section && $section->section_template_id) {
                // Get existing data to merge with new data (preserve existing fields)
                $existingData = [];
                if ($section->value) {
                    $existingData = json_decode($section->value, true) ?: [];
                }
                
                \Log::info('Section Data Before Merge', [
                    'section_id' => $sectionId,
                    'existing_data' => $existingData
                ]);
                
                // Merge existing data with new data
                $mergedData = array_merge($existingData, $fields);
                
                // For template-based sections, save as JSON in the value field
                $section->value = json_encode($mergedData);
                $section->save();
                
                \Log::info('Section Data Saved Successfully', [
                    'section_id' => $sectionId,
                    'section_name' => $section->name,
                    'merged_data' => $mergedData,
                    'final_value' => $section->value,
                    'user_id' => auth()->id()
                ]);
            } else {
                \Log::warning('Section Not Found or No Template', [
                    'section_id' => $sectionId,
                    'section_exists' => $section ? true : false,
                    'has_template_id' => $section && $section->section_template_id ? true : false
                ]);
            }
        }
        
        \Log::info('=== Processing Section Template Fields END ===', [
            'sections_processed' => count($sectionData),
            'page_id' => $page->id
        ]);
    }

}

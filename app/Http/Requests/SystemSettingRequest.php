<?php

namespace App\Http\Requests;

/**
 * Class SystemSettingRequest
 * @package App\Http\Requests
 */
class SystemSettingRequest extends Request
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|unique:system_settings,name,'.$this->route('system_setting').',id,deleted_at,NULL',
            'value' => 'required',
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'Name is required.',
            'value.required' => 'Value is required.',
        ];
    }
}
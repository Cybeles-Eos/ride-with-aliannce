<?php

namespace App\Http\Traits;

use App\Models\SystemSetting;
use App\Models\SeoMeta;

/**
 * Class SystemSettingTrait
 * @package App\Http\Traits
 * @author Richard Guevara
 */
trait SystemSettingTrait
{

    /**
     * @param $code
     *
     * @return mixed
     */
    public function getSystemSettingByCode($code)
    {
        $system_setting = SystemSetting::where('code', $code)->first();
        return $system_setting;
    }

    /**
     * @return mixed
     */
    public function getSystemSettings()
    {
        $system_settings = SystemSetting::get();
        return $system_settings;
    }

    /**
     * Generate system generated codes by getting max id of the passed model then increment by one
     *
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @param  string $code
     *
     * @return mixed
     */
    public function generateSystemCode($model, $code = 'SS')
    {
        $max_code = $code . '0001';
        if ($model) {
            $max_id = $model->max('id');
            if ($max_id) {
                $max_code = substr($max_code, 0, -strlen($max_id)) . '' . ($max_id + 1);
            }
        }
        return $max_code;
    }

    /**
     * Get seo meta fields
     *
     * @param array $page
     *
     * @return mixed
     */
    public function getSeoMeta($page = [])
    {
        $seo_meta = [
            'name' => 'Laravel Template',
            'author' => 'Monte Carlo Web Graphics Studio',
            'robots' => 'noindex, nofollow',
            'title' => 'Laravel Template',
            'keywords' => 'Laravel Template',
            'description' => 'Laravel Template. ACL Integrated (Access Control List).',
            'canonical' => '',
        ];

        if(env('APP_ENV') == 'prod' || env('APP_ENV') == 'prod_ssl') {
            $seo_meta['robots'] = 'index, follow';
        }

        $system_settings = $this->getSystemSettings();

        foreach ($system_settings as $system_setting) {
            if ($system_setting->code == 'SS0001') {
                $seo_meta['name'] = $system_setting->value;
            }
            if ($system_setting->code == 'SS0002') {
                $seo_meta['email'] = $system_setting->value;
            }
            if ($system_setting->code == 'SS0003') {
                $seo_meta['phone'] = $system_setting->value;
            }
            if ($system_setting->code == 'SS0004') {
                $seo_meta['address'] = $system_setting->value;
            }
            if ($system_setting->code == 'SS0005') {
                $seo_meta['title'] = $system_setting->value;
            }
            if ($system_setting->code == 'SS0006') {
                $seo_meta['keywords'] = $system_setting->value;
            }
            if ($system_setting->code == 'SS0007') {
                $seo_meta['description'] = $system_setting->value;
            }
        }

        if (isset($page) && !empty($page)) {
            if (isset($page->seo_meta_id)) {
                $page_seo_meta = SeoMeta::find($page->seo_meta_id);
                if (!empty($page_seo_meta)) {
                    $seo_meta['title'] = ($page_seo_meta->meta_title == '') ? $seo_meta['title'] : $page_seo_meta->meta_title;
                    $seo_meta['keywords'] = ($page_seo_meta->meta_keywords == '') ? $seo_meta['keywords'] : $page_seo_meta->meta_keywords;
                    $seo_meta['description'] = ($page_seo_meta->meta_description == '') ? $seo_meta['description'] : $page_seo_meta->meta_description;
                    $seo_meta['canonical'] = ($page_seo_meta->canonical_link == '') ? $seo_meta['canonical'] : $page_seo_meta->canonical_link;
                }
            }
        }

        view()->share(['seo_meta' => $seo_meta]);
        return $seo_meta;
    }
}

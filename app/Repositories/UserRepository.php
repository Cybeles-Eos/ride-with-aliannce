<?php

namespace App\Repositories;

use App\Http\Traits\SystemSettingTrait;
use App\Models\User;
use File;
use Mail;

/**
 * Class UserRepository
 * @package App\Repositories
 * @author Richard Guevara
 */
class UserRepository
{
    use SystemSettingTrait;

    /**
     * Get single instance
     *
     * @param  $id
     *
     * @return App/Models/User;
     */
    public function get($id)
    {
        $item = User::findOrFail($id);
        return $item;
    }

    public function sendEmail($params = null)
    {
        if (isset($params)) {
            $system_setting_name = $this->getSystemSettingByCode('SS0001');
            $system_setting_email = $this->getSystemSettingByCode('SS0002');
            $is_admin = isset($params['is_admin']) && $params['is_admin'];

            $data = [
                'type' => $params['type'],
                'subject' => $params['subject'],
                'user' => [
                    'name' => $params['user']['name'],
                    'email' => $params['user']['email']
                ],
                'user_data' => $params['user_data'],
                'attachments' => $params['attachments']
            ];

            Mail::send($params['view'], compact('data'), function ($message) use ($data, $system_setting_name, $system_setting_email, $is_admin) {
                $message->from(/*$system_setting_email->value*/config('constants.no_reply_email'), $system_setting_name->value);
                $message->bcc(config('constants.dnr_bcc'));
                if ($is_admin) {
                    $message->to($system_setting_email->value, $system_setting_name->value);
                } else {
                    $message->to($data['user']['email'], $data['user']['name']);
                }
                $message->subject($data['subject']);
                if (isset($data['attachments']) && count($data['attachments'])) {
                    foreach ($data['attachments'] as $attachment) {
                        if (File::exists($attachment)) {
                            $message->attach($attachment);
                        }
                    }
                }
            });
        }
    }
}
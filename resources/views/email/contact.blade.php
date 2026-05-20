@include('email.header')
<tr>
    <td align="center" bgcolor="#ffffff"
        style="padding: 40px 20px 40px 20px; color: #555555; font-family: Arial, sans-serif; font-size: 20px; line-height: 30px; border-bottom: 1px solid #f6f6f6;">
        <b>Hi {{ isset($data['user_data']) ? $data['user_data']['name'] : '' }},</b>
        <br>
        <span>Thanks for contacting us at {{ $seo_meta['name'] }}.</span>
    </td>
</tr>
<tr>
    <td align="center" bgcolor="#f9f9f9"
        style="padding: 20px 20px 0 20px; color: #555555; font-family: Arial, sans-serif; font-size: 20px; line-height: 30px;">
        <p>
            <b>Name: {{ isset($data['user_data']) ? $data['user_data']['name'] : '' }}</b>
        </p>
        <p>
            <b>Email: {{ isset($data['user_data']) && $data['user_data']['email'] ? $data['user_data']['email'] : '' }}</b>
        </p>
        <p>
            <b>Phone: {{ isset($data['user_data']) && $data['user_data']['phone'] ? $data['user_data']['phone'] : '' }}</b>
        </p>
        <p>
            <b>Company: {{ isset($data['user_data']) && $data['user_data']['company'] ? $data['user_data']['company'] : '' }}</b>
        </p>
        <p>
            <b>Subject: {{ isset($data['user_data']) && $data['user_data']['subject'] ? $data['user_data']['subject'] : '' }}</b>
        </p>
        <p>
            <b>Message: {!! isset($data['user_data']) && $data['user_data']['message'] ? $data['user_data']['message'] : '' !!}</b>
        </p>
    </td>
</tr>
@include('email.footer')
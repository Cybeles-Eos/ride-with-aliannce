@include('email.header')
<tr>
    <td align="center" bgcolor="#ffffff"
        style="padding: 40px 20px 40px 20px; color: #555555; font-family: Arial, sans-serif; font-size: 20px; line-height: 30px; border-bottom: 1px solid #f6f6f6;">
        <b>New customer registered.</b>
    </td>
</tr>
<tr>
    <td align="center" bgcolor="#f9f9f9"
        style="padding: 20px 20px 0 20px; color: #555555; font-family: Arial, sans-serif; font-size: 20px; line-height: 30px;">
        <p>
            <b>Name: {{ isset($data['user_data']) ? $data['user_data']['first_name'] .' '.  $data['user_data']['last_name'] : '' }}</b>
        </p>
        <p>
            <b>Email: {{ isset($data['user_data']) && $data['user_data']['email'] ? $data['user_data']['email'] : '' }}</b>
        </p>
    </td>
</tr>
<tr>
    <td align="center" bgcolor="#f9f9f9"
        style="padding: 30px 20px 30px 20px; font-family: Arial, sans-serif; border-bottom: 1px solid #f6f6f6;">
        <table bgcolor="#425688" border="0" cellspacing="0" cellpadding="0" class="buttonwrapper">
            <tr>
                <td align="center" height="50" style="font-family: Arial, sans-serif; font-size: 16px; font-weight: bold; background-color: #425688; padding: 0px 20px;">
                    <a class="button" style="color: #ffffff; text-align: center; text-decoration: none;"
                       href="{{ url('admin/users') }}">Users</a>
                </td>
            </tr>
        </table>
    </td>
</tr>
@include('email.footer')
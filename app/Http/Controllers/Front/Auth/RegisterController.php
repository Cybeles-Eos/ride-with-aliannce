<?php

namespace App\Http\Controllers\Front\Auth;

use App\Http\Controllers\Controller;
use App\Http\Traits\SystemSettingTrait;
use App\Models\User;
use App\Repositories\PageRepository;
use App\Repositories\UserRepository;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

/**
 * Class RegisterController
 * @package App\Http\Controllers\Auth
 */
class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers, SystemSettingTrait;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/customer/dashboard';

    /**
     * Create a new controller instance.
     *
     * @param User $user_model
     * @param Role $role_model
     * @param PageRepository $page_repository
     * @param UserRepository $user_repository
     *
     */
    public function __construct(User $user_model,
                                Role $role_model,
                                PageRepository $page_repository,
                                UserRepository $user_repository
    )
    {
        /*
        * Model namespace
        * using $this->user_model can also access $this->user_model->where('id', 1)->get();
        * */
        $this->user_model = $user_model;
        $this->role_model = $role_model;
        $this->page_repository = $page_repository;
        $this->user_repository = $user_repository;

        $this->middleware('isFront.guest');
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        $page = $this->page_repository->getActivePageBySlug('customer/register');
        if (!empty($page)) {
            $seo_meta = $this->getSeoMeta($page);
        }

        return view('front.auth.register', compact('page'));
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => 'required',
            'last_name' => 'required',
            'user_name' => 'required|unique:users,user_name,NULL,id,deleted_at,NULL',
            'email' => 'required|unique:users,email,NULL,id,deleted_at,NULL',
            'password' => 'required|min:87|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     *
     * @return User
     */
    protected function create(array $data)
    {
        $user = $this->user_model->create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'user_name' => $data['user_name'],
            'email' => $data['email'],
            'password' => $data['password'],
        ]);

        /* customer role */
        $roles = [3];
        if (isset($roles)) {
            foreach ($roles as $role) {
                $role_r = $this->role_model->where('id', '=', $role)->firstOrFail();
                $user->assignRole($role_r);
            }
        }

        return $user;
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        $this->guard()->login($user);

        if (!in_array($_SERVER['REMOTE_ADDR'], ['127.0.0.1', '::1'])) {
            $email_data = [
                'view' => 'email.registered',
                'type' => 'registered',
                'user' => [
                    'name' => $user->first_name,
                    'email' => $user->email,
                ],
                'user_data' => $user,
                'subject' => 'Registration Successful',
                'attachments' => [],
                'is_admin' => FALSE,
            ];

            /* send email to customer */
            $this->user_repository->sendEmail($email_data);

            /* send email to admin */
            $email_data['is_admin'] = TRUE;
            $email_data['view'] = 'email.registered_admin';
            $email_data['subject'] = 'New Registration';
            $this->user_repository->sendEmail($email_data);
        }

        return $this->registered($request, $user)
            ?: redirect($this->redirectPath());
    }
}

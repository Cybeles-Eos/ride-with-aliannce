<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Repositories\ContactRepository;

/**
 * Class ContactController
 * @package App\Http\Controllers
 * @author Richard Guevara
 */
class ContactController extends Controller
{
    /**
     * Contact model instance.
     *
     * @var Contact
     */
    private $contact_model;

    /**
     * ContactRepository repository instance.
     *
     * @var ContactRepository
     */
    private $contact_repository;

    /**
     * Create a new controller instance.
     *
     * @param Contact $contact_model
     * @param ContactRepository $contact_repository
     */
    public function __construct(Contact $contact_model, ContactRepository $contact_repository)
    {
        /*
         * Model namespace
         * using $this->contact_model can also access $this->contact_model->where('id', 1)->get();
         * */
        $this->contact_model = $contact_model;

        /*
         * Repository namespace
         * this class may include methods that can be used by other controllers, like getting of contacts with other data (related tables).
         * */
        $this->contact_repository = $contact_repository;

//        $this->middleware(['isAdmin']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        if (!auth()->user()->hasPermissionTo('Read Contact')) {
            abort('401', '401');
        }

        $contacts = $this->contact_model->get();

        return view('admin.pages.contact.index', compact('contacts'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
//            'phone' => 'required',
            'message' => 'required',
            'subject' => 'required',
            'g-recaptcha-response' => 'required|captcha'
        ]);

        $input = $request->all();
        $contact = $this->contact_model->create($input);

        if (!in_array($_SERVER['REMOTE_ADDR'], ['127.0.0.1', '::1'])) {
            $email_data = [
                'view' => 'email.contact',
                'type' => 'contact',
                'user' => [
                    'name' => $contact->name,
                    'email' => $contact->email,
                ],
                'user_data' => $contact,
                'subject' => 'Thank you for contacting us.',
                'attachments' => [],
                'is_admin' => FALSE,
            ];

            /* send email to customer */
            $this->contact_repository->sendEmail($email_data);

            /* send email to admin */
            $email_data['is_admin'] = TRUE;
            $email_data['view'] = 'email.contact_admin';
            $email_data['subject'] = 'New Contact Us Form';
            $this->contact_repository->sendEmail($email_data);
        }

        return redirect()->back()->with('flash_message', [
            'title' => '',
            'message' => 'Thanks! We will get back to you soon.',
            'type' => 'success'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!auth()->user()->hasPermissionTo('Read Contact')) {
            abort('401', '401');
        }

        $contact = $this->contact_model->findOrFail($id);

        return view('admin.pages.contact.show', compact('contact'));
    }
}

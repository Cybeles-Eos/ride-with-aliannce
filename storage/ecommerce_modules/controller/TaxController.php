<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\State;
use Illuminate\Http\Request;

/**
 * Class TaxController
 * @package App\Http\Controllers
 * @author Richard Guevara
 */
class TaxController extends Controller
{
    /**
     * Tax model instance.
     *
     * @var Tax
     */
    private $state_model;

    /**
     * TaxRepository repository instance.
     *
     * @var TaxRepository
     */
    private $tax_repository;

    /**
     * Create a new controller instance.
     *
     * @param State $state_model
     * @param Country $country_model
     */
    public function __construct(State $state_model,
                                Country $country_model
    )
    {
        /*
         * Model namespace
         * using $this->state_model can also access $this->state_model->where('id', 1)->get();
         * */
        $this->state_model = $state_model;
        $this->country_model = $country_model;

        /*
         * Repository namespace
         * this class may include methods that can be used by other controllers, like getting of taxes with other data (related tables).
         * */

//        $this->middleware(['isAdmin']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        if (!auth()->user()->hasPermissionTo('Read Tax')) {
            abort('401', '401');
        }

        $countries = $this->country_model->get();
        $states = $this->state_model->limit(10)->get();

        return view('admin.pages.tax.index', compact('countries', 'states'));
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
        if (!auth()->user()->hasPermissionTo('Update Tax')) {
            abort('401', '401');
        }

        $state = $this->state_model->findOrFail($id);

        return view('admin.pages.tax.edit', compact('state'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $id)
    {
        if (!auth()->user()->hasPermissionTo('Update Tax')) {
            abort('401', '401');
        }

        $this->validate($request, [
            'tax' => 'required',
        ]);

        $tax = $this->state_model->findOrFail($id);
        $input = $request->all();
        $tax->fill($input)->save();

        return redirect()->route('admin.taxes.index')->with('flash_message', [
            'title' => '',
            'message' => 'Tax ' . $tax->name . ' successfully updated.',
            'type' => 'success'
        ]);
    }

    /**
     * Datatables draw
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function draw(Request $request)
    {
        $columns = array(
            0 => 'name',
            1 => 'country',
            2 => 'tax',
            3 => 'action',
        );

        $totalData = $this->state_model->count();

        $country = $request->input('columns.1.search.value');
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if ($country != '') {
            $totalFiltered = $this->state_model
                ->whereHas('country', function ($query) use ($country) {
                    $query->where('name', '=', "{$country}");
                })
                ->count();
        } else {
            $totalFiltered = $this->state_model->count();
        }

        if (empty($request->input('search.value'))) {
            if ($limit == -1) {
                if ($country != '') {
                    $states = $this->state_model
                        ->whereHas('country', function ($query) use ($country) {
                            $query->where('name', '=', "{$country}");
                        })
                        ->orderBy($order, $dir)
                        ->get();
                } else {
                    $states = $this->state_model
                        ->orderBy($order, $dir)
                        ->get();
                }
            } else {
                if ($country != '') {
                    $states = $this->state_model
                        ->whereHas('country', function ($query) use ($country) {
                            $query->where('name', '=', "{$country}");
                        })
                        ->offset($start)
                        ->limit($limit)
                        ->orderBy($order, $dir)
                        ->get();
                } else {
                    $states = $this->state_model
                        ->offset($start)
                        ->limit($limit)
                        ->orderBy($order, $dir)
                        ->get();
                }
            }
        } else {
            $search = $request->input('search.value');

            if ($limit == -1) {
                if ($country != '') {
                    $states = $this->state_model
                        ->whereHas('country', function ($query) use ($country) {
                            $query->where('name', '=', "{$country}");
                        })
                        ->where(function ($query) use ($search) {
                            $query->orWhere('name', 'LIKE', "%{$search}%")
                                ->orWhere('tax', 'LIKE', "%{$search}%")
                                ->orWhereHas('country', function ($query) use ($search) {
                                    $query->where('name', 'LIKE', "%{$search}%");
                                });
                        })
                        ->orderBy($order, $dir)
                        ->get();
                } else {
                    $states = $this->state_model
                        ->where(function ($query) use ($search) {
                            $query->orWhere('name', 'LIKE', "%{$search}%")
                                ->orWhere('tax', 'LIKE', "%{$search}%")
                                ->orWhereHas('country', function ($query) use ($search) {
                                    $query->where('name', 'LIKE', "%{$search}%");
                                });
                        })
                        ->orderBy($order, $dir)
                        ->get();
                }

            } else {
                if ($country != '') {
                    $states = $this->state_model
                        ->whereHas('country', function ($query) use ($country) {
                            $query->where('name', '=', "{$country}");
                        })
                        ->where(function ($query) use ($search) {
                            $query->orWhere('name', 'LIKE', "%{$search}%")
                                ->orWhere('tax', 'LIKE', "%{$search}%")
                                ->orWhereHas('country', function ($query) use ($search) {
                                    $query->where('name', 'LIKE', "%{$search}%");
                                });
                        })
                        ->offset($start)
                        ->limit($limit)
                        ->orderBy($order, $dir)
                        ->get();
                } else {
                    $states = $this->state_model
                        ->where(function ($query) use ($search) {
                            $query->orWhere('name', 'LIKE', "%{$search}%")
                                ->orWhere('tax', 'LIKE', "%{$search}%")
                                ->orWhereHas('country', function ($query) use ($search) {
                                    $query->where('name', 'LIKE', "%{$search}%");
                                });
                        })
                        ->offset($start)
                        ->limit($limit)
                        ->orderBy($order, $dir)
                        ->get();
                }
            }

            if ($country != '') {
                $totalFiltered = $this->state_model
                    ->whereHas('country', function ($query) use ($country) {
                        $query->where('name', '=', "{$country}");
                    })
                    ->where(function ($query) use ($search) {
                        $query->orWhere('name', 'LIKE', "%{$search}%")
                            ->orWhere('tax', 'LIKE', "%{$search}%")
                            ->orWhereHas('country', function ($query) use ($search) {
                                $query->where('name', 'LIKE', "%{$search}%");
                            });
                    })
                    ->count();
            } else {
                $totalFiltered = $this->state_model
                    ->where(function ($query) use ($search) {
                        $query->orWhere('name', 'LIKE', "%{$search}%")
                            ->orWhere('tax', 'LIKE', "%{$search}%")
                            ->orWhereHas('country', function ($query) use ($search) {
                                $query->where('name', 'LIKE', "%{$search}%");
                            });
                    })
                    ->count();
            }
        }

        $data = [];
        if (!empty($states)) {
            foreach ($states as $state) {
                $nestedData['id'] = $state->id;
                $nestedData['name'] = $state->name;
                $nestedData['country'] = $state->country->name;
                $nestedData['tax'] = $state->tax;
                $edit = '';
                if (auth()->user()->hasPermissionTo('Update Tax')) {
                    $edit = '<a href="' . route('admin.taxes.edit', $state->id) . '"
                                   target="_blank"
                                   data-toggle="tooltip"
                                   title=""
                                   class="btn btn-default"
                                   data-original-title="Edit"><i class="fa fa-pencil"></i></a>';
                }
                $nestedData['action'] = '<div class="btn-group btn-group-xs">' . $edit . '</div>';
                $data[] = $nestedData;
            }
        }

        $response = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data,
        );

        return json_encode($response);
    }
}

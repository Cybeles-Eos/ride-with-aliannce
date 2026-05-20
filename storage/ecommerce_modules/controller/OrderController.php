<?php

namespace App\Http\Controllers;

use App\Http\Traits\SystemSettingTrait;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Repositories\OrderRepository;
use App\Repositories\PageRepository;
use Illuminate\Http\Request;

/**
 * Class OrderController
 * @package App\Http\Controllers
 * @author Richard Guevara
 */
class OrderController extends Controller
{
    use SystemSettingTrait;

    /**
     * Order model instance.
     *
     * @var Order
     */
    private $order_model;

    /**
     * OrderRepository repository instance.
     *
     * @var OrderRepository
     */
    private $order_repository;

    /**
     * Create a new controller instance.
     *
     * @param Order $order_model
     * @param OrderRepository $order_repository
     * @param OrderStatus $order_status_model
     * @param PageRepository $page_repository
     */
    public function __construct(Order $order_model, OrderRepository $order_repository,
                                OrderStatus $order_status_model,
                                PageRepository $page_repository
    )
    {
        /*
         * Model namespace
         * using $this->order_model can also access $this->order_model->where('id', 1)->get();
         * */
        $this->order_model = $order_model;
        $this->order_status_model = $order_status_model;

        /*
         * Repository namespace
         * this class may include methods that can be used by other controllers, like getting of orders with other data (related tables).
         * */
        $this->order_repository = $order_repository;
        $this->page_repository = $page_repository;

//        $this->middleware(['isAdmin']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        if (!auth()->user()->hasPermissionTo('Read Order')) {
            abort('401', '401');
        }

        $orders = $this->order_model->limit(10)->get();
//        $all_orders_total_amount = $this->order_model->sum('total_amount');
        $all_orders_total_amount = 0;

        return view('admin.pages.order.index', compact('orders', 'all_orders_total_amount'));
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
        if (!auth()->user()->hasPermissionTo('Read Order')) {
            abort('401', '401');
        }

        $order = $this->order_model->findOrFail($id);
        $statuses = $this->order_status_model->get();

        return view('admin.pages.order.show', compact('order', 'statuses'));
    }

    /**
     * Update order status.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function updateStatus(Request $request, $id)
    {
        $input = $request->only(['order_status_id']);
        if (isset($input['order_status_id'])) {
            $order = $this->order_model->findOrFail($id);
            if (!empty($order)) {
                $order->fill($input)->save();

                return redirect()->route('admin.orders.show', $id)
                    ->with('flash_message', [
                        'title' => '',
                        'message' => 'Order Status successfully updated.',
                        'type' => 'success'
                    ]);
            }
        }

        return redirect()->route('admin.orders.show', $id)
            ->with('flash_message', [
                'title' => '',
                'message' => 'Please try again.',
                'type' => 'error'
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
            0 => 'reference_no',
            1 => 'total_amount',
            2 => 'created_at',
            3 => 'order_status',
            4 => 'action',
        );

        $totalData = $this->order_model->count();

        $order_status = $request->input('columns.3.search.value');
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if ($order_status != '') {
            $totalFiltered = $this->order_model
                ->whereHas('status', function ($query) use ($order_status) {
                    $query->where('name', 'LIKE', "%{$order_status}%");
                })
                ->count();
        } else {
            $totalFiltered = $this->order_model->count();
        }

        if (empty($request->input('search.value'))) {
            if ($limit == -1) {
                if ($order_status != '') {
                    $orders = $this->order_model
                        ->whereHas('status', function ($query) use ($order_status) {
                            $query->where('name', 'LIKE', "%{$order_status}%");
                        })
                        ->orderBy($order, $dir)
                        ->get();
                } else {
                    $orders = $this->order_model
                        ->orderBy($order, $dir)
                        ->get();
                }
            } else {
                if ($order_status != '') {
                    $orders = $this->order_model
                        ->whereHas('status', function ($query) use ($order_status) {
                            $query->where('name', 'LIKE', "%{$order_status}%");
                        })
                        ->offset($start)
                        ->limit($limit)
                        ->orderBy($order, $dir)
                        ->get();
                } else {
                    $orders = $this->order_model
                        ->offset($start)
                        ->limit($limit)
                        ->orderBy($order, $dir)
                        ->get();
                }
            }
        } else {
            $search = $request->input('search.value');

            if ($limit == -1) {
                if ($order_status != '') {
                    $orders = $this->order_model
                        ->whereHas('status', function ($query) use ($order_status) {
                            $query->where('name', 'LIKE', "%{$order_status}%");
                        })
                        ->where(function ($query) use ($search) {
                            $query->orWhere('reference_no', 'LIKE', "%{$search}%")
                                ->orWhere('total_amount', 'LIKE', "%{$search}%")
                                ->orWhere('created_at', 'LIKE', "%{$search}%")
                                ->orWhereHas('order_status', function ($query) use ($search) {
                                    $query->where('name', 'LIKE', "%{$search}%");
                                });
                        })
                        ->orderBy($order, $dir)
                        ->get();
                } else {
                    $orders = $this->order_model
                        ->where(function ($query) use ($search) {
                            $query->orWhere('reference_no', 'LIKE', "%{$search}%")
                                ->orWhere('total_amount', 'LIKE', "%{$search}%")
                                ->orWhere('created_at', 'LIKE', "%{$search}%")
                                ->orWhereHas('order_status', function ($query) use ($search) {
                                    $query->where('name', 'LIKE', "%{$search}%");
                                });
                        })
                        ->orderBy($order, $dir)
                        ->get();
                }
            } else {
                if ($order_status != '') {
                    $orders = $this->order_model
                        ->whereHas('status', function ($query) use ($order_status) {
                            $query->where('name', 'LIKE', "%{$order_status}%");
                        })
                        ->where(function ($query) use ($search) {
                            $query->orWhere('reference_no', 'LIKE', "%{$search}%")
                                ->orWhere('total_amount', 'LIKE', "%{$search}%")
                                ->orWhere('created_at', 'LIKE', "%{$search}%")
                                ->orWhereHas('order_status', function ($query) use ($search) {
                                    $query->where('name', 'LIKE', "%{$search}%");
                                });
                        })
                        ->offset($start)
                        ->limit($limit)
                        ->orderBy($order, $dir)
                        ->get();
                } else {
                    $orders = $this->order_model
                        ->where(function ($query) use ($search) {
                            $query->orWhere('reference_no', 'LIKE', "%{$search}%")
                                ->orWhere('total_amount', 'LIKE', "%{$search}%")
                                ->orWhere('created_at', 'LIKE', "%{$search}%")
                                ->orWhereHas('order_status', function ($query) use ($search) {
                                    $query->where('name', 'LIKE', "%{$search}%");
                                });
                        })
                        ->offset($start)
                        ->limit($limit)
                        ->orderBy($order, $dir)
                        ->get();
                }
            }

            if ($order_status != '') {
                $totalFiltered = $this->order_model
                    ->whereHas('status', function ($query) use ($order_status) {
                        $query->where('name', 'LIKE', "%{$order_status}%");
                    })
                    ->where(function ($query) use ($search) {
                        $query->orWhere('reference_no', 'LIKE', "%{$search}%")
                            ->orWhere('total_amount', 'LIKE', "%{$search}%")
                            ->orWhere('created_at', 'LIKE', "%{$search}%")
                            ->orWhereHas('order_status', function ($query) use ($search) {
                                $query->where('name', 'LIKE', "%{$search}%");
                            });
                    })
                    ->count();
            } else {
                $totalFiltered = $this->order_model
                    ->where(function ($query) use ($search) {
                        $query->orWhere('reference_no', 'LIKE', "%{$search}%")
                            ->orWhere('total_amount', 'LIKE', "%{$search}%")
                            ->orWhere('created_at', 'LIKE', "%{$search}%")
                            ->orWhereHas('order_status', function ($query) use ($search) {
                                $query->where('name', 'LIKE', "%{$search}%");
                            });
                    })
                    ->count();
            }
        }

        $data = [];
        if (!empty($orders)) {
            foreach ($orders as $order) {
                $nestedData['id'] = $order->id;
                $nestedData['reference_no'] = $order->reference_no;
                $nestedData['total_amount'] = '$ ' . number_format($order->total_amount, 2);
                $nestedData['created_at'] = $order->created_at->format('F d, Y h:i A');
                $nestedData['order_status'] = $order->status->name;
                $show = '';
                if (auth()->user()->hasPermissionTo('Read Order')) {
                    $show = '<a href="' . route('admin.orders.show', $order->id) . '"
                                   data-toggle="tooltip"
                                   title=""
                                   class="btn btn-default"
                                   data-original-title="View"><i class="fa fa-eye"></i></a>';
                }
                $nestedData['action'] = '<div class="btn-group btn-group-xs">' . $show . '</div>';
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

    /**
     * View orders dashboard page.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function indexOrders(Request $request)
    {
        $page = $this->page_repository->getActivePageBySlug('customer/orders');
        if (!empty($page)) {
            $seo_meta = $this->getSeoMeta($page);
        }

        $orders = $this->order_repository->getAllOrdersByUser();

        return view('front.pages.dashboard.orders', compact('page', 'orders'));
    }
}

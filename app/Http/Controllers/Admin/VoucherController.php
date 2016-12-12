<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use App\Repositories\Voucher\VoucherRepository;
use App\Http\Requests\CreateVoucherRequest;

class VoucherController extends Controller
{

    /**
     * The VoucherRepository instance
     *
     * @param VoucherRepository
     */
    protected $voucherRepository;

    /**
     * Create a new VoucherRepository instance
     *
     * @param VoucherRepository $voucherRepository description
     *
     * @return void
     */
    public function __construct(VoucherRepository $voucherRepository)
    {
        $this->voucherRepository = $voucherRepository;
    }

    /**
     * Display a listing of the resource
     *
     * @return Response
     */
    public function index()
    {
        $vouchers = $this->voucherRepository->all();

        return view('admin.voucher.index', compact('vouchers'));
    }

    /**
     * [Show the form for creating a new resource]
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.voucher.create');
    }

    /**
     * Store a newly created resource in storage
     *
     * @param CreateVoucherRequest $request [validate values input]
     *
     * @return Response
     */
    public function store(CreateVoucherRequest $request)
    {
        $input = $request->only('name', 'point', 'value');
        $this->voucherRepository->create($input);

        Session::flash('msg', trans('voucher.create_voucher_successful'));

        return redirect(route('voucher.index'));
    }
}

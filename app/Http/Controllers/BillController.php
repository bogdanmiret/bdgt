<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use Illuminate\Support\Facades\Request;

class BillController extends Controller
{
    public function index()
    {
        return view('bill.index')->with(
            'bills',
            Bill::all()->sortBy(function ($bill) {
                return $bill->nextDue;
            })
        );
    }

    /**
     * Show an individual bill to the user.
     *
     * @param  Bill $bill
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Bill $bill)
    {
        return view('bill.show')->with('bill', $bill->load('transactions'));
    }

    /**
     * Create and store a new bill.
     *
     * @return Redirect
     */
    public function store()
    {
        request()->validate([
            'start_date' => 'required|date',
            'frequency' => 'required|numeric',
            'label' => 'required|string',
            'amount' => 'required|numeric',
        ]);

        if ($bill = Bill::create(Request::all())) {
            return redirect(route('bills.show', $bill->id))->with('alerts.success', trans('crud.bills.created'));
        }

        return redirect()->back()->with('alerts.danger', trans('crud.bills.error'));
    }

    /**
     * Update an existing bill with new data.
     *
     * @param  Bill $bill
     *
     * @return Redirect
     */
    public function update(Bill $bill)
    {
        if ($bill->update(Request::all())) {
            return redirect(route('bills.show', $bill->id))->with('alerts.success', trans('crud.bills.updated'));
        }

        return redirect()->back()->with('alerts.danger', trans('crud.bills.error'));
    }

    /**
     * Delete a bill.
     *
     * @param  Bill $bill
     *
     * @return Redirect
     */
    public function destroy(Bill $bill)
    {
        if ($bill->delete()) {
            return redirect(route('bills.index'))->with('alerts.success', trans('crud.bills.deleted'));
        }

        return redirect()->back()->with('alerts.danger', trans('crud.bills.error'));
    }
}

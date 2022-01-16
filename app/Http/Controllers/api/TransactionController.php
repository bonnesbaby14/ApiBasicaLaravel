<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\api\Transaction;
use Illuminate\Http\Request;
use App\Http\Requests\Transaction as TransactionRequest;
use App\Http\Resources\TransactionResource;
use App\Http\Resources\TrasactionResource;

class TransactionController extends Controller
{

    protected $transaction;

    public function __construct(Transaction $transaction)
    {
        $this->transaction=$transaction;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Transaction::paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TransactionRequest $request)
    {
        $transaction=Transaction::create($request->all());

        return response()->json($transaction,201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction $transaction)
    {
        return new TransactionResource($transaction);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TransactionRequest $request, Transaction $transaction)
    {

        
        $transaction->update($request->all());

        return response()->json($transaction,201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $transaction)
    {

        $transaction->delete();
        return response()->json(null,204);
    }
}

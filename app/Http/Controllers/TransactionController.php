<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Http\Request;
use DB;
use Auth;

class TransactionController extends Controller
{
    public function __construct()
	{
	    $this->middleware('auth');
	}
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $res = $this->transactionTable();
        $transactions = $res['transactions'];
        $sent = $this->transactionAmountTable('sent');
        $received = $this->transactionAmountTable('received');

        return view('dashboard',compact('received', 'sent', 'transactions'));
    }

    protected function transactionAmountTable($type = null){
        $amount = Transaction::select(DB::raw('sum(amount) as amount, name, wallet_id'))
        ->leftJoin('wallets as w', function($join) {
            $join->on('w.id', '=', 'transactions.wallet_id');
        })
        ->where('type', $type)
        ->where('user_id', Auth::user()->id)
        ->where('is_fraudulent', 0)
        ->whereNull('w.deleted_at')
        ->groupBy('wallet_id')
        ->get();

        return $amount;
    }

    protected function transactionTable(){
        $transactions = Transaction::leftJoin('wallets as w', 'w.id', '=', 'transactions.wallet_id')
            ->where('user_id', Auth::user()->id)
            ->orderBy('transactions.created_at', 'DESC')
            ->select('transactions.id as id', 'wallet_id', 'type', 'description', 'amount', 'is_fraudulent', 'name', 'transactions.created_at as created_at')
            ->get();

        $amount = Transaction::select(DB::raw('sum(amount) as amount, name, wallet_id'))
        ->leftJoin('wallets as w', function($join) {
            $join->on('w.id', '=', 'transactions.wallet_id');
        })
        ->where('user_id', Auth::user()->id)
        ->whereNull('w.deleted_at')
        ->groupBy('wallet_id')
        ->get()
        ;
    
        $res = [
            'transactions' => $transactions,
            'amount' => $amount,
        ];

        return $res;
    }

    /**
     * Display a listing of the wallet resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getWallet()
    {
        $wallet = Wallet::where('user_id', Auth::user()->id)->whereNull('deleted_at')->get();
        $res = $this->transactionTable();
        $transactions = $res['transactions'];
        $amount = $res['amount'];

        return view('wallet',compact('transactions', 'amount', 'wallet'));
    }

    /**
     * Display a listing of the wallet resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getTransaction()
    {
        $res = $this->transactionTable();
        $transactions = $res['transactions'];
        $amount = $res['amount'];

        return view('transaction',compact('transactions', 'amount'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $transact = Transaction::create($request->all());
        return response()->json(['message' => 'Transfer has been sucessfull', 'data' => $transact]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction $transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaction $transaction)
    {
        try {
            $posting = $transaction->where('id', $request->id)->update(['is_fraudulent' => 1]);
            return response()->json(['message' => 'Transaction has been mark as fraudulent', 'data' => $posting]);
        } catch(\Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $transaction)
    {
        //
    }

    /**
     * Remove temporary the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function softDelete($id)
    {
        $transact = Transaction::destroy($id);
        if ($transact) {
            $response =  response()->json(['message' => 'Successfully deleted', 'data' => $transact]);
        } else {
            $response =  response()->json(['code' => 404,'message' => 'Not found','success' => false,]);
        }

        return $response;
    }
}

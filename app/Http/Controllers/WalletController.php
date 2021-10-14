<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use App\Models\User;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Auth;
use DB;

class WalletController extends Controller
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
        $wallets = Wallet:: where('user_id', Auth::user()->id)->whereNull('deleted_at')->get();
        $users = User::where('id', "<>", Auth::user()->id)->get();

        $history = DB::table('wallets as w')->where('user_id', Auth::user()->id)
        ->leftJoin('transactions as t', function($join) {
            $join->on('w.id', '=', 't.wallet_id');
        })
        ->where('user_id', Auth::user()->id)
        ->whereNull('t.deleted_at')
        ->orderBy('t.created_at', 'DESC')
        ->get();

        return view('transfer',compact('wallets', 'users', 'history'));
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
        $wallet = Wallet::create(['name' => $request->walletName, 'user_id' => Auth::user()->id]);
        return response()->json(['message' => 'Wallet has been sucessfully added', 'data' => $wallet]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Wallet  $wallet
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Wallet  $wallet
     * @return \Illuminate\Http\Response
     */
    public function edit(Wallet $wallet)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Wallet  $wallet
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Wallet $wallet)
    {
        try {
            $posting = $wallet->where('id', $request->wallet_id)->update(['name' => $request->name]);
            return response()->json(['message' => 'Wallet has been sucessfully saved', 'data' => $posting]);
        } catch(\Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Wallet  $wallet
     * @return \Illuminate\Http\Response
     */
    public function destroy(Wallet $wallet)
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
        $wallet = Wallet::destroy($id);
        if ($wallet) {
            $response =  response()->json(['message' => 'Successfully deleted', 'data' => $wallet]);
        } else {
            $response =  response()->json(['code' => 404,'message' => 'Not found','success' => false,]);
        }
    
        return $response;
    }
}

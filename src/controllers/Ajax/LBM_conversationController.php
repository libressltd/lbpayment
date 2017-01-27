<?php

namespace LIBRESSLtd\LBMessenger\Controllers\Ajax;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\LBM_conversation;

class LBM_conversationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $conversations = LBM_conversation::with("last_user")->orderBy("updated_at", "desc")->get();
        return $conversations;
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
        $transaction = LBP_transaction::where("txn_id", $request->txn_id)->first();
        if ($transaction)
        {
            $ipn = new LBP_transaction_ipn;
            $ipn->ipn_version = $request->ipn_version;
            $ipn->ipn_id = $request->ipn_id;
            $ipn->ipn_mode = $request->ipn_mode;
            $ipn->merchant = $request->merchant;
            $ipn->ipn_type = $request->ipn_type;
            $ipn->status = $request->status;
            $ipn->status_text = $request->status_text;
            $ipn->currency1 = $request->currency1;
            $ipn->currency2 = $request->currency2;
            $ipn->fee = $request->fee;
            $ipn->amount1 = $request->amount1;
            $ipn->amount2 = $request->amount2;
            $ipn->fee = $request->fee;
            $ipn->buyer_name = $request->buyer_name;
            $ipn->received_amount = $request->received_amount;
            $ipn->received_confirms = $request->received_confirms;
            $ipn->lbp_transaction_id = $transaction->id;
            $ipn->save();

            $transaction->status_id = $ipn->status;
            $transaction->save();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

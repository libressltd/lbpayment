<?php

namespace LIBRESSLtd\LBMessenger\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\LBM_conversation;

class LBM_conversationItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($conversation_id)
    {
        $conversations = LBM_conversation::get();
        $conversation = LBM_conversation::findOrFail($conversation_id);
        return view("libressltd.lbmessenger.conversation.index", [
            "conversations" => $conversations, 
            "conversation" => $conversation
        ]);
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
    public function store(Request $request, $conversation_id)
    {
        $conversation = LBM_conversation::findOrFail($conversation_id);
        $conversation->addMessage($request->content);
        return redirect()->back();
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

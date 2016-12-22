<?php

namespace LIBRESSLtd\LBPayment\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use GuzzleHttp\Client;

class LBPCoinPaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $form_params = [
            'version' => '1',
            'key' => '076336aab864a9021078f7c1ff110cfc640f47d408c9fe070953b3ca5d9ff9d3',
            'cmd' => 'create_transaction',
            'amount' => '0.01',
            'currency1' => 'BTC',
            'currency2' => 'BTC'
        ];
        $private_key = "708029D7f9D7e733AB1975711892a2d99000E16E56128Be9e8DE1574D7628Eaa";
        $url_encoded_params = http_build_query($form_params);

        $hmac = hash_hmac("sha256", $url_encoded_params, $private_key);

        $client = new Client();
        $res = $client->request('POST', 'https://www.coinpayments.net/api.php', [
            'form_params' => $form_params,
            'headers' => [
                'HMAC' => $hmac
            ],
        ]);
        echo $res->getStatusCode();
        // "200"
        print_r($res->getHeader('content-type'));
        // 'application/json; charset=utf8'
        return $res->getBody();
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
        //
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

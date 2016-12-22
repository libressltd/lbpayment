<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Alsofronie\Uuid\Uuid32ModelTrait;
use GuzzleHttp\Client;
use Auth;

class LBP_transaction extends Model
{
	use Uuid32ModelTrait;

    public function creator()
    {
        return $this->belongsTo("App\Models\User", "created_by");
    }

    public function updater()
    {
        return $this->belongsTo("App\Models\User", "updated_by");
    }

    static function addTransaction($amount, $currency)
    {
    	$transaction = new LBP_transaction;
    	$transaction->amount = $amount;
    	$transaction->currency1 = $currency;
    	$transaction->currency2 = "BTC";
    	$transaction->network = "coinpayments";
    	$transaction->save();

        $transaction->requestTransaction();

        return $transaction;
    }

    public function requestTransaction()
    {
        $form_params = [
            'version' => '1',
            'key' => '076336aab864a9021078f7c1ff110cfc640f47d408c9fe070953b3ca5d9ff9d3',
            'cmd' => 'create_transaction',
            'amount' => $transaction->amount,
            'currency1' => $transaction->currency1,
            'currency2' => 'BTC',
            'ipn_url' => "http://testbf.xenren.co/lbpayment/coinpayment"
        ];

        $private_key = "708029D7f9D7e733AB1975711892a2d99000E16E56128Be9e8DE1574D7628Eaa";
        $url_encoded_params = http_build_query($form_params);

        $hmac = hash_hmac("sha512", $url_encoded_params, $private_key);

        $client = new Client();
        $res = $client->request('POST', 'https://www.coinpayments.net/api.php', [
            'form_params' => $form_params,
            'headers' => [
                'HMAC' => $hmac
            ],
        ]);

        $response_object = json_decode($res->getBody());

        $transaction->txn_id = $response_object->result->txn_id;
        $transaction->confirms_needed = $response_object->result->confirms_needed;
        $transaction->timeout = $response_object->result->timeout;
        $transaction->status_url = $response_object->result->status_url;
        $transaction->qrcode_url = $response_object->result->qrcode_url;
        $transaction->save();
    }

    static public function boot()
    {
        LBP_transaction::bootUuid32ModelTrait();
        LBP_transaction::saving(function ($media) {
            if (Auth::user())
            {
                if ($media->id)
                {
                    $media->updated_by = Auth::user()->id;
                }
                else
                {
                    $media->created_by = Auth::user()->id;
                }
            }
        });
    }
}

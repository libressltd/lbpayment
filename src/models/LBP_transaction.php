<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Alsofronie\Uuid\Uuid32ModelTrait;
use GuzzleHttp\Client;
use Auth;

class LBP_transaction extends Model
{
    use Uuid32ModelTrait;

    public $wallet_name;
    public $wallet_info;

    function __construct($wallet = false)
    {
        parent::__construct();
        if ($wallet)
        {
            $this->wallet_name = $wallet;
        }
        else
        {
            $this->wallet_name = config('lbpayment.default');
        }
        $this->wallet_info = config('lbpayment.wallets.'.$this->wallet_name);
    }

    public function schema()
    {
        return "bitcoin:".$this->send_to."?amount=".$this->amount;
    }

    static function addTransaction($amount, $currency)
    {
        $transaction = new LBP_transaction;
        $transaction->amount = $amount;
        $transaction->currency1 = $currency;
        $transaction->currency2 = "BTC";
        $transaction->network = "coinpayments";
        $transaction->type = "deposit";
        $transaction->save();

        $transaction->requestTransaction();

        return $transaction;
    }

    static public function addWithdrawal($amount, $currency, $wallet_id)
    {
        $transaction = new LBP_transaction;
        $transaction->amount = $amount;
        $transaction->currency1 = $currency;
        $transaction->currency2 = "BTC";
        $transaction->network = "coinpayments";
        $transaction->type = "withdrawal";
        $transaction->send_to = $wallet_id;
        $transaction->save();

        $transaction->requestWithdrawal();

        return $transaction;
    }

    public function requestWithdrawal()
    {
        $form_params = [
            'version' => '1',
            'key' => $this->wallet_info['api_key'],
            'cmd' => 'create_withdrawal',
            'amount' => abs($this->amount),
            'currency' => $this->currency1,
            'address' => $this->send_to,
            'ipn_url' => $this->wallet_info['ipn_url'],
            'auto_confirm' => 0
        ];

        $private_key = $this->wallet_info['api_secret'];
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
        if (!isset($response_object->error) || $response_object->error != "ok")
        {
            dd($response_object);
        }

        $this->txn_id = $response_object->result->id;
        $this->save();
    }

    public function requestTransaction()
    {
        $form_params = [
            'version' => '1',
            'key' => $this->wallet_info['api_key'],
            'cmd' => 'create_transaction',
            'amount' => $this->amount,
            'currency1' => $this->currency1,
            'currency2' => 'BTC',
            'ipn_url' => $this->wallet_info['ipn_url']
        ];

        $private_key = $this->wallet_info['api_secret'];
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

        $this->txn_id = $response_object->result->txn_id;
        $this->send_to = $response_object->result->address;
        $this->confirms_needed = $response_object->result->confirms_needed;
        $this->timeout = $response_object->result->timeout;
        $this->status_url = $response_object->result->status_url;
        $this->qrcode_url = $response_object->result->qrcode_url;
        $this->save();
    }

    // relationship

    public function creator()
    {
        return $this->belongsTo("App\Models\User", "created_by");
    }

    public function updater()
    {
        return $this->belongsTo("App\Models\User", "updated_by");
    }

    public function transaction()
    {
        return $this->morphTo();
    }

    static public function boot()
    {
        LBP_transaction::bootUuid32ModelTrait();
        LBP_transaction::saving(function ($transaction) {
            if (Auth::user())
            {
                if ($transaction->id)
                {
                    $transaction->updated_by = Auth::user()->id;
                }
                else
                {
                    $transaction->created_by = Auth::user()->id;
                }
            }
            if ($transaction->transaction && method_exists($transaction->transaction, "LBP_transaction_updated"))
            {
                $transaction->transaction->LBP_transaction_updated($transaction->status_id);
            }
        });
    }
}

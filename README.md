# LBPayment

Install

composer require libressltd/lbpayment

After install

Add to config/app.php, service provider

LIBRESSLtd\LBPayment\LBPaymentServiceProvider::class,

Run migration & vendor publish

```php
php artisan migration

php artisan vendor:publish --tag="lbpayment" --force
php artisan vendor:publish --tag="lbpayment_config" --force
```

Implement inside your transaction class (to handle when transaction change the status)

function LBP_transaction_updated($status)
{
	// $status
	// 0: pending
	// -1 failed
	// 1: done
}

Payments will post with a 'status' field, here are the currently defined values:
-2 = PayPal Refund or Reversal
-1 = Cancelled / Timed Out
0 = Waiting for buyer funds
1 = We have confirmed coin reception from the buyer
2 = Queued for nightly payout (if you have the Payout Mode for this coin set to Nightly)
3 = PayPal Pending (eChecks or other types of holds)
100 = Payment Complete. We have sent your coins to your payment address or 3rd party payment system reports the payment complete
For future-proofing your IPN handler you can use the following rules:
<0 = Failures/Errors
0-99 = Payment is Pending in some way
>=100 = Payment completed successfully
IMPORTANT: You should never ship/release your product until the status is >= 100 OR == 2 (Queued for nightly payout)!

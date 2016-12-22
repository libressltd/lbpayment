<?php

Route::group(['middleware' => 'web'], function () {
	Route::resource("lbpayment/coinpayment", "libressltd\lbpayment\controllers\LBPCoinpaymentController");
});

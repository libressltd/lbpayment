<?php

Route::group(['middleware' => 'web'], function () {
	Route::get("lbpayment/coinpayment", "libressltd\lbpayment\controllers\LBPCoinpamyentController");
});

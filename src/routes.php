<?php

Route::group(["prefix" => "lbmessenger", "namespace" => "libressltd\lbmessenger\controllers", "middleware" => ["web", "auth"]], function() {
	Route::resource("conversation", "LBM_conversationController");
	Route::resource("conversation.item", "LBM_conversationItemController");

	Route::resource("ajax/conversation", "Ajax\LBM_conversationController");
	Route::resource("ajax/conversation.item", "Ajax\LBM_conversationItemController");
});
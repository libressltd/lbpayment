<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLBPTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('l_b_p_transactions', function (Blueprint $table) {
            $table->char('id', 32);

            $table->decimal('amount', 10, 4);
            $table->char('transaction_id', 32)->nullable();
            $table->string('transaction_type')->nullable();

            $table->string('network');

            $table->string('currency1');
            $table->string('currency2');

            $table->string('txn_id')->nullable();
            $table->integer('confirms_needed')->nullable();
            $table->integer('timeout')->nullable();
            $table->string('status_url')->nullable();
            $table->string('qrcode_url')->nullable();


            $table->char('created_by', 32)->nullable();
            $table->char('updated_by', 32)->nullable();
            $table->timestamps();
            $table->primary('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('l_b_p_transactions');
    }
}

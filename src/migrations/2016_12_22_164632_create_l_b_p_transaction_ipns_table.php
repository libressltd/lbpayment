<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLBPTransactionIpnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('l_b_p_transaction_ipns', function (Blueprint $table) {
            $table->char('id', 32);
            $table->char('lbp_transaction_id', 32)->nullable();

            $table->string('ipn_version');
            $table->string('ipn_id');
            $table->string('ipn_mode');
            $table->string('merchant');
            $table->string('ipn_type');

            $table->string('txn_id');
            $table->integer('status');
            $table->string('status_text');
            $table->string('currency1');
            $table->string('currency2');

            $table->decimal('amount1', 10, 4);
            $table->decimal('amount2', 10, 4);
            $table->decimal('fee', 10, 4);

            $table->string('buyer_name');

            $table->decimal('received_amount', 10, 4);
            $table->integer('received_confirms');

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
        Schema::dropIfExists('l_b_p_transaction_ipns');
    }
}

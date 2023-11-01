<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableinvoicelogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tableinvoicelogs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_table_id')->constrained()->cascadeOnDelete();
            $table->date('sales_date');
            $table->json('invoice_id')->nullable();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->decimal('total_table_invoice')->nullable();
            $table->decimal('total_paid')->nullable();
            $table->unsignedBigInteger("payment_method_id")->nullable();
            $table->timestamps();

            $table->foreign('payment_method_id')->references('id')->on('payment_method')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tableinvoicelogs');
    }
}

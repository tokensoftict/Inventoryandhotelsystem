<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTableIdToAllInvoiceTableAndPaymentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->foreignId('customer_table_id')->after('department')->nullable()->constrained()->nullOnDelete();
        });

        Schema::table('invoice_items', function (Blueprint $table) {
            $table->foreignId('customer_table_id')->after('department')->nullable()->constrained()->nullOnDelete();
        });

        Schema::table('invoice_item_batches', function (Blueprint $table) {
            $table->foreignId('customer_table_id')->after('department')->nullable()->constrained()->nullOnDelete();
        });

        Schema::table('payment_method_table', function (Blueprint $table) {
            $table->foreignId('customer_table_id')->after('department')->nullable()->constrained()->nullOnDelete();
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->foreignId('customer_table_id')->after('department')->nullable()->constrained()->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropForeign('customer_table_id');
        });

        Schema::table('invoice_items', function (Blueprint $table) {
            $table->dropForeign('customer_table_id')->after('department');
        });

        Schema::table('invoice_item_batches', function (Blueprint $table) {
            $table->dropForeign('customer_table_id')->after('department');
        });

        Schema::table('payment_method_table', function (Blueprint $table) {
            $table->dropForeign('customer_table_id')->after('department');
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->dropForeign('customer_table_id')->after('department');
        });
    }
}

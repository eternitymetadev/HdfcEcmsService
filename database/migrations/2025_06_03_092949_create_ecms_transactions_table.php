<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('ecms_transactions', function (Blueprint $table) {
            $table->id();

            $table->string('transaction_id', 25)->unique();
            $table->string('remitter_name', 100)->nullable();
            $table->string('from_account_number', 70)->nullable();
            $table->string('from_bank_name', 100)->nullable();
            $table->string('utr', 22);
            $table->string('remitterifsc', 11)->nullable();
            $table->string('cheque_no', 22)->nullable();
            $table->string('narration', 150)->nullable();
            $table->string('virtual_account', 25);
            $table->decimal('amount', 17, 2);
            $table->string('transfer_mode', 20)->nullable();
            $table->dateTime('credit_date_time');
            $table->date('value_date')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ecms_transactions');
    }
};

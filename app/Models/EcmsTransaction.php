<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EcmsTransaction extends Model
{
    protected $table = 'ecms_transactions';

    protected $fillable = [
        'transaction_id',
        'remitter_name',
        'from_account_number',
        'from_bank_name',
        'utr',
        'remitterifsc',
        'cheque_no',
        'narration',
        'virtual_account',
        'amount',
        'transfer_mode',
        'credit_date_time',
        'value_date',
    ];

    protected $casts = [
        'credit_date_time' => 'datetime',
        'value_date' => 'date',
        'amount' => 'decimal:2',
    ];
}

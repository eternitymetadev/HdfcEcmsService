<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EcmsTransaction;
use Illuminate\Support\Facades\Log;

class EcmsController extends Controller
{
    public function receiveTransaction(Request $request)
    {
        // Optional Basic Auth
        if (!$this->checkAuth($request)) {
            return response()->json([
                'transactionId' => $request->transactionId ?? null,
                'code' => 401,
                'status' => 'Unauthorized'
            ], 401);
        }

        // Validate input
        $data = $request->validate([
            'transactionId'       => 'required|numeric|max:9999999999999999999999999',
            'remitterName'        => 'nullable|string|max:100',
            'fromAccountNumber'   => 'nullable|string|max:70',
            'fromBankName'        => 'nullable|string|max:100',
            'utr'                 => 'required|string|max:22',
            'remitterifsc'        => 'nullable|string|max:11',
            'chequeNo'            => 'nullable|string|max:22',
            'narration'           => 'nullable|string|max:150',
            'virtualAccount'      => 'required|string|max:25',
            'amount'              => 'required|numeric',
            'transferMode'        => 'nullable|string|max:20',
            'creditDateTime'      => 'required|date_format:Y-m-d H:i:s',
            'valueDate'           => 'nullable|date_format:d-m-Y'
        ]);

        // Check for duplicate
        if (EcmsTransaction::where('transaction_id', $data['transactionId'])->exists()) {
            return response()->json([
                'transactionId' => $data['transactionId'],
                'code' => 200,
                'status' => 'Duplicate - Already Processed'
            ]);
        }

        // Save transaction
        EcmsTransaction::create([
            'transaction_id'       => $data['transactionId'],
            'remitter_name'        => $data['remitterName'] ?? null,
            'from_account_number'  => $data['fromAccountNumber'] ?? null,
            'from_bank_name'       => $data['fromBankName'] ?? null,
            'utr'                  => $data['utr'],
            'remitterifsc'         => $data['remitterifsc'] ?? null,
            'cheque_no'            => $data['chequeNo'] ?? null,
            'narration'            => $data['narration'] ?? null,
            'virtual_account'      => $data['virtualAccount'],
            'amount'               => $data['amount'],
            'transfer_mode'        => $data['transferMode'] ?? null,
            'credit_date_time'     => $data['creditDateTime'],
            'value_date'           => isset($data['valueDate']) ? \Carbon\Carbon::createFromFormat('d-m-Y', $data['valueDate'])->toDateString() : null,
        ]);

        return response()->json([
            'transactionId' => $data['transactionId'],
            'code' => 200,
            'status' => 'Success'
        ]);
    }

    private function checkAuth(Request $request)
    {
        $expectedUsername = env('ECMS_USERNAME');
        $expectedPassword = env('ECMS_PASSWORD');

        return $request->getUser() === $expectedUsername &&
               $request->getPassword() === $expectedPassword;
    }
}

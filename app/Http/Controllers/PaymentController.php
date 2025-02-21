<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\PaymentLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    protected mixed $endpointEasyMoney;
    protected mixed $endpointSuperWalletz;

    public function __construct()
    {
        $this->endpointEasyMoney = config('services.easy_money.base_uri');
        $this->endpointSuperWalletz = config('services.super_walletz.base_uri');
    }

    public function processDeposit(Request $request)
    {
        $paymentMethod = $request->input('pay-method');

        $message = 'Invalid payment method';
        $status = 'failed';
        if ($paymentMethod === 'easymoney') {
            $validator = Validator::make($request->all(), [
                'amount' => 'required|integer',
            ]);

            if ($validator->fails()) {
                return back()->with('error', $validator->errors()->first('amount'));
            }
            $response = $this->processEasyMoney($request);
            $message = $response['message'];
            $status = $response['status'];
        } elseif ($paymentMethod === 'superwalletz') {
            $request->merge(['callback_url' => url('/super-walletz/webhook')]);
            $response = $this->processSuperWalletz($request);
            $message = $response['message'];
            $status = $response['status'];
        }
        return back()->with($status, $message);
    }

    public function processEasyMoney(Request $request)
    {
        $amount = intval($request->input('amount'));
        $currency = $request->input('currency');

        $response = Http::post($this->endpointEasyMoney, [
            'amount' => $amount,
            'currency' => $currency
        ]);

        PaymentLog::create([
            'payment_system' => 'EasyMoney',
            'request' => $request->all(),
            'response' => $response->json()
        ]);

        $status = $response->successful() ? 'success' : 'failed';
        $message = $status === 'success' ? 'Transacction Succesfully' : 'Transacction failed';
        Transaction::create([
            'payment_system' => 'EasyMoney',
            'amount' => $amount,
            'currency' => $currency,
            'status' => $status
        ]);
        return [
            'message' => $message,
            'status' => $status,
            ];
    }

    public function processSuperWalletz(Request $request)
    {
        $amount = $request->input('amount');
        $currency = $request->input('currency');
        $callbackUrl = $request->input('callback_url');

        $response = Http::post($this->endpointSuperWalletz, [
            'amount' => $amount,
            'currency' => $currency,
            'callback_url' => $callbackUrl
        ]);

        PaymentLog::create([
            'payment_system' => 'SuperWalletz',
            'request' => $request->all(),
            'response' => $response->json()
        ]);

        $status = $response->successful() ? 'success' : 'failed';
        $message = $status === 'success' ? 'Transacction Succesfully' : 'Transacction failed';
        $transaction_id = $response->json()['transaction_id'] ?? null;

        Transaction::create([
            'payment_system' => 'SuperWalletz',
            'amount' => $amount,
            'currency' => $currency,
            'status' => $status,
            'transaction_id' => $transaction_id
        ]);

        return [
            'message' => $message,
            'status' => $status,
            'transaction_id' => $transaction_id
        ];
    }

    public function handleWebhook(Request $request)
    {
        PaymentLog::create([
            'payment_system' => 'SuperWalletz-Webhook',
            'request' => $request->all()
        ]);

        // Actualizar el estado de la transacción basado en el webhook recibido
        $transaction = Transaction::where('transaction_id', $request->input('transaction_id'))->first();
        if ($transaction) {
            $transaction->update(['status' => $request->input('status')]);
        }

        return response()->json(['message' => 'Webhook received']);
    }
}

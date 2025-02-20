<?php

// app/Http/Controllers/PaymentController.php
namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\PaymentLog;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\RedirectResponse;

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
                /*return response()->json([
                    'errors' => $validator->errors()->first('amount'),
                ], Response::HTTP_BAD_REQUEST);*/
            }
            $response = $this->processEasyMoney($request);
            $message = $response['message'];
            $status = $response['status'];
        } elseif ($paymentMethod === 'superwalletz') {
            $request->merge(['callback_url' => url('/super-walletz/webhook')]);
            $response = $this->processSuperWalletz($request);
            $message = $response['message'];
            $status = $response['status'];
            if ($status === 'success') {
                return redirect($request->input('callback_url'))
                    ->with('transaction_id', $response['transaction_id'])
                    ->with('status', $status)
                    ->with('message', $message);
            }
        }
        return back()->with($status, $message);
       // return response()->json(['error' => 'Invalid payment method'], Response::HTTP_BAD_REQUEST);
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
        //return response()->json('Transacction Succesfully', $response->status());
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
        //return response()->json('Transacction Succesfully', $response->status());
    }

    public function handleWebhook(Request $request)
    {
        // Redirigir a una vista de confirmación con los datos del webhook
        return redirect()->route('confirmation')->with([
            'transaction_id' => session('transaction_id'),
            'status' => session('status'),
            'message' => session('message')
        ]);
    }
}

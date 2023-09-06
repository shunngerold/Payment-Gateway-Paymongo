<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Curl;

class PaymentController extends Controller
{
    public function pay() {
        $data = [
            'data' => [
                'attributes' => [
                    'line_items' => [
                        [
                            'currency' => 'PHP',
                            'amount' => 100000,
                            'description' => 'text',
                            'name' => 'Test Product',
                            'quantity' => 1,
                        ]
                    ],
                    'payment_method_types' => [
                        'gcash',
                        'card'
                    ],
                    'success_url' => 'http://127.0.0.1:8000/success',
                    'cancel_url' => 'http://127.0.0.1:8000/success',
                    'description' => 'text'
                ],
            ]
        ];
        $response = Curl::to('https://api.paymongo.com/v1/checkout_sessions')
                    ->withHeader('Content-Type: application/json')
                    ->withHeader('accept: application/json')
                    ->withHeader('Authorization: Basic '. env('AUTH_PAY'))
                    ->withData($data)
                    ->asJson()
                    ->post();
        \Session::put('session_id', $response->data->id);
        return redirect()->to($response->data->attributes->checkout_url);
    }
    public function success() {
        $sessionId = \Session::get('session_id');

        $response = Curl::to('https://api.paymongo.com/v1/checkout_sessions/'.$sessionId)
                    ->withHeader('accept: application/json')
                    ->withHeader('Authorization: Basic '. env('AUTH_PAY'))
                    ->asJson()
                    ->get();
        dd($response);
    }
    public function linkPay() {
        $data['data']['attributes']['amount'] = 30000;
        $data['data']['attributes']['description'] = "test desc";
        
        $response = Curl::to('https://api.paymongo.com/v1/links')
                    ->withHeader('Content-Type: application/json')
                    ->withHeader('accept: application/json')
                    ->withHeader('Authorization: Basic '. env('AUTH_PAY'))
                    ->withData($data)
                    ->asJson()
                    ->post();

        // return redirect($response->data->attributes->checkout_url);
        dd($response);
    }
    public function linkStatus($linkId) {
        $response = Curl::to('https://api.paymongo.com/v1/links/'.$linkId)
                ->withHeader('accept: application/json')
                ->withHeader('Authorization: Basic '. env('AUTH_PAY'))
                ->asJson()
                ->get();
        dd($response);
    }
}

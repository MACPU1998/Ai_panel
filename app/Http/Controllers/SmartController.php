<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;

class SmartController extends Controller
{
    public function index()
    {
        return view('admin.layouts.smarts.smart');
    }

    public function send(Request $request)
    {
        $message = $request->input('message');

        $response = "شما : " . $message;

        return response()->json([
            'reply' => $response
        ]);
    }

}

<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use App\Device;
use App\Message;

use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function receiveMessage(Request $request)
    {
        $device = Device::where('token', '=', $request->input('token'))
            ->first();
        $message = new Message([
            'body' => $request->input('body')
        ]);
        $device->messages()->save($message);
    }
}

<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use App\Device;
use App\Message;

use Illuminate\Http\Request;

class MessageController extends Controller
{
    /**
     * Handle an incoming request from a device.
     * Find the device based on the provided token and save the message body to that device
     *
     * @param Request $request
     */
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

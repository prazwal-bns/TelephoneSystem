<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Twilio\Rest\Client;

class TwilioController extends Controller
{
    public function showCallForm()
    {
        return view('call-form');
    }

    public function initiateCall(Request $request)
    {
        $request->validate([
            'phone_number' => 'required|string',
        ]);

        $twilioSid = env('TWILIO_SID');
        $twilioToken = env('TWILIO_TOKEN');
        $twilioFrom = env('TWILIO_FROM');

        $client = new Client($twilioSid, $twilioToken);

        try {
            // For trial accounts, you can only call verified numbers
            // So, we're using the 'to' number as both the 'to' and 'from' number
            $call = $client->calls->create(
                $request->phone_number, // To
                $request->phone_number, // From (must be a verified number for trial accounts)
                [
                    "url" => "http://demo.twilio.com/docs/voice.xml"
                ]
            );

            return back()->with('success', 'Call initiated successfully. SID: ' . $call->sid);
        } catch (RestException $e) {
            $errorMessage = $e->getMessage();
            if (strpos($errorMessage, 'unverified') !== false) {
                return back()->with('error', 'Error: The number you\'re trying to call is not verified. Please verify it in your Twilio console first.');
            }
            return back()->with('error', 'Error: ' . $errorMessage);
        }
    }
}

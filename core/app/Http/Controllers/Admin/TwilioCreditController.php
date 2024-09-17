<?php

namespace App\Http\Controllers\Admin;

use Session;

use App\TwilioCredit;
use App\BasicExtended;
use Twilio\Rest\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;


class TwilioCreditController extends Controller
{
    public function edit()
    {
        $data['abe'] = BasicExtended::first();
        $data['credit'] = TwilioCredit::first();
        return view('admin.twilio.twilio_credit', $data);
    }

    public function update(Request $request)
    {
        // dd($request->all());
        $messages = [
            'auth_token.required_if' => 'The smtp host field is required when smtp status is active.',
            'account_sid.required_if' => 'The from name field is required when smtp status is active.',
            'phone_number.required_if' => 'The smtp host field is required when smtp status is active.',
        ];
        $request->validate([
            'auth_token' => 'required_if:is_smtp,1',
            'account_sid' => 'required_if:is_smtp,1',
            'phone_number' => 'required_if:is_smtp,1',
        ], $messages);

        $bes = BasicExtended::all();
        foreach ($bes as $key => $be) {
            $be->is_twilio = $request->is_twilio;
            $be->save();
        }

        $credit = TwilioCredit::all();
        foreach ($credit as $key => $tc) {
            $tc->auth_token = $request->auth_token;
            $tc->account_sid = $request->account_sid;
            $tc->phone_number = $request->phone_number;
            $tc->save();
        }
        Session::flash('success', 'Twilio configuration updated successfully!');
        return back();
    }

    public function sendTestUpdate(Request $request)
    {
        $request->validate([
            'from' => 'required',
            'message' => 'required',
            'to' => 'required',
        ]);

        $credit = TwilioCredit::all();
        foreach ($credit as $key => $tc) {
            $tc->from = $request->from;
            $tc->message = $request->message;
            $tc->to = $request->to;
            $tc->save();
        }
        $credit = TwilioCredit::first();
        $twilioClient = new Client($credit->account_sid, $credit->auth_token);
        try {
            $twilioClient->messages->create(
                $credit->to,
                [
                    'from' => $credit->phone_number,
                    'body' => "$credit->from\n$credit->message",
                ]
            );

            return redirect()->back()->with('success', 'Test message sent successfully');
        } catch (\Exception $e) {
            Log::error('Twilio API Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to send test message. ' . $e->getMessage());
        }
    }
    public function verifyTextUpdate(Request $request)
    {
        $request->validate([
            'verify_page_text' => 'required|string',
        ]);

        $credit = TwilioCredit::all();

        if ($credit->isEmpty()) {
            return redirect()->back()->withErrors(['Credit not found']);
        }

        foreach ($credit as $tc) {
            $tc->verify_page_text = $request->verify_page_text;
            $tc->save();
        }

        session()->flash('success', 'Verify Text updated successfully!');
        return back();
    }
}

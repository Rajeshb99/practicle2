<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Log;
use Twilio\Rest\Client;
use Twilio\Exceptions\TwilioException;
use Twilio\Http\CurlClient;
use App\Models\WhatsAppMessage;

class WhatsAppController extends Controller
{
    public function sendWhatsAppMessage(Request $request)
    {
        try {
            // Replace these values with your actual Twilio credentials
            $accountSid = config('twilio.account_sid');
            $authToken = config('twilio.auth_token');
            $twilioNumber = config('twilio.whatsapp_number');
            $toNumber = ""; // Replace with the recipient's WhatsApp number

            // Create a new instance of CurlClient with custom cURL options
            $curlClient = new CurlClient([
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => 0,
            ]);

            // Create a new Twilio client with the custom CurlClient
            $twilio = new Client($accountSid, $authToken, null, null, $curlClient);

            // Send a WhatsApp message
            $message = $twilio->messages->create($toNumber, [
                'from' => $twilioNumber,
                'body' => $request->body,
            ]);
            // Output the SID of the sent message
            return "Message sent successfully. SID: " . $message->sid;
        } catch (TwilioException $e) {
            // Log Twilio API exceptions
            Log::error('Twilio API Exception: ' . $e->getMessage());
            return "TwilioException: " . $e->getMessage();
        } catch (\Exception $e) {
            // Log other exceptions
            Log::error('Exception: ' . $e->getMessage());
            return "Exception: " . $e->getMessage();
        }
    }

    public function receivedWhatsAppMessage(Request $request)
    {
        // Log the incoming request data for debugging (optional)
        \Log::info('Twilio WhatsApp Webhook Request:', $request->all());

        // Process the incoming message
        $from = $request->input('From');
        $body = $request->input('Body');

        if(!empty($body)){
            // Store the incoming message in the database
            WhatsAppMessage::create([
                'from' => $from,
                'body' => $body,
            ]);
        }
    }

    public function getWhatsAppMessage(Request $request)
    {
        $messages = WhatsAppMessage::latest()->paginate(5);
        
        return view('messages.index',compact('messages'))
                    ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function create(Request $request)
    {   
        return view('messages.create');
    }
}


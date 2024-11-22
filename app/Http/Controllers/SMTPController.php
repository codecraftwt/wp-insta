<?php

namespace App\Http\Controllers;

use App\Mail\TestMail;
use Illuminate\Http\Request;
use App\Models\SMPTModel;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;

class SMTPController extends Controller
{
    public function showpage()
    {
        return view("pages.smptsetting");
    }


    public function store(Request $request)
    {
        $request->validate([
            'mail_mailer' => 'required',
            'mail_host' => 'required',
            'mail_port' => 'required',
            'mail_username' => 'required',
            'mail_password' => 'required',
            'mail_encryption' => 'required',
            'mail_from_address' => 'required',
            'mail_from_name' => 'required',
            'status' => 'required',
        ]);

        SMPTModel::create($request->all());

        return redirect()->back()->with('success', 'SMTP settings saved successfully!');
    }

    public function getsmtp()
    {
        $smtpSettings = SMPTModel::all(); // Fetch all SMTP settings

        return response()->json(['data' => $smtpSettings]); // Return data in JSON format
    }
    public function toggleStatus(Request $request, $id)
    {
        $smtpSetting = SMPTModel::find($id);

        if (!$smtpSetting) {
            return response()->json(['message' => 'Not Found'], 404);
        }

        // Toggle status
        $smtpSetting->status = $request->status;
        $smtpSetting->save();

        return response()->json(['message' => 'Status updated successfully!']);
    }



    //     public function sendMail(Request $request)
    //     {

    //         $validate = Validator::make($request->all(), [
    //             'email' => 'required|email',
    //         ]);

    //         if ($validate->fails()) {

    //             return redirect()->back()->with('error', $validate->errors());
    //         }

    //         $SMTP = SMPTModel::where('status', '1')->first();


    //         if (!$SMTP) {
    //             return redirect()->back()->with('error', 'No active SMTP configuration found');
    //         }

    //         Config::set('mail.mailers.smtp.host', $SMTP->MAIL_HOST);
    //         Config::set('mail.mailers.smtp.port', $SMTP->MAIL_PORT);
    //         Config::set('mail.mailers.smtp.username', $SMTP->MAIL_USERNAME);
    //         Config::set('mail.mailers.smtp.password', $SMTP->MAIL_PASSWORD);
    //         Config::set('mail.mailers.smtp.encryption', $SMTP->MAIL_ENCRYPTION);
    //         Config::set('mail.from.address', $SMTP->MAIL_FROM_ADDRESS);
    //         Config::set('mail.from.name', $SMTP->MAIL_FROM_NAME);

    //         Mail::to($request->email)->send(new TestMail("Hiiiii"));
    //         return redirect()->back()->with('success', 'Email sent successfully');
    //     }


    public function updateSmtpSettings(Request $request)
    {
        $smtpSetting = SMPTModel::where('status', '1')->first();
        $smtpSetting->update($request->all());

        return redirect()->back()->with('success', 'SMTP settings updated successfully.');
    }

    public function destroy($id)
    {
        // Find the smtp by ID
        $smtp = SMPTModel::find($id);

        // If smtp not found, return error
        if (!$smtp) {
            return response()->json(['success' => false, 'message' => 'Permission not found'], 404);
        }

        // Delete the smtp
        $smtp->delete();

        // Return success response
        return response()->json(['success' => true, 'message' => 'Permission deleted successfully']);
    }
}

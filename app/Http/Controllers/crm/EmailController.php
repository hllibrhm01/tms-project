<?php

namespace App\Http\Controllers\crm;

use App\Http\Controllers\Controller;
use App\Libraries\MailSender;
use App\Models\crm\CRMAssignment;
use App\Models\crm\CRMAssignmentMail;
use App\Models\crm\CRMCustomer;
use App\Models\crm\CRMEmailTemplate;
use App\Models\crm\CRMCustomerMail;
use App\Models\crm\CRMMultiEmail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmailController extends Controller
{

    public function sentCustomerMail(Request $request)
    {
        if (!$request->exists("customer_id") || !$request->exists("email_template_id"))
            return response()->json((["error" => true, "message" => "E-posta şablonu bulunamadı."]));

        $emailTemplate = CRMEmailTemplate::getEmailTemplate($request->email_template_id);
        if (is_null($emailTemplate))
            return response()->json((["error" => true, "message" => "E-posta şablonu bulunamadı."]));

        $customer = CRMCustomer::getCustomerById($request->customer_id);
        $mailBody = $this->getCustomerMailFormattedContent($customer, $emailTemplate);

        $user = Auth::user();
        $mailPassword = User::getDecodeMailPassword($user);
        if (is_null($mailPassword))
            return response()->json((["error" => true, "message" => "E-posta ayarlarınız yapılandırılmamış."]));

        $mailSender = new MailSender($user->email, $mailPassword, $user->email, $user->name , true);
        $isMailSent = $mailSender->sendMail($customer->name, $customer->email, $emailTemplate->subject,  $mailBody);

        if ($isMailSent)
            CRMCustomerMail::addCustomerMail($request->customer_id, $emailTemplate->type, $mailBody);

        $emails = CRMCustomerMail::getCustomerMails($request->customer_id);
        foreach ($emails as $email)
            $email->type = config('constants.mail_types')[$email->type];

        return response()->json((["error" => false, "message" => "E-Posta gönderildi.", "emails" => $emails]));
    }

    public function sentAssignmentMail(Request $request)
    {
        if (!$request->exists("assignment_id") || !$request->exists("email_template_id"))
            return response()->json((["error" => true, "message" => "E-posta şablonu bulunamadı."]));

        $emailTemplate = CRMEmailTemplate::getEmailTemplate($request->email_template_id);
        if (is_null($emailTemplate))
            return response()->json((["error" => true, "message" => "E-posta şablonu bulunamadı."]));

        $user = Auth::user();
        $mailPassword = User::getDecodeMailPassword($user);
        if (is_null($mailPassword))
            return response()->json((["error" => true, "message" => "E-posta ayarlarınız yapılandırılmamış."]));
        $mailSender = new MailSender($user->email, $mailPassword, $user->email, $user->name, true);

        $assignment = CRMAssignment::getAssignmentById($request->assignment_id);
        $mailBody = $this->getAssignmentMailFormattedContent($assignment, $emailTemplate);
        $isMailSent = $mailSender->sendMail($assignment->name, $assignment->email, $emailTemplate->subject,  $mailBody);

        if ($isMailSent)
            CRMAssignmentMail::addAssignmentMail($request->assignment_id, $emailTemplate->type, $mailBody);

        return response()->json((["error" => false, "message" => "E-Posta gönderildi."]));
    }

    public function multiMail()
    {
        $emailTemplates = CRMEmailTemplate::getAllEmailTemplates();
        $customerSectorGroups = CRMCustomer::getSectorGroupedCustomers();
        $customerTitleGroups = CRMCustomer::getTitleGroupedCustomers();
        $assignmentsSectorGroups = CRMAssignment::getTitleGroupedAssignment();
        return view('crm.email.multi-sent', compact('emailTemplates', 'customerSectorGroups', 'customerTitleGroups', 'assignmentsSectorGroups'));
    }

    public function sendMultiMail(Request $request)
    {
        $emailTemplate = CRMEmailTemplate::getEmailTemplate($request->get("template"));

        $sector = $request->get("sector") == "ALL" ? null : $request->get("sector");
        $title = $request->get("title") == "ALL" ? null : $request->get("title");

        $user = Auth::user();
        $mailPassword = User::getDecodeMailPassword($user);

        if (is_null($mailPassword))
            return "E-posta ayarlarınız yapılandırılmamış.";

        $mailSender = new MailSender($user->email, $mailPassword, $user->email, $user->name, true);

        switch ($request->get("type")) {
            case "1":
                $customers = CRMCustomer::getCustomerBySector($sector, $title);
                foreach ($customers as $customer) {
                    $mailBody = $this->getCustomerMailFormattedContent($customer, $emailTemplate);
                    $mailSender->sendMail($customer->name, $customer->email, $emailTemplate->subject,  $mailBody);
                }
                break;
            case "2":
                $assignments = CRMAssignment::getAssignmentByTitle($sector);
                foreach ($assignments as $assignment) {
                    $mailBody = $this->getAssignmentMailFormattedContent($assignment, $emailTemplate);
                    $mailSender->sendMail($assignment->name, $assignment->email, $emailTemplate->subject,  $mailBody);
                }
                break;
        }

        CRMMultiEmail::addMultiEmail($request->get("type"), $request->get("template"), $request->get("group"), Carbon::now());
        return $request->get("group") . " mail atıldı ";
    }

    private function getCustomerMailFormattedContent($customer, $emailTemplate)
    {
        $userSignature = "";
        if (Auth::check()) {
            $signature = Auth::user()->signature;
            $signature   = env('DO_SPACE_URL') . "/" . $signature;
            $userSignature = '<p style="font-size:11pt;font-family:Calibri,sans-serif;margin-top:50px;"><img src="' . $signature . '" width="415" height="189" ></p>';
        }

        $mailBody = str_replace("[author]", $customer->author, $emailTemplate->body);
        $mailBody = str_replace("[company_name]", $customer->company_name, $mailBody);
        $mailBody = str_replace("[signature]", $userSignature, $mailBody);
        return $mailBody;
    }


    private function getAssignmentMailFormattedContent($assignment, $emailTemplate)
    {
        $userSignature = "";
        if (Auth::check()) {
            $signature = Auth::user()->signature;
            $signature   = env('DO_SPACE_URL') . "/" . $signature;
            $userSignature = '<p style="font-size:11pt;font-family:Calibri,sans-serif;margin-top:50px;"><img src="' . $signature . '" width="415" height="189" ></p>';
        }

        $mailBody = str_replace("[author]", $assignment->name, $emailTemplate->body);
        $mailBody = str_replace("[title]", $assignment->title, $mailBody);
        $mailBody = str_replace("[signature]", $userSignature, $mailBody);
        return $mailBody;
    }
}

<?php

namespace App\Http\Controllers\crm;

use App\Http\Controllers\Controller;
use App\Models\crm\CRMAssignment;
use App\Models\crm\CRMAssignmentMail;
use App\Models\crm\CRMCustomer;
use App\Models\crm\CRMCustomerMail;
use App\Models\crm\CRMCustomerPaper;
use App\Models\crm\CRMCustomerReminder;
use App\Models\crm\CRMEmailTemplate;
use App\Models\crm\CRMMeeting;
use App\Models\crm\CRMMeetingNote;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ExcelController extends Controller
{

    public function exportCustomer()
    {
        $customers = CRMCustomer::getAllCustomers();
        return view('crm.customer.excel', compact('customers'));
    }

    public function exportAssignment()
    {
        $assignments = CRMAssignment::getAllAssignments();
        $emailTemplates = CRMEmailTemplate::getAllEmailTemplates();
        return view('crm.assignment.excel', compact('assignments', 'emailTemplates'));
    }

    public function importExcel()
    {
        return view('crm.excel.index');
    }

    public function importCustomerMail(Request $request)
    {
        if (!$request->has("import_customer_mail_file"))
            return redirect()->back()->withErrors("Dosya seçiniz");

        set_time_limit(30 * 60);
        $spreadsheet = IOFactory::load($request->file('import_customer_mail_file'));
        $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

        for ($i = 0; $i < count($sheetData) + 1; $i++) {

            if ($i < 2)  // this is the heading row
                continue;
            try {
                $user_id =  ucwords($sheetData[$i]["A"]);
                $customer_id =  ucwords($sheetData[$i]["B"]);
                $type =  ucwords($sheetData[$i]["C"]);
                $body =  ucwords($sheetData[$i]["D"]);
                $sent_time =  ucwords($sheetData[$i]["E"]);
                CRMCustomerMail::importCustomerMail($customer_id, $type, $body, $sent_time);
            } catch (Exception $e) {
            }
        }
        return Redirect::route('get.crm.customer.index');
    }

    public function importAssignmentMail(Request $request)
    {
        if (!$request->has("import_assignment_mail_file"))
            return redirect()->back()->withErrors("Dosya seçiniz");

        set_time_limit(30 * 60);
        $spreadsheet = IOFactory::load($request->file('import_assignment_mail_file'));
        $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

        for ($i = 0; $i < count($sheetData) + 1; $i++) {
            if ($i < 2)  // this is the heading row
                continue;

            try {
                $user_id =  ucwords($sheetData[$i]["A"]);
                $assignment_id =  ucwords($sheetData[$i]["B"]);
                $type =  ucwords($sheetData[$i]["C"]);
                $body =  ucwords($sheetData[$i]["D"]);
                $sent_time =  ucwords($sheetData[$i]["E"]);

                CRMAssignmentMail::importAssignmentMail($assignment_id, $type, $body, $sent_time);
            } catch (Exception $e) {
                dd($e->getMessage());
            }
        }
        return Redirect::route('get.crm.customer.index');
    }

    public function importCustomerPaper(Request $request)
    {
        if (!$request->has("import_customer_paper_file"))
            return redirect()->back()->withErrors("Dosya seçiniz");

        set_time_limit(30 * 60);
        $spreadsheet = IOFactory::load($request->file('import_customer_paper_file'));
        $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

        for ($i = 0; $i < count($sheetData) + 1; $i++) {

            if ($i < 2)  // this is the heading row
                continue;
            try {
                $user_id =  ucwords($sheetData[$i]["A"]);
                $customer_id =  ucwords($sheetData[$i]["B"]);
                $type =  ucwords($sheetData[$i]["C"]);
                $description =  ucwords($sheetData[$i]["D"]);
                $path =  ucwords($sheetData[$i]["E"]);
                CRMCustomerPaper::addCustomerPaper($customer_id, $type, $description, $path);
            } catch (Exception $e) {
            }
        }
        return Redirect::route('get.crm.customer.index');
    }

    public function importCustomerReminder(Request $request)
    {
        if (!$request->has("import_customer_reminder_file"))
            return redirect()->back()->withErrors("Dosya seçiniz");

        set_time_limit(30 * 60);
        $spreadsheet = IOFactory::load($request->file('import_customer_reminder_file'));
        $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

        for ($i = 0; $i < count($sheetData) + 1; $i++) {

            if ($i < 2)  // this is the heading row
                continue;
            try {
                $user_id =  ucwords($sheetData[$i]["A"]);
                $customer_id =  ucwords($sheetData[$i]["B"]);
                $email =  ucwords($sheetData[$i]["C"]);
                $abstract =  ucwords($sheetData[$i]["D"]);
                $body =  ucwords($sheetData[$i]["E"]);
                $is_completed =  ucwords($sheetData[$i]["F"]);
                $finish_time =  ucwords($sheetData[$i]["G"]);
                CRMCustomerReminder::addCustomerReminder($customer_id, $email, $abstract, $body, $is_completed, Carbon::parse($finish_time));
            } catch (Exception $e) {
            }
        }
        return Redirect::route('get.crm.customer.index');
    }

    public function importMeeting(Request $request)
    {
        if (!$request->has("import_meeting_file"))
            return redirect()->back()->withErrors("Dosya seçiniz");

        set_time_limit(30 * 60);
        $spreadsheet = IOFactory::load($request->file('import_meeting_file'));
        $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

        for ($i = 0; $i < count($sheetData) + 1; $i++) {

            if ($i < 2)  // this is the heading row
                continue;
            try {
                $user_id =  ucwords($sheetData[$i]["A"]);
                $customer_id =  ucwords($sheetData[$i]["B"]);
                $type =  ucwords($sheetData[$i]["C"]);
                $header =  ucwords($sheetData[$i]["D"]);
                $description =  ucwords($sheetData[$i]["E"]);
                $schedule_date =  ucwords($sheetData[$i]["F"]);
                CRMMeeting::addMeeting($customer_id, $type, $header, $description, Carbon::parse($schedule_date));
            } catch (Exception $e) {
            }
        }
        return Redirect::route('get.crm.customer.index');
    }

    public function importMeetingNote(Request $request)
    {
        if (!$request->has("import_meeting_notes_file"))
            return redirect()->back()->withErrors("Dosya seçiniz");

        set_time_limit(30 * 60);
        $spreadsheet = IOFactory::load($request->file('import_meeting_notes_file'));
        $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

        for ($i = 0; $i < count($sheetData) + 1; $i++) {
            if ($i < 2)  // this is the heading row
                continue;

            try {
                $user_id =  ucwords($sheetData[$i]["A"]);
                $customer_id =  ucwords($sheetData[$i]["B"]);
                $meeting_id =  ucwords($sheetData[$i]["C"]);
                $discussed_topics =  ucwords($sheetData[$i]["D"]);
                $notes =  ucwords($sheetData[$i]["E"]);
                $to_dos =  ucwords($sheetData[$i]["E"]);
                CRMMeetingNote::addNote($customer_id, $meeting_id, $discussed_topics, $notes, $to_dos);
            } catch (Exception $e) {
            }
        }
        return Redirect::route('get.crm.customer.index');
    }

    public function importEmailTemplate(Request $request)
    {
        if (!$request->has("import_email_template_file"))
            return redirect()->back()->withErrors("Dosya seçiniz");

        set_time_limit(30 * 60);
        $spreadsheet = IOFactory::load($request->file('import_email_template_file'));
        $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

        for ($i = 0; $i < count($sheetData) + 1; $i++) {
            if ($i < 2)  // this is the heading row
                continue;

            try {
                $user_id =  ucwords($sheetData[$i]["A"]);
                $type =  ucwords($sheetData[$i]["B"]);
                $name =  ucwords($sheetData[$i]["C"]);
                $subject =  ucwords($sheetData[$i]["D"]);
                $body =  ucwords($sheetData[$i]["E"]);
                CRMEmailTemplate::addEmailTemplate($type, $name, $subject, $body);
            } catch (Exception $e) {
            }
        }
        return Redirect::route('get.crm.customer.index');
    }

    public function importCustomerExcel(Request $request)
    {
        if (!$request->has("import_customer_file"))
            return redirect()->back()->withErrors("Dosya seçiniz");

        set_time_limit(30 * 60);
        $spreadsheet = IOFactory::load($request->file('import_customer_file'));
        $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

        for ($i = 0; $i < count($sheetData) + 1; $i++) {
            if ($i < 2)  // this is the heading row
                continue;

            try {
                $no =  ucwords($sheetData[$i]["A"]);
                $companyName =  ucwords($sheetData[$i]["B"]);
                $sector =  ucwords($sheetData[$i]["C"]);
                $author =  ucwords($sheetData[$i]["D"]);
                $title =  ucwords($sheetData[$i]["E"]);
                $email =  ucwords($sheetData[$i]["F"]);
                $phone =  ucwords($sheetData[$i]["G"]);
                $callContent =  ucwords($sheetData[$i]["H"]);
                $callDetail =  ucwords($sheetData[$i]["I"]);
                $note =  ucwords($sheetData[$i]["J"]);

                $phone = str_replace("T", "", $phone);
                $phone = str_replace(":", "", $phone);
                $phone = str_replace("-", "", $phone);

                $request = new Request([
                    'company_name'   => $companyName,
                    'sector' => $sector,
                    'author' => $author,
                    'title' =>  $title,
                    'email' => $email,
                    'phone' =>  $phone,
                    'call_content' => $callContent,
                    'call_detail' => $callDetail,
                    'note' =>  $note,
                ]);

                if (empty($companyName))
                    continue;

                CRMCustomer::addCustomer($request);
            } catch (Exception $e) {
            }
        }
        return Redirect::route('get.crm.customer.index');
    }

    public function importAssignmentExcel(Request $request)
    {
        if (!$request->has("import_assignment_file"))
            return redirect()->back()->withErrors("Dosya seçiniz");

        set_time_limit(30 * 60);
        $spreadsheet = IOFactory::load($request->file('import_assignment_file'));
        $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

        for ($i = 0; $i < count($sheetData) + 1; $i++) {
            if ($i < 2)  // this is the heading row
                continue;

            try {
                $companyName =  ucwords($sheetData[$i]["A"]);
                $sector =  ucwords($sheetData[$i]["B"]);
                $name =  ucwords($sheetData[$i]["C"]);
                $title =  ucwords($sheetData[$i]["D"]);
                $email =  ucwords($sheetData[$i]["E"]);
                $phone =  ucwords($sheetData[$i]["F"]);
                $note =  ucwords($sheetData[$i]["G"]);

                $phone = str_replace("T", "", $phone);
                $phone = str_replace(":", "", $phone);
                $phone = str_replace("-", "", $phone);

                if (empty($companyName))
                    continue;


                CRMAssignment::addAssignment($companyName, $sector, $name, $title, $email, $phone, $note);
            } catch (Exception $e) {
            }
        }
        return Redirect::route('get.crm.assignment.index');
    }
}

<?php

namespace App\Http\Controllers\crm;

use App\Http\Controllers\Controller;
use App\Http\Requests\crm\EmailTemplateRequest;
use App\Models\crm\CRMEmailTemplate;
use Illuminate\Support\Facades\Redirect;

class EmailTemplateController extends Controller
{
    public function index()
    {
        $emailTemplates = CRMEmailTemplate::getAllEmailTemplates();
        return view('crm.email.templates.index', compact('emailTemplates'));
    }

    public function add()
    {
        return view('crm.email.templates.add');
    }

    public function store(EmailTemplateRequest $request)
    {
        CRMEmailTemplate::addEmailTemplate($request->type, $request->name, $request->subject, $request->body);
        return Redirect::route('get.crm.email.templates.index');
    }

    public function edit($id)
    {
        $emailTemplate = CRMEmailTemplate::getEmailTemplate($id);

        if (is_null($emailTemplate))
            return Redirect::route('get.crm.email.templates.index');

        return view('crm.email.templates.edit', compact('emailTemplate'));
    }

    public function update(EmailTemplateRequest $request, $id)
    {
        CRMEmailTemplate::editEmailTemplate($id, $request->type, $request->name, $request->subject, $request->body);
        return Redirect::route('get.crm.email.templates.index');
    }

    public function delete($id)
    {
        CRMEmailTemplate::deleteEmailTemplate($id);
        return Redirect::route('get.crm.email.templates.index');
    }
}

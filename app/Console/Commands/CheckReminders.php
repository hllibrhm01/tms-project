<?php

namespace App\Console\Commands;

use App\Libraries\MailSender;
use App\Models\crm\CRMCustomer;
use App\Models\crm\CRMCustomerReminder;
use Illuminate\Console\Command;

class CheckReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check Reminders';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $mailSender = new MailSender(env('MAIL_USERNAME'), env('MAIL_PASSWORD'), env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME') , false);
        $uncompletedReminders = CRMCustomerReminder::getUncompletedReminders();
        foreach ($uncompletedReminders as $uncompletedReminder) {
            try{
                $customer =  CRMCustomer::getCustomerById($uncompletedReminder->customer_id);
                $body = "Firma : " .  $customer->company_name . " Mesaj : " . $uncompletedReminder->body;
                $mailSender->sendMail($uncompletedReminder->email, $uncompletedReminder->email, $uncompletedReminder->abstract, $body);
            }
            catch (\Exception $e) {
                $uncompletedReminder->is_completed = 1;
                $uncompletedReminder->save();
            }
        }

        return Command::SUCCESS;
    }
}

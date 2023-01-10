<?php

namespace App\Console\Commands;

use App\Models\tms\TMSOrder;
use App\Models\tms\TMSVehiclePlan;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SetExpiredOrdersAsNotCompleted extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'expired-order-checker';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checking yesterday orders and set as not completed if not delivered';

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
        $tmsOrders = TMSVehiclePlan::whereHas("order", function ($query) {
            $query->where(function ($q) {
                return $q
                    ->where('status', '!=', TMSOrder::STATUS_COMPLETED)
                    ->where('status', '!=', TMSOrder::STATUS_BROKEN)
                    ->where('status', '!=', TMSOrder::STATUS_PENDING_REVIEW)
                    ->where('status', '!=', TMSOrder::STATUS_NOT_COMPLETED);
            });
        })->where("plan_date", "<", Carbon::now()->format('Y-m-d'))->get();

        foreach ($tmsOrders as $tmsOrder) {
            $tmsOrder->order->status = TMSOrder::STATUS_NOT_COMPLETED;
            $tmsOrder->order->save();
        }

        // WMS Orders will be placed in here

        return $this->info("Status updated.Count : " . count($tmsOrders));
    }
}

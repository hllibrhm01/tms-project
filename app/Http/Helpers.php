<?php

use App\Helper\TMSOrderHelper;
use App\Libraries\MailSender;
use App\Models\GeneralSetting;
use App\Models\Notification;
use App\Models\tms\TMSCustomerAuthor;
use App\Models\User;

if (!function_exists('app_path')) { // Bunu bulamadığı için log yazıyordu ekledim.
    /**
     * Get the path to the application folder.
     *
     * @param  string $path
     * @return string
     */
    function app_path($path = '')
    {
        return app('path') . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }
}

if (!function_exists('public_path')) {
    function public_path($path = '')
    {
        return env('PUBLIC_PATH', base_path('public')) . ($path ? '/' . $path : $path);
    }
}

if (!function_exists('null_if_empty')) {
    function null_if_empty($value)
    {
        return !empty(trim($value)) ? $value : null;
    }
}

if (!function_exists('generate_random_string')) {
    function generate_random_string($length = 16)
    {
        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        return substr(str_shuffle(str_repeat($pool, 5)), 0, $length);
    }
}

if (!function_exists('do_space_url')) {
    function do_space_url($path = null)
    {
        if (is_null($path))
            return env('DO_SPACE_URL');

        if (str_starts_with($path, "/"))
            return env('DO_SPACE_URL') .  $path;

        if (str_ends_with(env('DO_SPACE_URL'), "/"))
            return env('DO_SPACE_URL') .  $path;

        return env('DO_SPACE_URL') . DIRECTORY_SEPARATOR . $path;
    }
}


if (!function_exists('generate_verification_code')) {
    function generate_verification_code($length = 6)
    {
        $pool = '0123456789';

        return substr(str_shuffle(str_repeat($pool, 5)), 0, $length);
    }
}



if (!function_exists('send_order_notification')) {
    function send_order_notification($order, $vehicle)
    {
        $generalSettings = GeneralSetting::getSettings();
        if (in_array($order->status, json_decode($generalSettings->dealer_notify_mandatory_status))) {
            $customerAuthors = TMSCustomerAuthor::getCustomerAuthors($order->owner_id);
            $notificationBody = TMSOrderHelper::getNotificationBody($order,  $vehicle);
            foreach ($customerAuthors as $author) {
                $notification = Notification::addNotification($order->id, $order->status, $author->name, $author->phone, $author->email, $notificationBody);
                if (!is_null($notification)) {
                    $mailSender = new MailSender(env('MAIL_USERNAME'), env('MAIL_PASSWORD'), env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'), false);
                    $mailSender->sendMail($notification->name, $notification->email, env('NOTIFICATION_TITLE'), $notification->content);
                }
            }
        }

        if (in_array($order->status, json_decode($generalSettings->planner_notify_mandatory_status))) {
            send_notification_to_planners($order, "Planner");
        }

        if (in_array($order->status, json_decode($generalSettings->orderer_notify_mandatory_status))) {
            $notificationBody = TMSOrderHelper::getNotificationBody($order,  $vehicle);
            $notification = Notification::addNotification($order->id, $order->status, $order->orderer_name, $order->orderer_phone, $order->orderer_email, $notificationBody);
            if (!is_null($notification)) {
                // sms gidecek
                $mailSender = new MailSender(env('MAIL_USERNAME'), env('MAIL_PASSWORD'), env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'), false);
                $mailSender->sendMail($notification->name, $notification->email, env('NOTIFICATION_TITLE'), $notification->content);
            }
        }
        return true;
    }
}


if (!function_exists('send_notification_to_planners')) {
    function send_notification_to_planners($order , $type)
    {
        $notificationBody = TMSOrderHelper::getPlannerNotificationBody($order , $type);
        $planners = User::getUsersByRole("Planner");
        foreach ($planners as $planner) {
            $notification = Notification::addNotification($order->id, $order->status, $planner->name, "", $planner->email, $notificationBody);
       
            if (!is_null($notification)) {
                $mailSender = new MailSender(env('MAIL_USERNAME'), env('MAIL_PASSWORD'), env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'), false);
                $mailSender->sendMail($notification->name, $notification->email, env('NOTIFICATION_TITLE'), $notification->content);
            }
        }

        return true;
    }
}

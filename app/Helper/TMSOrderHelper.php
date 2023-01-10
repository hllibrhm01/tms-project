<?php

namespace App\Helper;

use App\Libraries\Hasher;
use App\Models\tms\TMSOrder;

class TMSOrderHelper
{
    public static function getNextStatus($order)
    {
        $nextStatus = [];
        $status = $order->status;
        $orderType = $order->order_type;
        switch ($status) {
            case TMSOrder::STATUS_RECEIVED:
                if ($orderType == TMSOrder::ORDER_TYPE_FAST) {
                    $nextStatus[] = [
                        "id" => TMSOrder::STATUS_ON_ROAD,
                        "value" => TMSOrder::OrderStatus[TMSOrder::STATUS_ON_ROAD]
                    ];
                } else {
                    $nextStatus[] = [
                        "id" => TMSOrder::STATUS_ON_VEHICLE,
                        "value" => TMSOrder::OrderStatus[TMSOrder::STATUS_ON_VEHICLE]
                    ];
                }
                break;
            case TMSOrder::STATUS_ON_VEHICLE:
                $nextStatus[] = [
                    "id" => TMSOrder::STATUS_ON_ROAD,
                    "value" => TMSOrder::OrderStatus[TMSOrder::STATUS_ON_ROAD]
                ];
                $nextStatus[] = [
                    "id" => TMSOrder::STATUS_RECEIVED,
                    "value" => TMSOrder::OrderStatus[TMSOrder::STATUS_RECEIVED]
                ];
                break;
            case TMSOrder::STATUS_ON_ROAD:
                if ($orderType == TMSOrder::ORDER_TYPE_FAST) {
                    $nextStatus[] = [
                        "id" => TMSOrder::STATUS_COMPLETED,
                        "value" => TMSOrder::OrderStatus[TMSOrder::STATUS_COMPLETED]
                    ];
                    $nextStatus[] = [
                        "id" => TMSOrder::STATUS_BROKEN,
                        "value" => TMSOrder::OrderStatus[TMSOrder::STATUS_BROKEN]
                    ];
                } else {
                    $nextStatus[] = [
                        "id" => TMSOrder::STATUS_ON_ADDRESS,
                        "value" => TMSOrder::OrderStatus[TMSOrder::STATUS_ON_ADDRESS]
                    ];
                    $nextStatus[] = [
                        "id" => TMSOrder::STATUS_NOT_COMPLETED,
                        "value" => TMSOrder::OrderStatus[TMSOrder::STATUS_NOT_COMPLETED]
                    ];
                }
                break;
            case TMSOrder::STATUS_ON_ADDRESS:
                $nextStatus[] = [
                    "id" => TMSOrder::STATUS_ON_EXPLORE,
                    "value" => TMSOrder::OrderStatus[TMSOrder::STATUS_ON_EXPLORE]
                ];
                break;
            case TMSOrder::STATUS_ON_EXPLORE:
                $nextStatus[] = [
                    "id" => TMSOrder::STATUS_READY_TO_INSTALL,
                    "value" => TMSOrder::OrderStatus[TMSOrder::STATUS_READY_TO_INSTALL]
                ];
                $nextStatus[] = [
                    "id" => TMSOrder::STATUS_NOT_READY_TO_INSTALL,
                    "value" => TMSOrder::OrderStatus[TMSOrder::STATUS_NOT_READY_TO_INSTALL]
                ];
                break;
            case TMSOrder::STATUS_READY_TO_INSTALL:
                $nextStatus[] = [
                    "id" => TMSOrder::STATUS_INSTALLED,
                    "value" => TMSOrder::OrderStatus[TMSOrder::STATUS_INSTALLED]
                ];
                $nextStatus[] = [
                    "id" => TMSOrder::STATUS_BROKEN,
                    "value" => TMSOrder::OrderStatus[TMSOrder::STATUS_BROKEN]
                ];
                break;
            case TMSOrder::STATUS_NOT_READY_TO_INSTALL:
                $nextStatus[] = [
                    "id" => TMSOrder::STATUS_NOT_READY_TO_INSTALL,
                    "value" => TMSOrder::OrderStatus[TMSOrder::STATUS_NOT_READY_TO_INSTALL]
                ];
                break;
            case TMSOrder::STATUS_INSTALLED:
                $nextStatus[] = [
                    "id" => TMSOrder::STATUS_PENDING_REVIEW,
                    "value" => TMSOrder::OrderStatus[TMSOrder::STATUS_PENDING_REVIEW]
                ];
                $nextStatus[] = [
                    "id" => TMSOrder::STATUS_CONFIRM_WITH_DELIVERY_RECEIPT,
                    "value" => TMSOrder::OrderStatus[TMSOrder::STATUS_CONFIRM_WITH_DELIVERY_RECEIPT]
                ];
                break;
            case TMSOrder::STATUS_CONFIRM_WITH_DELIVERY_RECEIPT:
                $nextStatus[] = [
                    "id" => TMSOrder::STATUS_CONFIRM_WITH_DELIVERY_RECEIPT,
                    "value" => TMSOrder::OrderStatus[TMSOrder::STATUS_CONFIRM_WITH_DELIVERY_RECEIPT]
                ];
                break;
            case TMSOrder::STATUS_WAITING_FOR_CONFIRMATION:
                break;
            case TMSOrder::STATUS_PENDING_REVIEW:
                break;
            case TMSOrder::STATUS_BROKEN:
                break;
            case TMSOrder::STATUS_COMPLETED:
                break;
            case TMSOrder::STATUS_NOT_COMPLETED: 
                break;
        }
        return $nextStatus;
    }

    public static function getNotificationBody($order, $vehicle)
    {
        $hashedOrderId = Hasher::encode($order->id);
        $hashedVehicleId = Hasher::encode($order->vehicle_id);
        // $hashedVehicleId = Hasher::encode($vehicle->id);
        $followLink = route('get.tms.order.tracking.notification') . "?oid=" . $hashedOrderId;
        $surveyLink = route('get.tms.survey') . "?oid=" . $hashedOrderId . "&vid=" . $hashedVehicleId;

        $body = '';
        switch ($order->status) {
            case TMSOrder::STATUS_RECEIVED:
                $body = "Siparişiniz alındı. İşlem sonucunda kullanacağınız 6 haneli şifreniz: " . $order->sms_verification_code . "  .Takip etmek için <a href='$followLink'> tıklayınız </a>";
                break;
            case TMSOrder::STATUS_ON_VEHICLE:
                $body = "Siparişiniz araca yüklendi. İşlem sonucunda kullanacağınız 6 haneli şifreniz: " . $order->sms_verification_code . " .Takip etmek için <a href='$followLink'> tıklayınız </a>";
                break;
            case TMSOrder::STATUS_ON_ROAD:
                $body = "Siparişiniz yola çıktı. İşlem sonucunda kullanacağınız 6 haneli şifreniz: " . $order->sms_verification_code . " .Takip etmek için <a href='$followLink'> tıklayınız </a>";
                break;
            case TMSOrder::STATUS_ON_ADDRESS:
                $body = "Siparişiniz adresinize ulaştı. Ekibimiz keşif için adresinize ulaşacaktır.  İşlem sonucunda kullanacağınız 6 haneli şifreniz: " . $order->sms_verification_code . " .Takip etmek için <a href='$followLink'> tıklayınız </a>";
                break;
            case TMSOrder::STATUS_ON_ROAD;
                $body = "Siparişiniz yola çıktı. İşlem sonucunda kullanacağınız 6 haneli şifreniz: " . $order->sms_verification_code . " .Takip etmek için <a href='$followLink'> tıklayınız </a>";
                break;
            case TMSOrder::STATUS_ON_EXPLORE:
                $body = "Siparişinizin kurulumu için keşif yapılıyor. İşlem sonucunda kullanacağınız 6 haneli şifreniz: " . $order->sms_verification_code . " .Takip etmek için <a href='$followLink'> tıklayınız </a>";
                break;
            case TMSOrder::STATUS_READY_TO_INSTALL:
                $body = "Siparişinizin kuruluma hazır. İşlem sonucunda kullanacağınız 6 haneli şifreniz: " . $order->sms_verification_code . " .Takip etmek için <a href='$followLink'> tıklayınız </a>";
                break;
            case TMSOrder::STATUS_NOT_READY_TO_INSTALL:
                $body = "Siparişinizin kurulumu için gerekli koşullar sağlanamadı. İşlem sonucunda kullanacağınız 6 haneli şifreniz: " . $order->sms_verification_code . " .Takip etmek için <a href='$followLink'> tıklayınız </a>";
                break;
            case TMSOrder::STATUS_INSTALLED:
                $body = "Siparişinizin kurulumu tamamlandı. İşlem sonucunda kullanacağınız 6 haneli şifreniz: " . $order->sms_verification_code . " .Takip etmek için <a href='$followLink'> tıklayınız </a>";
                break;
            case TMSOrder::STATUS_WAITING_FOR_CONFIRMATION:
                $body = "Siparişin onayı için cep telefonunuza kod gönderildi. İşlem sonucunda kullanacağınız 6 haneli şifreniz: " . $order->sms_verification_code . " .Takip etmek için <a href='$followLink'> tıklayınız </a>";
                break;
            case TMSOrder::STATUS_PENDING_REVIEW:
                $body = "Siparişiniz için oluşturulan anketimizi doldurmak için <a href='$surveyLink'> tıklayınız </a>";
                break;
            case TMSOrder::STATUS_BROKEN:
                $body = "Siparişinizde hasar tespit edildi. İşlem sonucunda kullanacağınız 6 haneli şifreniz: " . $order->sms_verification_code . " .Takip etmek için <a href='$followLink'> tıklayınız </a>";
                break;
            case TMSOrder::STATUS_COMPLETED:
                $body = "Siparişinizin tüm süreçleri tamamlandı. Takip etmek için <a href='$followLink'> tıklayınız </a>";
                break;
            case TMSOrder::STATUS_NOT_COMPLETED:
                $body = "Siparişiniz tamamlanamadı. Takip etmek için <a href='$followLink'> tıklayınız </a>";
                break;
        }
        return $body;
    }

    public static function getPlannerNotificationBody($order, $type)
    {
        $body = '';
        switch ($type) {
            case TMSOrder::PLANNER_NOTIFICATION_TYPE_PREORDER_RECEIVED:
                $followLink = route('get.tms.preorder.view', ['id' => $order->id]);
                $body = "Ön sipariş oluşturuldu. Siparişi incelemek için <a href='$followLink'> tıklayınız </a>";
                break;
            case TMSOrder::PLANNER_NOTIFICATION_TYPE_FAST_ORDER_RECEIVED:
                $followLink = route('get.tms.preorder.view', ['id' => $order->id]); // fast order
                $body = "Hızlı sipariş oluşturuldu. Siparişi incelemek için <a href='$followLink'> tıklayınız </a>";
                break;
        }
        return $body;
    }
}

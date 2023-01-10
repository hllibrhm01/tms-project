<?php

namespace App\Http\Controllers\tms;

use App\Http\Controllers\Controller;
use App\Http\Requests\tms\SurveyRequest;
use App\Libraries\Hasher;
use App\Models\tms\TMSOrder;
use App\Models\tms\TMSSurvey;

class SurveyController extends Controller
{
    public function survey(SurveyRequest $request)
    {
        $orderId = $request->oid;
        $vehicleId = $request->vid;

        $orderData = Hasher::decode($orderId);
        $vehicleData = Hasher::decode($vehicleId);

        if (!$orderData || !$vehicleData)
            return view('tms.survey.error');

        $isSurveyAnswered = TMSSurvey::isSurveyAnswered($vehicleData, $orderData);
        if ($isSurveyAnswered)
            return view('tms.survey.answered');

        return view('tms.survey.survey', compact('orderId', 'vehicleId'));
    }

    public function send(SurveyRequest $request)
    {
        $orderIdData = $request->oid;
        $vehicleIdData = $request->vid;

        $orderId = Hasher::decode($orderIdData);
        $vehicleId = Hasher::decode($vehicleIdData);
        if (!$orderId || !$vehicleId)
            return view('tms.survey.error');

        $survey = TMSSurvey::addSurvey(
            $orderId,
            $vehicleId,
            $request->etiquette_point,
            $request->safefy_rule_point,
            $request->work_area_cleaning_point,
            $request->service_quality_point
        );

        if (is_null($survey))
            return view('tms.survey.answered');

        $order = TMSOrder::getOrder($orderId);
        if (is_null($order))
            TMSOrder::surveyCompleted($order);

        TMSOrder::surveyCompleted($order);
        return view('tms.survey.success');
    }
}

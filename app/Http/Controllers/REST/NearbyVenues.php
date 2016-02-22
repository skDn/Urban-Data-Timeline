<?php
/**
 * Created by IntelliJ IDEA.
 * User: yordanyordanov
 * Date: 03/01/2016
 * Time: 14:36
 */
namespace Urban\Http\Controllers\REST;

use Illuminate\Http\Request;
use Urban\Http\Controllers\Controller;
use Urban\Models\BusyVenues;
use Validator;

class NearbyVenues extends Controller
{
    public function getNearbyVenues(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules());
        $response = array(
            "status" => null,
            "message" => null,
        );

        if ($validator->fails()) {
            $response['status'] = 'failed';
            $response['message'] = $validator->errors()->all();
            return json_encode($response);
        }

        $lat = $request->get('lat');
        $lng = $request->get('lng');
        /**
         * making radius an optional parameter
         */
        $radius = $request->has('radius') ? $request->get('radius') : 0.05;
        $venues = new BusyVenues($lat,$lng,'2015-07-01',$radius);

        $message = $venues->getVenuesNearBy();
        if(count($message) == 0 )
        {
            $response['status'] = 'failed';
            $response['message'] = 'No response from services';
            return json_encode($response);
        }

        $response['status'] = 'OK';
        $response['message'] = $message;
        return json_encode($response);

    }

    private function rules()
    {
        return [
//            digits_between:min,max for lat/lng
            'lat' => 'required',
            'lng' => 'required',
        ];
    }
}

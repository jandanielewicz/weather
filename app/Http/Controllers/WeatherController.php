<?php

namespace App\Http\Controllers;

use App\Classes\Weather;
use App\Notifications\WeatherAlert;
use App\Helpers\CustomJsonResponse;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Notification;

class WeatherController extends Controller
{
    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        return $this->runApiForGivenTypeWithCoordinatesFromInputOrUser($request, 'today');
    }


    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function forecast(Request $request)
    {
        return $this->runApiForGivenTypeWithCoordinatesFromInputOrUser($request, 'forecast');
    }

    public function history5days(Request $request)
    {
        return $this->runApiForGivenTypeWithCoordinatesFromInputOrUser($request, 'history5days');
    }

    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function alert(Request $request)
    {
        $user = User::find(Auth()->user()->id);
        $settings = config('weather');

        $json = $this->runApiForGivenTypeWithCoordinatesFromInputOrUser($request, 'today');

        $json = json_decode($json, true);
        $finalWeatherCode = $json['forecast']['weather'][0]['id'];
        $finalWeatherMain = $json['forecast']['weather'][0]['main'];
        $finalWeatherDescription = $json['forecast']['weather'][0]['description'];
        $arrayOfWeatherForAlerts = $settings['alertCodes'];
        $firstCodeDigit = substr($finalWeatherCode, 0, 1);

        $rainNotification = $user->settings()->get('rain') == true && $firstCodeDigit == 5;
        $snowNotification = $user->settings()->get('snow') == true && $firstCodeDigit == 6;
        $drizzleNotification = $user->settings()->get('drizzle') == true && $firstCodeDigit == 3;
        $stormNotification = $user->settings()->get('storm') == true && $firstCodeDigit == 2;
        $atmosphereNotification = $user->settings()->get('atmosphere') == true && $firstCodeDigit == 7;


        if (in_array($finalWeatherCode, $arrayOfWeatherForAlerts)
        ) {
            if ($rainNotification
                || $snowNotification
                || $drizzleNotification
                || $stormNotification
                || $atmosphereNotification
            ) {

                Notification::send($user, new WeatherAlert($finalWeatherMain, $finalWeatherDescription));
                return json_encode(['success']);
            }

        }



    }

    private function runApiForGivenTypeWithCoordinatesFromInputOrUser(Request $request, $type) {
        $long = $request->input('long');
        $lat = $request->input('lat');

        if (empty($long) || empty ($lat)) {
            $user = Auth()->user();
            $lat = $user->settings()->get('lat');
            $long = $user->settings()->get('long');
        }

        $weather = new Weather();
        $weatherJson = $weather->getWeatherDataByCoordinates($long, $lat, $type);
        return json_encode($weatherJson);
    }

}

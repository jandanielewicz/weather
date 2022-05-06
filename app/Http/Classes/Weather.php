<?php

namespace App\Classes;

use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use GuzzleHttp;

class Weather
{

    private $urlPartsForTypes = [
        'today' => 'weather',
        'forecast' => 'forecast',
        'history5days' => 'onecall/timemachine',
        'alert' => 'onecall',
    ];

    protected $settings;

    function __construct()
    {
        $this->settings = config('weather');

        if (empty($this->settings)) {
            abort(500, 'No settings found!');
        }
    }

    /**
     * Get weather by coordinates.
     *
     * @param $long
     * @param $lat
     * @param string $type
     * @param null $provider
     * @param bool $refresh
     * @return array|mixed
     * @throws GuzzleHttp\Exception\GuzzleException
     */
    function getWeatherDataByCoordinates($long, $lat, $type = 'today')
    {
        $weather = array();

        if ($this->settings['sessionEnabled']) {
            if ($weatherSession = Session::get($type)) {
                $weather = json_decode($weatherSession, true);
            }
        }

        if (empty($weather) and $long and $lat) {

            $appId =  $this->settings['appid'];

            $typeURlPart = $this->urlPartsForTypes[$type];
            $url = "https://api.openweathermap.org/data/2.5/$typeURlPart?appid=$appId&lat=$lat&lon=$long&units=metric&mode=json&lang=en";
            $url = $this->addStringToQueryByType($type, $url);
            $json = $this->sendGuzzleRequest($url);

            if (!empty($json)) {
                $decodedArray = json_decode($json, true);
                if ($type == 'forecast' && !empty($decodedArray['list'])) {
                    $i = 0;
                    foreach ($decodedArray['list'] as $forecast) {
                        $forecast['day'] = Carbon::createFromTimestamp($forecast['dt'])->format('l');;
                        $forecast['date'] = Carbon::createFromTimestamp($forecast['dt'])->format('M/D/Y');;

                        $decodedArray['list'][$i] = $forecast;
                        $i++;
                    }
                }
                $weather['forecast'] = $decodedArray;
            }

            if ($type == 'today') {
                $url = "http://api.openweathermap.org/data/2.5/$typeURlPart?appid=$appId&lat=$lat&lon=$long&units=metric&mode=json&lang=en";
                $json = $this->sendGuzzleRequest($url);

                if (!empty($json)) {
                    $decodedArray = json_decode($json, true);
                    if (!empty($json)) {
                        $decodedArray = json_decode($json, true);
                        $decodedArray['day'] = Carbon::createFromTimestamp($decodedArray['dt'])->format('l');
                        $decodedArray['date'] = Carbon::createFromTimestamp($decodedArray['dt'])->format('M/D/Y');
                    }

                    $weather['current'] = $decodedArray;
                }
            }


            if ($this->settings['sessionEnabled']) {
                //Store in session
                Session::put($type, json_encode($weather), $this->settings['sessionTimeout']);
            }

        }

        return $weather;
    }

    /**
     *
     * @param $type
     * @param $url
     * @return string
     */
    private function addStringToQueryByType($type, $url)
    {
        if ($type == 'forecast') {
            $url .= '&cnt=7';
        } else if ($type == 'alert') {
            $url .= "&exclude=hourly,daily";
        } else if ( $type == 'history5days') {
            $carbonTimeSubstract = Carbon::now()->subDays(5)->timestamp;
            $url .= "&dt=$carbonTimeSubstract";
        }
        return $url;
    }

    /**
     * @param $url
     * @return string
     * @throws GuzzleHttp\Exception\GuzzleException
     */
    private function sendGuzzleRequest($url)
    {
        $guzzle = new GuzzleHttp\Client();
        $response = $guzzle->request('GET', $url);
        $body = $response->getBody();

        return is_object($body) ? $body->getContents() : null;
    }


}

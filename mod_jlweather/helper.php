<?php
/**
 * Mod JLweather
 *
 * @version 2.3
 * @author Anton Voynov (anton@joomline.ru)
 * @copyright (C) 2011 by Anton Voynov(http://www.joomline.ru)
 * @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
 **/


// no direct access
defined('_JEXEC') or die;
use Joomla\Registry\Registry as JRegistry;

class modJLWeatherHelper
{

    private static
        $currentWeatherUrl = 'http://api.openweathermap.org/data/2.5/weather?id=%s&appid=%s&mode=json&lang=ru&units=metric',
        $fiveDayWeatherUrl = 'http://api.openweathermap.org/data/2.5/forecast?id=%s&appid=%s&mode=json&lang=ru&units=metric'
    ;

    private static function getWeather($params, $type='current')
    {
        $key = $params->get('key');
        $cid = $params->get('city');
        $url = $type=='current' ? self::$currentWeatherUrl : self::$fiveDayWeatherUrl;
        $url = JText::sprintf($url, $cid, $key);

        $file = @file_get_contents($url);

        if($file == false){
            echo 'Current weather file empty';
            return false;
        }

        $json = json_decode($file, true);

        if($json == null){
            echo 'Current weather file decoding error';
            return false;
        }
        else if(empty($json['cod']) || $json['cod'] != 200){
            echo 'Current weather '.$json['message'];
            return false;
        }

        return $json;
    }

    private static function getTextTime($timestamp, $hoffset){

        $time = date ('H:i',$timestamp+$hoffset);
        return $time;
    }

    private static function getTextWindDeg($windDeg)
    {
        $text = '';
        if($windDeg >= 0 && $windDeg < 22.5){
            $text = 'северный';
        }
        else if($windDeg >= 22.5 && $windDeg < 67.5){
            $text = 'северо-восточный';
        }
        else if($windDeg >= 67.5 && $windDeg < 112.5){
            $text = 'восточный';
        }
        else if($windDeg >= 112.5 && $windDeg < 157.5){
            $text = 'юго-восточный';
        }
        else if($windDeg >= 157.5 && $windDeg < 202.5){
            $text = 'южный';
        }
        else if($windDeg >= 202.5 && $windDeg < 247.5){
            $text = 'юго-западный';
        }
        else if($windDeg >= 247.5 && $windDeg < 292.5){
            $text = 'западный';
        }
        else if($windDeg >= 292.5 && $windDeg < 337.5){
            $text = 'северо-западный';
        }
        else if($windDeg >= 337.5 && $windDeg <= 360){
            $text = 'северный';
        }

        return $text;
    }

    static function getForecastXML($params, $moduleId)
    {
        $cache = JFactory::getCache('mod_jlweather', '');
        $cache->setCaching(1);
        $cache->setLifeTime($params->get('cachetime') * 3600);
        if (!($data = $cache->get('weather'.$moduleId)))
        {

            $hoffset = $params->get('hoffset',4) * 3600;
            $enablednow = $params->get('enablednow',0);
            $enabledFiveDays = $params->get('enabled_five_days',0);

            $data['current'] = array();
            $data['fiveDays'] = array();
            if($enablednow){
                $json = self::getWeather($params);
                if($json == false){
                    return false;
                }
                //
                $data['current'] = array(
                    'description' => $json["weather"][0]["description"],
                    'icon' => 'http://openweathermap.org/img/w/'.$json["weather"][0]["icon"].'.png',
                    'temp' => $json["main"]["temp"],
                    'pressure' => intval($json["main"]["pressure"]/1000*750.062),
                    'humidity' => $json["main"]["humidity"],
                    'temp_min' => $json["main"]["temp_min"],
                    'temp_max' => $json["main"]["temp_max"],
                    'visibility' => $json["visibility"],
                    'wind_speed' => $json["wind"]["speed"],
                    'wind_deg' => $json["wind"]["deg"],
                    'wind_deg_text' => self::getTextWindDeg($json["wind"]["deg"]),
                    'clouds' => $json["clouds"]["all"],
                    'dt' => $json["dt"],
                    'sunrise' => self::getTextTime($json["sys"]["sunrise"], $hoffset),
                    'sunset' => self::getTextTime($json["sys"]["sunset"], $hoffset),
                );

            }
            if($enabledFiveDays){
                $json = self::getWeather($params, 'fiveDays');
                if($json == false){
                    return false;
                }
                if(!is_array($json["list"]) || !count($json["list"])){
                    return false;
                }


                foreach ($json["list"] as $v){
                    $date = date ('d-m-Y',$v['dt']);
                    $time = date ('H:i',$v['dt']);
                    $array = array(
                        'date' => $date,
                        'time' => $time,
                        'temp' => $v["main"]['temp'],
                        'temp_min' => $v["main"]['temp_min'],
                        'temp_max' => $v["main"]['temp_max'],
                        'pressure' => intval($v["main"]["pressure"]/1000*750.062),
                        'sea_level' => $v["main"]['sea_level'],
                        'grnd_level' => $v["main"]['grnd_level'],
                        'humidity' => $v["main"]['humidity'],
                        'temp_kf' => $v["main"]['temp_kf'],
                        'description' => $v["weather"][0]['description'],
                        'icon' => 'http://openweathermap.org/img/w/'.$v["weather"][0]['icon'].'.png',
                        'clouds' => $v["clouds"]["all"],
                        'wind_speed' => $v["wind"]["speed"],
                        'wind_deg' => $v["wind"]["deg"],
                        'wind_deg_text' => self::getTextWindDeg($v["wind"]["deg"])
                    );
                    $data['fiveDays'][$date][$time] = $array;
                }

            }

            $cache->store($data, 'weather'.$moduleId);
        }
        return $data;
    }
}



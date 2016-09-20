<?php
 /**
 * JLweather - components of the weather for joomla.
 *
 * @version 1.0
 * @package JLweather
 * @author Anton Voynov (anton@joomline.ru)
 * @copyright (C) 2010 by Anton Voynov(http://www.joomline.ru)
 * @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
 *
 * If you fork this to create your own project,
 * please make a reference to JoomLine someplace in your code
 * and provide a link to http://www.joomline.ru
 **/ 
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

jimport( 'joomla.application.component.model' );

class JlweatherModelJlweather extends JModelLegacy
{
    private static
        $currentWeatherUrl = 'http://api.openweathermap.org/data/2.5/weather?id=%s&appid=%s&mode=json&lang=ru&units=metric',
        $fiveDayWeatherUrl = 'http://api.openweathermap.org/data/2.5/forecast?id=%s&appid=%s&mode=json&lang=ru&units=metric'
    ;

    private static function getWeather($params, $type='current', $cid)
    {
        $key = $params->get('key');
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

	static function getForecastXML($cid)
	{
		$params = JcomponentHelper::getParams('com_jlweather');


	    $weekdays[0] = JText::_("SUNDAY");
	    $weekdays[1] = JText::_("MONDAY");
	    $weekdays[2] = JText::_("TUESDAY");
	    $weekdays[3] = JText::_("WEDNESDAY");
	    $weekdays[4] = JText::_("THURSDAY");
	    $weekdays[5] = JText::_("FRIDAY");
	    $weekdays[6] = JText::_("SATURDAY");


        $hoffset = $params->get('hoffset',4) * 3600;
        $enablednow = $params->get('enablednow',0);
        $enabledFiveDays = $params->get('enabled_five_days',0);

        $data['current'] = array();
        $data['fiveDays'] = array();
        if($enablednow){
            $json = self::getWeather($params, 'current', $cid);
            if($json == false){
                return false;
            }
            $data['current'] = array(
                'description' => $json["weather"][0]["description"],
                'icon' => 'http://openweathermap.org/img/w/'.$json["weather"][0]["icon"].'.png',
                'temp' => $json["main"]["temp"],
                'pressure' => intval($json["main"]["pressure"]/1000*750.062),
                'humidity' => $json["main"]["humidity"],
                'temp_min' => $json["main"]["temp_min"],
                'temp_max' => $json["main"]["temp_max"],
//                'visibility' => $json["visibility"],
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
            $json = self::getWeather($params, 'fiveDays', $cid);
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

        return $data;


		if (count($xml->forecast->day)>0){
	    foreach ($xml->forecast->day as $fpart) {
		    $forecast = array();
		    $attr = $fpart->attributes();
		    $forecast['t']['min'] = (string)$fpart->t->min;
		    $forecast['t']['min'] = $forecast['t']['min'] > 0 ? "+".$forecast['t']['min'] : $forecast['t']['min'];
		    $forecast['t']['max'] = (string)$fpart->t->max;
		    $forecast['t']['max'] = $forecast['t']['max'] > 0 ? "+".$forecast['t']['max'] : $forecast['t']['max'];
		    $forecast['p']['min'] = (string)$fpart->p->min;
		    $forecast['p']['max'] = (string)$fpart->p->max;
		    $forecast['w']['min'] = (string)$fpart->wind->min;
		    $forecast['w']['max'] = (string)$fpart->wind->max;
		    $forecast['w']['rumb'] = (string)$fpart->wind->rumb;
		    $forecast['h']['min'] = (string)$fpart->hmid->min;
		    $forecast['h']['max'] = (string)$fpart->hmid->max;
		    $forecast['pict'] = (string)$fpart->pict;
		    $date = (string)$attr['date'];
		    $hour = (string)$attr['hour'];
		    $date0 = strtotime($date." ".$hour.":00");
		    $forecast['timestamp'] = $date0;
		    $date = strtotime($date);
		    $dayofweek = date('w',$date);
		    $date = $weekdays[$dayofweek]." ".date('d.m',$date);
		    if ($forecast['timestamp'] > time()+$hoffset){
			    $days[$date][$hour] = $forecast;
		    }

	    }
		} else {$days=array();}

		return array($cityname,$days);
	}
}

<?php
 /**
 * JLweather - components of the weather for joomla.
 *
 * @version 3.0.0
 * @package JL Weather
 * @author Artem Zhukov (artem@joomline.ru), Anton Voynov (anton@joomline.ru), Vadim Kunitsyn vadim@joomline.ru, Arkadiy (a.sedelnikov@gmail.com)
 * @copyright (C) 2010-2016 by Joomline (http://www.joomline.ru)
 * @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
 *
 * If you fork this to create your own project,
 * please make a reference to JoomLine someplace in your code
 * and provide a link to http://www.joomline.ru
 **/ 
jimport( 'joomla.application.component.view');

class JlweatherViewJlweather extends JViewLegacy
{
	function display($tpl = null)
	{
		$mainframe = JFactory::getApplication();
		$params = JcomponentHelper::getParams('com_jlweather');
		$citymenu = $mainframe->getMenu()->getActive()->params;

		$tmp_city_list = $citymenu->get('citymenu')!='' ? $citymenu->get('citymenu') : $params->get('citylist');

		$cache = JFactory::getCache('com_jlweather');
		$cache->setCaching(1);
		$cache->setLifeTime($params->get('cachetime')*60);
		
		$model = $this->getModel();
		$city_list = explode(",",$tmp_city_list);
		if (is_array($city_list)) {
			$city_list = array_map('trim',$city_list);
		}

		if (count($city_list)>0) {
			foreach ($city_list as $k =>$v) {
				$city_list[$k] = explode('#',$v);
			}
		}
		$reqcity = JRequest::getInt('cid',0);

		$city = '';
		if($reqcity > 0){
			foreach ($city_list as $k => $v){
				if($v[0] == $reqcity){
					$city = $v[1];
				}
			}
			$selcity = $reqcity;
		}
		else{
			$city = $city_list[0][1];
			$selcity = $city_list[0][0];
		}

		$forecast = $cache->call( array( 'JlweatherModelJlweather', 'getForecastXML') , $selcity  );

		$daysOfWeek = array(
			0 => JText::_('SUNDAY'),
			1 => JText::_('MONDAY'),
			2 => JText::_('TUESDAY'),
			3 => JText::_('WEDNESDAY'),
			4 => JText::_('THURSDAY'),
			5 => JText::_('FRIDAY'),
			6 => JText::_('SATURDAY')
		);

		$this->assignRef( 'selcity',	$selcity );
		$this->assignRef( 'city_list',	$city_list );
		$this->assignRef( 'city',	$city );
		$this->assignRef( 'forecast',	$forecast );
		$this->assignRef( 'daysOfWeek',	$daysOfWeek );

		$gettitle = $params->get('title')!='' ? $params->get('title') : JText::_('COM_JL_WEATHER_TITLE');
		$app = JFactory::getApplication();
		$doc = JFactory::getDocument();
		$menu = $app->getMenu()->getActive();

        $currentMenuName = isset($menu->title) ? $menu->title : '';
        $title = $currentMenuName.' '. JText::_('COM_JL_WEATHER_FOR_CITY') .' '.$city;

        $doc->setTitle($title);

        if ($menu->params->get('menu-meta_keywords', ''))
        {
            $doc->setMetadata('keywords', $menu->params->get('menu-meta_keywords', ''));
        }

        if ($menu->params->get('menu-meta_description', ''))
        {
            $doc->setDescription($menu->params->get('menu-meta_description', ''));
        }

		$pathway = $app->getPathway(); 
		$pathway->addItem(JText::_('FORECAST_CITY') .$this->city, '/component/jlweather/');
		parent::display($tpl);
	}
}
?>

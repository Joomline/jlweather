<?php
/**
 * JLweather - components of the weather for joomla.
 *
 * @version 2.6.1
 * @package JL Weather
 * @author Artem Zhukov (artem@joomline.ru) Anton Voynov (anton@joomline.ru)
 * @copyright (C) 2013 by Anton Voynov(http://www.joomline.ru)
 * @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
 *
 * If you fork this to create your own project,
 * please make a reference to JoomLine someplace in your code
 * and provide a link to http://www.joomline.ru
 **/
function JlweatherBuildRoute(&$query)
{
    $segments = array();

    if (isset($query['view']) && isset($query['Itemid'])) {
        $menus = JFactory::getApplication()->getMenu();
        $menu = $menus->getItem($query['Itemid']);
        if($menu->query['view'] != $query['view']){
            $segments[] = $query['view'];
        }
        unset($query['view']);
    }

    if (isset($query['cid'])) {
        $segments[] = $query['cid'];
        unset($query['cid']);
    } else {
        $segments[] = '';
    }

    return $segments;
}

function JlweatherParseRoute($segments)
{
    $params = JcomponentHelper::getParams('com_jlweather');
    $vars = array();

    if(count($segments) == 2){
        $vars['view'] = $segments[0];
        $cid = $segments[1];
    }
    else{
        $cid = $segments[0];
    }
    $city_list = explode(",", $params->get('citylist'));
    if (is_array($city_list)) {
        $city_list = array_map('trim', $city_list);
    } else {
        $city_list[0] = trim($city_list);
    }
    $c_id = 0;

    if (count($city_list) > 0) {
        foreach ($city_list as $k => $v) {
            $city_list[$k] = explode('#', $v);
            if ($city_list[$k][0] == $cid) {
                $c_id = $city_list[$k][0];
            }
        }
    }

    $vars['cid'] = $c_id;

    return $vars;
}

?>

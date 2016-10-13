<?php // no direct access
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
defined('_JEXEC') or die('Restricted access'); ?>
<?php if (count($this->city_list) > 1) : ?>

    <?php foreach ($this->city_list as $city) : ?>
        <?php if ($city[0] != $this->selcity) { ?>
            <?php $city_html[] = "<a href='" . Jroute::_('index.php?option=com_jlweather&cid=' . $city[0]) . "'>" . $city[1] . "</a>"; ?>
        <?php } else { ?>
            <?php $city_html[] = $city[1] ?>
        <?php } ?>
    <?php endforeach; ?>

    <div><?php echo JText::_('SELECT_CITY') ?> <?php echo implode(' | ', $city_html); ?></div>
<?php endif; ?>
<h1><?php echo JText::_('FORECAST_CITY') ?><?php echo $this->city ?></h1>
<?php
$dayparts[3] = JText::_("NIGHT");
$dayparts[9] = JText::_("MORNING");
$dayparts[15] = JText::_("DAY");
$dayparts[21] = JText::_("EVENING");

?>
<style type="text/css">
    .jlwdate {border-bottom: 1px solid #E3E3E3; display: block; padding: 5px; width: 100%;}
    .jlwitem {margin-bottom: 20px;}
    .comjlweathertemp{font-size:30px;}
    .comjlweathertext{font-size:90%;}
</style>
<?php if (count($this->forecast['current']) > 0) { ?>
    <?php $data = $this->forecast['current']; ?>
    <div class="jlwitem">
        <h3 class="jlwdate"><?php echo JText::_('COM_JL_WEATHER_NOW') ?></h3>
        <table cellpadding="5" cellspacing="5" border="0">
            <tr style="padding-top:10px;">
                <td>
                    <img src="<?php echo $data['icon']; ?>" alt=".">
                </td>
                <td class="comjlweathertemp" width="50"><?php if($data['temp_min']>0){echo '+';} echo round($data['temp_min'],0); ?></td>
                <td class="comjlweathertemp">...</td>
                <td class="comjlweathertemp" width="50"><?php if($data['temp_max']>0){echo '+';} echo round($data['temp_max'],0) ?></td>
                <td class="comjlweathertext">

                    <?php echo JText::_('PRESSURE') .' '. $data['pressure'] .' '. JText::_('MM') ?>
                    <br/>
                    <?php echo JText::_('WIND') . ' ' . $data['wind_deg_text'] . ' ' . $data['wind_speed'] . ' ' . JText::_('MC') ?>
                    <br/>
                    <?php echo JText::_('RELATIVE_HUMIDITY') . ' ' . $data['humidity'] ?> %<br/>
                    <?php echo JText::_('COM_JL_WEATHER_TEMP_SUNRISE') ?> <?php echo $data['sunrise'] ?><br/>
                    <?php echo JText::_('COM_JL_WEATHER_TEMP_SUNSET') ?> <?php echo $data['sunset'] ?><br/>
                </td>
            </tr>
        </table>
    </div>
<?php } ?>
<?php if (count($this->forecast['fiveDays']) > 0) { ?>
    <?php foreach ($this->forecast['fiveDays'] as $date => $daypart) : ?>
    <?php $oDate = new JDate($date); $dayOfWeek =  $this->daysOfWeek[$oDate->format('w')] ?>
        <div class="jlwitem">
            <h3 class="jlwdate"><?php echo $date .', '.$dayOfWeek ?></h3>
            <table cellpadding="5" cellspacing="5" border="0">
                <?php foreach ($daypart as $dp => $data) : ?>
                    <tr style="padding-top:10px;">
                        <td width="55"><?php echo $dp ?></td>
                        <td>
                            <img src="<?php echo $data['icon']; ?>" alt=".">
                        </td>
                        <td class="comjlweathertemp" width="50"><?php if($data['temp_min']>0){echo '+';} echo round($data['temp_min'],0) ?></td>
                        <td class="comjlweathertemp">...</td>
                        <td class="comjlweathertemp" width="50"><?php if($data['temp_max']>0){echo '+';} echo round($data['temp_max'],0) ?></td>
                        <td class="comjlweathertext">

                            <?php echo JText::_('PRESSURE') ?> <?php echo $data['pressure'] ?> <?php echo JText::_('MM') ?>
                            <br/>

                            <?php echo JText::_('WIND') . ' ' . $data['wind_deg_text'] . ' ' . $data['wind_speed'] . ' ' . JText::_('MC') ?>
                            <br/>
                            <?php echo JText::_('RELATIVE_HUMIDITY') . ' ' . $data['humidity'] ?> %
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    <?php endforeach;
} else { ?>
    <div class="jlwitem">
        <h3 class="jlwdate"><?php echo JText::_('NO_INFO') ?></h3>
    </div>
<?php } ?>


<div style="text-align: right;">
    <a style="text-decoration:none; color: #c0c0c0; font-family: arial,helvetica,sans-serif; font-size: 5pt; "
       target="_blank" href="http://joomline.ru/">Расширения Joomla</a>
</div>
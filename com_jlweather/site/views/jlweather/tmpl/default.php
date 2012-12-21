<?php // no direct access
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
defined('_JEXEC') or die('Restricted access'); ?>
<?php if (count($this->city_list) > 1) : ?>
	<h2><?=JText::_('SELECT_CITY') ?></h2>
	<?php foreach ($this->city_list as $city) : ?>
		<?php if ($city[0] != $this->selcity ) { ?>
			<?php $city_html[] = "<a href='".Jroute::_('index.php?option=com_jlweather&cid='.$city[1])."'>".$city[1]."</a>"; ?>
		<?php } else { ?>
			<?php $city_html[] = $city[1]?>
		<?php } ?>
	<?php endforeach; ?>
	<?=implode(' | ',$city_html); ?>
<?php endif; ?>
<h3><?=JText::_('FORECAST_CITY') ?><?=$this->city?></h3>
<?php
$dayparts[3]= JText::_("NIGHT");
$dayparts[9]= JText::_("MORNING");
$dayparts[15]= JText::_("DAY");
$dayparts[21]= JText::_("EVENING");

?>
		<style type="text/css">
			.jlwdate {
				display: block;
				width:100%;
				background-color:#f5f5dc;
				padding:5px;
			}
		</style>
<?php foreach ($this->forecast as $date=>$daypart) : ?>
	<h1 class="jlwdate"><?=$date?></h1>
<table cellpadding="5" cellspacing="5" border="0">
	<?php foreach ($daypart as $dp=>$data) : ?>
	<tr style="padding-top:10px;" >
		<td width="55"><?=$dayparts[$dp]?></td>
		<td><img src="/components/com_jlweather/img/<?=$data['pict']?>" alt="."></td>
		<td style="font-size:30px;" width="50"><?=$data['t']['min']?></td>
		<td style="font-size:30px;">...</td>
		<td style="font-size:30px;" width="50"><?=$data['t']['max']?></td>
		<td style="font-size:90%">
			<?php if (($data['p']['min']+$data['p']['max']) > 0) : ?>
				<?=JText::_('PRESSURE') ?> <?=$data['p']['min']?>-<?=$data['p']['max']?> <?=JText::_('MM') ?><br/>
			<?php endif; ?>
			<?=JText::_('WIND') ?> <?=$data['w']['min']?>-<?=$data['w']['max']?> <?=JText::_('MC') ?> <br/>
			<?=JText::_('RELATIVE_HUMIDITY') ?>  <?=$data['h']['min']?>-<?=$data['h']['max']?> %
		</td>
	</tr>
	<?php endforeach; ?>

</table>

<?php endforeach; ?>

<?php //echo "<pre>" . print_r($this->forecast, true) . "</pre>";?>
	<div style="text-align: right;">
		<a style="text-decoration:none; color: #c0c0c0; font-family: arial,helvetica,sans-serif; font-size: 5pt; " target="_blank" href="http://joomline.ru/">Расширения для Joomla</a>
	</div>
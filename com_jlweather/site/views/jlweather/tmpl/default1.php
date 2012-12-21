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
<h3><?=JText::_('FORECAST_CITY') ?> <?=$this->city?></h3>
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
<table cellpadding="5" cellspacing="5" border="0">
  <tr style="padding-top:10px;" >
    <td class="jlwitem" valign="bottom">
      <table>
        <tr><td width="55">&nbsp;</td></tr>
        <tr><td width="55">&nbsp;</td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td style="font-size:20px;" width="50">&nbsp;</td></tr>
        <tr><td width="55"><?=JText::_('PRESSURE1') ?> </td></tr>
        <tr><td width="55"><?=JText::_('WIND1') ?></td></tr>
        <tr><td width="55"><?=JText::_('RELATIVE_HUMIDITY1') ?></td></tr>
      </table>
    </td>
    <td class="jlwitem">
  <?php foreach ($this->forecast as $date=>$daypart) : ?>
    <td class="jlwitem" valign="top">
      <h1 class="jlwdate"><?=$date?></h1>
      <div  style="display: inline">
	<?php foreach ($daypart as $dp=>$data) : ?>
      <table style="float: left; width: 30px;padding-left: 5px">
        <!--<tr><td width="55"><?=$date?></td></tr>-->
        <tr><td width="30" align="center"><?=$dayparts[$dp]?></td></tr>
        <tr><td align="center"><img src="/components/com_jlweather/img/<?=$data['pict']?>" alt="." style="width: 27px"></td></tr>
        <tr><td style="font-size:20px;" width="30"><?=$data['t']['max']?><br /><br /></td></tr>
        <tr><td width="30" align="center"><?php if (($data['p']['min']+$data['p']['max']) > 0) : ?><?=$data['p']['max']?><?php endif; ?>&nbsp;<br /><br /></td></tr>
        <tr><td width="30" align="center"><?=$data['w']['max']?></td></tr>
        <tr><td width="30" align="center"><?=$data['h']['max']?><br /><br /></td></tr>
      </table>
    <?php endforeach; ?>
      </div>
	</td>
  <?php endforeach; ?>
	</td>
  </tr>
</table>

<?php //echo "<pre>" . print_r($this->forecast, true) . "</pre>";?>
	<div style="text-align: right;">
		<a style="text-decoration:none; color: #c0c0c0; font-family: arial,helvetica,sans-serif; font-size: 5pt; " target="_blank" href="http://joomline.ru/">Расширения для Joomla</a>
	</div>
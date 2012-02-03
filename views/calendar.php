<?php

/* date settings */
$month= "";
$year = "";

$month = ( isset( $new_month) && $new_month != "") ? (int)$new_month : (int)date('m');
$year = ( isset( $new_year ) && $new_year != "") ? (int)$new_year :	(int)date('Y');

$next_month_link = '<a href="'.site_url($this->config->item('module_name') . '/calendar').'/'.($month != 12 ? $month + 1 : 1).'/'.($month != 12 ? $year : $year + 1).'" class="next_month_link">&nbsp;</a>';
$previous_month_link = '<a href="'.site_url($this->config->item('module_name') . '/calendar').'/'.($month != 1 ? $month - 1 : 12).'/'.($month != 1 ? $year : $year - 1).'" class="pre_month_link">&nbsp;</a>';

$daynames = array('sun','mon','tue','wed','thu','fri','sat');
$row_counter = 1;

?>
<h1>
Calender <strong>Month View</strong>
<div class="cal-options">
	<a class="cal-button" href="<?php echo site_url($this->config->item('module_name') . '/agenda'); ?>"><span>Agenda View</span></a>
</div>
</h1>

<div class="cal-top" >

	<div class="cal-top-month">
		<?php echo date('F',mktime(0,0,0,$month,1,$year)).' '.$year; ?> <a class="calendar-top-today<?=($month==date('n')) ? ' disabled' : ''?>" href="<?=($month==date('n')) ? 'javascript:void(0)' : site_url($this->config->item('module_name') . '/calendar')?>"><span>Today</span></a>
	</div>
		
    <div class="cal-month-nav">
	    <div class="cal-month-nav-pre">
	    	<a href="<?=site_url($this->config->item('module_name') . '/calendar').'/'.($month != 1 ? $month - 1 : 12).'/'.($month != 1 ? $year : $year - 1)?>"><span>Last</span></a>
	    </div>
	    <div class="cal-month-nav-next">
	    	<a href="<?=site_url($this->config->item('module_name') . '/calendar').'/'.($month != 12 ? $month + 1 : 1).'/'.($month != 12 ? $year : $year + 1)?>"><span>Next</span></a>
	    </div>
    </div>
    
</div>

<div id='calendar'>
	<table cellpadding="0" cellspacing="0" class="cal-head">
		<tr class="cal-head-days"><td class="sun">Sun</td><td class="mon">Mon</td><td class="tue">Tue</td><td class="wed">Wed</td><td class="thu">Thu</td><td class="fri">Fri</td><td class="sat">Sat</td></tr>
	</table>
	
	<table cellpadding="0" cellspacing="0" class="cal-body">
		<tr class="cal-row">		
<?php for($days_in_this_week=1; $days_in_this_week <= $running_day; $days_in_this_week++):?>
		<td class="cal-day cal-numless <?=$daynames[$days_in_this_week-1]?>">&nbsp;&nbsp;</td>
<?php endfor;?>

<?php for($list_day = 1; $list_day <= $days_in_month; $list_day++): $event_day = $year.'-'.$month.'-'.$list_day;?>
			<td class="cal-day <?=$daynames[$running_day]?><?=(isset($events[$list_day])) ? ' events' : null?><?=($event_day == date('Y-n-j') ? ' today' : null)?>">
				<div class="cal-day-box">
					<div class="cal-day-wrapper">
						<div class="day-number"><?=$list_day?></div>
	<?php 	if(isset($events[$list_day])):?>
						<div class="cal-event-count"><span><?=$events[$list_day]['day_count']?></span></div>
						<a href="<?=$events[$list_day]['url']?>" class="cal-event-link"><span>SHOW<strong>AGENDA</strong></span></a>
						<div class="cal-event-arrow"><span style="display:none;">&nbsp&nbsp</span></div>
	<?php 	endif;?>
					</div>
				</div>
			</td>
			
<?php 	if($running_day==6):?>
		</tr>
<?php 		if(($day_counter+1) != $days_in_month):?>
		<tr><td  class="cal-agenda" colspan="7"><div class="cal-agenda-container" style="display:none;"><div class="cal-agenda-wrapper">&nbsp;&nbsp;</div></div></td></tr>
		
		<tr class="cal-row">
<?php 		endif; $running_day = -1; $days_in_this_week = 0;?>
<?php 	endif; $days_in_this_week++; $running_day++; $day_counter++;?>
<?php endfor;?>

<?php if($days_in_this_week < 8 && $days_in_this_week > 1):?>
<?php 	for($x = 1; $x <= (8 - $days_in_this_week); $x++):?>
		<td class="cal-day <?=$daynames[$running_day++]?> cal-numless ">&nbsp;&nbsp;</td>
<?php 	endfor;?>
<?php endif;?>
		</tr>
		<tr><td  class="cal-agenda" colspan="7"><div class="cal-agenda-container" style="display:none;"><div class="cal-agenda-wrapper">&nbsp;&nbsp;</div></div></td></tr>
	</table>
	
</div>
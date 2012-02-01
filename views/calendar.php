<?php
/* draws a calendar */
function draw_calendar($month,$year,$events = array()){

	/* draw table */
	$calendar = '<table cellpadding="0" cellspacing="0" class="calendar-head">';

	/* table headings */
	$headings = array('Sun','Mon','Tue','Wed','Thu','Fri','Sat');
	
	$calendar.= '<tr class="calendar-day-head-row"><td>'.implode('</td><td>',$headings).'</td></tr>';
	
	$calendar.= '</table>';
	
	$calendar.= '<table cellpadding="0" cellspacing="0" class="calendar-body">';
	/* days and weeks vars now ... */
	$running_day = date('w',mktime(0,0,0,$month,1,$year));
	$days_in_month = date('t',mktime(0,0,0,$month,1,$year));
	$days_in_this_week = 1;
	$day_counter = 0;
	$last_right_col_class = '';
	$dates_array = array();
	$row_counter = 1;

	/* row for week one */
	$calendar.= '<tr class="calendar-row">';

	/* print "blank" days until the first of the current week */
	for($x = 0; $x < $running_day; $x++):
		$calendar.= '<td class="calendar-day-np">&amp;nbsp;</td>';
		$days_in_this_week++;
	endfor;

 
	/* keep going with days.... */
	for($list_day = 1; $list_day <= $days_in_month; $list_day++):
		
		$event_day = $year.'-'.$month.'-'.$list_day;
		$today_col_class = '';
		
		if( $event_day == date('Y-n-j'))
			$today_col_class = 'calender-today-col';
		else
			$today_col_class = '';
			
		
		$calendar.= '<td class="calendar-day  '.$today_col_class.'">';
		
		$calendar.= '<div style="position:relative;height:113px;">';
			/* add in the day number */
			$calendar.= '<div class="day-number">'.$list_day.'</div>';
			
			if(isset($events)) {
				foreach($events as $keys => $event) {
					if( $event_day  == $event['event_date'] ) {
						
						if($running_day == 6)
							$dmp_event_date = $event_day;
							
						$calendar.= '<div class="ws_t_event_in_day">'.$event['total_event_in_a_day'].'</div>';
						$calendar.= '<div class="calendar-event-detail-link" onclick="ShowEventDetail(\''.$event['event_date'].'\', this, \''.$row_counter.'\');">SHOW</div>';
						$calendar.= '<div class="calendar-event-title">'.$event['title'].'</div>';
						$calendar.= '<div id="detail_open_arrow_'.$event['event_date'].'" class="detail_open_arrow" style="display:none;"></div>';
					}
				}
			}
			else {
				//$calendar.= str_repeat('<p>&amp;nbsp;</p>',2);
			}
			
			
		$calendar.= '</div></td>';
		if($running_day == 6):
			$calendar.= '</tr>';
			if(($day_counter+1) != $days_in_month):
				$calendar.= '<tr id="event_detail_block_'.$row_counter.'" style="display:none;"><td colspan="7" style="padding:35px 0px 35px 0px;">&nbsp;</td></tr>';
				$calendar.= '<tr class="calendar-row">';
				$row_counter++;
			endif;
			$running_day = -1;
			$days_in_this_week = 0;
		endif;
		$days_in_this_week++; $running_day++; $day_counter++;
	endfor;

	/* finish the rest of the days in the week */
	if($days_in_this_week < 8 && $days_in_this_week > 1):
		for($x = 1; $x <= (8 - $days_in_this_week); $x++):
			$calendar.= '<td class="calendar-day-np">&amp;nbsp;</td>';	
		endfor;
	endif;

	/* final row */
	$calendar.= '</tr><tr id="event_detail_block_'.$row_counter.'" style="display:none;"><td colspan="7" style="padding:35px 0px 35px 0px;"><div style="height:50px; width:200px;">hr</div></td></tr>';
	

	/* end the table */
	$calendar.= '</table>';

	/** DEBUG **/
	$calendar = str_replace('</td>','</td>'."\n",$calendar);
	$calendar = str_replace('</tr>','</tr>'."\n",$calendar);
	
	/* all done, return result */
	return $calendar;
}

function random_number() {
	srand(time());
	return (rand() % 7);
}

/* date settings */
$month= "";
$year = "";

if( isset( $new_month) && $new_month != "")
{
	$month = (int) $new_month;
}
else
{
	$month = (int) date('m');
}

if( isset( $new_year ) && $new_year != "")
{
	$year = (int)  $new_year;
}
else
{
	$year = (int) date('Y');
}

$next_month_link = '<a href="'.site_url($this->config->item('module_name') . '/calendar').'/'.($month != 12 ? $month + 1 : 1).'/'.($month != 12 ? $year : $year + 1).'" class="next_month_link">&nbsp;</a>';

$previous_month_link = '<a href="'.site_url($this->config->item('module_name') . '/calendar').'/'.($month != 1 ? $month - 1 : 12).'/'.($month != 1 ? $year : $year - 1).'" class="pre_month_link">&nbsp;</a>';


?>
<div class="views">Calender Month View</div>    
<div class="buttons">
    <div class="disable_btn"><a href="<?php echo site_url($this->config->item('module_name') . '/agenda'); ?>">Agenda View</a></div>
    <div class="enable_btn"><a href="<?php echo site_url($this->config->item('module_name') . '/calendar'); ?>">Month View</a></div>
</div>
<div class="seprator"></div>

<div class="calendar_head" >
	<div class="calendar_month_lbl"><?php echo date('F',mktime(0,0,0,$month,1,$year)).' '.$year; ?></div>
	<?php if( $month == date('n')){ ?>
    	<div class="today_disable_btn">Today</div>
    <?php }else { ?>
		<div class="today_enable_btn" onclick="javascript: document.location='<?php echo site_url($this->config->item('module_name') . '/calendar'); ?>';">Today</div>
    <?php } ?>
    
    <div style="float:right;"><div class="pre_month_link"><?php echo $previous_month_link ; ?></div><div class="next_month_link"><?php echo $next_month_link ; ?></div></div>
</div>

<div id='calendar'><?php echo draw_calendar($month,$year,$events);?></div>
<div class='seprator'></div>
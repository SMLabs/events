<?php
	$total = count($events);
	$index = 0;
?>
<div class="cal-agenda-list">
<?php foreach( $events as $keys => $event ):?>
				<div class="agenda-listing<?=(++$index==$total)?' last':''?>">
					<div class="agenda-date">
						<div class="agenda-date-wrapper">
							<div class="agenda-day"><?= date('l',strtotime($event->event_date))?></div>
							<div class="agenda-month"><?=date('F d,Y',strtotime($event->event_date))?></div>
							<div class="agenda-time"><?=Time24hFormat_Into_AMPMTime($event->start_time)?> - <?= Time24hFormat_Into_AMPMTime($event->end_time)?></div>
						</div>
					</div>
						
					<article class="agenda-details">
						<header><h2 class="agenda-header"><?=$event->name?> </h2></header>
						<p><?=$event->description ?></p>
						
					<?php if($event->sponsors!=''):?>
						<div class="agenda-spon-heading">Sponsors</div>
						<div class="agenda-spon-list"><?=$event->sponsors?></div>
					<?php endif;?>

					<?php if($event->eventbrite_event_url!='' OR $event->facebook_event_url!=''):?>
						<div class="agenda-view-heading">View Event:</div>
						<div class="agenda-view-buttons">
							<?php if($event->eventbrite_event_url!=''):?><a href="<?=CheckHTTP_InURL($event->eventbrite_event_url)?>"><div class="orange_btn">Eventbrite</div></a><?php endif;?>
							<?php if($event->facebook_event_url!=''):?><a href="<?=CheckHTTP_InURL($event->facebook_event_url)?>"><div class="facebook_btn">facebook</div></a><?php endif;?>
						</div>
					<?php endif;?>
					
					</article>
            	</div>
<?php endforeach;?>
</div>
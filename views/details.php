<?php
	$total = count($events);
	$index = 0;
?>
<?php foreach( $events as $keys => $event ):?>
				<div class="postings<?=(++$index==$total)?' last':''?>">
					<div class="a_date">
						<div class="a_date_text">
							<div class="day"><?= date('l',strtotime($event->event_date))?></div>
							<div class="month"><?=date('F d,Y',strtotime($event->event_date))?></div>
							<div class="time"><?=Time24hFormat_Into_AMPMTime($event->start_time)?> - <?= Time24hFormat_Into_AMPMTime($event->end_time)?></div>
						</div>
					</div>
						
					<article class="a_detail">
						<header><h2 class="posting_hdr"><?=$event->name?> </h2></header>
						<p>
							<?=$event->description ?> 
							<div class="a_detail_text01">Sponsors</div>
							<div class="a_detail_text02"><?=$event->sponsors?></div>
							<div class="a_detail_text01">View Event on:</div>
							<div class="a_detail_btn">
								<a href="<?=CheckHTTP_InURL($event->eventbrite_event_url)?>"><div class="orange_btn">Eventbrite</div></a>
								<a href="<?=CheckHTTP_InURL($event->facebook_event_url)?>"><div class="facebook_btn">facebook</div></a>
							</div>
						</p>
					</article>
            	</div>
<?php endforeach;?>
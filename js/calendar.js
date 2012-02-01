$(document).ready(function() {
  
  $('.calendar-day-head-row').find('td:last').css("border-right","1px solid #C8DEE7");
  
  $('.calendar-body').find('tr:last').prev('tr').find('td').css("border-bottom","1px solid #C8DEE7");
  
  $('.calendar-row').find('td:last').css("border-right","1px solid #C8DEE7");
  
  $('.calendar-event-title').parents().filter('.calendar-day').css({backgroundColor:'#7AABCB', color:'#FFF'});
  
  $('.calendar-day-np').css({backgroundColor:'#F4F4F4', color:'#F4F4F4'});
  
  $('.calender-today-col').css({backgroundColor:'#EAF7FF', color:'#A6CCE3'});
  
 
  
  
});

function ShowEventDetail( eventDate, obj, row_counter )
{
	if($('#event_detail_block_' + row_counter).is(':hidden'))
	{
		jQuery.ajax({
			type : "POST",
			url  : 'event/detail_by_event_date/',
			data : 'event_date=' + eventDate,
			//dataType: "json",
			success : 
			function(html)
			{
				$(obj).parents().filter('.calendar-row').find('td').css("border-bottom","1px solid #C8DEE7");
				$(obj).parents().filter('.calendar-day').css({backgroundColor:'#286CAB', color:'#FFF', border:'1px solid #286CAB'});
				
				$(obj).html('HIDE');
				
				$('#detail_open_arrow_' + eventDate).show();
				$('#event_detail_block_' + row_counter).find('td').html(html);
				$('#event_detail_block_' + row_counter).fadeIn('slow');
			}
		}); 
	}
	else
	{
		$('#event_detail_block_' + row_counter).fadeOut('slow');
		$(obj).html('SHOW');
		$(obj).parents().filter('.calendar-day').css({backgroundColor:'#7AABCB', color:'#FFF', border:'1px solid #C8DEE7'});
		$('#detail_open_arrow_' + eventDate).hide();
		
	}
}
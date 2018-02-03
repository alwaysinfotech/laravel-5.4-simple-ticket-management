<?php 
    /*
    Laravel5.4
    Module Name: Ticket Management System
    Description : Very simple and useful ticket management system for Laravel 5.4 for frontend logged in users and Admin panel. Dependency is Auth module
    Author URI: http://www.alwaysinfotech.com/
    Author: Deepak Verma
    */
?>
<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\TicketComments;

class Tickets extends Model
{
    protected $table = 'tickets';

	protected $fillable=['user_id','ticket_category','ticket_subject','ticket_code',
						'ticket_description','ticket_attachement','status','assigned_to','assigned_status','close_date','parent_ticket_id'];

	public static function getTicketData($ticket_id){

    	$ticket_data=Tickets::select('tickets.ticket_subject','tickets.ticket_code',
    							'tickets.status','tickets.created_at',
    							'tickets_categories.ticket_category','users.name','users.email')
	    						->join('tickets_categories','tickets_categories.id','=','tickets.ticket_category')
	    						->join('users','users.id','=','tickets.user_id')
	    						->where('tickets.ticket_code',$ticket_id)
	    						->get();

	    $get_comment=TicketComments::select('ticket_comments.description',
	    							'ticket_comments.created_at','users.name','users.user_image')
    							->join('users','users.id','=','ticket_comments.user_id')
    							->where('ticket_comments.ticket_id',$ticket_id)
    							->orderBy('ticket_comments.id','asc')
    							->get();
    							
    	return ['ticket_data'=>$ticket_data,'get_comment'=>$get_comment];
	    
    }
}

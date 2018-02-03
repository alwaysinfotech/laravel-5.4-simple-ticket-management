<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TicketComments extends Model
{
    protected $table = 'ticket_comments';

	protected $fillable=['id','user_id','ticket_id','ticket_subject','description'];
}

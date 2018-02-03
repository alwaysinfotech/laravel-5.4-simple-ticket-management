<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TicketCategories extends Model
{
    protected $table = 'tickets_categories';

	protected $fillable=['id','ticket_category'];
}

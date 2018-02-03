@extends('layouts.app')
@section('content')
<section class="content">
<div class="container">
	<div class="row">
		<div class="box-header with-border">
          <h3 class="box-title">Tickets</h3>
        </div>
        <div class="col-xs-4"></div>
        <div class="col-xs-6"></div>
        <div class="col-xs-2 form-group"><button type="button" class="btn btn-success" onclick='window.location.href="{{url('create-ticket')}}"'>Create Ticket</button></div>
    </div>
    <div class="row">
		<div class="col-md-12">
    		@if (Session::has('status'))
			  <div class="alert alert-success">
			  	<a href="#" class="close" data-dismiss="alert">&times;</a>
			    {{ Session::get('status') }}
			  </div>
			@endif
    		<div class="box box box-danger">
	    			<div class="box-body">
	    				<table class="table-responsive table table-hover">
			    			<thead>
			    				<tr>
			    					<th>Ticket Number</th>
			    					<th>Type</th>
			    					<th>Subject</th>
			    					<th>Status</th>
			    					<th>Created At</th>
			    				</tr>
			    			</thead>
			    			<tbody>
			    				@if(count($open_ticket)>0)
			    				@foreach($open_ticket as $result)
			    				<tr>
			    					<td><a href="{{url('ticket').'/'.$result->ticket_code}}">{{$result->ticket_code}}</a></td>
			    					<td>{{$result->ticket_category}}</td>
				    				<td>{{ucfirst($result->ticket_subject)}}</td>
				    				<td>{{ucfirst($result->status)}}</td>
				    				<td>{{$result->created_at}}</td>
				    			</tr>
			    				@endforeach
			    				@else
			    				<tr><td colspan="5">No record found</td></tr>
			    				@endif
			    			</tbody>
			    		</table>
			    	</div>
	    		</div>{{ $open_ticket->links() }}
    	</div>
    </div>
</div>    
</section>

@endsection

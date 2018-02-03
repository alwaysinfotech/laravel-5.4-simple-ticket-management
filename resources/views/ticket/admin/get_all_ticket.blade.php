@extends('layouts.app')
@section('content')
<section class="content">
<div class="container">
	<div class="row">
		<div class="box-header with-border">
          <h3 class="box-title">All Tickets</h3>
        </div>
        <div class="col-md-12">
	        @if (Session::has('status'))
			  <div class="alert alert-success">
			  	<a href="#" class="close" data-dismiss="alert">&times;</a>
			    {{ Session::get('status') }}
			  </div>
			@endif
		</div>
        <div class="col-xs-12">
            <div class="box">
                <div class="box-body">
                    <form class="form-inline" action="" method="get">
                    	<div class="form-group">
                        	<input type="text" class="form-control" placeholder="Keyword" value="{{$keyword}}" name="keyword">
                        </div>
                        <div class="form-group">
                            <select class="form-control" name="process">
                                <option value="">All</option>
                                <option value="under process" <?php if(isset($process) && $process=='under process') echo "selected"; ?>>Under Process</option>
                                <option value="close" <?php if(isset($process) && $process=='close') echo "selected"; ?>>Close</option>
                                <option value="unassigned" <?php if(isset($process) && $process=='unassigned') echo "selected"; ?>>Unassigned</option>
                            </select>
                        </div>
						<div class="form-group">
                            <input type="text" class="form-control  datepicker" name="from_date" placeholder="From Date" id="datepicker" value="{{$from_date}}">
                        </div>
                        <div class="form-group">
                        	<input type="text" class="form-control datepicker" name="to_date" placeholder="To Date" value="{{$to_date}}">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-default">Search</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
		<div class="col-md-12">
    		<form method="post" id="form" action="{{url('action-delete-ticket')}}">
		        {{ csrf_field() }}
		      	<div class="row">
			      	<div class="col-xs-3">
			      		<div style="color:red;" id="error"></div>
			      		 	<ul class="list-inline ">
				               <li>
				                  	<select class="form-control radiousnone"  id="actiononuser" name="performAction">
				                        <option value="">Actions</option>   
				                        <option value="1">Delete</option>
				                        <option value="2">Open</option>
				                        <option value="3">Close</option>
				                    </select>
				                </li>
								<li class="dropdown">
									<button class="btn  bg-olive dropdown-toggle" aria-expanded="true" aria-haspopup="true" data-toggle="dropdown" type="button">Submit
									</button>
									<ul class="dropdown-menu" style="left: auto;">
										<li>
											<a href="javascript:void(0)" onclick="checkValidateUser();">Do you want to continue?</a>
										</li>
										<li> 
											<a href="javascript:void(0)">Cancel</a> 
										</li>
									</ul>
								</li>
							</ul>
					</div>
				</div>
				<div class="box box box-danger">
	    			<div class="box-body">
	    				<table class="table-responsive table table-hover">
			    			<thead>
			    				<tr>
			    					<th><input type="checkbox" id="checkAll" class="checked_all"></th>
			    					<th>Ticket Number</th>
			    					<th>Type</th>
			    					<th>Subject</th>
			    					<!-- <th>Assigned Status</th>-->
			    					<th>Status</th> 
			    					<th>Created At</th>
			    					<th>Action</th>
			    				</tr>
			    			</thead>
			    			<tbody>
			    				@foreach($open_ticket as $result)
			    				<tr>
			    					<td><input type="checkbox" class="deleteSelected checkbox" name="ticket_code[]" value="{{$result->ticket_code}}"></td>
			    					<td><a href="{{url('admin/ticket').'/'.$result->ticket_code}}">{{$result->ticket_code}}</a></td>
			    					<td>{{$result->ticket_category}}</td>
				    				<td>{{ucfirst($result->ticket_subject)}}</td>
				    				<td>{{ucfirst($result->status)}}</td>
				    				<td>{{$result->created_at}}</td>
				    				<td><a href="javascript:void(0);" onclick="deleteTicket('{{$result->ticket_code}}');" class="btn btn-danger" data-toggle="modal" data-target="#myModal"><i class="fa fa-trash-o" aria-hidden="true"></i></a></td>
			    				</tr>
			    				@endforeach
			    			</tbody>
			    		</table>
			    	</div>
		    	</div>
	    	</form>
	    	{{ $open_ticket->links() }}
    	</div>
    </div>
</div>    
</section>
<script type="text/javascript">
	function deleteTicket(id){
		$('#ticket_code').val(id);
		$('#activate-user-model-form').attr('action','<?php echo url('delete-ticket');?>');
		$('.modal-title').html('CAUTION');
		$('#makeUserAsActiveBody').html('<h4><br>Are you sure you want to perform this action?</h4><br><h5>Note: This action can not be undone.</h5>');
	}

</script>
@endsection

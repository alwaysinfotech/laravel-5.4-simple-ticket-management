@extends('layouts.app')
@section('content')
<section class="content">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
	            <div class="box box-info">
		            <div class="box-header with-border">
		              <h3 class="box-title">Ticket</h3>
		            </div>
	            	<div class="box-body">
		                <div class="form-group">
		                  	<label class="col-sm-2 control-label">Name</label>
							<div class="col-sm-10">
		                    	<label class="col-sm-2 control-label"> {{ucfirst($ticket_data[0]->name)}}
		                    	</label>
		                  	</div>
		                </div>
		                <div class="form-group">
		                  	<label class="col-sm-2 control-label">Ticket Id</label>
							<div class="col-sm-10">
		                    	<label class="col-sm-2 control-label"> {{$ticket_data[0]->ticket_code}}
		                    	</label>
		                  	</div>
		                </div>
		                <div class="form-group">
		                  	<label class="col-sm-2 control-label">Status</label>
							<div class="col-sm-10">
		                    	<label class="col-sm-2 control-label"> {{ucfirst($ticket_data[0]->status)}}
		                    	</label>
		                  	</div>
		                </div>
		                <div class="form-group">
		                  	<label class="col-sm-2 control-label">Type</label>
							<div class="col-sm-10">
		                    	<label class="col-sm-2 control-label"> {{ucfirst($ticket_data[0]->ticket_category)}}
		                    	</label>
		                  	</div>
		                </div>
	            	</div>
	            </div>
	    	</div>
	    	<div class="col-md-12">
		        @if (Session::has('status'))
				  <div class="alert alert-success">
				  	<a href="#" class="close" data-dismiss="alert">&times;</a>
				    {{ Session::get('status') }}
				  </div>
				@endif
			</div>
			<!-- Comment Message -->
			<div class="row">
				@foreach($get_comment as $result)
				<div class="col-sm-1">
					<div class="thumbnail">
						<?php 
							if(file_exists(base_path().'/public/images/'.$result->user_image) && $result->user_image!='') {
							$user_img = $result->user_image;
							}else{
								$user_img = "user1.png";
							}
						?>
						<img src="{{ asset('public/images'.'/'.$user_img) }}" class="img-responsive" alt="" title="" />
					</div><!-- /thumbnail -->
				</div><!-- /col-sm-1 -->
				<div class="col-sm-5">
					<div class="panel panel-default">
						<div class="panel-heading">
							<strong>{{ucfirst($result->name)}}</strong>
								<span class="text-muted">commented {{ $result->created_at->diffForHumans() }}</span>
								<span class="pull-right"><i class="fa fa-clock-o" aria-hidden="true"></i>{{ $result->created_at}}</span>
						</div>
						<div class="panel-body">
							{{ucfirst(strip_tags($result->description))}}
						</div><!-- /panel-body -->
					</div><!-- /panel panel-default -->
				</div><!-- /col-sm-5 -->
				<div class="clearfix"></div>
				@endforeach
			</div>
	    	<div class="row">
	    		<!-- Editor -->
	    	<form method="post" action="{{url('comment')}}">
	    		 {{ csrf_field() }}
	    		<input type="hidden" value="{{$ticket_data[0]->ticket_code}}" name="ticket_id">
	    		<input type="hidden" value="{{$ticket_data[0]->email}}" name="email">
	    		<input type="hidden" value="{{$ticket_data[0]->ticket_subject}}" name="ticket_subject">
		    	<div class="col-md-7 form-group">
		            <h3>Leave a reply</h3>
					<textarea class="textarea form-control" name="message"  placeholder="Place some text here"></textarea>
					<div class="box-footer">
	                <button type="submit" class="btn btn-success">Post Comment</button>
	                <button type="button" class="btn btn-default" onclick='window.location.href="{{url('ticket')}}"'>Cancel</button>
	               </div>
				</div>
			</form>
	    	</div>
		</div> 
	</div>   
</section>

@endsection

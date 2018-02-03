@extends('layouts.app')
@section('content')

<section class="content">
<div class="container">
    <div class="row">
    	@if (Session::has('status'))
		  <div class="alert alert-success">
		  	<a href="#" class="close" data-dismiss="alert">&times;</a>
		    {{ Session::get('status') }}
		  </div>
		@endif
		<div class="box-header with-border">
              <h3 class="box-title">Create Ticket</h3>
            </div>
    	<form method="post" action="{{url('add-ticket')}}" enctype="multipart/form-data">
    		{{ csrf_field() }}
    		<div class="col-md-6 form-group">
	        	<label for="Subject">Subject</label>
	        	<input class="form-control" name="subject" type="text" id="subject" value="{{old('subject')}}">
	        	@if ($errors->has('subject'))
				    <div class="error">{{ $errors->first('subject') }}</div>
				@endif
	    	</div>
	      	
 			<div class="col-md-6  form-group">
	        	<label>Regarding</label>
	        	<select name="regarding" class="form-control" id="support_query">
	        	   	<option value="">Select Topic</option>
	        	   	@foreach($tickets_categories as $result)
        	   		<option value="{{$result->id}}" <?php if(old('regarding')==$result->id) echo "selected";?>>{{$result->ticket_category}}</option>
    	   			@endforeach
	        	</select>
	        	@if ($errors->has('regarding'))
				    <div class="error">{{ $errors->first('regarding') }}</div>
				@endif
	      	</div>
	      	<div class="">
	    	<div class="col-md-7 form-group">
	            <label for="Message">Description</label>
				<textarea class="textarea form-control" name="message" id="newseditor" placeholder="Place some text here">{{old('message')}}
				</textarea>

				@if ($errors->has('message'))
				    <div class="error">{{ $errors->first('message') }}</div>
				@endif
	        </div></div>
	        <div class="col-md-12 form-group">
	            <label for="Details">Attachment(optional)</label>
				<input type="file" name="attachment[]" id="attachment"  multiple accept=".gif,.jpg,.jpeg,.png,.doc,.docx,.pdf,.xlsx">
				@if ($errors->has('attachment.0'))
		            <div class="error">The attachment must be pdf, xls, doc, docx, jpeg, jpg, png ,xlsx format</div>
	            @elseif(Session::has('message'))
				<div class="error">{{ Session::get('message') }}</div>
				@endif
        		<p class="error">Press CTRL to select upload multiple files. Maximum three files are allowed</p>
			</div>
			<div class="col-md-12 form-group">
	            <button type="Submit" class="btn btn-success">Submit
	            </button>
	            <button type="button" class="btn btn-default" onclick='window.location.href="{{url('ticket')}}"'>Cancel
	            </button>
			</div>
		</form>
	</div>
</div>    
</section>

@endsection

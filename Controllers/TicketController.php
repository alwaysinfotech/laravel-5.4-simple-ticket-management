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
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tickets;
use App\TicketCategories;
use App\TicketComments;
use App\User;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Mail\Ticket;
use Mail;
use log;
class TicketController extends Controller
{
    function getTicket(){
    	$tickets_categories=TicketCategories::select('id','ticket_category')->get();
    	return view('ticket.create_ticket_form')->with(['tickets_categories'=>
        	$tickets_categories]);
    }
    function addTicket(Request $request){
		$request->validate([
		    'subject' =>'required|max:255',
			'regarding' => 'required',
		    'message' => 'required|max:500',
		    'attachment.*'=> 'sometimes|mimes:pdf,xls,doc,docx,jpg,jpeg,png,xlsx',
		]);

		$id   = Auth::user()->id;
    	$file = array();

		$subject        = $request->subject;
    	$message        = $request->message;
    	$support_query  = $request->regarding;
    	$attachment     = $request->attachment;
    	$ticket_code    = time();

    	$count_ticket = Tickets::where('ticket_code',$ticket_code)->count();

		if($count_ticket>0){
    		for($i=0;$i<5;$i++){
    			$ticket_code=time();
    			$count_ticket=Tickets::where('ticket_code',$ticket_code)->count();
	    		if($count_ticket>0){
	    			break;
	    		}
	    	}
    	}
    	if($request->hasFile('attachment')) {

    		if(count($request->file('attachment'))<4){
	    		foreach($request->file('attachment') as $attachment) {
	    			$attachment_size = $attachment->getClientSize();
	    			if($attachment_size > 1000000){
	    				Session::flash('message','Please upload only less then 1MB file');
	    				return redirect()->back()->withInput();
	    			}
	    			$destinationPath = storage_path('app/ticket_attachment/');
			        $filename = time() . '_' .$attachment->getClientOriginalName();
			        $file[]=$filename;
			        $attachment->move($destinationPath, $filename);
				}
			}else{
				Session::flash('message', 'Please upload only three files'); 
				return redirect()->back()->withInput();
			}
		}

		Tickets::create(['user_id'=>$id,'ticket_subject'=>$subject,'ticket_description'=>$message,'ticket_category'=>$support_query,'ticket_attachement'=>json_encode($file),'ticket_code'=>$ticket_code]);

		TicketComments::create(['user_id'=>$id,'description'=>$message,'ticket_id'=>$ticket_code]);

		$email = User::where('user_type','admin')->value('email');
		$name  = Auth::user()->name;
		$subject = ucfirst($name).' has created a new ticket';
		$mailContent=array('ticket_code'=>$ticket_code,'name'=>$name);

		try {
			Mail::to($email)->send(new Ticket($mailContent,$subject));
		} catch(\Exception $e){
			Log::info($e);
		}
		
		return redirect()->back()->with(['status'=>'Ticket has been created successfully']);

    }
    function openTicket(){
		if (Auth::check()) {
			
			$id=Auth::user()->id;

	   		$open_ticket=Tickets::select('tickets.id','tickets.ticket_subject',
								'tickets.ticket_code','tickets.status','tickets.created_at','tickets_categories.ticket_category')
	    						->join('tickets_categories','tickets_categories.id','=','tickets.ticket_category')
	    						->where('tickets.user_id',$id)
	    						->orderBy('tickets.id','desc')
	    						->paginate(config('app.pagination'));

	    	return view('ticket.open_ticket')->with(['open_ticket'=>$open_ticket]);

	    }else{

	    	return view('ticket.contact');
	    }
	}
	function getManageTicket(){
		$keyword	= '';
		$from_date	= '';
		$to_date	= '';
		$process	= '';

		$open_ticket=Tickets::select('tickets.id','tickets.ticket_subject',
								'tickets.ticket_code','tickets.status','tickets.assigned_status','tickets.created_at','tickets_categories.ticket_category')
	    						->join('tickets_categories','tickets_categories.id','=','tickets.ticket_category');

	    if(isset($_GET['keyword']) && $_GET['keyword']!=''){
	    	$keyword=$_GET['keyword'];

	    	$open_ticket=$open_ticket->where('tickets.ticket_subject','like','%'.$keyword.'%')->orWhere('tickets.ticket_description','like','%'.$keyword.'%');
		}

		if(isset($_GET['from_date']) && trim($_GET['from_date'])!='' && isset($_GET['to_date']) && trim($_GET['to_date'])!='') {
			$from_date	= $_GET['from_date'];
			$to_date	= $_GET['to_date'];

            $open_ticket=$open_ticket->whereDate('tickets.created_at','>=',trim($from_date)); 
            $open_ticket=$open_ticket->whereDate('tickets.created_at','<=',trim($to_date)); 
        }

        if(isset($_GET['process']) && $_GET['process']!=''){
        	$process=$_GET['process'];

        	if($_GET['process']=='close' || $_GET['process']=='under process'){
        	$open_ticket=$open_ticket->where('tickets.status','like','%'.$process.'%');
	    	}else{
	    		$open_ticket=$open_ticket->where('tickets.assigned_status','like','%'.$process.'%');
	    	}
        }
	    $open_ticket=$open_ticket->orderBy('tickets.id','desc')
	    						->paginate(config('app.pagination'));

	    return view('ticket.admin.get_all_ticket')->with(['open_ticket'=>$open_ticket,'keyword'=>$keyword,'from_date'=>$from_date,'to_date'=>$to_date,'process'=>$process]);
	}
	function deleteTicket(Request $request){
		$ticket_code	= $request->ticket_code;

		$data=Tickets::select('ticket_attachement')->where('ticket_code',$ticket_code)->first();

		foreach(json_decode($data->ticket_attachement) as $value){
			
			unlink(storage_path('app/ticket_attachment/').$value);
		}
		
		Tickets::where('ticket_code',$ticket_code)->delete();
		TicketComments::where('ticket_id',$ticket_code)->delete();

		return redirect()->back()->with(['status'=>'Successfully deleted']);
	}
	function deleteActionTicket(Request $request){
		$ticket_code	= $request->ticket_code;
        $action 		= $request->performAction;

        if (isset($ticket_code) && $action == 1) {

            for($i=0;$i<count($ticket_code);$i++) {

            	$data=Tickets::select('ticket_attachement')->where('ticket_code',$ticket_code[$i])->first();

            	foreach(json_decode($data->ticket_attachement) as $value){

	            	if(file_exists(storage_path('app/ticket_attachment/').$value)){
	            		unlink(storage_path('app/ticket_attachment/').$value);
					}
				}
			}
	        foreach ($ticket_code as $key => $value) {

	            Tickets::where('ticket_code',$value)->delete();
				TicketComments::where('ticket_id',$value)->delete();
	        } 

	        return redirect()->back()->with(['status'=>"successfully deleted"]);
    	}

		if (isset($ticket_code) && $action == 2){

			foreach ($ticket_code as $key => $value) {

                $data = Tickets::where('ticket_code',$value)->update(['status'=>'open']); 
            } 

            return redirect()->back()->with(['status'=>"Successfully updated"]);
		}

		if (isset($ticket_code) && $action == 3){

			foreach ($ticket_code as $key => $value) {

                $data = Tickets::where('ticket_code',$value)->update(['status'=>'close']); 
            } 

            return redirect()->back()->with(['status'=>"Successfully updated"]);
		}
		
	}
	function myTicket($ticket_id){
		$view_file=Tickets::getTicketData($ticket_id);

	    return view('ticket.admin.comment')->with($view_file);
	    
	}
	function sendComment(Request $request){
		$request->validate([
		    'message' => 'required|max:500',
		]);

		$id 			= Auth::user()->id;
		$ticket_id  	= $request->ticket_id;
		$description 	= $request->message;
		$email 			= $request->email;
		$ticket_subject = $request->ticket_subject;

		TicketComments::create(['ticket_id'=>$ticket_id,'description'=>$description,'user_id'=>$id]);

		$name 	=Auth::user()->name;
		$subject="Re: ".ucfirst($ticket_subject);

		$mailContent=array('ticket_code'=>$ticket_id,'description'=>$description,'name'=>$name);

		Mail::to($email)->send(new Ticket($mailContent,$subject));

		return redirect()->back()->with(['status'=>'Successfully receive. We will reply as soon as.']);
	}
	function userTicket($ticket_id){
		$view_file=Tickets::getTicketData($ticket_id);
		
	    return view('ticket.comment')->with($view_file);
	}
}

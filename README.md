##laravel-5.4-simple-ticket-management
```
Very simple and useful ticket management system for Laravel 5.4 for frontend logged in users and Admin panel. Dependency is Auth module
```
##Getting Started
```
These instructions will get you a copy of the project up and running on your local machine for development and testing purposes. See deployment for notes on how to deploy the project on a live system.
```
-[Route:-Copy all routes in web.php file and paste in your web.php file]
-[Upload folder:-Create "ticket_attachment" folder in storage\app and create "images" folder in public folder]
-[Controller:-Copy TicketController in app\http controller folder and paste in your app\http controller folder]
-[View:-Copy Ticket folder inside resources->views folder]
-[Model:-Copy all models inside models folder]
-[Js:-Copy .js files in js folder and paste in your js folder]
-[Css:-Copy .css files in css folder and paste in your css folder]

## Frontend URL
```
http://localhost/ticket/create-ticket
http://localhost/ticket/ticket

```
##Backend URL
```
http://localhost/ticket/admin/manage-ticket
```
-[Copy Functions of script and Modal which is given below and paste in your layout file]
##Functions of script
```
<script type="text/javascript">

    $(document).ready(function(){
        $("#checkAll").click(function(){
            $('input:checkbox').not(this).prop('checked', this.checked);
        });
    });
    $('.checked_all').on('change', function() {     
        $('.checkbox').prop('checked', $(this).prop("checked"));              
    });
    //deselect "checked all", if one of the listed checkbox product is unchecked amd select "checked all" if all of the listed checkbox product is checked
    $('.checkbox').change(function(){ //".checkbox" change 
        if($('.checkbox:checked').length == $('.checkbox').length){
               $('.checked_all').prop('checked',true);
        }else{
               $('.checked_all').prop('checked',false);
        }
    });
    $(function () {
        //Date picker
        $('.datepicker').datepicker({
          autoclose: true,
          format: 'yyyy-mm-dd'
        });
    });
    function checkValidateUser(){

        var userstatus=$('#actiononuser').find(":selected").val();
        var total=$('.deleteSelected:checked').length;

        if(total>0 && userstatus == ""){
            $('#error').html('Please select action');
        }
        else if(total== "" && userstatus == ""){
          $('#error').html('Please select record and action');
        }
        else if(total>0 && userstatus != "") {
            $('#form').submit();
        } 
        else {
            $('#error').html('Please select at least one record');
        }
    }
</script>
<script>
  $(function () {
    $('.textarea').wysihtml5();
  });

</script>
``` 
##Bootstrap Modal(PopUp)
```
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <form id="activate-user-model-form" method="post" action="">
       {{ csrf_field() }}
       <input type="hidden" id="ticket_code" name="ticket_code" value="">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body" id="makeUserAsActiveBody">
            </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-danger">Submit</button>
          </div>
        </div>
    </form>
  </div>
</div>
```
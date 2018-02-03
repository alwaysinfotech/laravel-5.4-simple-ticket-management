@extends('ticket.emails.ticket-layout')
@section('content')

<table border="1" cellpadding="1" cellspacing="1" style="background: transparent;/* padding: 6px; */color: #424242; border:none; width: 100%; font-size: 12px;">
    <tbody style="background:#EBEBEB; border: solid thin #ebebeb; font-weight: bold; ">
      <tr>
        <td style="border: solid thin #ebebeb;font-variant: small-caps;padding: 5px;">Name</td>
        <td style="border: solid thin #ebebeb;font-variant: small-caps;padding: 5px;"> Ticket Id</td>
      <tr>
        <td style="border: solid thin #ebebeb;font-variant: small-caps;padding: 5px;">{{ $name }}
        </td>
        <td style="border: solid thin #ebebeb;font-variant: small-caps;padding: 5px;">{{ $ticket_code }}
        </td>
      </tr>
      @if(isset($description) && $description!='')
      <tr>
        <td colspan="2" style="border: solid thin #ebebeb;font-variant: small-caps;padding: 5px;"> Description</td>
      </tr>
      <tr>
        <td colspan="2" style="border: solid thin #ebebeb;font-variant: small-caps;padding: 5px;">{{ucfirst(strip_tags($description)) }}
      </tr>
      @endif
    </tbody>
  </table>

@endsection
@extends('messages.layout')
 
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Messages List</h2>
                <a href="{{ route('message.create') }}">Send Message</a>
            </div>
        </div>
    </div>
   
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
   
    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>From</th>
            <th>Body</th>
        </tr>
        @foreach ($messages as $msg)
        <tr>
            <td>{{ ++$i }}</td>
            <td>{{ $msg->from }}</td>
            <td>{{ $msg->body }}</td>
        </tr>
        @endforeach
    </table>
  
    {!! $messages->links() !!}
      
@endsection
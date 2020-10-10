<table>
	<thead>
		<tr>
			<th>Sl.No</th>

			<th>Name</th>
			
			<th>Email</th> 
			
			<th>Phone Number</th> 
			
			<th>Enquire About</th>                                         

			<th>Message</th>

			<th>Submitted Date</th>
			
		</tr>
	</thead>
	<tbody>
	    @if( !empty($contact) && $contact->count() >0 )
			<?php $inc = 1; ?>
			@foreach($contact as $item)
					<tr>
						<td>{{$inc++}}</td>
						<td>{{$item->cu_name}}</td>
						<td>{{$item->cu_email}}</td>
						<td>{{$item->cu_phone_code}}{{$item->cu_phone_number}}</td>
						<td>{{$item->cu_enquire_about}}</td>
						<td>{{$item->cu_message}}</td>
						<td>{{date('d M Y h:i A',strtotime($item->created_at))}}</td>					
					</tr>
			@endforeach
	    @endif
	</tbody>
</table>

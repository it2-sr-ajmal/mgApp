@extends('admin.layouts.master')
@section('content')
  @section('bodyClass')
    @parent 
        hold-transition skin-blue sidebar-mini
  @stop
    <div class="container-fluid dashboard-content">
        <div class="row">

            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card">
                    <div class="card-header d-flex">
                        <h3 class="card-header-title">Users List</h3>   
                        <!-- <a href="{{ apa('users/create') }}" class="btn btn-outline-success ml-auto">Create New</a>   -->             
                    </div>
                    @include('admin.users.list_filters')                    
                    <div class="card-body border-top" style="{{(empty($userMessage)) ? 'display: none' : ''}}">                     
                        @include('admin.common.user_message')           
                    </div>
                    <div class="card-body border-top">
                        <h4>{{ $users->total() }} results found.</h4>
                        <div class="table-responsive ">
                            <table class="table table-bordered ">
                                <thead>
                                    <tr>
                                        <th scope="col" width="50px"  class="text-center">#</th>
                                        <th scope="col">Details</th>                                                                          
                                        <th scope="col">Register From</th>                                                                          
                                        <th scope="col">Email Verified</th>                                                                          
                                        <th scope="date" width="220px">Date</th>                                            
                                        <th scope="col" class="text-center">Status</th>
                                        <th scope="col" width="130px" class="text-center">Update</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if( !empty($users) && $users->count() >0 )
                                            <?php $inc = getPaginationSerial($users);   ?>
                                            @foreach($users as $user)
                                            <?php $statusChangeUrl = URL::to(Config::get('app.admin_prefix').'/users/changestatus/'.$user->id.'/'.$user->status); ?>
                                                <tr>
                                                    <th class="text-center">{{ $inc++ }}</th>
                                                    <td>{{ $user->user_full_name }}
                                                        <br/><span class="text-muted">{{ $user->user_email }}</span>
                                                    </td> 
                                                 	<td>{{ $user->registerType()}}</td>												
                                                 	<td>
													       @if($user->user_email_confirmed==1)
															<span class="bt-content">
															  <span class="badge badge-success text-white font-weight-normal">Verified</span>
														    </span>
															@else
															<span class="bt-content">
															  <span class="badge badge-danger text-white font-weight-normal">Not Verified</span>
														    </span>
															<a href="{{ apa('resend-verification-link/'.$user->id) }}"  title="edit" class="btn btn-outline-success btn-sm">Resend verification link</a>
                                                            															
															
															@endif
															
													
													
													</td>												
                                                    <td>{{ date('dS F, Y H:i a',strtotime($user->created_at)) }}</td>
                                                    <td class="status text-center">{!! getAdminStatusIcon($user->user_status,$statusChangeUrl) !!}</td>
                                                    <td class="text-center">
                                                        <a href="{{ apa('users/update/'.$user->id) }}"  title="edit" class="btn btn-outline-success btn-sm">View</a>
                                                        @if($user->is_system_account == 2)
                                                            <a href="{{ apa('users/delete/'.$user->id) }}"  title="edit" class="btn btn-outline-success btn-sm danger">Remove</a>
                                                        @endif
														@if($user->user_email_confirmed==2)
															<a href="{{ apa('verify-user/'.$user->id) }}"  title="edit" class="btn btn-outline-info btn-sm verify-user">Verify</a>
														@endif
														 
                                                    </td>                                                
                                                </tr>
                                            @endforeach
                                      <tr>
                                       <td colspan="7">{{ $users->appends(request()->all())->links() }}</td>
                                      </tr>
                                    @else
                                     <tr>
                                       <td colspan="7">{{lang('no_details_found')}}</td>
                                     </tr>  
                                    @endif
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>

           
        </div> 
		
       <?php /* <div class="row">
            <div class="col-sm-12">
				@include('admin.common.user_message')
			</div>
            
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card">
                    <div class="col-sm-12 card-header my-table-header">
                        <div class="row align-items-center">
                            <div class="col-sm-6"><h5 class="">{{ $users->total() }} results found.</h5></div>
                            
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive-md">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
										
                                        <th scope="col">#</th>

                                        <th scope="col">Name</th>
                                        
                                        <th scope="col">Email</th>
                                        
                                        <!-- <th scope="col">User Role</th> -->

                                        <th scope="date">Date</th>                                            

										<th scope="col">Current Status</th>

                                        <th scope="col">Update</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if( !empty($users) && $users->count() >0 )
                                        <?php $inc = getPaginationSerial($users); 	?>
                                        @foreach($users as $user)
										<?php $statusChangeUrl = URL::to(Config::get('app.admin_prefix').'/users/changestatus/'.$user->id.'/'.$user->status); ?>
                                            <tr>
                                                <th scope="row">{{ $inc++ }}</th>
                                                <td>{{ $user->user_full_name }}</td>
                                                <td>{{ $user->user_email }}</td>
											
												<td>{{ date('dS F, Y H:i a',strtotime($user->created_at)) }}</td>
												<td>
													{!! getAdminStatusIcon($user->user_status,$statusChangeUrl) !!}
												</td>

												<td class="manage">
													<ul>
														<li>
															<a href="{{ apa('users/update/'.$user->id) }}"  title="edit"><i class="far fa-edit"></i></a>
														</li>
														@if($user->is_system_account == 2)
															<li>
																<a class="deleteRecord" href="{{ apa('users/delete/'.$user->id) }}"  title="delete" ><i class="fa fa-trash"></i></a>
															</li>
														@endif
													</ul>
												</td>
												
                                            </tr>
                                        @endforeach
										<tr>
										<td colspan="7">{{ $users->links() }}</td>
										</tr>
                                    @else
                                        <tr class="no-records">
											<td colspan="7" class="text-center text-danger">No records found!</td>
										</tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
          
        </div> */ ?>
        
            
                
     </div>
@stop
@section('scripts')
@parent

<script>
$('.verify-user').on('click',function(e){
	e.preventDefault();
	var url = $(this).attr('href');
	Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.value) {
                    window.location.href = url;
                   
                }
            })
	
	
})

</script>

@stop

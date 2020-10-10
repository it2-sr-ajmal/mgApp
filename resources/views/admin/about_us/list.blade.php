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
                    <h3 class="card-header-title">About Us</h3>                    
                </div>
                
                <div class="card-body border-bottom" style="{{(empty($userMessage)) ? 'display: none' : ''}}">                      
                    @include('admin.common.user_message')           
                </div>
                <div class="card-body ">
                    <h4>{{ $post_items->count() }} results found.</h4>
                    <div class="table-responsive ">
                        <table class="table table-bordered ">
                            <thead>
                                <tr>
                                    <th scope="col" width="50px"  class="text-center">#</th>                                                                        
                                    <th scope="col" style="width: 70%;">Title</th> 
                                    @if($buttons['status'] )
                                        <th scope="col" class="text-center">Status</th>
                                    @endif                                                                                                   
                                    <th scope="col" class="text-center">Action</th>                                 
                                </tr>
                            </thead>
                            <tbody>
                                @if( !empty($post_items) && $post_items->count() >0 )
                                        <?php $inc = getPaginationSerial($post_items);  ?>
                                        @foreach($post_items as $item)
                                        <?php
                                            
                                            $statusChangeUrl = route('post_change_status',[$postType,$item->post_id,$item->post_status]);
                                        ?>
                                            <tr>
                                                <td class="text-center">{{ $inc++ }}</td>
                                                <td>{!!  $item->post_title !!}</td>                                                                                             
                                                @if($buttons['status'] )
                                                    <td class="status text-center">
                                                        {!! getAdminStatusIcon($item->post_status,$statusChangeUrl) !!}
                                                    </td>
                                                @endif
                                                
                                                {!! getAdminActionIcons($buttons,$postType,$item) !!}
                                            </tr>
                                        @endforeach
                                    @else
                                    <tr>
                                        <td colspan="4">@lang('global.app_no_entries_in_table')</td>
                                    </tr>
                                @endif
                                    
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>


        </div> 
        <?php /*<div class="row">
			<div class="col-sm-12">
				@include('admin.common.user_message')
			</div>
           
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card">
                    <div class="col-sm-12 card-header my-table-header">
                        <div class="row align-items-center">
                            <div class="col-sm-6"><h5 class="">{{ $post_items->count() }} results found.</h5></div>                         
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive-md">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        
                                        <th scope="col">Title</th>
										@if($buttons['status'] )
											<th scope="col">Current Status</th>
										@endif
                                        <th scope="col">Update</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if( !empty($post_items) && $post_items->count() >0 )
                                        <?php $inc = getPaginationSerial($post_items); 	?>
                                        @foreach($post_items as $item)
										<?php
											
											$statusChangeUrl = route('post_change_status',[$postType,$item->post_id,$item->post_status]);
										?>
                                            <tr>
                                                <th scope="row">{{ $inc++ }}</th>
                                                <td>{!!  $item->post_title !!}</td>                                              
												
												@if($buttons['status'] )
													<td>
														{!! getAdminStatusIcon($item->post_status,$statusChangeUrl) !!}
													</td>
												@endif

												
												{!! getAdminActionIcons($buttons,$postType,$item) !!}
                                            </tr>
                                        @endforeach
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
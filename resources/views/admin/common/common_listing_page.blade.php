@extends('admin.layouts.master')
@section('content')
  @section('bodyClass')
    @parent
        hold-transition skin-blue sidebar-mini
  @stop
    <div class="container-fluid dashboard-content">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="page-header">
                    <h2 class="pageheader-title">Manage Digital Domains
						@if($buttons['add'] )
						<a class="float-sm-right" href="{{ route('post_create',$postType) }}">
							<button class="btn btn-success btn-flat">Create New</button>
						</a>
						@endif
					</h2>
                </div>
            </div>
        </div> 
        <div class="row">
			<div class="col-sm-12">
				@include('admin.common.user_message')
			</div>
            <!-- ============================================================== -->
            <!-- striped table -->
            <!-- ============================================================== -->
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card">
                    <div class="col-sm-12 card-header my-table-header">
                        <div class="row align-items-center">
                            <div class="col-sm-6"><h5 class="">{{ $post_items->count() }} results found.</h5></div>
                            <?php /*<div class="col-sm-6"><h5 class="text-right">Showing {{ $hubList->currentPage() }} of {{  $hubList->total() }} pages</h5></div> */ ?>
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
                                              <?php /*  <td>{!! $item->post_title_arabic !!}</td> */ ?>
												
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
							@include('admin.common.pagination_links')
                        </div>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- end striped table -->
            <!-- ============================================================== -->
        </div>
        
            
                
     </div>
@stop
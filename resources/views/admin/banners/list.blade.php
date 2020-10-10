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
                    <h3 class="card-header-title">Website Banner</h3>
                    @if($buttons['add'] )
                        <a class="btn btn-outline-success btn-flat ml-auto" href="{{ route('post_create',$postType) }}">Create New</a>
                    @endif
                </div>
                
                <div class="card-body border-bottom" style="{{(empty($userMessage)) ? 'display: none' : ''}}">                      
                    @include('admin.common.user_message')           
                </div>
                <div class="card-body ">
                    <h4>{{ $post_items->total() }} results found.</h4>
                    <div class="table-responsive ">
                        <table class="table table-bordered ">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">Banner</th>
                                    <th scope="col">Banner mobile</th>
                                    @if($buttons['status'] )
                                    <th scope="col">Current Status</th>
                                    @endif
                                    <th scope="col">Update</th>                             
                                </tr>
                            </thead>
                            <tbody>
                                @if( !empty($post_items) && $post_items->count() >0 )
                                <?php $inc = getPaginationSerial($post_items); ?>
                                @foreach($post_items as $item)
                                <?php
                                $statusChangeUrl = route('post_change_status', [$postType, $item->post_id, $item->post_status]);
                                ?>
                                <tr>
                                    <th scope="row">{{ $inc++ }}</th>
                                    <td>{!!  $item->post_title !!}</td>
									<td>
									  <img src="{{PT($item->getData('banner_image'))}}" width='100'>
									</td>
									<td>
									  @if($item->getData('banner_image_mob'))
									  <img src="{{PT($item->getData('banner_image_mob'))}}" width='100'>
								      @endif
									</td>
                                    @if($buttons['status'] )
                                    <td>
                                        {!! getAdminStatusIcon($item->post_status,$statusChangeUrl) !!}
                                    </td>
                                    @endif

                                    {!! getAdminActionIcons($buttons,$postType,$item) !!}
                                </tr>
                                @endforeach
								 <tr >
                                    <td colspan="7" >{{ $post_items->links() }}</td>
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

    </div> 


  


</div>
@stop
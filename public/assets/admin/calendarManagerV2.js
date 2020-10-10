var calendarManager = (function(){
	var _this = this, _dateTimeFormat="YYYY-MM-DD HH:mm", selDate, operationPerformed = false , blockTableID = '#blockingDetailsTable', dynaSpaceSelectBoxClass = '.blockingTblSpaceSelect';
	_this.utils = {

				sendAjax: function (url,type,dataToSend,func,loaderDivID){
						if(loaderDivID){ $(loaderDivID).show(); }
						$.ajax({
							url:url,
							type:type,
							async:true,
							data:dataToSend,
							dataType:'json',
							statusCode: {
								302:function(){ console.log('Forbidden. Access Restricted'); },
								403:function(){ console.log('Forbidden. Access Restricted','403'); },
								404:function(){ console.log('Page not found','404'); },
								500:function(){ console.log('Internal Server Error','500'); }
							}
						}).done(function(responseData){
							if(loaderDivID){$(loaderDivID).hide();}								
							func(responseData);	
												
						});
				},
				getSelectedDate : function(){
					return selDate;
				},
				_redrawFullTableAndBindEventsFromAjaxResponse: function(responseData){
					if(responseData.status){

						monthlyUserBookings = responseData.userBookings;
						monthlyEvents = responseData.eventBookings;
						monthlyBlocks = responseData.adminBlocks;
                        
                        
						$( "#selectableTableCells" ).selectable( "destroy" );
						$('#dailyDetailsWrapper').html(responseData.responseHTML);
						$('#selectedDateForDetails').html(responseData.popupHeader);
						$( "#popupTabs" ).tabs();
						_this.utils.copyBookingDataToCellAttributes();
						_this.BlockTimeSlots.initSelectable();
						var $table = $('#timeSlotWrapper');
						$table.floatThead({
						    scrollContainer: function($table){
						        return $table.closest('#scrollableTableWrapper');
						    }
						});
                        // console.log('#li-'+selDate);
                        $('#li-'+selDate).find('.dayMetaWrapper').html(responseData.calendarCellBlock);
                        $('#li-'+selDate+' .myPopover').popover({
                           placement:'top',
                          trigger: 'click',
                           title: function(){
                               return $(this).attr('title');
                           },
                           html: true,
                           content: function(){
                               var divId = $(this).attr('data-div');  
                               return $('#'+divId).html();
                           }
                        });
                        $('#li-'+selDate+' .myPopover').click(function (e) {
                             
                            e.stopPropagation();
                            $('#li-'+selDate+' > .myPopover').not(this).popover('hide'); //all but this
                        });
					}
				},
				validateAndRetrieveUserSelectionForAdminBlocking:function(){
					var spacesSelectedArr = [], fromTimeArr=[] , toTimeArr=[] , returnObj={status:false,message:'', data:null};
					$('#blockingDetailsTable > tbody > tr').each(function(i,v){
						if($(this).hasClass('spaceTR') && $(this).attr('data-space')){
							var spaceID = parseInt($(this).attr('data-space'));
							if(spaceID > 0 ){
								spacesSelectedArr.push(spaceID);
								var t = $(this).find('.blockTimeStart');
								var sT = $('option:selected' , t).val();
								var t = $(this).find('.blockTimeEnd');
								var eT = $('option:selected' , t).val();

								fromTime = moment( selDate +' '+sT , _dateTimeFormat);
								toTime = moment( selDate +' '+eT , _dateTimeFormat);
								
								if(fromTime.diff(toTime) >= 0){
									returnObj.message = "Invalid block times. Please select a valid time.";
									return returnObj;
								}
								fromTimeArr.push(fromTime.format(_dateTimeFormat));
								toTimeArr.push(toTime.format(_dateTimeFormat));
								// .format(_dateTimeFormat)
								// console.log(sT , eT);
							}
						}
					});

					
					if(spacesSelectedArr.length < 1) {
						returnObj.message = "Please select atleast one space";
						return returnObj;
					}

					if(!selDate) {
						returnObj.message = "Please select a valid date";
						return returnObj;
					}

					var _blockingExplanation = {
						blocking_entity:$('#bookingManagerWrapper').find('input[name="blocking_entity"]').val(),
						blocking_purpose:$('#bookingManagerWrapper').find('input[name="blocking_purpose"]').val(),
					}

					// var sT = $('#blockStartTimeSelect option:selected').val();
					// var eT = $('#blockEndTimeSelect option:selected').val();

					// fromTime = moment( selDate +' '+sT , _dateTimeFormat);
					// toTime = moment( selDate +' '+eT , _dateTimeFormat);
					
					// console.log('loggin');
					// console.log(_blockingExplanation);

					returnObj.status = true;
					returnObj.data = {spaces:spacesSelectedArr,fromTime:fromTimeArr,toTime:toTimeArr,blockingDetails:_blockingExplanation};
					return returnObj;

				},
				removeSelectDuplicateOptions:function(){ // function for removing duplicates from selectboxes if one is selected
					var selectedSpacesToBlock = [];
					$(blockTableID +' > tbody > tr').each(function(i,v){
						var tt = $(this).attr('data-space');
						if(tt){
							selectedSpacesToBlock.push(parseInt(tt));
						}
					});
					$(dynaSpaceSelectBoxClass).each(function(i , sel){
						$('option' , this).each(function(ii, opt){
							 if($.inArray(parseInt(opt.value) , selectedSpacesToBlock) != -1){
							 	$(this).remove();
							 }
						});
					});
				},
				createTimeSlotSelectbox: function(excludeFirst , excludeLast){
					
						var $select = $('<select></select>');
						var timeSlots;
						if(excludeFirst == true ) {
							timeSlots = timeSlotOpts.slice(0, (timeSlotOpts.length-1)); 
						}

						if(excludeLast == true){
							timeSlots = timeSlotOpts.slice(1,timeSlotOpts.length);
						}

					    $.each(timeSlots, function(key, obj) {   
					    	
					         $select.append($("<option></option>")
					                        .attr("value",obj.val)
					                        .text(obj.text));
					    });
					    // console.log(val)
					    /*if(val){
					    	// console.log(val)
					        $select.val(val);
					    }*/
					    return $select;
				},

				createSpaceSelectbox : function(){ // to create a new select box for listing spaces
					$select = $('<select></select>');
					$select.append($('<option>',{
						value: 0,
						text : '-- Select One --'
					}));
					var selectedSpacesToBlock = [];
					$(blockTableID + ' > tbody > tr').each(function(i,v){
						var tt = $(this).attr('data-space');
						if(tt){
							selectedSpacesToBlock.push(parseInt(tt));
						}
					});
					var leftSpaceCount = 0;
					$(allSpaces).each(function(i,v){
						if( $.inArray(parseInt(v.team_id) , selectedSpacesToBlock) == -1 ){
							$select.append($('<option>',{
								value: v.space_id,
								text : v.space_title
							}));
							leftSpaceCount++;
						}
					});
					$select.addClass('blockingTblSpaceSelect').addClass('form-control');
					if(leftSpaceCount < 1) return false;
					return $select;
				},
				rectifySerialNumberAndRowSpan: function(){
					$(blockTableID + ' > tbody > tr').find('td:nth-child(1)').each(function(i,v){
						$(this).html(i+1);
					});
					$('#timeSlotTD').attr('rowspan',$(blockTableID +' > tbody > tr').length);
				},
				copyBookingDataToCellAttributes : function(){
					$('.occupiedCell').each(function(i,v){
						var id = $(this).data('id');
						var type = $(this).data('type');
						$(this).closest('td').attr('data-ocType',type);
						$(this).closest('td').attr('data-ocId',id);
					});
				},
			
				createTableBasedOnSelectableArea: function(selDate){
					var infoHTML = '', selectedSpaces=[], selectedStartTime, selectedEndTime, userBookingOverlaped = false, 
					eventOverlapped = false, blockOverlapped = false, blockIDs=[], bookingIDs =[], eventIDs=[], startTime=[], tempSpaceNames = []; 
					dataToSend = { _token: window.Laravel.csrfToken , blocking_date: selDate, spaces:[],team_from_time:[], team_to_time:[]};
					bookingIDs =[], eventIDs=[], startTime=[], tempSpaceNames = []; 
					$('#occupiedDetails').html('');
					$('.ui-selected').each(function(i,v){

						if($(this).hasClass('eventBooking')){
							eventOverlapped = true;
							eventIDs.push($(this).data('ocid'));
							// eventIDs.push($(this).find())
						}



						if($(this).hasClass('userBooking')){
							userBookingOverlaped = true;
							bookingIDs.push($(this).data('ocid'));
						}

						if($(this).hasClass('adminBooking')){
							blockOverlapped = true;
							blockIDs.push($(this).data('ocid'));
						}

					    var cellIndex = $(this).index();
					    var rowIndex = $(this).closest('tr').index();
					    var spaceID = parseInt($(this).attr('data-space'));
					    startTime.push($(this).attr('data-time'));

					    var spaceAdded = false;
					    $(selectedSpaces).each(function(i,v){
					        if (v == spaceID){
					            spaceAdded = true;
					        }
					    });
					    if(!spaceAdded){
					        selectedSpaces.push(spaceID);
					        tempSpaceNames.push($(this).attr('data-space-name'));
					    }
					});

					var uniqueArray = eventIDs.filter(function(item, pos) {
					    return eventIDs.indexOf(item) == pos;
					});

					eventIDs = uniqueArray;

					var uniqueArray1 = bookingIDs.filter(function(item, pos) {
					    return bookingIDs.indexOf(item) == pos;
					});

					bookingIDs = uniqueArray1;

					var sTime = startTime.sort(function (a,b) {
					                if(a > b) { return -1; }
					                if(a < b) { return 1; }    
					                return 0;
					            });					

					if(sTime.length < 1){
						return false; // selected on other areas
					}

					infoHTML = '<h3>Block Selected TimeSlots?</h3>';
					infoHTML += '<table id="blockingDetailsTable" class="adminBlockTable table table-bordered">';
					infoHTML += '<thead><tr><th >Sl.No</th><th style="width:350px">Space <a  title="Add Space" class="addBlockingSpaceAnchor" href="#"><i class="fa fa-plus-square" aria-hidden="true"></i></a></th><th>Time</th></tr></thead>';
					infoHTML += '<tbody>';


					var tt = 0;
					$(tempSpaceNames).each(function(i,v){
					    infoHTML += '<tr class="spaceTR" data-space="'+selectedSpaces[i]+'">';
					        infoHTML += '<td style="text-align:center">';
					            infoHTML += tt+1;
					        infoHTML += '</td>';
					        infoHTML += '<td>';
					            infoHTML += v;
					        infoHTML += '</td>';
					        infoHTML += '<td class="timeSlotTD" style="vertical-align:middle; text-align:center" >';
					                 var $fromSelect =     _this.utils.createTimeSlotSelectbox( true , false);
					                 var $toSelect =     _this.utils.createTimeSlotSelectbox(false, true);
					                 $fromSelect.addClass('blockTimeSelects').addClass('blockTimeStart').attr('name','blockFromTime[]');
					                 $toSelect.addClass('blockTimeSelects').addClass('blockTimeEnd').attr('name','blockToTime[]');
		                 	infoHTML += $fromSelect.get(0).outerHTML +' to '  +$toSelect.get(0).outerHTML;
				            infoHTML += '</td>';

					       /* if(tt==0){
					        	
					            infoHTML += '<td id="timeSlotTD" style="vertical-align:middle; text-align:center" rowspan="'+tempSpaceNames.length+'">';
					                 var $fromSelect =     _this.utils.createTimeSlotSelectbox( true , false);
					                 var $toSelect =     _this.utils.createTimeSlotSelectbox(false, true);
					                 $fromSelect.addClass('blockTimeSelects').attr('name','blockFromTime').attr('id','blockStartTimeSelect');
					                 $toSelect.addClass('blockTimeSelects').attr('name','blockToTime').attr('id','blockEndTimeSelect');
					                 infoHTML += $fromSelect.get(0).outerHTML +' to '  +$toSelect.get(0).outerHTML;
					            infoHTML += '</td>';
					        }*/

					    infoHTML += '</tr>';
					    tt++;
					});

					infoHTML += '</tbody></table>';

					// console.log(userBookingOverlaped);

					if(userBookingOverlaped == true){
                        // console.log('User Overlapped');
						var tt = _this.utils.getOverlappedBookingDetailsTable(bookingIDs);
						var warning = '<div class="warningDiv">'+
				                '<h4><i class="icon fa fa-warning"></i> User bookings found on the selected time slots!</h4>'+
				                'You can either cancel the below user bookings or preserve it.'+
				              '</div>';
						$('#occupiedDetails').append(warning);
						$('#occupiedDetails').append(tt);
					}

					if(eventOverlapped == true){
                        // console.log('Event Overlapped',eventIDs);
						var tt = _this.utils.getOverlappedEventDetailsTable(eventIDs);
						var warning = '<div class="warningDiv">'+
				                '<h4><i class="icon fa fa-warning"></i> Events found on the selected time slots!</h4>'+
				                'Please go to <a target="_blank" style="text-decoration:underline;color:#2078c3" href="'+eventsPageURL+'">events</a> menu to manage events.'+
				              '</div>';
						$('#occupiedDetails').append(warning);
						$('#occupiedDetails').append(tt);
						
					}

					//Append Other Admin Blockings 
					var tt = _this.utils.getDailyAdminBlockDetailsTable(selDate);

					if(tt != false){
						var warning = '<h3>Other Admin Blocks For The Day</h3>';
						$('#occupiedDetails').append(warning);
						$('#occupiedDetails').append(tt);
					}

					$('#selectedTimeSlotsWrapper').html(infoHTML);

					var tmp =  moment( selDate +' '+sTime[0], _dateTimeFormat);
		        	var adjustedEndTime = tmp.add(30,'minutes').format('HH:mm');

					$('.blockTimeStart').val(sTime[sTime.length-1]);
					$('.blockTimeEnd').val(adjustedEndTime);


					$('#bkMgrDate').html(moment(selDate).format('Do MMMM, YYYY'));

					

				},
				getOverlappedBookingDetailsTable : function(bookingIDs){
					
					if(typeof bookingIDs != 'object') return false;
					if(!bookingIDs.length) return false;

					var $table = $('<table></table>');
					$table.addClass('table').addClass('table-striped');
					var $tbody = $('<tbody></tbody>');
					var $thead = $('<thead><tr><th>Sl.No</th><th>Booking ID</th><th>Booked By</th><th>Time & Duration</th><th>Booked Space & Type</th><th>Booking Purpose</th><th style="width:35%">Cancel Options</th></tr></thead>');
					
					var slNo =0; 
					$(bookingIDs).each(function(i,v){
						

						$cur = null;
						$(monthlyUserBookings).each(function(ind,val){ 

							if(val.bookingID == v){
								$tr = $('<tr>');
								var tdHTML = '<td>'+(++slNo)+'</td><td>'+val.bookingID+'</td><td>'+val.bookedBy+'</td>';
								tdHTML += '<td>'+val.startTime+' to '+val.endTime+' ['+ val.bookedDuration +']' +'</td>';
								tdHTML += '<td>'+val.spaceNameEn+' - '+((val.sb_room_type)?' Meeting Room ':' Space ') +'</td>';
								tdHTML += '<td>'+val.purpose_txt +'</td>';
								tdHTML += '<td style="text-align:center"><div><input type="checkbox" class="reasonLangSwitch"/> Arabic </div>'+
										  '<textarea class="form-control" placeholder="Reason for cancellation" class=""></textarea>'+
										  ' <button data-id="'+val.bookingID+'" class="cancelBookingBtn">Cancel Booking</button>'+
										  '<div class="cancelLoader"><img src="'+(window.baseURL+'assets/admin/images/ajax-loader.gif')+'" /></div></td>';
								$tr.append(tdHTML);
								$tbody.append($tr);
								
							}
						});

					});
					$table.append($thead);
					$table.append($tbody);
					return $table;
				},
				getOverlappedEventDetailsTable : function(eventIDs){
					if(typeof eventIDs != 'object') return false;
					if(!eventIDs.length) return false;
					var $table = $('<table></table>');
					$table.addClass('table').addClass('table-striped');
					var $tbody = $('<tbody></tbody>');
					var $thead = $('<thead><tr><th>Sl.No</th><th>Event Title</th><th>Time & Duration</th><th>Event Space</th></tr></thead>');
					
					var slNo =0; 
					$(eventIDs).each(function(i,v){
						// console.log(monthlyEvents);

						$cur = null;
						$(monthlyEvents).each(function(ind,val){ 
							if(val.bookingID == v){
								$tr = $('<tr>');
								var tdHTML = '<td>'+(++slNo)+'</td><td>'+val.eventNameEn+'</td><td>'+val.date+' ['+val.startTime+'-'+val.endTime+'] </td>';
								tdHTML += '<td>'+val.spaceNameEn+'</td>';
								$tr.append(tdHTML);
								$tbody.append($tr);
								
							}
						});

					});
					$table.append($thead);
					$table.append($tbody);
					return $table;
				},
				getDailyAdminBlockDetailsTable : function(dat){

					var adminBlockPresent = false;
					var $table = $('<table></table>');
					$table.addClass('table').addClass('table-striped');
					var $tbody = $('<tbody></tbody>');
					var $thead = $('<thead><tr><th>Sl.No</th><th>Space</th><th>From</th><th>To</th><th style="text-align:center;width:200px">Operation</th></tr></thead>');
					
					var slNo =0; 
						$cur = null;
						$(monthlyBlocks).each(function(ind,val){ 
							if(val.date == dat && val.bookingStatus == 1){
								adminBlockPresent = true;
								$tr = $('<tr>');
								var tdHTML = '<td>'+(++slNo)+'</td><td>'+val.spaceNameEn+'</td><td>'+val.startTime+'</td>';
								tdHTML += '<td>'+val.endTime+'</td>';
								tdHTML += '<td><a class="deleteBlock" data-blockID="'+val.bookingID+'" href="#">Delete</a></td>';
								$tr.append(tdHTML);
								$tbody.append($tr);
								
							}
						});
					$table.append($thead);
					$table.append($tbody);
					return (adminBlockPresent == true )?$table:false;
				},
				openFancyBox: function(){
					$.fancybox.open({
						   	titleShow:true,
							src  : '#bookingManagerWrapper',
							width:'600px',
							type : 'inline',
							clickOutside: false,
                           
							opts : {
                                touch: false,
								helpers : {
						            title : {
						                type: 'inside',
						                position : 'top'
						            },
				             	 	overlay : {
							            closeClick  : false
							        }
						        },
						        beforeLoad:function(){
						        	$( "#bookingManagerTabs" ).tabs( "option", "active", 1 );
						        	$('#blockSuccessMessage').html('').fadeOut();
                                    $('[name="blocking_entity"]').val('');
                                    $('[name="blocking_purpose"]').val('');
						        },
							   	afterShow: function() {
									tinyMCE.remove();
							    	tinymce.init({
										mode : "exact",
										selector: '.editorEN',
										plugins: ["link", "paste", "spellchecker", "preview", "fullscreen", "code", "table", "directionality","media","image"],
										toolbar: ["media | image | fullscreen | undo redo | ltr rtl  | filemanager  | bullist numlist |styleselect | bold italic | aligncenter alignright alignjustify | link"],
									});
									tinymce.init({
										mode : "exact",
										selector: '.editorAR',
										plugins: ["link", "paste", "spellchecker", "preview", "fullscreen", "code", "table", "directionality","media","image"],
										toolbar: ["media | image | fullscreen | undo redo | ltr rtl  | filemanager  | bullist numlist |styleselect | bold italic | aligncenter alignright alignjustify | link"],
										 directionality : "rtl",
									});
							   	},
							   	beforeClose:function(){
							   		$('#blockBtn').removeAttr('disabled').removeClass('disabledBtn');
							   		$('.ui-selected').removeClass('ui-selected');	
							   	}
							}
					});
				}	

	};
	_this.BlockTimeSlots = {
			bindBlockingTableEvents : function(){
				$('#bookingManagerTabs').on('mouseenter','.spaceTR',function(e){
					$(this).find('td:nth-child(2)').append('<a class="delTableRow"><i class="fa fa-times" aria-hidden="true"></i></a>');
				});
			
				$('#bookingManagerTabs').on('mouseleave','.spaceTR',function(e){
					$(this).find('.delTableRow').remove();
				});

				$('#bookingManagerTabs').on('change','.blockingTblSpaceSelect',function(e){
					 var spaceID =  $('option:selected',this).val() , spacename =  $('option:selected',this).text() ;
					 $(this).closest('tr').attr('data-space',spaceID);
					 $(this).closest('td').html(spacename);
					 _this.utils.removeSelectDuplicateOptions();
				});

				$('#bookingManagerTabs').on('change','.blockTimeSelects',function(e){
					var tmpSt = $(this).parent().find('.blockTimeStart');
					var tmpEn = $(this).parent().find('.blockTimeEnd');

					var sT= $('option:selected',tmpSt).val(), eT=$('option:selected',tmpEn).val(),  
					

					startTime = moment( selDate +' '+sT, _dateTimeFormat), endTime = moment( selDate +' '+eT , _dateTimeFormat),  
					startTimeChanged = false;
					
					
					if($(this).hasClass('blockTimeStart')){
					 	startTimeChanged = true;
					}

					// var toTime = $('blockEndTimeSelect option:selected').val();
					if(startTimeChanged == true ){
						if(startTime.diff(endTime) >= 0){
							var newEndTime =  startTime.add(30, 'minutes');
							var newVal = newEndTime.format('HH:mm');
							$(tmpEn).val(newVal);
							$(tmpEn).addClass('glowBorder');
							setTimeout(function(){
								$(tmpEn).removeClass('glowBorder');
							},800);
						}
					}else{

						if(endTime.diff(startTime) <= 0){
							/*var newStartTime =  startTime.subtract(30, 'minutes');
							var newVal = newStartTime.format('HH:mm');
							console.log(newStartTime.format('HH:mm'))
							$('#blockStartTimeSelect').val(newVal);*/
							var newEndTime =  startTime.add(30, 'minutes');
							var newVal = newEndTime.format('HH:mm');
							$(tmpEn).val(newVal);
							$(tmpEn).addClass('glowBorder');
							setTimeout(function(){
								$(tmpEn).removeClass('glowBorder');
							},800);
						}

					}
					 


				});

				$('#bookingManagerTabs').on('click','#blockBtn',function(e){
					// console.log('cccc');
					$('#blockBtn').attr("disabled", "disabled").addClass('disabledBtn');
                    $('#blockErrorMessage').html('').hide();
                    $('#blockSuccessMessage').html('').hide();
				 	var dataToSend = _this.utils.validateAndRetrieveUserSelectionForAdminBlocking();
				 	
				 	dataToSend._token = window.Laravel.csrfToken;
					// console.log(dataToSend);
			 		/* if(dataToSend.status == false){
					 	$('#blErrorWrapper').html(dataToSend.message);
					 	$('#blockErrorMessage').fadeIn();
					 	return;	
				 	} */

				 	_this.utils.sendAjax(blockTimeSlotURL,'post',dataToSend , function(responseData){
				 		
				 		_this.utils._redrawFullTableAndBindEventsFromAjaxResponse(responseData);
							var message = responseData.message;
				 			
				 		if(responseData.status){
                            
				 			$('#blockSuccessMessage').html(message).fadeIn();
				 			setTimeout(function(){
				 					$.fancybox.close();
				 			},1000);
				 			/*$( "#selectableTableCells" ).selectable( "destroy" );
							$('#dailyDetailsWrapper').html(responseData.responseHTML);
							$('#selectedDateForDetails').html(responseData.popupHeader);
							$( "#popupTabs" ).tabs();
							$('#blockSuccessMessage').html(message).fadeIn();
							_this.utils.copyBookingDataToCellAttributes();
							_this.BlockTimeSlots.initSelectable();*/

				 		}else{
                            $('#blockErrorMessage').html(message).fadeIn();
                            $('#blockBtn').removeAttr('disabled').removeClass('disabledBtn');
                        }



				 	}, '#blockAjaxloader');

				});

				$('#dailyDetailsWrapper').on('click','.deleteAdminBlockBatch',function(e){
					e.stopImmediatePropagation();
					// alert('asd');
					e.preventDefault();
					
				});

				/*$('#dailyDetailsWrapper').on('mouseover','td.adminBooking',function(e){
					$(this).find('.deleteAdminBlockBatch').show();
				});

				$('#dailyDetailsWrapper').on('mouseleave','td.adminBooking',function(e){
					$(this).find('.deleteAdminBlockBatch').hide();
				});*/


				$('#bookingManagerTabs').on('click','#cancelBtn',function(e){
					e.preventDefault();
					$.fancybox.close();
				});

				$('#bookingManagerTabs').on('click','.addBlockingSpaceAnchor',function(e){
					e.preventDefault();
					if($('#blockingDetailsTable > tbody > tr').length > allSpaces.length){
						alert('Limit reached. No more spaces/Meeting rooms. ');
						return;
					}
					$spacesSelect = _this.utils.createSpaceSelectbox();
					if(!$spacesSelect) {
						alert('No space or meeting rooms to add');
						return false;
					}
					 var $fromSelect =     _this.utils.createTimeSlotSelectbox( true , false);
	                 var $toSelect =     _this.utils.createTimeSlotSelectbox(false, true);
	                 $fromSelect.addClass('blockTimeSelects').addClass('blockTimeStart').attr('name','blockFromTime[]');
	                 $toSelect.addClass('blockTimeSelects').addClass('blockTimeEnd').attr('name','blockToTime[]');

					$('#blockingDetailsTable > tbody').append('<tr class="spaceTR" ><td style="text-align:center"></td><td>'+$spacesSelect.get(0).outerHTML+'</td><td class="timeSlotTD" style="vertical-align:middle; text-align:center">'+$fromSelect.get(0).outerHTML +' to '  +$toSelect.get(0).outerHTML+'</td></tr>');
					_this.utils.rectifySerialNumberAndRowSpan();
				});

			
				//deleting space row
				$('#bookingManagerTabs').on('click','.deleteBlock',function(e){

					e.preventDefault();

					var bookingId = $(this).attr('data-blockid');
					
					$elem = $(this);
					
					 $(this).parent().append('<img style="padding-left:5px" src="'+window.baseURL+'assets/admin/images/ajax-loader.gif"/>'); 
					
					var dataToSend = {bookingId:bookingId , selDate: selDate};
					dataToSend._token = window.Laravel.csrfToken;
					_this.utils.sendAjax(adminBlockCancelURL,'post',dataToSend , function(responseData){
						_this.utils._redrawFullTableAndBindEventsFromAjaxResponse(responseData);
						 if(responseData.status){
						 	  $elem.closest('tr').addClass('deletedRecord');
						 	  $elem.closest('td').html(responseData.message);

						 }
					});
				});

				$('#bookingManagerTabs').on('click','.cancelBookingBtn',function(e){
					$(this).closest('td').find('.cancelLoader').fadeIn();
					$elem = $(this);
					var dataToSend = {};
					var textarea = $(this).closest('td').find('textarea');
					var langSwitcher = $(this).closest('td').find('.reasonLangSwitch');

					dataToSend._token = window.Laravel.csrfToken;
					dataToSend.bookingId = $(this).attr('data-id');
					dataToSend.cancelReason = $(textarea).val();
					dataToSend.lang = ($(langSwitcher).is(':checked'))?'ar':'en';
					dataToSend.selDate = selDate;

					_this.utils.sendAjax(userBookingCancelURL,'post', dataToSend, function(responseData){
						/*if(responseData.status){
							$( "#selectableTableCells" ).selectable( "destroy" );
							$('#dailyDetailsWrapper').html(responseData.responseHTML);
							$( "#popupTabs" ).tabs();
							_this.utils.copyBookingDataToCellAttributes();
							_this.BlockTimeSlots.initSelectable();
							$elem.closest('td').html(responseData.message);

						}*/
						_this.utils._redrawFullTableAndBindEventsFromAjaxResponse(responseData);
						if(responseData.status){
							$elem.closest('td').html(responseData.message);
						}
					},null);


				});

				$('#bookingManagerTabs').on('click','.delTableRow',function(e){
					if($('#blockingDetailsTable > tbody > tr').length ==1){
						alert('Cannot delete');
						return;
					}
					var $tr = $(this).closest('tr') , trIndex = $tr.index();
					if( trIndex == 0){
						$timeTD = $tr.find('td:nth-child(3)');
						$tr.next().append($timeTD);
					}
					$(this).closest('tr').remove();		
					_this.utils.rectifySerialNumberAndRowSpan();
				});


				//textarea direction
				$('#bookingManagerTabs').on('click','.reasonLangSwitch',function(e){
					if($(this).is(':checked')){
						$(this).closest('td').find('textarea').attr('dir','rtl');
					}else{
						$(this).closest('td').find('textarea').attr('dir','ltr');
					}
				});


				$('.dailyDetails').on('click',function(e){
					// alert('asd');
					e.preventDefault();
					$('#dailyDetailsWrapper').html('<div id="dataLoading"> <img src="'+window.baseURL+'/assets/admin/images/ajax-loader.gif">Loading content...</div>');
					selDate = $(this).attr('data-date');

					$.ajax({
						url:dailyURL+selDate,
						type:"GET",
						async:true,
					
						dataType:'json',
						statusCode: {
							302:function(){ console.log('Forbidden. Access Restricted'); },
							403:function(){ console.log('Forbidden. Access Restricted','403'); },
							404:function(){ console.log('Page not found','404'); },
							500:function(){ console.log('Internal Server Error','500'); }
						}
					}).done(function(responseData){
						/*if(responseData.status){
							$( "#selectableTableCells" ).selectable( "destroy" );
							$('#dailyDetailsWrapper').html(responseData.responseHTML);
							$('#selectedDateForDetails').html(responseData.popupHeader);
							$( "#popupTabs" ).tabs();
							_this.utils.copyBookingDataToCellAttributes();
							_this.BlockTimeSlots.initSelectable();
							var $table = $('#test');
							$table.floatThead({
							    scrollContainer: function($table){
							        return $table.closest('#scrollableTableWrapper');
							    }
							});
						}*/
						_this.utils._redrawFullTableAndBindEventsFromAjaxResponse(responseData);
					});
				});

			},
		initSelectable: function(){
			$( "#selectableTableCells" ).selectable({
                    scrollSnapX: 5, // When the selection is that pixels near to the top/bottom edges, start to scroll
                    scrollSnapY: 5, // When the selection is that pixels near to the side edges, start to scroll
                    scrollAmount: 25, // In pixels
                    scrollIntervalTime: 100, // In milliseconds
					filter: "td.space",
					start:function(event, ui){
						$('#team_date').val(calendarManager.utils.getSelectedDate())
						// console.log('selection started');
					},
					selecting: function (event, ui) {	
						
                        /*$(ui.selecting).each(function(i,v){
                            if(!$(this).hasClass('hasOccupied')){
                                $(this).html('<div class="adminBooking"><a href="#" title="Admin Blocked"><i class="fa fa-lock" aria-hidden="true"></i></a></div>');
                            }
                        });*/
					},
                    selected: function (event, ui) {   
                        
                        $(ui.selected).each(function(i,v){
                            if(!$(this).hasClass('hasOccupied')){
                                // $(this).html('<div class="adminBooking"><a href="#" title="Admin Blocked"><i class="fa fa-lock" aria-hidden="true"></i></a></div>');
                            }
                        });
                    },
                    unselected: function(event,ui){
                       $(ui.unselected).each(function(i,v){
                            if(!$(this).hasClass('hasOccupied')){
                                $(this).html('');
                            }
                        });
                    },
					stop: function( event, ui ) {
                         _this.utils.createTableBasedOnSelectableArea(selDate);
                         _this.utils.openFancyBox();
                 	}
         	});

		}
	};

	_this.manager = {
			
				init: function(){

					$('#bookingManagerTabs').tabs();
					$('.datepicker').datepicker();
					
					_this.BlockTimeSlots.bindBlockingTableEvents();

				}
	};

	return _this;
})();
(function ($) {
    var group_mode = 'new';
    var show_pickup = '';
    var group_data = '';
    var dt_pickup_list;
    
    $( document ).on( 'click', '.user_approve', function ( e ) {
        e.preventDefault();
        var id = $( this ).data( 'id' );
        swal({
            title: "Are you sure?",
            text: "",
            type: "warning",
            showCancelButton: false,
            confirmButtonClass: "btn-success",
            confirmButtonText: "Approve",
            cancelButtonText: "Cancel",
            closeOnConfirm: false,
            closeOnCancel: false
        },
        function( isConfirm ) {
            if ( isConfirm && id != "" ) { 
                $.ajax({
                    dataType:   "html",
                    url:        USER_AJAX_URL,
                    method:     "POST",
                    cache:      false,
                    data:       {'id': id, 'action': 'user_approve'},
                    success:    function ( data ) {
                        var decode_data = JSON.parse( data );
                        if( decode_data['success_flag'] == true ) {
                            swal( decode_data['message'], "success");
                            // $( "#user_list tbody" ).find( '.user_' + id ).remove();
                            var employee_data = "";
                            employee_data += "<div class='button-wrap'><button type='button' class='btn btn-success' title='Approved'><i class='fa fa-check'></i></button>";
                            employee_data += '<a href="" data-id="' + id + '" class="btn btn-danger user_delete" title="Delete"><i class="fa fa-trash-o"></i></a>';
                            employee_data += '<a href="" data-id="' + id + '" class="btn btn-danger user_disable" title="Disable"><i class="fa fa-thumbs-o-down"></i></a>' +
                                             '<a href="" data-id="' + id + '" class="btn btn-danger vw_user_info" title="View Details"><i class="fa fa-eye"></i></a></div>';
                            $( '.rep_'+id ).html( employee_data );
                        } else {
                        }
                    },
                    error: function ( jqXHR, textStatus, errorThrown ) {
                        console.log( jqXHR + " :: " + textStatus + " :: " + errorThrown );
                    }
                });
            } else {
                swal( "Cancelled", "Its Cancelled :)", "error" );
            }
        });
    }); 
    $( document ).on( 'click', '.user_disable', function ( e ) {
        e.preventDefault();
        var id = $( this ).data( 'id' );
        swal({
            title: "Are you sure?",
            text: "",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-success",
            confirmButtonText: "disable",
            cancelButtonText: "Cancel",
            closeOnConfirm: false,
            closeOnCancel: false
        },
        function( isConfirm ) {
            if ( isConfirm && id != "" ) { 
                $.ajax({
                    dataType:   "html",
                    url:        USER_AJAX_URL,
                    method:     "POST",
                    cache:      false,
                    data:       {'id': id, 'action': 'user_disable'},
                    success:    function ( data ) {
                        var decode_data = JSON.parse( data );
                        if( decode_data['success_flag'] == true ) {
                            swal( decode_data['message'], "success");
                            // $( "#user_list tbody" ).find( '.user_' + id ).remove();
                            var employee_data = "";
                            employee_data += "<div class='button-wrap'><button type='button' class='btn btn-success' title='Approved'><i class='fa fa-check'></i></button>";
                            employee_data += '<a href="" data-id="' + id + '" class="btn btn-danger user_delete" title="Delete"><i class="fa fa-trash-o"></i></a>';
                            employee_data += '<a href="" data-id="' + id + '" class="btn btn-danger user_enable" title="Enable"><i class="fa fa-thumbs-o-up"></i></a>' +
                                             '<a href="" data-id="' + id + '" class="btn btn-danger vw_user_info" title="View Details"><i class="fa fa-eye"></i></a></div>';
                            $( '.rep_'+id ).html( employee_data );
                        } else {
                        }
                    },
                    error: function ( jqXHR, textStatus, errorThrown ) {
                        console.log( jqXHR + " :: " + textStatus + " :: " + errorThrown );
                    }
                });
            } else {
                swal( "Cancelled", "Its Cancelled :)", "error" );
            }
        });
    }); 
    $( document ).on( 'click', '.user_enable', function ( e ) {
        e.preventDefault();
        var id = $( this ).data( 'id' );
        swal({
            title: "Are you sure?",
            text: "",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-success",
            confirmButtonText: "Enable",
            cancelButtonText: "Cancel",
            closeOnConfirm: false,
            closeOnCancel: false
        },
        function( isConfirm ) {
            if ( isConfirm && id != "" ) { 
                $.ajax({
                    dataType:   "html",
                    url:        USER_AJAX_URL,
                    method:     "POST",
                    cache:      false,
                    data:       {'id': id, 'action': 'user_enable'},
                    success:    function ( data ) {
                        var decode_data = JSON.parse( data );
                        if( decode_data['success_flag'] == true ) {
                            swal( decode_data['message'], "success");
                            // $( "#user_list tbody" ).find( '.user_' + id ).remove();
                            var employee_data = "";
                            employee_data += "<div class='button-wrap'><button type='button' class='btn btn-success' title='Approved'><i class='fa fa-check'></i></button>";
                            employee_data += '<a href="" data-id="' + id + '" class="btn btn-danger user_delete" title="Delete"><i class="fa fa-trash-o"></i></a>';
                            employee_data += '<a href="" data-id="' + id + '" class="btn btn-danger user_disable" title="Disable"><i class="fa fa-thumbs-o-down"></i></a>' +
                                             '<a href="" data-id="' + id + '" class="btn btn-danger vw_user_info" title="View Details"><i class="fa fa-eye"></i></a></div>';
                            $( '.rep_'+id ).html( employee_data );
                        } else {
                        }
                    },
                    error: function ( jqXHR, textStatus, errorThrown ) {
                        console.log( jqXHR + " :: " + textStatus + " :: " + errorThrown );
                    }
                });
            } else {
                swal( "Cancelled", "Its Cancelled :)", "error" );
            }
        });
    }); 
    
    $( document ).on( 'click', '.user_delete', function ( e ) {
        e.preventDefault();
        var id = $( this ).data( 'id' );
        swal({
            title: "Are you sure?",
            text: "You will not be able to recover this!",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-success",
            confirmButtonText: "Delete",
            cancelButtonText: "Cancel",
            closeOnConfirm: false,
            closeOnCancel: false
        },
        function( isConfirm ) {
            if ( isConfirm && id != "" ) { 
                $.ajax({
                    dataType:   "html",
                    url:        USER_AJAX_URL,
                    method:     "POST",
                    cache:      false,
                    data:       {'id': id, 'action': 'user_delete'},
                    success:    function ( data ) {
                        var decode_data = JSON.parse( data );
                        if( decode_data['success_flag'] == true ) {
                            swal( decode_data['message'], "success" );
                            $( '.user_' + id ).remove();
                        } else {
                            swal( decode_data['message'], "warning" );
                        }
                    },
                    error: function ( jqXHR, textStatus, errorThrown ) {
                        console.log( jqXHR + " :: " + textStatus + " :: " + errorThrown );
                    }
                });
            } else {
                swal( "Cancelled", "Its Cancelled :)", "error" );
            }
        });
    }); 
    
   
    
    $( document ).on( 'click', '.user_reject', function ( e ) {
        e.preventDefault();
        var id = $( this ).data( 'id' );
        swal({
            title: "Enter Your Reason",
            text: "<textarea id='text'></textarea><div class='text-danger' id='def_error'></div>",
            html: true,
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Reject",
            cancelButtonText: "Cancel",
            closeOnConfirm: false,
            closeOnCancel: true
        },
        function( isConfirm ) {
            var val = document.getElementById( 'text' ).value;
            if ( val == "" ) {
                document.getElementById( "def_error" ).innerHTML = 'Please enter reason';
                return false;
            } 
            if ( isConfirm && id != "" && val != "" ) {   
                $.ajax({
                    dataType:   "html",
                    url:        USER_AJAX_URL,
                    method:     "POST",
                    cache:      false,
                    data:       {'id': id, 'val': val, 'action': 'user_reject'},
                    success:    function ( data ) {
                        var decode_data = JSON.parse( data );
                        if( decode_data['success_flag'] == true ) {
                            swal( decode_data['message'], "success" );
                            var employee_data = "";
                            employee_data += "<div class='button-wrap'><button type='button' class='btn btn-danger'><i class='fa fa-times' title='Rejected'></i></button>";
                            employee_data += '<a href="" data-id="' + id + '" class="btn btn-danger vw_user_info" title="View Details"><i class="fa fa-eye"></i></a></div>';
                            $( '.rep_'+id ).html( employee_data );
                        } 
                    },
                    error: function ( jqXHR, textStatus, errorThrown ) {
                        console.log( jqXHR + " :: " + textStatus + " :: " + errorThrown );
                    }
                }); 
            } else {
                
            }
        });
    });
    
    $( document ).on( 'click', '.cancel_pickup', function ( e ) {
        e.preventDefault();
        var id = $( this ).data( 'pickup-id' );
        swal({
            title: "Enter Your Reason",
            text: "<textarea id='text'></textarea><div class='text-danger' id='def_error'></div>",
            html: true,
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Submit",
            cancelButtonText: "Cancel",
            closeOnConfirm: false,
            closeOnCancel: true
        },
        function( isConfirm ) {
            var val = document.getElementById( 'text' ).value;
            if ( val == "" ) {
                document.getElementById( "def_error" ).innerHTML = 'Please enter reason';
                return false;
            } 
            if ( isConfirm && id != "" && val != "" ) { 
                $(".confirm").addClass('loader');
                show_loader();
                setTimeout(function(){ 
                    $.ajax({
                        dataType:   "html",
                        url:        USER_AJAX_URL,
                        method:     "POST",
                        cache:      false,
                        data:       { 'id': id, 'val': val, 'action': 'cancel_pickup_list'},
                        success:    function ( data ) {
                            var decode_data = JSON.parse( data );
                            if( decode_data['success_flag'] == true ) {
                                swal( decode_data['message'], "success" );
                                hide_loader();
                                $( '.pickup_' +id ).remove();
                            } else{
                                hide_loader();
                            }
                        },
                        error: function ( jqXHR, textStatus, errorThrown ) {
                            console.log( jqXHR + " :: " + textStatus + " :: " + errorThrown );
                        }
                    });
                }, 1000);
            } else {
            }
        });
    });
    
    $( document ).on( 'click', '.driver_pay_amount', function ( e ) {
        e.preventDefault();
        var id = $( this ).data( 'job-id' );
        swal({
            title: "Are you sure?",
            text: "",
            html: true,
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Yes",
            cancelButtonText: "No",
            closeOnConfirm: false,
            closeOnCancel: true
        },
        function( isConfirm ){ 
            if ( isConfirm && id != "" ){   
                $.ajax({
                    dataType:   "html",
                    url:        USER_AJAX_URL,
                    method:     "POST",
                    cache:      false,
                    data:       { 'id': id, 'action': 'driver_pay_amounts'},
                    success:    function ( data ) {
                        var decode_data = JSON.parse( data );
                        if( decode_data['success_flag'] == true ) {
                            swal( decode_data['message'], "success" );
                            $( '.job_' + id ).find( '.driver_pay_amount' ).replaceWith( '<label  class="paid_amt btn btn-danger">Paid</label>' );
                        } else{
                            swal( decode_data['message'], "warning" );
                        }
                    },
                    error: function ( jqXHR, textStatus, errorThrown ) {
                        console.log( jqXHR + " :: " + textStatus + " :: " + errorThrown );
                    }
                }); 
            } else {
                
            }
        });
    });
    
  
    
     $( document ).on( 'click', '.arr_pickup', function ( e ) {
        var pickup_id = $( this ).data( 'id' );
        var pickup_date = $( this ).data( 'date' );
        var group_id = $( this ).data( 'group-id' );
        dt_pickup_list.$( this ).closest( '#pickup_list' ).find( '.pickup_date_check' ).each( function(){
            var current_pickup_date = $( this ).data( 'date' );
            var current_group_id = $( this ).data( 'group-id' );
            if( current_pickup_date == pickup_date ){
                if( group_id == current_group_id ){
                    dt_pickup_list.$( this ).siblings().find( '.arr_pickup' ).attr( 'disabled' , false );
                }else{
                    dt_pickup_list.$( this ).siblings().find( '.arr_pickup' ).attr( 'disabled' , true );
                }
            }else{
                dt_pickup_list.$( this ).siblings().find( '.arr_pickup' ).attr( 'disabled' , true );
            }
        });
        var ckName = document.getElementsByName( "arr_pick[]" );
        if( dt_pickup_list.$( 'input[name="arr_pick[]"]:checked' ).length == 0 ){
            for(  var i=0; i < ckName.length; i++ ){
                ckName[i].disabled = false;
            } 
        }
        
     });
    
    $( document ).on( 'submit', '#frm_request_driver', function ( e ) {
        var arr_pick = [];
        $.each( $( "input[name='arr_pick[]']:checked" ), function(){            
            arr_pick.push( $(this).val() );
        });
        var driver_assign_mode = $( "#driver_assign_mode" ).val();
        var arr_pick1 = arr_pick;
        arr_pick = arr_pick.join(", ");
        var arr_pick = arr_pick.split(",").map(Number);
        console.log(arr_pick);
        if( driver_assign_mode == "all" ){
            var str = '&action=all_driver_request&pickup_id=' + arr_pick1;
        }else{
            var str = '&action=driver_request&pickup_id=' + arr_pick1;
        }
        
        show_loader();
        setTimeout(function(){ 
        $.ajax({
            dataType:   "html",
            url:        USER_AJAX_URL,
            method:     "POST",
            cache:      false,
            data:       $( "#frm_request_driver" ).serialize() + str,
            success:    function ( data ) {
                var decode_data = JSON.parse( data );
                if( decode_data['success_flag'] == true ) {
                    hide_loader();
                    $( ".info-success" ).find( ".info-msg" ).html( "<strong>" + decode_data['message'] + "</strong>");
                    $( ".info-failed" ).hide();
                    close_notification( ".info-success" );
                    $( "#pickup_job_assign" ).modal( 'hide' );
                    reset_form( 'frm_request_driver' );
                    for (var i = 0; i < arr_pick.length; i++) {
                        $( "#pickup_list tbody" ).find( '.pickup_' + arr_pick[i] ).remove();
                        $( "#pickup_list1 tbody" ).find( '.pickup_' + arr_pick[i] ).remove();
                        $( "#pickup_list3 tbody" ).find( '.pickup_' + arr_pick[i] ).remove();
                        $( "#pickup_list4 tbody" ).find( '.pickup_' + arr_pick[i] ).remove();
                        $( "#pickup_list5 tbody" ).find( '.pickup_' + arr_pick[i] ).remove();
                        //Do something
                    }
                    var ckName = document.getElementsByName("arr_pick[]");
                    if( $( 'input[name="arr_pick[]"]' ) ){
                        for( var i=0; i < ckName.length; i++ ){
                            ckName[i].disabled = false;
                        } 
                    }
                } else {
                    hide_loader();  
                    // $(".info-failed").find(".info-msg").html("<strong>" + decode_data['message'] + "</strong>");
                    // $(".info-success").hide();
                    // close_notification(".info-failed");
                    swal( "", decode_data['message'], "warning" );
                }
            },
            error: function ( jqXHR, textStatus, errorThrown ) {
                console.log( jqXHR + " :: " + textStatus + " :: " + errorThrown );
            }
        });
        }, 1000);
        return false;
    });
    
    $( document ).on( 'submit', '#frm_reassign_driver', function ( e ) {
        var str = '&action=job_reassign_driver';
        
        show_loader();
        setTimeout(function(){ 
        $.ajax({
            dataType:   "html",
            url:        USER_AJAX_URL,
            method:     "POST",
            cache:      false,
            data:       $( "#frm_reassign_driver" ).serialize() + str,
            success:    function ( data ) {

                var decode_data = JSON.parse( data );
                if( decode_data['success_flag'] == true ) {
                    hide_loader();
                    $( ".job_"  + decode_data['id'] ).find( '.driver_name' ).text( decode_data['data'] )
                    swal( "", decode_data['message'] , "success" );
                    $( "#pickup_reassign_driver" ).modal( 'hide' );
                    reset_form( 'frm_reassign_driver' );
                } else {
                    hide_loader();  
                    swal( "", decode_data['message'] , "warning" );
                }
            },
            error: function ( jqXHR, textStatus, errorThrown ) {
                console.log( jqXHR + " :: " + textStatus + " :: " + errorThrown );
            }
        });
        }, 1000);
        return false;
    });
    
    $( document ).on( 'submit', '#frm_other_settings', function ( e ) {
        var str = '&action=admin_other_setting';
        show_loader();
        setTimeout(function(){ 
        $.ajax({
            dataType:   "html",
            url:        USER_AJAX_URL,
            method:     "POST",
            cache:      false,
            data:       $( "#frm_other_settings" ).serialize() + str,
            success:    function ( data ) {

                var decode_data = JSON.parse( data );
                if( decode_data['success_flag'] == true ) {
                    hide_loader();
                    swal( "", decode_data['message'],"success");
                    $( ".info-failed" ).hide();
                    
                } else {
                    hide_loader(); 
                    swal( "", decode_data['message'],"warning");
                    
                }
            },
            error: function ( jqXHR, textStatus, errorThrown ) {
                console.log( jqXHR + " :: " + textStatus + " :: " + errorThrown );
            }
        });
        }, 1000);
        return false;
    });
    
    var driver_info = '';
    $( document ).on( 'click', '.check_driver_name', function ( e ) {
        // var selectedIds = dt_pickup_list.columns().checkboxes.selected()[0];
        // console.log(selectedIds)
   
        var arr_pick = [];
        $( "#driver_assign_mode" ).val( "selected" );
        $( ".assign_driver" ).show();
        var driver_amt = $( "#driver_amt" ).val();
        var pickup_count = dt_pickup_list.$( "input[name='arr_pick[]']:checked" ).length;
        $.each( dt_pickup_list.$( "input[name='arr_pick[]']:checked" ), function(){            
            arr_pick.push( $(this).val() );
        });
        if( arr_pick.length == 0 ){
            $( "#pickup_job_assign" ).modal('hide');
            $( "#select_driver" ).modal('show');
            return false;
        }else {
            driver_info = get_driver_info( arr_pick );
            $( "#driver_pickup_amt" ).val( pickup_count * driver_amt );
            $( "#pickup_job_assign" ).modal('show');
        }
    });
    
    
    
    $( document ).on( 'click', '.view_pickup_detail', function ( e ) {
        var id =  $( this ).data( 'pickup-id' );
        var pickup_data = get_pickup_info( id );
    });
    
    $( document ).on( 'click', '.view_job_detail', function ( e ) {
        var id =  $( this ).data( 'job-id' );
        var job_data = get_job_info( id );
    });
    
    $( document ).on( 'click', '.vw_user_info', function ( e ) {
        var id =  $( this ).data( 'id' );
        var user_data = get_user_info( id );
        return false;
    });
    
    $( document ).on( 'click', '.reassign_pickup', function ( e ) {
        var job_id = $( this ).data( 'job-id' );
        $( "#reassign-job_id" ).val( job_id );
        var bo_id = $( this ).data( 'bo-id' );
        $( "#reassign_bo_id" ).val( bo_id );
        $( "#pickup_reassign_driver" ).modal( 'show' );
    });
    
    $( document ).on( 'click', '.assign_drivers_job', function ( e ) {
        var arr_pick = [];
        $( ".assign_driver" ).hide();
        var driver_amt = $( "#driver_amt" ).val();
        var pickup_count = dt_pickup_list.$( "input[name='arr_pick[]']:checked" ).length;
        $.each( dt_pickup_list.$( "input[name='arr_pick[]']:checked" ), function(){            
            arr_pick.push( $(this).val() );
        });
        $( "#driver_assign_mode" ).val( "all" );
        if( arr_pick.length == 0 ){
            $( "#pickup_job_assign" ).modal('hide');
            $( "#select_driver" ).modal('show');
            return false;
        }else {
            driver_info = get_driver_info( arr_pick );
            $( "#driver_pickup_amt" ).val( pickup_count * driver_amt );
            $( "#pickup_job_assign" ).modal('show');
        }
            
    });
    
    $( ".other_location" ).hide();
    $( ".first_other_location" ).hide();
    function get_driver_info( arr_pick ){
        
        var arr_pick1 = arr_pick;
        arr_pick = arr_pick.join(", ");
        var str = '&action=get_drivers_info&pickup_id=' + arr_pick1;
        $.ajax({
            dataType:   "html",
            url:        USER_AJAX_URL,
            method:     "POST",
            cache:      false,
            data:       $( "#frm_request_driver" ).serialize() + str,
            success:    function ( data ) {
                var item_html = '';
                var k = 0;
                var bank_name = '';
                var pickup_type = '';
                var decode_data = JSON.parse( data );
                $( ".selected_driver" ).html('');
                if( decode_data['success_flag'] == true ) {
                    $( ".other_location" ).hide();
                    $( "#txt_address" ).val( '' );
                    $( "#hdn_latitude" ).val( '' );
                    $( "#hdn_longitude" ).val( '' );
                    item_html = '';
                    item_html += '<div><span class="fa fa-circle pickup"></span>Pick Up <span class="fa fa-circle change_order"></span> Change Order</div>';
                    if( decode_data['type'] != "" ) {
                        item_html += '<ul id="bank_selector1" class="droptrue ui-sortable">';
                        item_html += '<li class="ui-state-default"><b><input type="radio" id="first_addess_bank" checked name="first_last_address" value="bank"/>Bank Address: </b><label>' + decode_data['bank'] + '</label></li>';
                        item_html += '<li class="ui-state-default"><b><input type="radio" id="first_addess_other" name="first_last_address" value="other"/>Other Address </b></li>';
                        item_html += '</ul>' ;
                        item_html += '<div class="first_other_location " style="display:none;">' ;
                        item_html += '<div class="form-group">' ;
                        item_html += '<label class="col-md-3" for="txt_other_address">Other Address</label>' ;
                        item_html += '<div class="col-md-9">' ;
                        item_html += '<input type="text" class="form-control" id="txt_other_address" name="txt_other_address" placeholder="Address" />' ;
                        item_html += '<input type="hidden" id="hdn_other_latitude" name="hdn_other_latitude"/>' ;
                        item_html += '<input type="hidden" id="hdn_other_longitude" name="hdn_other_longitude"/>' ;
                        item_html += '<span class="help-block"></span>' ;
                        item_html += '</div>' ;
                        item_html += '</div>' ;
                        item_html += '<div class="form-group">' ;
                        item_html += '<label class="col-md-3"></label>' ;
                        item_html += '<div class="col-md-9">' ;
                        item_html += '<div id="map_other_location" style="width: 100%; height: 200px;"></div>' ;
                        item_html += '<div class="clearfix">&nbsp;</div><div class="clearfix"></div>' ;
                        item_html += '</div>' ;
                        item_html += '</div>' ;
                        item_html += '</div>';
                    }  
                    item_html += '<div class="driver_selector col-md-12">'+ 
                                    '<div class="col-md-3">' + 
                                        '<ul id="fixed_bank" class="droptrue ui-sortable">' +
                                            '<li class="ui-state-default">' + 
                                            '<input  type="hidden" value="bank" name="pickup_type[]" /> ' +
                                                decode_data['bank'] + 
                                            '</li>' +
                                        '</ul>' +
                                    '</div>' + 
                                    '<div class="col-md-8">';
                    item_html += '<ul id="sortable1" class="droptrue ui-sortable">';
                    $.each( decode_data['data'], function (i, v) {
                        pickup_type = 'change_order';
                        if( v.st_order_type !="change_order" ){
                            bank_name = decode_data['bank'];
                            pickup_type = 'pickup';
                        }
                        
                        k =  i + 1;
                        item_html += '<li class="ui-state-default ' + pickup_type + '">' +
                                    '<input  type="hidden" value="' + v.in_pickup_id  + '" name="pickup_sorting[]" /> ' +
                                    '<input  type="hidden" value="' + v.in_pickup_id  + '" name="pickup_type[]" /> ' +
                                    '<div>' + v.st_location_name + '</div>' +
                                    '<div>' + v.st_address + '</div>' +
                                '</li>';
                    });
                    
                    item_html += '</ul></div></div>';
                    if( bank_name != "" ){
                        item_html += '<ul id="bank_selector" class="droptrue ui-sortable">';
                        item_html += '<li class="ui-state-default"><b><input type="radio" id="last_addess_bank" checked name="last_addess" value="bank"/>Bank Address: </b><label>' + decode_data['bank'] + '</label></li>';
                        if( decode_data['home_add'] == '' ){
                            
                        }else{
                            item_html += '<li class="ui-state-default"><b><input type="radio" id="last_addess_home" name="last_addess" value="home"/>Home Address: </b><label>' + decode_data['home_add'] + '</label></li>';
                        }
                        if( decode_data['warehouse_add'] == '' ){
                            
                        }else{
                            item_html += '<li class="ui-state-default"><b><input type="radio" id="last_addess_warehouse" name="last_addess" value="warehouse"/>Warehouse Address: </b><label>' + decode_data['warehouse_add'] + '</label></li>';
                        }
                        item_html += '<li class="ui-state-default"><b><input type="radio" id="last_addess_other" name="last_addess" value="other"/>Other Address </b></li>';
                        item_html += '</ul>';
                    }
                    
                    // console.log(item_html);
                    
                    
                    $( ".selected_driver" ).html(item_html);
                    initialize();
                    initialize_map();
                    $( "#fixed_bank" ).sortable({
                        connectWith: "ul",
                        remove: function( event, ui ) {
                            ui.item.clone().appendTo( '#sortable1' );
                            $(this).sortable( 'cancel' );
                        }
                    }).disableSelection();
                    
                    $( "#sortable1" ).sortable({
                        containment: ".driver_selector",
                        placeholder: "ui-state-highlight",
                        connectWith: "ul",
                        
                    });
                    $( "#bank_selector" ).sortable({
                        disabled: true
                    });
                    $( "#bank_selector1" ).sortable({
                        disabled: true
                    });
                     $( "#sortable1 li" ).disableSelection();
                } else {
                    $( "#pickup_job_assign" ).modal( 'hide' );
                    // $(".info-failed").find(".info-msg").html("<strong>" + decode_data['message'] + "</strong>");
                    // $(".info-success").hide();
                    // close_notification(".info-failed");
                    swal( "", decode_data['message'], "warning" );
                }
            },
            error: function ( jqXHR, textStatus, errorThrown ) {
                console.log( jqXHR + " :: " + textStatus + " :: " + errorThrown );
            }
        });
        return false;
    }
    
    $( document ).on( 'change' , 'input[type=radio][name=last_addess]', function() {
        
        if (this.value == 'other') {
            $( ".other_location" ).show();
        }else {
            $( ".other_location" ).hide();
            $( "#txt_address" ).val( '' );
            $( "#hdn_latitude" ).val( '' );
            $( "#hdn_longitude" ).val( '' );
        }
    });
    
    $( document ).on( 'change' , 'input[type=radio][name=first_last_address]', function() {
        
        if (this.value == 'other') {
            // console.log($( ".first_other_location" ).html());
            // $( '#bank_selector1' ).after( $( ".first_other_location" ).show() );
            $( ".first_other_location" ).show();
        }else {
            $( ".first_other_location" ).hide();
            $( "#txt_other_address" ).val( '' );
            $( "#hdn_other_latitude" ).val( '' );
            $( "#hdn_other_longitude" ).val( '' );
        }
    });
    
    function get_pickup_info( id ){
        var str = '&action=get_pickup_info&id=' + id;
        $.ajax({
            dataType:   "html",
            url:        USER_AJAX_URL,
            method:     "POST",
            cache:      false,
            data:       str,
            success:    function ( data ) {
                var decode_data = JSON.parse( data );
                if( decode_data['success_flag'] == true ){

                    if( decode_data['data'].st_order_type == null ){
                        decode_data['data'].st_order_type = "Pick Up";
                    }else{
                        decode_data['data'].st_order_type = "Change order"; 
                    }
                    if( decode_data['data'].st_pickup_type == "recurring" ){
                        decode_data['data'].st_pickup_type = "Yes";
                    }else{
                        decode_data['data'].st_pickup_type = "No"; 
                    }
                    $( '.sw_pickup_ct_dt' ).text( decode_data['data'].dt_created_at );
                    $( '.sw_pickup_address' ).text( decode_data['data']['location'].st_address );
                    $( '.sw_pickup_type' ).text( decode_data['data'].st_order_type );
                    $( '.sw_pickup_recurring' ).text( decode_data['data'].st_pickup_type );
                    $( "#pickup_detail" ).modal( 'show' );
                }
            },
            error: function ( jqXHR, textStatus, errorThrown ) {
                console.log( jqXHR + " :: " + textStatus + " :: " + errorThrown );
            }
        });
        return false;
    }
    
    function get_job_info( id ){
        var str = 'action=get_job_info&id=' + id;
        $.ajax({
            dataType:   "html",
            url:        USER_AJAX_URL,
            method:     "POST",
            cache:      false,
            data:       str,
            success:    function ( data ) {
                var decode_data = JSON.parse( data );
                if( decode_data['success_flag'] == true ){
                    $( '.sw_pickup_ct_dt' ).text( decode_data['data'][0].dt_created_at );
                    $( '.sw_pickup_location' ).text( decode_data['data'][0].pickup_count );
                    $( '.sw_pickup_status' ).text( decode_data['data'][0].st_status );
                    $( '.sw_pickup_type' ).text( decode_data['data'][0].pickup_type );
                    $( '.sw_pickup_recurring' ).text( decode_data['data'][0].recurring );
                    $( "#job_detail" ).modal( 'show' );
                }
            },
            error: function ( jqXHR, textStatus, errorThrown ) {
                console.log( jqXHR + " :: " + textStatus + " :: " + errorThrown );
            }
        });
        return false;
    }
    
    function get_user_info( id ){
        var str = 'action=get_user_info&id=' + id ;
        $.ajax({
            dataType:   "html",
            url:        USER_AJAX_URL,
            method:     "POST",
            cache:      false,
            data:       str,
            success:    function ( data ) {
                var decode_data = JSON.parse( data );
                if( decode_data['success_flag'] == true ){
                    if( decode_data['data'].st_user_type == "driver" ){
                        var user_data = '';
                        user_data += '<div class="form-group row">' +
                                        '<label class="col-md-3">Contact No:</label>' +
                                        '<label class="col-md-9">' + decode_data['data'].in_contact_no + '</label>' +
                                    '</div>';
                        user_data += '<div class="form-group row">' +
                                        '<label class="col-md-3">License No:</label>' +
                                        '<label class="col-md-9">' + decode_data['data']['other_info'].in_license_no + '</label>' +
                                    '</div>';
                        $( ".user_data_add" ).html( user_data );
                    }else{
                        var user_data = '';
                        user_data += '<div class="form-group row">' +
                                        '<label class="col-md-3">Contact No:</label>' +
                                        '<label class="col-md-9">' + decode_data['data'].in_contact_no + '</label>' +
                                    '</div>';
                        user_data += '<div class="form-group row">' +
                                        '<label class="col-md-3">Business Name:</label>' +
                                        '<label class="col-md-9">' + decode_data['data']['other_info'].st_business_name + '</label>' +
                                    '</div>';
                        user_data += '<div class="form-group row">' +
                                        '<label class="col-md-3">ENI Number:</label>' +
                                        '<label class="col-md-9">' + decode_data['data']['other_info'].in_eni_number + '</label>' +
                                    '</div>';
                        user_data += '<div class="form-group row">' +
                                        '<label class="col-md-3">Job Title:</label>' +
                                        '<label class="col-md-9">' + decode_data['data']['other_info'].st_job_title + '</label>' +
                                    '</div>';
                        user_data += '<div class="form-group row">' +
                                        '<label class="col-md-3">Address Line 1:</label>' +
                                        '<label class="col-md-9">' + decode_data['data'].st_address_1 + '</label>' +
                                    '</div>';
                        user_data += '<div class="form-group row">' +
                                        '<label class="col-md-3">Address Line 2:</label>' +
                                        '<label class="col-md-9">' + decode_data['data'].st_address_2 + '</label>' +
                                    '</div>';
                        user_data += '<div class="form-group row">' +
                                        '<label class="col-md-3">City:</label>' +
                                        '<label class="col-md-9">' + decode_data['data'].st_city + '</label>' +
                                    '</div>';
                        user_data += '<div class="form-group row">' +
                                        '<label class="col-md-3">State:</label>' +
                                        '<label class="col-md-9">' + decode_data['data'].st_state + '</label>' +
                                    '</div>';
                        user_data += '<div class="form-group row">' +
                                        '<label class="col-md-3">Zip Code:</label>' +
                                        '<label class="col-md-9">' + decode_data['data'].st_zipcode + '</label>' +
                                    '</div>';
                        $( ".user_data_add" ).html( user_data );
                    }
                    
                    $( "#user_view_detail" ).modal( 'show' );
                }
            },
            error: function ( jqXHR, textStatus, errorThrown ) {
                console.log( jqXHR + " :: " + textStatus + " :: " + errorThrown );
            }
        });
        return false;
    }
    
    $( document ).on( 'click', '#create_group' , function(){
        group_mode = 'new';
        $( ".add-edit-group-title" ).text( "Create Group" );
        reset_form( 'frm_create_group' );
        $( "#edit_group_id" ).val();
        $( '#select_loc_bo' ).dataTable().fnDestroy();
        $( '#selected_loc_bo' ).dataTable().fnDestroy();
        $( '#selected_loc_bo tbody' ).html( '' );
        $( '#select_loc_bo' ).hide();
        $( '#selected_loc_bo' ).hide();
        $( ".st_location_name" ).find('span').show();
        $( "#create_loc_group" ).modal( 'show' );
        $( "#arr_location_id" ).val( '' );
        $( "#select_bo" ).attr( 'data-group-id' , 0 );
        $( "#select_bo" ).val('0');
        $( "#select_bo" ).selectpicker( 'refresh' );
        
        reset_form( 'frm_create_group' );  
    });
    
    var delivery_driver_id = '', loc_click = 0;
    
    $( document ).on( 'click', '.arr_location', function ( e ) {
        var location_id = $( this ).val();
        var hdn_location_id = $( "#arr_location_id" ).val();
        if( hdn_location_id == undefined || hdn_location_id != '' ){
            hdn_location_id += ',' + location_id;
        }else{
            hdn_location_id += '' + location_id;
        }
        $( "#arr_location_id" ).val( hdn_location_id );
        $( this ).removeClass( 'arr_location' ).text( "Added" );
        $( '#selected_loc_bo' ).dataTable().fnDestroy();
        var clone_ele = '<tr class="location_' + location_id + '">';
        clone_ele += $( this ).closest( '.location_' + location_id ).html();
        clone_ele += '</tr>';
        $( '#selected_loc_bo tbody' ).append( clone_ele );
        $( '#selected_loc_bo' ).show();
        $( '#selected_loc_bo' ).dataTable();
        
        
//        $( "#arr_location_id" ).val( delivery_driver_id );
    });
    
    $( document ).on( 'click', '.arr_added_location', function ( e ) {
        var location_id = $( this ).val();
        var hdn_location_id = $( "#arr_location_id" ).val();
        if( hdn_location_id == undefined || hdn_location_id != '' ){
            hdn_location_id += ',' + location_id;
        }else{
            hdn_location_id += '' + location_id;
        }
        $( "#arr_location_id" ).val( hdn_location_id );
        $( this ).removeClass( 'arr_added_location' ).text( "Added" );
        
    });
    
    $( document ).on( 'click', '.remove_location', function ( e ) {
        var location_id = $( this ).val();
        var hdn_location_id = $( "#arr_location_id" ).val();
        var myarr = hdn_location_id.split(",");
        removeItem_array( myarr, location_id );
        $( "#arr_location_id" ).val(  myarr.join() );
        $( this ).addClass( 'arr_added_location' ).removeClass( 'remove_location' ).text( "Add" );
        
    });
    
    $( document ).on( 'click', '.edit_group', function ( e ) {
        $( ".add-edit-group-title" ).text( "Edit Group" );
        var group_id = $( this ).data( 'group_id' );
        $( '#select_loc_bo' ).dataTable().fnDestroy();
        $( '#select_loc_bo tbody' ).html( '' );
        $( '#select_loc_bo' ).hide();
        reset_form( 'frm_create_group' );
        get_group_info( group_id );
        group_mode = 'edit';
        $( ".st_location_name" ).find('span').hide();
        $( "#select_bo" ).val('0');
        $( "#select_bo" ).selectpicker( 'refresh' );
        $( "#create_loc_group" ).modal( 'show' );
    });
    
    function get_group_info( group_id ){
         $.ajax({
            dataType:   "html",
            url:        USER_AJAX_URL,
            method:     "POST",
            cache:      false,
            data:       'action=get_group_info' + '&group_id=' + group_id,
            success:    function ( data ) {
                var decode_data = JSON.parse( data );
                if( decode_data['success_flag'] == true ){
                    
                    group_data = decode_data['data'];
                    if( group_data != "" ){
                        $( '#selected_loc_bo' ).dataTable().fnDestroy();
                        $( '#selected_loc_bo tbody' ).html('');
                        var loc_html = '',loc_click = 0;
                        $( '#selected_loc_bo' ).show();
                        $( '#selected_loc_bo' ).dataTable().fnDestroy();
                        $( "#txt_group_name" ).val( group_data.st_group_name );

                        if( group_data.location != null ){
                            $.each( group_data.location, function (i, v) {
                                
                                    loc_html += '<tr class="location_' + v.in_location_id + '">' +
                                                '<td  class="id_width"><div class=""><button type="button" id="location_chk_' + v.in_location_id + '" class="remove_location btn btn-success" name="arr_location[]" value="' + v.in_location_id + '">Remove</button></div></td>' + 
                                                '<td >' + v.in_location_id + '</td>' + 
                                                '<td>' + v.st_location_name + '</td>' + 
                                                '<td class="cut_location_address" title="' + v.st_address + '">' + v.st_address + '</td>' + 
                                                '<td>' + v.bo_name + '</td>' + 
                                            '</tr>';
                                    if( loc_click == 0 ){
                                        delivery_driver_id = v.in_location_id;
                                        loc_click = 1;
                                    }else{
                                        delivery_driver_id += ',' + v.in_location_id;
                                    }
                                    
                                    $( "#arr_location_id" ).val( delivery_driver_id );
                                    $( "#edit_group_id" ).val( group_id );
                                    
                                    $( "#select_bo" ).attr( 'data-group-id' , group_id );
                                    $( "#txt_location_name" ).attr( 'data-group-id' , group_id );
                                    $( "#select_bo" ).selectpicker('refresh');
                                    
                            });
                        }
                        $( '#selected_loc_bo tbody' ).append( loc_html );
                        $( '#selected_loc_bo' ).dataTable();
                    }
                } else{
                    
                }
            },
            complete: function () {
                location_address_cut();
            },
            error: function ( jqXHR, textStatus, errorThrown ) {
                console.log( jqXHR + " :: " + textStatus + " :: " + errorThrown );
            }
        });
    }
    
    $( '#select_loc_bo' ).hide();
    $( '#selected_loc_bo' ).hide();
    $( document ).on( 'change', '#select_bo' , function(){
        var bo_id = $( this ).val();
        var grp_id = document.getElementById( 'select_bo' ).getAttribute( 'data-group-id' );
        if( bo_id == 0 ){
            swal( "", "Please select Business owner" , "success" );
            return false;
        }
        $( '#select_loc_bo' ).show();
        $( '#select_loc_bo' ).dataTable().fnDestroy();
        $( '#select_loc_bo' ).DataTable({
            processing: false,
            serverSide: true,
            ajax: {
                url: USER_AJAX_URL,
                type: 'POST',
                data: {
                    'action':"load_location_bo", 
                    'bo_id':bo_id,
                    'group_id':grp_id
                },
                
                complete: function () {
                    $( '.common-loader' ).hide();
                }
            },    
            columns: [                
                {"data": "action"},
                {"data": "location_id"},                
                {"data": "location_name"},                
                {"data": "bo_name"},                
            ],
            createdRow: function ( row, data, dataIndex ) {
                $(row).addClass( 'location_' + data.location_id );
            },
            order: [[1, "desc"]]
            
        });
    });
    
    $( document ).on( 'keyup', '#txt_location_name' , function(){
        var loc_name = $( this ).val();
        var grp_id = document.getElementById( 'txt_location_name' ).getAttribute( 'data-group-id' );
        $( '#select_loc_bo' ).show();
        $( '#select_loc_bo' ).dataTable().fnDestroy();
        $( '#select_loc_bo' ).DataTable({
            processing: false,
            serverSide: true,
            ajax: {
                url: USER_AJAX_URL,
                type: 'POST',
                data: {
                    'action':"load_location_data", 
                    'loc_name':loc_name,
                    'group_id':grp_id
                },
                
                complete: function () {
                    $( '.common-loader' ).hide();
                    location_address_cut();
                }
            },    
            columns: [                
                {"data": "action"},
                {"data": "location_id"},                
//                {"data": "location_name"},                
                {"data": "address"},                
                {"data": "bo_name"},                
            ],
            createdRow: function ( row, data, dataIndex ) {
                $(row).addClass( 'location_' + data.location_id );
                $(row).children(':nth-child(4)').addClass('cut_location_address').attr( 'title',  data.address );
                $(row).children(':nth-child(1)').addClass('id_width');
                
//                $(row).children(':nth-child(4)').addClass('cut_location_address');
            },
            order: [[1, "desc"]]
            
        });
    });
    
    var add_pickup_validator = $( "#frm_create_group" ).validate({
        onsubmit: true,
        rules: {
            txt_group_name: {
                required: true
            },
        },
    });
    
    $( document ).on( 'submit', '#frm_create_group', function ( e ) {
        if( group_mode == "new" ){
            if( $( "#txt_location_name" ).val() == "" ) {
                swal( "", "Please enter location address." , "warning" );
                return false;
            }else{
                var str = '&action=add_group';
            }
            
        }else{
            var str = '&action=edit_group';
        }
        
        show_loader();
        setTimeout(function(){ 
        $.ajax({
            dataType:   "html",
            url:        USER_AJAX_URL,
            method:     "POST",
            cache:      false,
            data:       $( "#frm_create_group" ).serialize() + str,
            success:    function ( data ) {
                var decode_data = JSON.parse( data );
                if( decode_data['success_flag'] == true ) {
                    hide_loader();
                    swal({
                        title: "",
                        text: decode_data['message'],
                        type: "success",
                        showCancelButton: true,
                        confirmButtonClass: "btn-warning",
                        confirmButtonText: "Yes",
                        closeOnConfirm: true
                    },function() {
                        location.reload();
                    });
                    
                    $( "#create_loc_group" ).modal( 'hide' );
                    reset_form( 'frm_create_group' );
                } else {
                    hide_loader();  
                    $( "#create_loc_group" ).modal( 'hide' );
                    swal( "", decode_data['message'] , "warning" );
                }
            },
            error: function ( jqXHR, textStatus, errorThrown ) {
                console.log( jqXHR + " :: " + textStatus + " :: " + errorThrown );
            }
        });
        }, 1000);
        return false;
    });
    
    $( document ).on( 'click', '.pickup_date1', function ( e ) {
        var date_status = $( this ).data( 'date' );
        return false;
        dt_pickup_list = $( '#pickup_list' ).DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": USER_AJAX_URL,
                "type": 'POST',
                "data": function (d) {
                    d.action = "load_pickup_data";
                    d.pickup_date = date_status;
                },
            },
            "columns": [
                {"data": "in_user_id"},
                {"data": "in_membership_id"},
                {"data": "st_username"},
                {"data": "st_full_name"},
                {"data": "st_email_id"},
                {"data": "images"},
                {"data": "created_date"},
                {"data": "edit"},
                {"data": "approve"},
                {"data": "block"},
                {"data": "delete"}
            ],
            "createdRow": function ( row, data, dataIndex ) {
                $(row).addClass( 'user_' + data.in_user_id );
                // Add a class to the cell in the second column
                $(row).children(':nth-child(6)').addClass('images_dd').attr('id', 'images_dd_' + data.in_user_id);
                $(row).children(':nth-child(8)').addClass('edit_user').attr('data-edit-user', data.in_user_id);
                if (data.approve == 0 || data.approve == 2 || data.approve == -1) {
                    var disable = '';
                    if (data.approve == 2 || data.approve == -1) {
                        disable = "disabled=disabled";
                    }
                    $(row).children(':nth-child(9)').html("<i " + disable + " style='margin: 0 10px 10px 0;' title='Approve Driver' data-approve-user='" + data.in_user_id + "' class='approve_user fa fa-eye-slash btn btn-danger'></i>");
                    $(row).children(':nth-child(9)').append("<i " + disable + " title='Reject Driver' data-approve-user='" + data.in_user_id + "' class='reject_user fa fa-bug btn btn-info'></i>");
                } else {
                    $(row).children(':nth-child(9)').addClass('unapprove_user').attr('title', 'Sustain Deliver Driver').attr('data-approve-user', data.in_user_id).html("<i class='fa fa-eye btn btn-success'></i>");
                }
                if (data.block == -1) {
                    $(row).children(':nth-child(10)').addClass('unblock_user').attr('data-unblock-user', data.in_user_id).html("<i class='fa fa-unlock btn btn-danger'></i>");
                } else if (data.block == 1 || data.block == 0 || data.block == 2) {
                    $(row).children(':nth-child(10)').addClass('block_user').attr('data-block-user', data.in_user_id).html("<i class='fa fa-ban btn btn-danger'></i>");
                }
                $(row).children(':nth-child(11)').addClass('delete_user').attr('data-delete-user', data.in_user_id);
            },
            "order": [[0, "desc"]]
        });
    });
    
    function split(val) {
        return val.split(/,\s*/);
    }
    function extractLast( term ) {
        return split( term ).pop();
    }

    //accoradation
   
//    $('.bo-list a').click(function(e){
//         e.stopPropagation();
//        $(this).closest('.panel-body').toggleClass('in');
//    });

    
    // dt_pickup_list = $( '#pickup_list' ).DataTable({
    //     "order": [[ 2, "desc" ]]
    // });
    
})(jQuery);
var geocoder,other_geocoder;
    var gmarkers = [];
    var other_gmarkers = [];
    function initialize() {
        var hdn_latitude =  $( "#hdn_latitude" ).val() ;
        var hdn_longitude =  $( "#hdn_longitude" ).val() ;
        if( hdn_latitude == "" ) {
            hdn_latitude = parseFloat( '-34.397' );
        }else{
            hdn_latitude = parseFloat( hdn_latitude );
        }
        if( hdn_longitude == "" ) {
            hdn_longitude = parseFloat( '150.644' );
        }else{
            hdn_longitude = parseFloat( hdn_longitude );
        }
        geocoder = new google.maps.Geocoder();
        var map = new google.maps.Map(document.getElementById('location'), {
            center: {lat: hdn_latitude, lng: hdn_longitude},
            zoom: 13
        });

        var input = document.getElementById( 'txt_address' );
        var searchBox = new google.maps.places.SearchBox( input );
        var marker = [];
        marker = new google.maps.Marker({
            map: map,
            position: new google.maps.LatLng( hdn_latitude,hdn_longitude )
        });
        gmarkers.push( marker );
        map.addListener( 'bounds_changed', function () {
            searchBox.setBounds(map.getBounds());
        });

        var markers = [];
          var contentString = ''+ input.value +'';
            var infowindow = new google.maps.InfoWindow({
                content: contentString
            });
            google.maps.event.addListener( marker, 'click', function() {
                infowindow.open( map,marker );
            });

            // To add the marker to the map, call setMap();
            marker.setMap(map);
            searchBox.addListener( 'places_changed', function () {
            var places = searchBox.getPlaces();

            if ( places.length == 0 ) {
                return;
            }

            // Clear out the old markers.
            for ( var i = 0; i < gmarkers.length; i++ ) {
                gmarkers[i].setMap(null);
            }
            markers = [];
            // For each place, get the icon, name and location.
            var bounds = new google.maps.LatLngBounds();
            places.forEach( function ( place ) {
                if ( !place.geometry ) {
                    console.log( "Returned place contains no geometry" );
                    return;
                }

                // Create a marker for each place.
                markers = new google.maps.Marker({
                    map: map,
                    title: place.name,
                    draggable: true,
                    position: place.geometry.location
                });
                gmarkers.push( markers );
                var lat = place.geometry.location.lat();
                var lng = place.geometry.location.lng();
                google.maps.event.addListener( markers, 'dragend', function (e) {
                    lat = this.getPosition().lat();
                    lng = this.getPosition().lng();
                    var latlng = {lat: this.getPosition().lat(), lng: this.getPosition().lng()};
                    geocoder.geocode( {'location': latlng}, function ( results ) {
                        if ( results[0].formatted_address ) {
                            $( "#txt_address" ).val( results[0].formatted_address );
                        }
                    });
                });
                $( '#hdn_latitude' ).val( lat );
                $( '#hdn_longitude' ).val( lng );
                google.maps.event.addListener( markers, 'click', function (evt) {
                });
                google.maps.event.trigger( markers, 'click' );
                if ( place.geometry.viewport ) {
                    bounds.union( place.geometry.viewport );
                } else {
                    bounds.extend( place.geometry.location );
                }
            });
            map.fitBounds( bounds );
        });
        google.maps.event.addListener( map, 'bounds_changed', function () {
            var bounds = map.getBounds();
            searchBox.setBounds( bounds );
        });
    }
    function initialize_map() {
        var hdn_latitude =  $( "#hdn_other_latitude" ).val() ;
        var hdn_longitude =  $( "#hdn_other_longitude" ).val() ;
        if( hdn_latitude == "" ) {
            hdn_latitude = parseFloat( '-34.397' );
        }else{
            hdn_latitude = parseFloat( hdn_latitude );
        }
        if( hdn_longitude == "" ) {
            hdn_longitude = parseFloat( '150.644' );
        }else{
            hdn_longitude = parseFloat( hdn_longitude );
        }
        other_geocoder = new google.maps.Geocoder();
        var map = new google.maps.Map(document.getElementById( 'map_other_location' ), {
            center: {lat: hdn_latitude, lng: hdn_longitude},
            zoom: 13
        });

        var input = document.getElementById( 'txt_other_address' );
        var searchBox = new google.maps.places.SearchBox( input );
        var marker = [];
        marker = new google.maps.Marker({
            map: map,
            position: new google.maps.LatLng( hdn_latitude,hdn_longitude )
        });
        other_gmarkers.push( marker );
        map.addListener( 'bounds_changed', function () {
            searchBox.setBounds(map.getBounds());
        });

        var markers = [];
          var contentString = ''+ input.value +'';
            var infowindow = new google.maps.InfoWindow({
                content: contentString
            });
            google.maps.event.addListener( marker, 'click', function() {
                infowindow.open( map,marker );
            });

            // To add the marker to the map, call setMap();
            marker.setMap(map);
            searchBox.addListener( 'places_changed', function () {
            var places = searchBox.getPlaces();

            if ( places.length == 0 ) {
                return;
            }

            // Clear out the old markers.
            for ( var i = 0; i < other_gmarkers.length; i++ ) {
                other_gmarkers[i].setMap(null);
            }
            markers = [];
            // For each place, get the icon, name and location.
            var bounds = new google.maps.LatLngBounds();
            places.forEach( function ( place ) {
                if ( !place.geometry ) {
                    console.log( "Returned place contains no geometry" );
                    return;
                }

                // Create a marker for each place.
                markers = new google.maps.Marker({
                    map: map,
                    title: place.name,
                    draggable: true,
                    position: place.geometry.location
                });
                other_gmarkers.push( markers );
                var lat = place.geometry.location.lat();
                var lng = place.geometry.location.lng();
                google.maps.event.addListener( markers, 'dragend', function (e) {
                    lat = this.getPosition().lat();
                    lng = this.getPosition().lng();
                    var latlng = {lat: this.getPosition().lat(), lng: this.getPosition().lng()};
                    other_geocoder.geocode( {'location': latlng}, function ( results ) {
                        if ( results[0].formatted_address ) {
                            $( "#txt_address" ).val( results[0].formatted_address );
                        }
                    });
                });
                $( '#hdn_other_latitude' ).val( lat );
                $( '#hdn_other_longitude' ).val( lng );
                google.maps.event.addListener( markers, 'click', function (evt) {
                });
                google.maps.event.trigger( markers, 'click' );
                if ( place.geometry.viewport ) {
                    bounds.union( place.geometry.viewport );
                } else {
                    bounds.extend( place.geometry.location );
                }
            });
            map.fitBounds( bounds );
        });
        google.maps.event.addListener( map, 'bounds_changed', function () {
            var bounds = map.getBounds();
            searchBox.setBounds( bounds );
        });
    }


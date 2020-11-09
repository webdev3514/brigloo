(function ($) {
    //FOR ACTIVE
    $(document).ready( function() {
        $( '.x-navigation li a' ).click( function() {
            $( 'li a' ).removeClass( "active" );
            $( this ).addClass( "active" );
        });
    });
    
    var bo_validator = $( "#bo_edit" ).validate({
        onsubmit: true,
        rules: {
            txt_first_name: {
                required: true
            },
            txt_last_name: {
                required: true
            },
            txt_phone_no: {
                required: true,
                minlength: 10,
                maxlength: 10,
                number:true
            },
            txt_address_1: {
                required: true
            },
            txt_state: {
                required: true
            },
            txt_city: {
                required: true
            },
        },

    });

    $( document ).on( 'submit', '#bo_edit', function ( e ) {
        e.preventDefault();
        show_loader();
        setTimeout(function(){ 
        var str = '&action=update_business_owner';
        $.ajax({
            type:       "POST",
            dataType:   "html",
            url:        USER_AJAX_URL,
            data:       $( "#bo_edit" ).serialize() + str,
            async:      false,
            success:    function ( data ) {
                var decode_data = JSON.parse( data );
                if( decode_data['success_flag'] == true ){
                    hide_loader();
                    swal( "", decode_data['message'], "success" );
                    $( "#txt_first_name" ).val( decode_data['data']['st_first_name'] );
                    $( "#txt_last_name" ).val( decode_data['data']['st_last_name'] );
                    $( "#txt_phone_no" ).val( decode_data['data']['in_contact_no'] );
                    $( "#txt_address_1" ).val( decode_data['data']['st_address_1'] );
                    $( "#txt_address_2" ).val( decode_data['data']['st_address_2'] );
                    $( "#txt_state" ).val( decode_data['data']['st_state'] );
                    $( "#txt_city" ).val( decode_data['data']['st_city'] );
                    $( "#txt_home_address" ).val( decode_data['data']['st_bo_home_address'] );
                    $( "#hdn_home_latitude" ).val( decode_data['data']['st_bo_home_lat'] );
                    $( "#hdn_home_longitude" ).val( decode_data['data']['st_bo_home_long'] );
                    $( "#txt_warehouse_address" ).val( decode_data['data']['st_bo_warehouse_address'] );
                    $( "#hdn_warehouse_latitude" ).val( decode_data['data']['st_bo_warehouse_lat'] );
                    $( "#hdn_warehouse_longitude" ).val( decode_data['data']['st_bo_warehouse_long'] );
                    $( "#txt_business_name" ).val( decode_data['data']['st_business_name'] );
                    $( "#txt_eni_no" ).val( decode_data['data']['in_eni_number'] );
                    $( "#txt_job_title" ).val( decode_data['data']['st_job_title'] );
                } else {
                    hide_loader();
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
    
    //FOR DRIVER VALIDATION
    var driver_validator = $( "#driver_edit" ).validate({
        onsubmit: true,
        rules: {
            txt_first_name: {
                required: true,
                lettersonly: true
            },
            txt_last_name: {
                required: true,
                lettersonly: true
            },
            txt_liece: {
                required: true
            },
            txt_address_1: {
                required: true
            },
            txt_state: {
                required: true
            },
            txt_city: {
                required: true
            },
        },
    });


    //FOR UPDATE DRIVER DATA
    $( document ).on( 'submit', '#driver_edit', function ( e ) {
        e.preventDefault();
        show_loader();
        setTimeout(function(){ 
        var str = '&action=update_driver';
        $.ajax({
            type:       "POST",
            dataType:   "html",
            url:        USER_AJAX_URL,
            data:       $( "#driver_edit" ).serialize() + str,
            async:      false,
            success:    function ( data ) {
                var decode_data = JSON.parse( data );
                if( decode_data['success_flag'] == true ){
                        hide_loader();
                    swal( "", decode_data['message'], "success" );
                    $( "#txt_first_name" ).val( decode_data['data']['st_first_name'] );
                    $( "#txt_last_name" ).val( decode_data['data']['st_last_name'] );
                    $( "#txt_phone_no" ).val( decode_data['data']['in_contact_no'] );
                    $( "#txt_address_1" ).val( decode_data['data']['st_address_1'] );
                    $( "#txt_address_2" ).val( decode_data['data']['st_address_2'] );
                    $( "#txt_state" ).val( decode_data['data']['st_state'] );
                    $( "#txt_city" ).val( decode_data['data']['st_city'] );
                } else {
                        hide_loader();
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
    
    $( document ).on( 'click', '.send_change_password_link', function ( e ) {
        e.preventDefault();
        var myClass = $( this ).attr( "class" );
        if ( $( this ).hasClass( "send_change_password_link" ) ) {
            $( ".send_change_password_link" ).addClass( 'loader' );
            show_loader();
        } else {
            return false;
        }
        
        var user_id = $( "#user_id" ).val();
        setTimeout(function(){ 
        var str = 'user_id=' + user_id +'&action=send_change_password_link';
            $.ajax({
                type:       "POST",
                dataType:   "html",
                url:        USER_AJAX_URL,
                data:       str,
                async:      false,
                success:    function ( data ) {
                    var decode_data = JSON.parse( data );
                    if( decode_data['success_flag'] == true ){
                        hide_loader();
                        remove_loader();
                        swal( "", decode_data['message'], "success" );
                    } else {
                        hide_loader();
                        remove_loader();
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
    
     //FOR DRIVER VALIDATION
    var driver_validator = $( "#frm_change_email" ).validate({
        onsubmit: true,
        rules: {
            txt_email_id: {
                required: true,
                email: true
            },
        },
    });

    
    $( document ).on( 'submit', '#frm_change_email', function ( e ) {
        e.preventDefault();
        var myClass = $( this ).attr( "class" );
        if ( myClass == 'form-horizontal' ) {
            $( ".mm" ).addClass( 'loader' );
            show_loader();
        } else {
            return false;
        }

        setTimeout(function(){ 
        var user_id = $( "#in_user_id" ).val();
        var str = '&action=send_change_email_link';
        $.ajax({
            type:       "POST",
            dataType:   "html",
            url:        USER_AJAX_URL,
            data:       $( "#frm_change_email" ).serialize() + str,
            async:      false,
            success:    function ( data ) {
                
                var decode_data = JSON.parse( data );
                if( decode_data['success_flag'] == true ){
                        hide_loader();
                        remove_loader();
                    swal( "", decode_data['message'], "success" );
                } else {
                    $(".change_email-failed").find(".change_email-msg").html("<strong>" + decode_data['message'] + "</strong>");
                    $(".change_email-success").hide();
                    close_notification(".change_email-failed");
                        hide_loader();
                        remove_loader();
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
    
     //FOR DRIVER VALIDATION
    var driver_validator = $( "#frm_change_password" ).validate({
        onsubmit: true,
        rules: {
            txt_old_pwd: {
                required: true,
                minlength: 6,
                maxlength: 16
            },
            txt_new_pwd: {
                required: true,
                minlength: 6,
                maxlength: 16
            },
            txt_new_cpwd: {
                required: true,
                minlength: 6,
                maxlength: 16,
                equalTo: "#txt_new_pwd"
            },
        },
    });
    
    $( document ).on( 'submit', '#frm_change_password', function ( e ) {
        
        e.preventDefault();
        show_loader();
        setTimeout(function(){ 
        var str = '&action=change_password';
        $.ajax({
            type:       "POST",
            dataType:   "html",
            url:        USER_AJAX_URL,
            data:       $( "#frm_change_password" ).serialize() + str,
            async:      false,
            success:    function ( data ) {
                
                var decode_data = JSON.parse( data );
                if( decode_data['success_flag'] == true ){
                        hide_loader();
                        swal("", decode_data['message'], "success");
                    $(".change_password-success").find(".change_password-msg").html("<strong>" + decode_data['message'] + "</strong>");
                    $(".change_password-failed").hide();
                    close_notification(".change_password-success");
                    reset_form('frm_change_password');
                    
                } else {
                        hide_loader();
                        swal("", decode_data['message'], "warning");
                    $(".change_password-failed").find(".change_password-msg").html("<strong>" + decode_data['message'] + "</strong>");
                    $(".change_password-success").hide();
                    close_notification(".change_password-failed");
                }
            },
            error: function ( jqXHR, textStatus, errorThrown ) {
                console.log( jqXHR + " :: " + textStatus + " :: " + errorThrown );
            }
        });
        }, 1000);
        return false;
    });
    
    var bo_reg_validator = $( "#frm_sm_registration" ).validate({
        onsubmit: true,
        rules: {
            txt_email_address: {
                required: true,
                email: true
            },
            txt_pwd: {
                required: true,
                minlength: 6,
                maxlength: 16
            },
            txt_crm_pwd: {
                required: true,
                minlength: 6,
                maxlength: 16,
                equalTo: "#txt_pwd"
            }
        },
        
    });

            //FOR STORE MANAGER REGISTRATION
    $( document ).on( 'submit', '#frm_sm_registration', function ( e ) {
        e.preventDefault();
        flag = true; 
        

        is_email( '#txt_email_address' );
        match_two_elements( '#txt_pwd', '#txt_crm_pwd' );
        validate_length( '#txt_pwd', 6 , 15 );
        validate_length( '#txt_crm_pwd', 6 , 15 );
        show_loader();
        setTimeout(function(){ 
            if ( flag == true ) {
                var str = '&action=add_store_manager';
                $.ajax({
                    type:       "POST",
                    dataType:   "html",
                    url:        AJAX_URL,
                    data:       $( "#frm_sm_registration" ).serialize() + str,
                    async:      false,
                    success:    function ( data ) {
                        var decode_data = JSON.parse( data );
                        if( decode_data['success_flag'] == true ){
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
                                redirect_to_URL( decode_data['redirect'] );
                            });
                            reset_form( 'frm_sm_registration' );
                        } else {
                            hide_loader();
                            swal("", decode_data['message'], "warning");
                            $(".signup-failed").find(".signup-msg").html("<strong>" + decode_data['message'] + "</strong>");
                            $(".signup-success").hide();
                            close_notification(".signup-failed");
                        }
                    },
                    error: function ( jqXHR, textStatus, errorThrown ) {
                        console.log( jqXHR + " :: " + textStatus + " :: " + errorThrown );
                    }
                });
            }
         }, 1000);
        return false;
    });

    //FOR USERNAME VALIDATION
    function check_username( feild ){
        var username = $( feild ).val();
        var pattern = /^[A-Za-z0-9_]+$/;
        if ( username == "" ) {
            return 0;
        } else if ( !pattern.test( username ) ) {
            $( feild ).next('.select').css('border-color', '#b64645');
            $( feild ).html('<label id="txt_username-error" class="error" for="txt_username">White spaces are not allowed</label>');
            $( feild ).next('.select').focus();
            return 1;
        }
    }
    
    //FOR ADD IT
    var bo_validator = $( "#bank_bo_edit" ).validate({
        onsubmit: true,
        rules: {
            txt_full_name: {
                required: true,
                lettersonly: true
            },
            txt_acc_no: {
                required: true,
                number: true
            },
            txt_bank_name: {
                required: true,
                lettersonly: true
            },
            txt_branch_name: {
                required: true,
                lettersonly: true
            },  
            txt_routing_no: {
                required: true,
		number: true
            },
        },
    });

    $( document ).on( 'submit', '#bank_bo_edit', function ( e ) {
    e.preventDefault();
    show_loader();
    setTimeout(function(){ 
    flag = true; 
        if ( flag == true ) {
            var str = '&action=update_bank_detail';
            $.ajax({
                type:       "POST",
                dataType:   "html",
                url:        AJAX_URL,
                data:       $( "#bank_bo_edit" ).serialize() + str,
                async:      false,
                success:    function ( data ) {
                    console.log(data);
                    var decode_data = JSON.parse( data );
                    if( decode_data['success_flag'] == true ){
                        hide_loader();
                        swal({
                            title: "",
                            text: decode_data['message'],
                            type: "success",
                            showCancelButton: false,
                            confirmButtonClass: "btn-warning",
                            confirmButtonText: "OK",
                            closeOnConfirm: false
                        },function() {
                            redirect_to_URL( decode_data['redirect'] );
                        });
                        $( "#txt_full_name" ).val( decode_data['data']['st_account_holder_name'] );
                        $("#txt_acc_no").val( decode_data['data']['in_account_number'] );
                        $("#txt_bank_name").val( decode_data['data']['st_bank_name'] );
                        $("#txt_branch_name").val( decode_data['data']['st_branch_name'] );
                        $("#txt_routing_no").val( decode_data['data']['in_routing_number'] );
                        $("#txt_address").val( decode_data['data']['st_add'] );
                        
                    } else {
                        hide_loader();
                           swal("", decode_data['message'], "warning");
                    }
                },
                error: function ( jqXHR, textStatus, errorThrown ) {
                    console.log( jqXHR + " :: " + textStatus + " :: " + errorThrown );
                }
            });
        }
    }, 1000);
    return false;
    });
    
    var sm_verify_validator = $( "#sm_verify_driver_info" ).validate({
        onsubmit: true,
        rules: {
            txt_liecense_id: {
                required: true
            },
            txt_amount: {
                required: true,
                number:true
            },
        },
    });
    
    $( document ).on( 'submit', '#sm_verify_driver_info', function(e) {
        var str = '&action=sm_verify_driver_info';
        var con_msg = $( "#order_type_msg" ).val();
        var same_loc_id = $( "#same_loc_id" ).val();
        var pickup_type =  $( '#pickup_type' ).val();
        console.log(con_msg);
        $.ajax({
            type: "POST",
            dataType: "html",
            url: USER_AJAX_URL,
            data: $( "#sm_verify_driver_info" ).serialize() + '&action=verify_driver_sm_info',
            async: false,
            success: function( data ) {
                hide_loader();
                var decode_data = JSON.parse(data);
                if ( decode_data['success_flag'] == true ) {
                    if( same_loc_id > 0 ){
                        swal({
                            title: '',
                            text: 'Have you received the “Change Order” from driver?',
                            html: true,
                            type: "warning",
                            showCancelButton: true,
                            confirmButtonClass: "btn-danger",
                            confirmButtonText: "Yes",
                            cancelButtonText: "No",
                            closeOnConfirm: false,
                            closeOnCancel: true
                        },function( isConfirm ) {
                            str += '&change_order_verify=Yes';
                            $( ".confirm" ).addClass( 'loader' );
                            if ( isConfirm ) {
                                swal({
                                    title: '',
                                    text: 'Did you give driver the package?',
                                    html: true,
                                    type: "warning",
                                    showCancelButton: true,
                                    confirmButtonClass: "btn-danger",
                                    confirmButtonText: "Yes",
                                    cancelButtonText: "No",
                                    closeOnConfirm: false,
                                    closeOnCancel: true
                                },function( isConfirm ) {
                                    str += '&pickup_verify=Yes';
                                    $( ".confirm" ).addClass( 'loader' );
                                    if ( isConfirm ) {
                                    show_loader();
                                    setTimeout(function() {
                                        $.ajax({
                                            type: "POST",
                                            dataType: "html",
                                            url: USER_AJAX_URL,
                                            data: $( "#sm_verify_driver_info" ).serialize() + str,
                                            async: false,
                                            success: function( data ) {
                                                hide_loader();
                                                var decode_data = JSON.parse(data);
                                                if ( decode_data['success_flag'] == true ) {
                                                    location.reload();
                                                } else {
                                                    swal("", decode_data['message'], "warning");
                                                    hide_loader();
                                                }
                                            },
                                            error: function(jqXHR, textStatus, errorThrown) {
                                                console.log(jqXHR + " :: " + textStatus + " :: " + errorThrown);
                                            }
                                        });
                                    }, 1000);
                                    }
                                });
                            } 
                            return false;
                        });
                    } else if( same_loc_id == 0 && pickup_type == "change_order" ){
                       
                        swal({
                            title: '',
                            text: 'Did you receive change order from the driver?',
                            html: true,
                            type: "warning",
                            showCancelButton: true,
                            confirmButtonClass: "btn-danger",
                            confirmButtonText: "Yes",
                            cancelButtonText: "No",
                            closeOnConfirm: false,
                            closeOnCancel: true
                        },function( isConfirm ) {
                            $( ".confirm" ).addClass( 'loader' );
                            if ( isConfirm ) {
                                show_loader();
                                setTimeout(function() {
                                    $.ajax({
                                        type: "POST",
                                        dataType: "html",
                                        url: USER_AJAX_URL,
                                        data: $( "#sm_verify_driver_info" ).serialize() + str,
                                        async: false,
                                        success: function( data ) {
                                            hide_loader();
                                            var decode_data = JSON.parse(data);
                                            if ( decode_data['success_flag'] == true ) {
                                                location.reload();
                                            } else {
                                                swal("", decode_data['message'], "warning");
                                                hide_loader();
                                            }
                                        },
                                        error: function(jqXHR, textStatus, errorThrown) {
                                            console.log(jqXHR + " :: " + textStatus + " :: " + errorThrown);
                                        }
                                    });
                                }, 1000);
                            }
                        });
                    }else{
                        swal({
                            title: '',
                            text: 'Did you give driver the package?',
                            html: true,
                            type: "warning",
                            showCancelButton: true,
                            confirmButtonClass: "btn-danger",
                            confirmButtonText: "Yes",
                            cancelButtonText: "No",
                            closeOnConfirm: false,
                            closeOnCancel: true
                        },function( isConfirm ) {
                            $( ".confirm" ).addClass( 'loader' );
                            if ( isConfirm ) {
                                show_loader();
                                setTimeout(function() {
                                    $.ajax({
                                        type: "POST",
                                        dataType: "html",
                                        url: USER_AJAX_URL,
                                        data: $( "#sm_verify_driver_info" ).serialize() + str,
                                        async: false,
                                        success: function( data ) {
                                            hide_loader();
                                            var decode_data = JSON.parse(data);
                                            if ( decode_data['success_flag'] == true ) {
                                                location.reload();
                                            } else {
                                                swal("", decode_data['message'], "warning");
                                                hide_loader();
                                            }
                                        },
                                        error: function(jqXHR, textStatus, errorThrown) {
                                            console.log(jqXHR + " :: " + textStatus + " :: " + errorThrown);
                                        }
                                    });
                                }, 1000);
                            }
                        });
                    }
                } else {
                    swal("", decode_data['message'], "warning");
                    hide_loader();
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(jqXHR + " :: " + textStatus + " :: " + errorThrown);
            }
        });
        
        return false;
    });
    
    $( document ).on( 'click', '.edit_sm', function ( e ) {
        e.preventDefault();
        $( "#txt_email_address" ).attr( 'disabled',false );
        $( "#txt_pwd" ).attr( 'disabled',false );
        $( "#txt_crm_pwd" ).attr( 'disabled',false );
        $( "#submit_edit_sm" ).attr( 'disabled',false );
    });
    
})(jQuery);

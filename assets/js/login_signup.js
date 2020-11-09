(function ($) {
      
      
    var reg_validator = $("#frm_contact").validate({
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
            txt_des: {
                required: true,
            },
            txt_phone_no: {
                required: true,
                minlength: 10,
                maxlength: 10,
                number:true
            },
            txt_email_address: {
                required: true,
                email: true
            },
        },
        messages: {
            txt_phone_no: {
                number: "Please enter  phone number"
            }
        }
    });
    
    $( document ).on( 'submit', '#frm_contact', function ( e ) {
        e.preventDefault();
        flag = true;  
        
        is_email( '#txt_email_address' );
        show_loader();
        setTimeout(function(){ 
            if ( flag == true ){
                
                var str = '&action=add_contact_data';
                $.ajax({
                    type:       "POST",
                    dataType:   "html",
                    url:        AJAX_URL,
                    data:       $( "#frm_contact" ).serialize() + str,
                    async:      false,
                    success:    function ( data ) {
                            var decode_data = JSON.parse( data );
                            if( decode_data['success_flag'] == true ){
                            hide_loader();
                                swal("", decode_data['message'], "success");
                                reset_form('frm_contact');
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
    
    var reg_validator = $("#frm_driver_registration").validate({
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
            // txt_user_name: {
            //     required: true
            // },
            txt_phone_no: {
                required: true,
                minlength: 10,
                maxlength: 10,
                number:true
            },
            txt_license_no: {
                required: true
            },
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
            },
            term_condition: {
                required: true
            },
        },
        messages: {
            txt_phone_no: {
                number: "Please enter  phone number"
            }
        }
    });
    
    $( document ).on( 'submit', '#frm_driver_registration', function ( e ) {
        e.preventDefault();
        flag = true;  
        
        check_username( "#txt_user_name" );
        is_email( '#txt_email_address' );
        match_two_elements( '#txt_pwd', '#txt_crm_pwd' );
        validate_length( '#txt_pwd', 6 , 15 );
        validate_length( '#txt_crm_pwd', 6 , 15 );
        show_loader();
        setTimeout(function(){ 
            if ( flag == true ){
                
                var str = '&action=add_driver';
                $.ajax({
                    type:       "POST",
                    dataType:   "html",
                    url:        AJAX_URL,
                    data:       $( "#frm_driver_registration" ).serialize() + str,
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
                                reset_form('frm_driver_registration');
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
    
    var bo_reg_validator = $("#frm_bo_registration").validate({
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
            // txt_user_name: {
            //     required: true
            // },
            txt_phone_no: {
                required: true,
                minlength: 10,
                maxlength: 10,
                number:true
            },
            txt_eni_no: {
                required: true,
                number:true
            },
            txt_business_name: {
                required: true
            },
            // txt_job_title: {
            //     required: true
            // },
            txt_address_1: {
                required: true
            },
            txt_zip_code: {
                required: true
            },
            txt_state: {
                required: true
            },
            txt_city: {
                required: true
            },
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
            },
            term_condition: {
                required: function (element) {
                    var boxes = $('.checkbox');
                    if (boxes.filter(':checked').length == 0) {
                        return true;
                    }
                    return false;
                },
            },
        },
        messages: {
            txt_phone_no: {
                number: "Please enter  phone number"
            }
        }
    });
    
     $( document ).on( 'click', '.forgot_password', function(e){
        $( "#forgot_password" ).modal( 'show' );
    });
    
    $('#frm_bo_registration input[type=checkbox]').on('ifChanged', function (event) {

        //Check if checkbox is checked or not
        var checkboxChecked = $(this).is(':checked');

        if ( checkboxChecked ) {
            
        } else {
            $(this).find('.err_checkbox').html( "Please accept temrs and condition." );
            return false;
        }
    });
    $( document ).on( 'submit', '#frm_bo_registration', function ( e ) {
        e.preventDefault();
        flag = true; 
        check_username( "#txt_user_name" );
        set_only_alphabets("#txt_full_name");

        is_email( '#txt_email_address' );
        match_two_elements( '#txt_pwd', '#txt_crm_pwd' );
        validate_length( '#txt_pwd', 6 , 15 );
        validate_length( '#txt_crm_pwd', 6 , 15 );
        show_loader();
            if ( flag == true ){
                var str = '&action=add_business_owner';
                
                $.ajax({
                    type:       "POST",
                    dataType:   "html",
                    url:        AJAX_URL,
                    data:       $( "#frm_bo_registration" ).serialize() + str,
                    async:      false,
                    success:    function ( data ) {
                        var decode_data = JSON.parse( data );
                        if( decode_data['success_flag'] == true ){
                           swal({
                                title: "",
                                text: decode_data['message'],
                                type: "success",
                                showCancelButton: false,
                                confirmButtonClass: "btn-warning",
                                confirmButtonText: "Okay",
                                closeOnConfirm: false
                            },function() {
                                redirect_to_URL( decode_data['redirect'] );
                            });
                            reset_form( 'frm_bo_registration' );
                        } else {
                            swal( "", decode_data['message'], "warning" );
                        }
                    },
                    error: function ( jqXHR, textStatus, errorThrown ) {
                        console.log( jqXHR + " :: " + textStatus + " :: " + errorThrown );
                    }
                });
                
            }
        hide_loader();
        return false;
    });
    
    // Login validation
    
    var login_validator = $("#frm_login").validate({
        onsubmit: true,
        rules: {
            txt_email: {
                required: true,
                email: true
            },
            txt_password: {
                required: true
            },
        },

    });
    
    function check_username( feild ){
        var username = $( feild ).val();
        var pattern = /\s/;
        if (pattern.test(username)) {
            $( feild ).next('.select').css('border-color', '#b64645');
            $( feild ).html('<label id="txt_username-error" class="error" for="txt_username">White spaces are not allowed</label>');
            $( feild ).next('.select').focus();
            return false;
        }

        var spl_pattern = /[ !@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/;
        if (spl_pattern.test(username)) {
            $( feild ).next('.select').css('border-color', '#b64645');
            $( feild ).html('<label id="txt_username-error" class="error" for="txt_username">Special characters are not allowed</label>');
            $( feild ).next('.select').focus();
            return false;
        }
    }
    // Login submit event
    $( document ).on( 'submit', '#frm_login', function ( e ) {
        e.preventDefault();
        flag = true;
        is_email( '#txt_email' );
        
        if ( flag == true ) {
            show_loader();
            setTimeout(function(){ 
            var str = '&action=user_login';
            $.ajax({
                type:       "POST",
                dataType:   "html",
                url:        AJAX_URL,
                data:       $( "#frm_login" ).serialize() + str,
                async:      false,
                success:    function ( data ) {
                    var decode_data = JSON.parse( data );
                    if( decode_data['success_flag'] == true ) {
                        hide_loader();
//                        swal("", decode_data['message'], "success");  
                        redirect_to_URL( decode_data['redirect'] );
                    } else {
                           hide_loader();
                        $( ".login-failed" ).find( ".login-msg" ).html("<strong>" + decode_data['message'] + "</strong>");
                        $( ".login-success" ).hide();
                        $(".login-failed").show();
                        setTimeout(function () {
                            $(".login-failed").hide();
                        }, 10000);
                    }
                },
                error: function ( jqXHR, textStatus, errorThrown ) {
                    console.log( jqXHR + " :: " + textStatus + " :: " + errorThrown );
                }
            });
            }, 1000);
        }
       
        return false;
    }); 
    
    $( document ).on( 'click', '.resend_signup_link', function ( e ) {
        e.preventDefault();
        show_loader();
        setTimeout(function(){ 
        var mail_id = $( this ).data( 'email' );
        var str = 'mail_id='+ mail_id +'&action=resend_signup_link';
        $.ajax({
            type:       "POST",
            dataType:   "html",
            url:        USER_AJAX_URL,
            data:       str,
            async:      false,
            success:    function ( data ) {
                var decode_data = JSON.parse( data );
                if( decode_data['success_flag'] == true ) {
                         hide_loader();
                    swal("", decode_data['message'], "success");
                } else {
                         hide_loader();
                    swal("", decode_data['message'], "warning");
                }
            },
            error: function ( jqXHR, textStatus, errorThrown ) {
                console.log( jqXHR + " :: " + textStatus + " :: " + errorThrown );
            }
        });
        }, 1000);
        return false;
    }); 
    
    $( "#frm_forgot_password" ).submit( function ( e ) {        
        show_loader();
        e.preventDefault();
        var str = '&action=forgot_password';
        
        $.ajax({
            type: "POST",
            dataType: "html",
            url: USER_AJAX_URL,
            data: $( "#frm_forgot_password" ).serialize() + str,
            success: function ( data ) {
                console.log(data);
                var decode_data = JSON.parse( data );
                if ( decode_data['success_flag'] == true ) {
                    $( '#forgot_password' ).modal( 'hide' );
                    reset_form('frm_forgot_password');
                   swal("", decode_data['message'], "success");
                    setTimeout(function () {
                        $(".forgot_pwd-success").hide();
                        $("#forgot_password").modal('hide');
//                             window.location = 'password_recovery.php?email=' + decode_data['data']['email'] + '&key=' + decode_data['data']['generated_key'];
                    }, 3000);

                } else {
                   swal("", decode_data['message'], "warning");
                    setTimeout(function () {
                        $(".forgot_pwd-failed").hide();
                    }, 3000);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR + " :: " + textStatus + " :: " + errorThrown);
            }
        });
        hide_loader();
        return false;
    });
    
    $( "#frm_recovery_password" ).submit( function ( e ) {
        
        if ( !( $( this ).valid() ) ) {
            return false;
        } else {
            show_loader();
            e.preventDefault();
            var str = '&action=recovery_password';
            $.ajax({
                type: "POST",
                dataType: "html",
                url: USER_AJAX_URL,
                data: $( "#frm_recovery_password" ).serialize() + str,
                async: false,
                success: function ( data ) {
                    console.log( data );
                    var decode_data = JSON.parse( data );
                    
                    if ( decode_data['success_flag'] == true ) {
                        redirect_to_URL( FRONT_URL + 'view/login.php' );
                    } else {

                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR + " :: " + textStatus + " :: " + errorThrown);
                }
            });
            hide_loader();
            return false;
        }
    });
    

    function check_username( feild ){
        var username = $( feild ).val();
        var pattern = /^[A-Za-z0-9_]+$/;

        if ( !pattern.test( username ) ) {
            $( feild ).next('.select').css('border-color', '#b64645');
            $( feild ).html('<label id="txt_username-error" class="error" for="txt_username">White spaces are not allowed</label>');
            $( feild ).next('.select').focus();
            return 1;
        }

        // var spl_pattern = /[ !@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/;
        // if (spl_pattern.test(username)) {
        //     $( feild ).next('.select').css('border-color', '#b64645');
        //     $( feild ).html('<label id="txt_username-error" class="error" for="txt_username">Special characters are not allowed</label>');
        //     $( feild ).next('.select').focus();
        //     return false;
        // }
    }
    
})(jQuery);



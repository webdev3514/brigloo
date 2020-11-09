var ERR_AJAX = "Something went wrong!!! Please try again...";
var ERR_BLANK_FORM = "Please Fill All the Required Fields...";
var SUBDIR = '/brigloo/';
var UPLOAD_PATH = '/uploads/';
var FRONT_URL = window.location.protocol + "//" + window.location.host + SUBDIR;
var SERVER = window.location.protocol + '//' + window.location.host;
var flag = true;
var ADMIN_URL = SERVER + SUBDIR + "backend/";
var AJAX_URL = SERVER + SUBDIR + "user_ajax.php";
var ADMIN_AJAX_URL = ADMIN_URL + "admin_ajax.php";
var USER_AJAX_URL = SERVER + SUBDIR + "user_ajax.php";
var USER_URL = SERVER + SUBDIR + "core/user.php";
var SYM_PRICE = '$';
var GLOBAL_VAR = [];
var LIKE_ARRAY = ["profile", "dish", "user_pics", "custom", "store"];
var ENDLIMIT = 3;
var LOCATION_ARRAY = [];

function clear_element( element ) {
    jQuery( element ).attr( 'value', "" );
}

//function hide_loader() {
//    $( ".loader" ).removeClass( 'show' );
//    $( ".loader" ).hide();
//    
////    $( ".loader" ).fadeOut( "slow" );
//}
//
//function show_loader() {
//    $( ".loader" ).addClass( 'show' );
////    $( '.loader' ).fadeIn( 'show' );
//}

function hide_loader() {
        $( ".loader" ).removeClass( 'show' );
}

function show_loader() {
        $( ".loader" ).addClass( 'show' );
//    $( '.loader' ).fadeIn( 'show' );
}
function remove_loader() {
        $( ".mm" ).removeClass( 'loader' );
        $( ".send_change_password_link" ).removeClass( 'loader' );
}



//Pass Only el Name
function is_selected(el){
    if ( jQuery( el + " option:selected" ).index() == 0)
    {
        invalid_input( el, true );
        flag = false;
    } else{
        invalid_input( el, false );
    }
}

function validate_length( el, min, max )
{  
    if (jQuery( el ).val().length < min || jQuery( el ).val().length > max)
    {
        invalid_input( el, true );
        flag = false;
    } else{
        invalid_input( el, false );
    }
}

function match_two_elements( el1, el2 )
{
    if ( jQuery( el1 ).val() != jQuery( el2).val() )
    {
        invalid_input( el2, true );
        flag = false;
    } else
    {
        invalid_input( el2, false );
    }
}

//To Reload current page
function reload_page() {
    window.location.reload();
    window.location.href = document.URL;
}

//To Redirect Page
function redirect_to_URL( REDIRECT_URL ) {
    window.location.href = REDIRECT_URL;
}

//To Reset Form
function reset_form( formId ) {
    jQuery( '#' + formId )[0].reset();
}

//Remove Errors
function remove_form_errors( formId ) {
    jQuery( '#' + formId + ' input' ).css( 'box-shadow', '0' );
    jQuery( '#' + formId + ' select' ).css( 'box-shadow', '0' );
    jQuery( '#' + formId + ' textarea' ).css( 'box-shadow', '0' );
}


//Apply CSS to Wrong Input
function invalid_input( el, vflag ) {
    if ( vflag ) {
        jQuery( el ).addClass( "input-err" );
    } else {
        jQuery( el ).removeClass( "input-err" );
    }
}

//Check Validation On Blur
function err_on_blur( el, fn ) {
    jQuery( el ).blur( function () {
        fn( el );
    });
}

//Set Validation on Multiple IDs
function check_validation( arrlst, func ) {
    jQuery.map( arrlst, function ( val ) {
        func( val );
    });
}

//Set Validation on Blur Event on Multiple IDs
function set_on_blur_validation( arrlst, func ) {
    jQuery.map( arrlst, function ( val ) {
        err_on_blur( val, func );
    });
}

//Check Blank Text Field
function is_blank( el ) {
    if ( jQuery.trim( jQuery( el ).val() ) == "" ) {
        invalid_input( el, true );
        flag = false;
    } else {
        invalid_input( el, false );
    }
}

//Email Validation
function is_email( el ) {
    if ( jQuery.trim( jQuery( el ).val() ) != "" ) {
        var expr = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
        if ( !expr.test( jQuery.trim( jQuery( el ).val() ) ) ) {
            invalid_input( el, true );
            flag = false;
        } else {
            invalid_input( el, false );
        }
    } else {
        invalid_input( el, true );
    }
}

function set_only_alphabets( el )
{
    jQuery( el ).keypress( function ( e ) {
        if ( e.which != 8 && e.which != 0 && e.which != 32 && ( e.which < 65 || e.which > 90 ) && ( e.which < 97 || e.which > 122 ) ) {
            return false;
        }
    });
}

function set_only_digits( el )
{
    jQuery( el ).keypress( function ( e ) {
        if ( e.which != 8 && e.which != 0 && ( e.which < 48 || e.which > 57 ) ) {
            return false;
        }
    });
}
function set_only_price( el )
{
    jQuery( el ).keypress( function ( e ) {
        if ( e.which != 8 && e.which != 0 && e.which != 46 && ( e.which < 48 || e.which > 57 ) ) {
            return false;
        }
        if ( e.which == 46 && jQuery( el ).val().indexOf('.') > 0 ) {
            return false;
        }
    });
}

function set_values( data ){
    jQuery.each( data, function ( i, d ){
        $( "#" + i ).val( d );
    });
}

function set_text_values( data, type ){
    jQuery.each( data, function ( i, d ){
        jQuery( type + i ).text( d );
    });
}

function copyToClipboard( textToCopy ) {
    var $temp = $( "<input>" );
    $( "body" ).append( $temp );
    $temp.val( textToCopy ).select();
    document.execCommand( "copy" );
    $temp.remove();
}


function set_val( source, destination, event ){        
    jQuery( document ).on( event, source, function(){
        jQuery( destination ).val( jQuery( source ).val() );
    });
}

function scroll_to_focus( $toElement, $focusElement, $offset, $speed ){
        var $this = $( this ),
                $offset = $offset * 1 || 0,
                $speed = $speed * 1 || 500;
        $( 'html, body' ).animate({
            scrollTop: $( $toElement ).offset().top + $offset
        }, $speed );

        if ( $focusElement )
            $( $focusElement ).focus();
};

function readURL( input, output ) {

  if ( input.files && input.files[0] ) {
    var reader = new FileReader();

    reader.onload = function( e ) {
      $( output ).attr( 'src', e.target.result );
    }

    reader.readAsDataURL( input.files[0] );
  }
}

jQuery.fn.set_toggle = function () {
    if ( jQuery( this ).attr( 'checked' ) == undefined ) {
        jQuery( this ).attr( 'checked', true );
    } else {
        jQuery( this ).removeAttr( 'checked' );
    }
};

 function close_notification(el, effect, timeout) {
    $(el).show();
    if (typeof timeout == "undefined" || timeout == "") {
        timeout = 3000;
    }
    if (typeof effect == "undefined" || effect == "") {
        effect = 'fade';
    }
    setTimeout(function () {
        if (effect == 'hide' || effect == 'normal') {
            $(el).hide();
        } else if (effect == 'slide') {
            $(el).slideOut('normal');
        } else if (effect == 'fade') {
            $(el).fadeOut('normal');
        }
    }, timeout);
}

function location_address_cut( ){
    jQuery( '.cut_location_address' ).each( function(){
        var location_address = cutString( jQuery( this ).text() ) ;
        jQuery( this ).text( location_address );
    });
}

location_address_cut();


function removeItem_array(array, item){
    for(var i in array){
        if(array[i]==item){
            array.splice(i,1);
            break;
        }
    }
}

function cutString( text ){
    var wordsToCut = 5;
    var wordsArray = text.split( " " );
    
    if( wordsArray.length > wordsToCut ){
        var strShort = "";
        for( i = 0; i < wordsToCut; i++ ){

            strShort += wordsArray[i] + " ";
        }  
        return strShort + "...";
    }else{
        return text;
    }
};

jQuery.validator.addMethod("lettersonly", function(value, element) {
    return this.optional(element) || value == value.match(/^[a-zA-Z\s]+$/);
    // --                                    or leave a space here ^^
},"Letters only please");


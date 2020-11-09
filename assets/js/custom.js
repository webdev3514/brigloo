
 $(document).ready(function(){
		
		
		$(window).scroll(function(){
		  var sticky = $('header'),
			  scroll = $(window).scrollTop();

		  if (scroll >= 70) sticky.addClass('fixed');
		  else sticky.removeClass('fixed');
		});
		
	
        var current = window.location.href;
        $('.ul-menu li').click(function() {
            // e.preventDefault();                
            //$(this).siblings().removeClass('active').addClass('active');
           // console.log( $('.ul-menu').find('.active'));
             $('.ul-menu').find('.active').removeClass();
            $(this).addClass('active');
        });
		
		
//    $( '.brigloo-menu li a' ).each( function(){
//        var $this = $( this );        
//        // if the current path is like this link, make it active
//        if( $this.attr( 'href' ).indexOf( current ) !== -1 ){            
//            $this.parents( ".left-bar-li" ).addClass( 'active' );
//            $this.addClass( 'active' );
//        }
//    });
    $( '.brigloo-menu li' ).click( function(){
        var $this = $( this ); 
        alert("sd");
        // if the current path is like this link, make it active
        $( '.brigloo-menu' ).find( '.active' ).removeClass();
        $( this ).addClass( 'active' );
    });
});


// toogle menu 
$(document).ready(function(){
    $('#nav-icon2').click(function(e){
      e.stopPropagation();
        $('body').toggleClass('open-nav');
        $(this).toggleClass('open');
    });

    // $('body').click(function(e) {
    //   e.stopPropagation();
    // });

    $(".nav-bar .nav-left li a").each(function() {      
      $(this).click(function(e) {       
        $('body').removeClass('open-nav');
        $('#nav-icon2').removeClass('open');
      });
    })

    $('body,html').click(function(e){
        $('body').removeClass('open-nav');
        $('#nav-icon2').removeClass('open');
    });
});

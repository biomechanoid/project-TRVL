$(document).ready(function(){$(".sb").click(function(e){var t=$(this).index(".sb");$("body").append('<div class="smoothbox sb-load"><div class="smoothbox-table"><div class="smoothbox-centering"><div class="smoothbox-sizing"><div class="sb-nav"><a href="#" class="sb-prev sb-prev-on" alt="Previous">&larr;</a><a href="#" class="sb-cancel" alt="Close">&times;</a><a href="#" class="sb-next sb-next-on" alt="Next">&rarr;</a></div><ul class="sb-items"></ul></div></div></div></div>');$.fn.reverse=[].reverse;$(".sb").reverse().each(function(){var e=$(this).attr("href");if($(this).attr("title")){var t=$(this).attr("title");$(".sb-items").append('<div class="sb-item"><div class="sb-caption">'+t+'</div><img src="'+e+'"/></div>')}else{$(".sb-items").append('<div class="sb-item"><img src="'+e+'"/></div>')}});$(".sb-item").slice(0,-t).appendTo(".sb-items");$(".sb-item").not(":last").hide();$(".sb-item img:last").load(function(){$(".smoothbox-sizing").fadeIn("slow",function(){$(".sb-nav").fadeIn();$(".sb-load").removeClass("sb-load")})});e.preventDefault()});$(document).on("click",".sb-cancel",function(e){$(".smoothbox").fadeOut("slow",function(){$(".smoothbox").remove()});e.preventDefault()});$(document).on("click",".sb-next-on",function(e){$(this).removeClass("sb-next-on");if(jQuery.browser.version.substring(0,2)=="8."){$(".sb-item").eq(-2).fadeIn("fast");$(".sb-item:last").fadeOut().removeClass("sb-item-ani").prependTo(".sb-items")}else{$(".sb-item:last").addClass("sb-item-ani");$(".sb-item:last").bind("transitionend webkitTransitionEnd oTransitionEnd MSTransitionEnd",function(){$(".sb-item").eq(-2).addClass("no-trans").fadeIn("fast");$(this).removeClass("sb-item-ani").prependTo(".sb-items").hide();$(".sb-item:last").removeClass("no-trans");$(".sb-next").addClass("sb-next-on");$(".sb-item").unbind()})}e.preventDefault()});$(document).on("click",".sb-prev-on",function(e){$(this).removeClass("sb-prev-on");if(jQuery.browser.version.substring(0,2)=="8."){$(".sb-item:first").appendTo(".sb-items").fadeIn()}else{$(".sb-item:last").hide();$(".sb-item:first").addClass("sb-item-ani2 no-trans").appendTo(".sb-items");$(".sb-item:last").show().removeClass("no-trans").delay(1).queue(function(e){$(".sb-item:last").removeClass("sb-item-ani2");e()});$(this).addClass("sb-prev-on")}e.preventDefault()})})
(function() {
    var triggerBttn = $('.trigger-overlay');
        overlay = document.querySelector( 'div.overlay' ),
        // closeBttn = overlay.querySelector( 'a.overlay-close' );
    transEndEventNames = {
        'WebkitTransition': 'webkitTransitionEnd',
        'MozTransition': 'transitionend',
        'OTransition': 'oTransitionEnd',
        'msTransition': 'MSTransitionEnd',
        'transition': 'transitionend'
    },
        transEndEventName = transEndEventNames[ Modernizr.prefixed( 'transition' ) ],
        support = { transitions : Modernizr.csstransitions };

    function toggleOverlay() {
        if( classie.has( overlay, 'open' ) ) {
            classie.remove( overlay, 'open' );
            classie.add( overlay, 'close' );
            var onEndTransitionFn = function( ev ) {
                if( support.transitions ) {
                    if( ev.propertyName !== 'visibility' ) return;
                    this.removeEventListener( transEndEventName, onEndTransitionFn );
                }
                classie.remove( overlay, 'close' );
            };
            if( support.transitions ) {
                overlay.addEventListener( transEndEventName, onEndTransitionFn );
            }
            else {
                onEndTransitionFn();
            }
        }
        else if( !classie.has( overlay, 'close' ) ) {
            classie.add( overlay, 'open' );
        }

        $("div.overlay").animate({ scrollTop: 0 }, "slow");
    }
triggerBttn.each(function() {
  this.addEventListener( 'click', toggleOverlay );
});

    // closeBttn.addEventListener( 'click', toggleOverlay );
    return false;
})();

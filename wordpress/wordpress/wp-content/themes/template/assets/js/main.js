( function( $ ) {
    var showing = false;
    var hovering = false;
    var binds = [];
    var selectors = {};
    var tempSelectors={}
    var menuHoveringDepth = 1;
    var totalDepth = 1;
    var watchScroll = function(){
        $(window).scroll(function(){
            var scroll = $(this).scrollTop();
            if (scroll > 100 && !showing) {
                showing = true;
                $('#back-to-top').fadeIn();
            } else if(scroll <= 100 && showing) {
                showing = false;
                $('#back-to-top').fadeOut();
            }
        });
        $('#back-to-top').on('click', function(e){
            $(window).bind("mousewheel", function() {
                $("html, body").stop();
            });
            e.preventDefault();
            $('html, body').animate({scrollTop : 0},1000);
            return false;
        });
    }
    var watchButtonClicks = function(){
        $(".search-submit").on('click', function(e){
            if(event.target.nodeName === 'I') $('#search-submit-input-hidden').trigger('click');
        })
        $(".comment-submit").on('click', function(e){
            if(event.target.nodeName === 'I') $('#comment-submit-input-hidden').trigger('click');
        })
    }


    // Materialize's Menu doesn't work too well for this. So let's build our own.
    // $( document ).ready(function() {
    //     $("a.main-menu-link").dropdown({'hover':true});
    // });

    // This code is honestly garbage. This should really be cleaned up. Probably moving the 
    // while loop to it's own function, and possibly combining the selector objects.
    //
    // This is the definition of sphagetti shit code. 
    //
    var clearSelectors = function(sections,clear_binds,clear_temp_selectors,all){
        var to_remove = clear_temp_selectors ? tempSelectors : selectors;
        var n = sections;
        var all_counter = 0;
        while(n <= totalDepth){
            if(to_remove[n.toString()]){
                if(n === 0 && (!all || all_counter === 0)){
                    $(to_remove[n.toString()]).css({'display':'none', 'opacity':0})
                    to_remove[n.toString()] = null;
                } else {
                    var children = to_remove[n.toString()]
                    for(var i = 0; i < children.length; i++){
                        $(children[i]).parent().parent().css({'display':'none', 'opacity':0})
                    }
                }
            } 
            if(n === totalDepth && all_counter == 0){
                all_counter = 1; 
                n = -1; 
                to_remove = tempSelectors;
            }
            n++;
        }
        if(clear_binds){
            for(var i = 0; i < binds.length; i++){
                $(binds[i]).unbind();
            }
            watchMenu();
        }
        if(clear_temp_selectors || all) tempSelectors = {};
        else selectors = {};
    }

    var childMenu = function(selector,depth){
        $(selector).on('mouseenter mouseleave', function(e){
            selectors[depth.toString() + "_current"] = $(this);
            if(!selectors[depth.toString()]) selectors[depth.toString()] = ['#'+$(this).attr('data-activates') + ' > li > a']
            else selectors[depth.toString()].push('#' + $(this).attr('data-activates') + ' > li > a')
            binds.push($(this));
            if(e.type === 'mouseenter'){
                if(selectors[depth.toString() + "_current"] != $(this) && depth == menuHoveringDepth){
                    clearSelectors(depth+1,false,true,false);
                }
                tempSelectors = {};
                hovering = true;
                menuHoveringDepth = depth;
                totalDepth = depth + 1;

                if($(this).attr('data-activates')){
                    var top = $(this).parent().position().top;
                    $('#' + $(this).attr('data-activates')).css({'display':'initial','opacity':1, 'right':'150px', top: top})
                    var depth_string = String(depth + 1)
                    if(!tempSelectors[depth_string]) tempSelectors[depth_string] = ['#'+$(this).attr('data-activates') + ' > li > a']
                    else tempSelectors[depth_string].push('#' + $(this).attr('data-activates') + ' > li > a')
                    childMenu('#' + $(this).attr('data-activates') + ' > li > a', depth+1)
                }
            } else {
                hovering = false;
                setTimeout(function(){
                    if(!hovering)clearSelectors(0,true,false,true);
                },20);
            }
        });
    };
    var watchMenu = function(){
        binds = ["a.main-menu-link"];
        $("a.main-menu-link").on('mouseenter mouseleave', function(e){
            var activator = "#" + $(this).attr('data-activates');
            if(selectors['0'] && selectors['0'] != activator){
                clearSelectors(0,true);
            }
            var position = $(this).position();
            var right = window.innerWidth - position.left - $(this).parent().width();
            if(e.type === 'mouseenter'){
                hovering = true;
                $(activator).css({'display':'initial', 'opacity':1, 'right': right})
                selectors['0'] = activator
                binds.push($(this));
                if($(this).attr('data-activates')) childMenu(activator + ' > li > a',1)
            } else {
                hovering = false;
                setTimeout(function(){
                    if(!hovering) clearSelectors(0,true,false,true);
                },20);
            }
        })
    }
    watchScroll();
    watchButtonClicks();
    watchMenu();
    $(".button-collapse").sideNav();
})(jQuery)
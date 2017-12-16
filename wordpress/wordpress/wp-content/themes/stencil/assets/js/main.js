( function( $ ) {
    var showing = false;
    var hovering = false;
    var binds = {};
    // selectors are for menu items already created
    var selectors = {};
    // temp selectors are the menu items created when hovering over a menu item with a sub menu;
    var tempSelectors={};
    var menuHoveringDepth = 1;
    var totalDepth = 1;
    var menu_right = $('#menu-top').length && $('#menu-top').get(0).className.split(' ')[0] === 'right' ? true : false;


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

    var watchMobileMenu = function(){
        $(".button-collapse").sideNav({
            menuWidth: 300, // Default is 300
            edge: 'left', // Choose the horizontal origin
            closeOnClick: true, 
            draggable: true, 
            onOpen: function(el) { $('.nav-icon').get(0).className = "nav-icon open";  }, 
            onClose: function(el) { $('.nav-icon').removeClass('open') }, 
        });
    }


    // Materialize's Menu doesn't work too well for this. So let's build our own.
    // $( document ).ready(function() {
    //     $("a.main-menu-link").dropdown({'hover':true});
    // });

    // Bind patch for the clearBinds needs the be figured out.
    //   - For some reason, the display none is not occuring, but the selector is being removed.
    //
    // Code should probably be cleaned up a little.
    //
    var clearBinds = function(n){
        while(n <= totalDepth){
            nth_key = n.toString();
            if(binds[nth_key]){
                var children = binds[nth_key];
                for(let i = 0; i < binds[nth_key].length; i++){
                    $(children[i]).unbind();
                }
                binds[nth_key] = [];
            }
            n++;
        }
    }
    
    var clearSelectors = function(selector_type, n){
        while(n <= totalDepth){
            nth_key = n.toString()
            if(selector_type[nth_key]){
                if(n === 0){
                    $(selector_type[nth_key]).css({'display':'none', 'opacity':0})
                    selector_type[nth_key] = null;
                } else {
                    var children = selector_type[nth_key];
                    for(var i = 0; i < children.length; i++){
                        $(children[i]).parent().parent().css({'display':'none', 'opacity':0})
                    }
                    selector_type[nth_key] = [];
                }
            } 
            n++;
        }
    }

    var clearing = function(sections,bind_patch){
        clearSelectors(selectors, sections);
        clearSelectors(tempSelectors, sections);
        if(!bind_patch) clearBinds(sections);
        totalDepth = sections;
        if(sections === 0){
            tempSelectors = {};
            selectors = {};
            binds = {};
            watchMenu();
        }
    }

    var childMenu = function(selector,depth){
        $(selector).on('mouseenter mouseleave', function(e){
            selectors[depth.toString() + "_current"] = $(this);
            if(!binds[depth.toString()]) binds[depth.toString()] = [$(this)]
            else binds[depth.toString()].push($(this))
            if(e.type === 'mouseenter'){
                if(selectors[depth.toString() + "_current"] != $(this) && depth == menuHoveringDepth){
                    clearing(depth+1);
                }
                if(menuHoveringDepth > depth){
                    // clearing(depth+1);
                    clearing(depth,true);
                }

                tempSelectors = {};
                hovering = true;
                menuHoveringDepth = depth;
                totalDepth = totalDepth < depth + 1 ? depth + 1 : totalDepth;

                if($(this).attr('data-activates')){
                    if(!selectors[depth.toString()]) selectors[depth.toString()] = ['#'+$(this).attr('data-activates') + ' > li > a']
                    else selectors[depth.toString()].push('#' + $(this).attr('data-activates') + ' > li > a')
                    var top = $(this).parent().position().top;
                    if(menu_right) $('#' + $(this).attr('data-activates')).css({'display':'initial','opacity':1, 'right':'150px', top: top})
                    else $('#' + $(this).attr('data-activates')).css({'display':'initial','opacity':1, 'left':'150px', top: top})
                    var depth_string = String(depth + 1)
                    if(!tempSelectors[depth_string]) tempSelectors[depth_string] = ['#'+$(this).attr('data-activates') + ' > li > a']
                    else tempSelectors[depth_string].push('#' + $(this).attr('data-activates') + ' > li > a')
                    childMenu('#' + $(this).attr('data-activates') + ' > li > a', depth+1)
                }
            } else {
                hovering = false;
                setTimeout(function(){
                    if(!hovering)clearing(0);
                },20);
            }
        });
    };

    var watchMenu = function(){
        binds['0'] = ["a.main-menu-link"];
        $("a.main-menu-link").on('mouseenter mouseleave', function(e){
            var activator = "#" + $(this).attr('data-activates');
            if(selectors['0'] && selectors['0'] != activator){
                clearing(0);
            }
            var position = $(this).position();
            if(menu_right) var right = window.innerWidth - position.left - $(this).parent().width();
            else var left = position.left;
            if(e.type === 'mouseenter'){
                hovering = true;
                if(menu_right) $(activator).css({'display':'initial', 'opacity':1, 'right': right})
                else $(activator).css({'display':'initial', 'opacity':1, 'left': left})
                if(!binds['1']) binds['1'] = [$(this)]
                else binds['1'].push($(this));
                selectors['0'] = activator
                if($(this).attr('data-activates')) childMenu(activator + ' > li > a',1)
            } else {
                hovering = false;
                setTimeout(function(){
                    if(!hovering) clearing(0);
                },20);
            }
        })
    }
    watchScroll();
    watchButtonClicks();
    watchMobileMenu();
    watchMenu();
})(jQuery)
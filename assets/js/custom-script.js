(function ($) { 

function _init() {
    "use strict";
    $.AdminLTE.layout = {
        activate: function() {
            var a = this;
            a.fix(), a.fixSidebar(), $(window, ".wrapper").resize(function() {
                a.fix(), a.fixSidebar()
            })
        },
        fix: function() {
            var a = $(".main-header").outerHeight() + $(".main-footer").outerHeight(),
                b = $(window).height(),
                c = $(".sidebar").height();
            if ($("body").hasClass("fixed")) $(".content-wrapper, .right-side").css("min-height", b - $(".main-footer").outerHeight());
            else {
                var d;
                b >= c ? ($(".content-wrapper, .right-side").css("min-height", b - a), d = b - a) : ($(".content-wrapper, .right-side").css("min-height", c), d = c);
                var e = $($.AdminLTE.options.controlSidebarOptions.selector);
                "undefined" != typeof e && e.height() > d && $(".content-wrapper, .right-side").css("min-height", e.height())
            }
        },
        fixSidebar: function() {
            return $("body").hasClass("fixed") ? ("undefined" == typeof $.fn.slimScroll && window.console && window.console.error("Error: the fixed layout requires the slimscroll plugin!"), void($.AdminLTE.options.sidebarSlimScroll && "undefined" != typeof $.fn.slimScroll && ($(".sidebar").slimScroll({
                destroy: !0
            }).height("auto"), $(".sidebar").slimscroll({
                height: $(window).height() - $(".main-header").height() + "px",
                color: "rgba(0,0,0,0.2)",
                size: "3px"
            })))) : void("undefined" != typeof $.fn.slimScroll && $(".sidebar").slimScroll({
                destroy: !0
            }).height("auto"))
        }
    }, $.AdminLTE.pushMenu = {
        activate: function(a) {
            var b = $.AdminLTE.options.screenSizes;
            $(document).on("click", a, function(a) {
                a.preventDefault(), $(window).width() > b.sm - 1 ? $("body").hasClass("sidebar-collapse") ? $("body").removeClass("sidebar-collapse").trigger("expanded.pushMenu") : $("body").addClass("sidebar-collapse").trigger("collapsed.pushMenu") : $("body").hasClass("sidebar-open") ? $("body").removeClass("sidebar-open").removeClass("sidebar-collapse").trigger("collapsed.pushMenu") : $("body").addClass("sidebar-open").trigger("expanded.pushMenu")
            }), $(".content-wrapper").click(function() {
                $(window).width() <= b.sm - 1 && $("body").hasClass("sidebar-open") && $("body").removeClass("sidebar-open")
            }), ($.AdminLTE.options.sidebarExpandOnHover || $("body").hasClass("fixed") && $("body").hasClass("sidebar-mini")) && this.expandOnHover()
        },
        expandOnHover: function() {
            var a = this,
                b = $.AdminLTE.options.screenSizes.sm - 1;
            $(".main-sidebar").hover(function() {
                $("body").hasClass("sidebar-mini") && $("body").hasClass("sidebar-collapse") && $(window).width() > b && a.expand()
            }, function() {
                $("body").hasClass("sidebar-mini") && $("body").hasClass("sidebar-expanded-on-hover") && $(window).width() > b && a.collapse()
            })
        },
        expand: function() {
            $("body").removeClass("sidebar-collapse").addClass("sidebar-expanded-on-hover")
        },
        collapse: function() {
            $("body").hasClass("sidebar-expanded-on-hover") && $("body").removeClass("sidebar-expanded-on-hover").addClass("sidebar-collapse")
        }
    }, 
    $.AdminLTE.tree = function(a) {
        var b = this,
            c = $.AdminLTE.options.animationSpeed;
        $(document).off("click", a + " li a").on("click", a + " li a", function(a) {
            var d = $(this),
                e = d.next();
            if (e.is(".treeview-menu") && e.is(":visible") && !$("body").hasClass("sidebar-collapse")) e.slideUp(c, function() {
                e.removeClass("menu-open")
            }), e.parent("li").removeClass("active");
            else if (e.is(".treeview-menu") && !e.is(":visible")) {
                var f = d.parents("ul").first(),
                    g = f.find("ul:visible").slideUp(c);
                g.removeClass("menu-open");
                var h = d.parent("li");
                e.slideDown(c, function() {
                    e.addClass("menu-open"), f.find("li.active").removeClass("active"), h.addClass("active"), b.layout.fix()
                })
            }
            e.is(".treeview-menu") && a.preventDefault()
        })
    },  
    $.AdminLTE.controlSidebar = { 
        activate: function() {
            var a = this,
                b = $.AdminLTE.options.controlSidebarOptions,
                c = $(b.selector),
                d = $(b.toggleBtnSelector);
            d.on("click", function(d) {
                d.preventDefault(), c.hasClass("control-sidebar-open") || $("body").hasClass("control-sidebar-open") ? a.close(c, b.slide) : a.open(c, b.slide)
            });
            var e = $(".control-sidebar-bg");
            a._fix(e), $("body").hasClass("fixed") ? a._fixForFixed(c) : $(".content-wrapper, .right-side").height() < c.height() && a._fixForContent(c)
        },
        open: function(a, b) {
            // b ? a.addClass("control-sidebar-open") : $("body").addClass("control-sidebar-open")
        },
        close: function(a, b) {
            // b ? a.removeClass("control-sidebar-open") : $("body").removeClass("control-sidebar-open")
        },
        _fix: function(a) {
            var b = this;
            if ($("body").hasClass("layout-boxed")) {
                if (a.css("position", "absolute"), a.height($(".wrapper").height()), b.hasBindedResize) return;
                $(window).resize(function() {
                    b._fix(a)
                }), b.hasBindedResize = !0
            } else a.css({
                position: "fixed",
                height: "auto"
            })
        }, 
        _fixForFixed: function(a) {
            a.css({
                position: "fixed",
                "max-height": "100%",
                overflow: "auto",
                "padding-bottom": "50px"
            })
        }
    }
}
if ("undefined" == typeof jQuery) throw new Error("AdminLTE requires jQuery");

$.AdminLTE = {}, $.AdminLTE.options = {
        navbarMenuSlimscroll: !0,
        navbarMenuSlimscrollWidth: "3px",
        navbarMenuHeight: "200px",
        animationSpeed: 500,
        sidebarToggleSelector: "[data-toggle='offcanvas']",
        sidebarPushMenu: !0,
        sidebarSlimScroll: !0,
        sidebarExpandOnHover: !1,
        enableBoxRefresh: !0,
        enableBSToppltip: !0,
        BSTooltipSelector: "[data-toggle='tooltip']",
        enableFastclick: !1,
        enableControlSidebar: !0,
        controlSidebarOptions: {
            toggleBtnSelector: "[data-toggle='control-sidebar']",
            selector: ".control-sidebar",
            slide: !0
        },
        //enableBoxWidget: !0,
        screenSizes: {
            xs: 480,
            sm: 768,
            md: 992,
            lg: 1200
        }
    }, 

    $(function() {
        "use strict";
        $("body").removeClass("hold-transition"), "undefined" != typeof AdminLTEOptions && $.extend(!0, $.AdminLTE.options, AdminLTEOptions);
        var a = $.AdminLTE.options;
        _init(), $.AdminLTE.layout.activate(), $.AdminLTE.tree(".sidebar"), a.enableControlSidebar && $.AdminLTE.controlSidebar.activate(), a.navbarMenuSlimscroll && "undefined" != typeof $.fn.slimscroll && $(".navbar .menu").slimscroll({
            height: a.navbarMenuHeight,
            alwaysVisible: !1,
            size: a.navbarMenuSlimscrollWidth
        }).css("width", "100%"), a.sidebarPushMenu && $.AdminLTE.pushMenu.activate(a.sidebarToggleSelector), a.enableBSToppltip && $("body").tooltip({
            selector: a.BSTooltipSelector
        }) 
    }); 
	
})(jQuery.noConflict());


(function ($) { 
$("#user_btn").click(function(){
  $(".user-panel").slideToggle("fast"); 
});   
})(jQuery.noConflict());
/*
 *
 *   INSPINIA - Responsive Admin Theme
 *   version 2.6
 *
 */


$(document).ready(function () {

    $('#filter-form').find('input').change(function(){
        $('#filter-form').submit();
    });

    $('.select2').select2();

    var $reportRange = $('#reportrange');
    var created_from = $reportRange.find('input[name=created_from]').val();
    var created_to = $reportRange.find('input[name=created_to]').val();
    var group = $reportRange.parent().parent().find('input[type=radio]:checked').val();
    var shortDateFormat = 'YYYY-MM-DD';
    var longDateFormat = 'YYYY-MM-DD HH:mm:ss';
    var startOfDay = function() {
        return moment().startOf('day');
    };
    var endOfDay = function() {
        return moment().endOf('day');
    };

    $reportRange.find('span').html(moment(created_from).format('MMMM D, YYYY') + ' - ' + moment(created_to).format('MMMM D, YYYY'));

    $reportRange.daterangepicker({
        startDate: moment(created_from).format('MM/DD/YYYY HH:mm:ss'),
        endDate: moment(created_to).format('MM/DD/YYYY HH:mm:ss'),
        format: 'MM/DD/YYYY HH:mm:ss',
        timePicker: true,
        timePicker24Hour: true,
        timePickerIncrement: 1,
        alwaysShowCalendars: true,
        ranges: {
            'Today': [startOfDay(), endOfDay()],
            'Yesterday': [
                startOfDay().subtract(1, 'days'),
                endOfDay().subtract(1, 'days')
            ],
            'Last 7 Days': [
                startOfDay().subtract(7, 'days'),
                endOfDay().subtract(1, 'days')
            ],
            'Last 30,5 Days': [
                startOfDay().subtract(30.5 * 24, 'hours'),
                endOfDay().subtract(1, 'days')
            ],
            'This Month': [
                moment().startOf('month'),
                moment().endOf('month')
            ],
            'Last Month': [
                moment().subtract(1, 'month').startOf('month'),
                moment().subtract(1, 'month').endOf('month')
            ],
            'This Year': [
                moment().startOf('year'),
                endOfDay().subtract(1, 'days')
            ],
            'Last Year': [
                moment().subtract(1, 'year').startOf('year'),
                moment().subtract(1, 'year').endOf('year')
            ],
            'Last 3 Months': [
                startOfDay().subtract(3 * 30.5 * 24, 'hours'),
                endOfDay().subtract(1, 'days')
            ],
            'Last 6 Months': [
                startOfDay().subtract(6 * 30.5, 'days'),
                endOfDay().subtract(1, 'days')
            ],
            'Last 12 Months': [
                startOfDay().subtract(12 * 30.5, 'days'),
                endOfDay().subtract(1, 'days')
            ],
            'Since 2017': [
                moment('2017-01-01'),
                endOfDay().subtract(1, 'days')
            ]
        },
        opens: $reportRange.data('opens'),
        drops: 'down',
        buttonClasses: ['btn', 'btn-sm'],
        applyClass: 'btn-primary',
        cancelClass: 'btn-default',
        separator: ' to ',
        locale: {
            applyLabel: 'Submit',
            cancelLabel: 'Cancel',
            fromLabel: 'From',
            toLabel: 'To',
            customRangeLabel: 'Custom',
            daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr','Sa'],
            monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
            firstDay: 1
        }
    }, function(start, end) {
        datePickerSubmit(start, end);
    });

    $('#prev-btn, #next-btn').on('click', function (event ) {
        $(event.target).attr("disabled", true);
        var from = moment(created_from),
            to = moment(created_to),
            period = to.diff(from, 'days'),
            newTo, newFrom;

        if ($(event.target).data('period') < 0) {
            newTo = from.clone().subtract(1, 'days');
            newFrom = newTo.clone().subtract(period, 'days');
        } else {
            newFrom = to.clone().add(1, 'days');
            newTo = newFrom.clone().add(period, 'days');
        }

        datePickerSubmit(newFrom, newTo);
    });

    var datePickerSubmit = function(start, end) {
        var $form = $('#reportrange');
        var $fromInput = $form.find('input[name=created_from]');
        var $toInput = $form.find('input[name=created_to]');
        var startDateFormat = start.format('HH:mm:ss') === '00:00:00' ? shortDateFormat : longDateFormat;

        $fromInput.val(start.format(startDateFormat));
        $toInput.val(end.format(shortDateFormat));
        $form.find('span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        $('#filter-form').submit();
    };

    // Add body-small class if window less than 768px
    if ($(this).width() < 769) {
        $('body').addClass('body-small')
    } else {
        $('body').removeClass('body-small')
    }

    // MetsiMenu
    $('#side-menu').metisMenu();

    // Collapse ibox function
    $('.collapse-link').on('click', function () {
        var ibox = $(this).closest('div.ibox');
        var button = $(this).find('i');
        var content = ibox.find('div.ibox-content');
        content.slideToggle(200);
        button.toggleClass('fa-chevron-up').toggleClass('fa-chevron-down');
        ibox.toggleClass('').toggleClass('border-bottom');
        setTimeout(function () {
            ibox.resize();
            ibox.find('[id^=map-]').resize();
        }, 50);
    });

    // Close ibox function
    $('.close-link').on('click', function () {
        var content = $(this).closest('div.ibox');
        content.remove();
    });

    // Fullscreen ibox function
    $('.fullscreen-link').on('click', function () {
        var ibox = $(this).closest('div.ibox');
        var button = $(this).find('i');
        $('body').toggleClass('fullscreen-ibox-mode');
        button.toggleClass('fa-expand').toggleClass('fa-compress');
        ibox.toggleClass('fullscreen');
        setTimeout(function () {
            $(window).trigger('resize');
        }, 100);
    });

    // Close menu in canvas mode
    $('.close-canvas-menu').on('click', function () {
        $("body").toggleClass("mini-navbar");
        SmoothlyMenu();
    });

    // Run menu of canvas
    $('body.canvas-menu .sidebar-collapse').slimScroll({
        height: '100%',
        railOpacity: 0.9
    });

    // Open close right sidebar
    $('.right-sidebar-toggle').on('click', function () {
        $('#right-sidebar').toggleClass('sidebar-open');
    });

    // Initialize slimscroll for right sidebar
    $('.sidebar-container').slimScroll({
        height: '100%',
        railOpacity: 0.4,
        wheelStep: 10
    });

    // Open close small chat
    $('.open-small-chat').on('click', function () {
        $(this).children().toggleClass('fa-comments').toggleClass('fa-remove');
        $('.small-chat-box').toggleClass('active');
    });

    // Initialize slimscroll for small chat
    $('.small-chat-box .content').slimScroll({
        height: '234px',
        railOpacity: 0.4
    });

    // Small todo handler
    $('.check-link').on('click', function () {
        var button = $(this).find('i');
        var label = $(this).next('span');
        button.toggleClass('fa-check-square').toggleClass('fa-square-o');
        label.toggleClass('todo-completed');
        return false;
    });


    // Minimalize menu
    $('.navbar-minimalize').on('click', function () {
        $("body").toggleClass("mini-navbar");
        SmoothlyMenu();

    });

    // Tooltips demo
    $('.tooltip-demo').tooltip({
        selector: "[data-toggle=tooltip]",
        container: "body"
    });


    // Full height of sidebar
    function fix_height() {
        var heightWithoutNavbar = $("body > #wrapper").height() - 61;
        $(".sidebard-panel").css("min-height", heightWithoutNavbar + "px");

        var navbarHeigh = $('nav.navbar-default').height();
        var wrapperHeigh = $('#page-wrapper').height();

        if (navbarHeigh > wrapperHeigh) {
            $('#page-wrapper').css("min-height", navbarHeigh + "px");
        }

        if (navbarHeigh < wrapperHeigh) {
            $('#page-wrapper').css("min-height", $(window).height() + "px");
        }

        if ($('body').hasClass('fixed-nav')) {
            if (navbarHeigh > wrapperHeigh) {
                $('#page-wrapper').css("min-height", navbarHeigh + "px");
            } else {
                $('#page-wrapper').css("min-height", $(window).height() - 60 + "px");
            }
        }

    }

    fix_height();

    // Fixed Sidebar
    $(window).bind("load", function () {
        if ($("body").hasClass('fixed-sidebar')) {
            $('.sidebar-collapse').slimScroll({
                height: '100%',
                railOpacity: 0.9
            });
        }
    });

    // Move right sidebar top after scroll
    $(window).scroll(function () {
        if ($(window).scrollTop() > 0 && !$('body').hasClass('fixed-nav')) {
            $('#right-sidebar').addClass('sidebar-top');
        } else {
            $('#right-sidebar').removeClass('sidebar-top');
        }
    });

    $(window).bind("load resize scroll", function () {
        if (!$("body").hasClass('body-small')) {
            fix_height();
        }
    });

    $("[data-toggle=popover]")
        .popover();

    // Add slimscroll to element
    $('.full-height-scroll').slimscroll({
        height: '100%'
    });

    var url_string = window.location.href;
    var url = new URL(url_string);
    var compare_created_from = url.searchParams.get("c_created_from");
    var compare_created_to = url.searchParams.get("c_created_to");
    var datePeriod = moment(created_to).diff(moment(created_from), 'days');

    if (compare_created_from == null) {
        compare_created_from = moment(created_from).subtract(datePeriod+1, 'days').format('YYYY-MM-DD');
    }
    if (compare_created_to == null) {
        compare_created_to = moment(created_to).subtract(datePeriod+1, 'days').format('YYYY-MM-DD');
    }

    $('div.comparable-graph div.report-range span').html(moment(compare_created_from).format('MMMM D, YYYY') + ' - ' + moment(compare_created_to).format('MMMM D, YYYY'));
    $('button.compare').parent().parent().find('input[name=c_created_from]').val(compare_created_from);
    $('button.compare').parent().parent().find('input[name=c_created_to]').val(compare_created_to);

    $('button.compare').parent().parent().append('<input type="hidden" name="created_from" value="' + created_from + '" />');
    $('button.compare').parent().parent().append('<input type="hidden" name="created_to" value="' + created_to + '" />');
    $('button.compare').parent().parent().append('<input type="hidden" name="group" value="' + group + '" />');


    $('button.compare').click(function(e) {
        if ($(this).hasClass('active')) {
            $(this).parent().parent().find('.report-range').css('visibility', 'hidden');
            $(this).removeClass('active');
            $(this).parent().parent().find('input[name^=c_created]').attr('disabled', 'disabled');
            $(this).parent().parent().submit();
        } else {
            $(this).parent().parent().find('input[name^=c_created]').removeAttr('disabled');
            $(this).parent().parent().find('.report-range').css('visibility', 'visible');
            $(this).addClass('active');
            $(this).parent().parent().submit();
        }
    });

    $('div.comparable-graph div.report-range').daterangepicker({
        startDate: moment(compare_created_from).format('MM/DD/YYYY'),
        endDate: moment(compare_created_to).format('MM/DD/YYYY'),
        format: 'MM/DD/YYYY',
        alwaysShowCalendars: true,
        ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        opens: 'left',
        drops: 'down',
        buttonClasses: ['btn', 'btn-sm'],
        applyClass: 'btn-primary',
        cancelClass: 'btn-default',
        separator: ' to ',
        locale: {
            applyLabel: 'Submit',
            cancelLabel: 'Cancel',
            fromLabel: 'From',
            toLabel: 'To',
            customRangeLabel: 'Custom',
            daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr','Sa'],
            monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
            firstDay: 1
        }
    }, function(start, end, label) {
        $('div.comparable-graph div.report-range span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        $('div.comparable-graph').find('input[name=c_created_from]').val(start.format('YYYY-MM-DD'));
        $('div.comparable-graph').find('input[name=c_created_to]').val(end.format('YYYY-MM-DD'));
        $('div.comparable-graph').find('form').submit();
    });
});


// Minimalize menu when screen is less than 768px
$(window).bind("resize", function () {
    if ($(this).width() < 769) {
        $('body').addClass('body-small')
    } else {
        $('body').removeClass('body-small')
    }
});

// Local Storage functions
// Set proper body class and plugins based on user configuration
$(document).ready(function () {
    if (localStorageSupport()) {

        var collapse = localStorage.getItem("collapse_menu");
        var fixedsidebar = localStorage.getItem("fixedsidebar");
        var fixednavbar = localStorage.getItem("fixednavbar");
        var boxedlayout = localStorage.getItem("boxedlayout");
        var fixedfooter = localStorage.getItem("fixedfooter");

        var body = $('body');

        if (fixedsidebar == 'on') {
            body.addClass('fixed-sidebar');
            $('.sidebar-collapse').slimScroll({
                height: '100%',
                railOpacity: 0.9
            });
        }

        if (collapse == 'on') {
            if (body.hasClass('fixed-sidebar')) {
                if (!body.hasClass('body-small')) {
                    body.addClass('mini-navbar');
                }
            } else {
                if (!body.hasClass('body-small')) {
                    body.addClass('mini-navbar');
                }

            }
        }

        if (fixednavbar == 'on') {
            $(".navbar-static-top").removeClass('navbar-static-top').addClass('navbar-fixed-top');
            body.addClass('fixed-nav');
        }

        if (boxedlayout == 'on') {
            body.addClass('boxed-layout');
        }

        if (fixedfooter == 'on') {
            $(".footer").addClass('fixed');
        }
    }
});

// check if browser support HTML5 local storage
function localStorageSupport() {
    return (('localStorage' in window) && window['localStorage'] !== null)
}

// For demo purpose - animation css script
function animationHover(element, animation) {
    element = $(element);
    element.hover(
        function () {
            element.addClass('animated ' + animation);
        },
        function () {
            //wait for animation to finish before removing classes
            window.setTimeout(function () {
                element.removeClass('animated ' + animation);
            }, 2000);
        });
}

function SmoothlyMenu() {
    if (!$('body').hasClass('mini-navbar') || $('body').hasClass('body-small')) {
        // Hide menu in order to smoothly turn on when maximize menu
        $('#side-menu').hide();
        // For smoothly turn on menu
        setTimeout(
            function () {
                $('#side-menu').fadeIn(400);
            }, 200);
    } else if ($('body').hasClass('fixed-sidebar')) {
        $('#side-menu').hide();
        setTimeout(
            function () {
                $('#side-menu').fadeIn(400);
            }, 100);
    } else {
        // Remove all inline style from jquery fadeIn function to reset menu state
        $('#side-menu').removeAttr('style');
    }
}

// Dragable panels
function WinMove() {
    var element = "[class*=col]";
    var handle = ".ibox-title";
    var connect = "[class*=col]";
    $(element).sortable(
        {
            handle: handle,
            connectWith: connect,
            tolerance: 'pointer',
            forcePlaceholderSize: true,
            opacity: 0.8
        })
        .disableSelection();
}

Number.prototype.formatMoney = function(c, d, t){
    var n = this,
        c = isNaN(c = Math.abs(c)) ? 0 : c,
        d = d == undefined ? "." : d,
        t = t == undefined ? " " : t,
        s = n < 0 ? "-" : "",
        i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
        j = (j = i.length) > 3 ? j % 3 : 0;
    return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
};


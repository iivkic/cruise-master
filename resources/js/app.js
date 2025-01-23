require('./bootstrap');
import $ from 'jquery';

window.$ = window.jQuery = $;
require('./monthpicker');
require('./datepicker');
require('./jssocials');
import 'slick-carousel';
require("jquery-parallax.js");

import "jquery-ui-slider/jquery-ui";
import "jquery-ui-touch-punch";
import "selectric";
require("./modernizr");
import toastr from "toastr/toastr";
import moment from 'moment';

window.moment = moment;
import lightbox from "lightbox2";

window.lightbox = lightbox;
import "lightbox2/dist/css/lightbox.css";

toastr.options = {
    "closeButton": true,
    "closeHtml": '<svg xmlns="http://www.w3.org/2000/svg" width="23.335" height="23.335" viewBox="0 0 23.335 23.335">\n' +
        '    <g transform="translate(-260.333 -24.333)">\n' +
        '        <line class="icon_stroke" fill="none" stroke="white" x2="32" transform="translate(260.686 24.686) rotate(45)"/>\n' +
        '        <line class="icon_stroke" fill="none" stroke="white" x2="32" transform="translate(260.687 47.314) rotate(-45)"/>\n' +
        '    </g>\n' +
        '</svg>',
    "debug": false,
    "newestOnTop": false,
    "progressBar": false,
    "positionClass": "toast-top-center",
    "preventDuplicates": false,
    "onclick": null,
    "showDuration": "300",
    "hideDuration": "1000",
    "timeOut": "5000",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "slideDown",
    "hideMethod": "slideUp"
}

const throttle = (func, limit) => {
    let lastFunc
    let lastRan
    return function () {
        const context = this
        const args = arguments
        if (!lastRan) {
            func.apply(context, args)
            lastRan = Date.now()
        } else {
            clearTimeout(lastFunc)
            lastFunc = setTimeout(function () {
                if ((Date.now() - lastRan) >= limit) {
                    func.apply(context, args)
                    lastRan = Date.now()
                }
            }, limit - (Date.now() - lastRan))
        }
    }
};

function serializeForm($form = false, $recaptcha = false) {
    let data = {}
    if($form == false){
        $form = $('form input, form select, form textarea');
    }else{
        $form = $form.find('input, textarea, select');

    }
    $form.each(function () {
        if ($(this).attr('type') == "checkbox") {
            if ($(this).is(':checked')) data[$(this).attr('name')] = $(this).val();
        }else if($(this).attr('type') == "radio"){
            if ($(this).is(':checked')) data[$(this).attr('name')] = $(this).val();
        } else if ($(this).is('select')) {
            data[$(this).attr('name')] = $(this).closest('.selectric-hide-select').siblings('.selectric-items').find('.selected').text();
        } else if($(this).is('.selectric-input')){

        } else{
            data[$(this).attr('name')] = $(this).val();
        }
    });

    try{
    if($recaptcha != false){
        data['g-recaptcha-response'] =  getReCaptchaV3Response($recaptcha);
    }else{
        data['g-recaptcha-response'] =  getReCaptchaV3Response('contact_recaptcha');
    }
    }
    catch {
        console.log("No recaptcha was submitted.");
    }


    return data;
}

function debounce(func, wait, immediate) {
    var timeout;
    return function () {
        var context = this, args = arguments;
        var later = function () {
            timeout = null;
            if (!immediate) func.apply(context, args);
        };
        var callNow = immediate && !timeout;
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
        if (callNow) func.apply(context, args);
    };
};

function inputErrorHandler() {
    $("input, textarea").on('keyup change', function () {
        let error = $(this).siblings('.error-message');
        if(error.length > 0) {
            if ($(this).val() != "") {
                error.removeClass('error-show');
                $(this).removeClass('error');
            } else{
                error.addClass('error-show');
                $(this).addClass('error');
            }
        }else{
            if ($(this).val() != "") {
                $(this).removeClass('error');
            }
        }
    });
}

var pos;

let news_id = '';
if($(window).width() < 752){
    news_id = $('#newsletter_form');
}else if($(window).width() >=752 && $(window).width() <1200){
    news_id = $('#newsletter_form_m');
}else{
    news_id = $('#newsletter_form_l');
}

if(location.pathname == "/"){
    news_id = $('#newsletter_form');
}

$(window).scroll(function (e) {
    var $el = $('.navigation-wrapper');
    var isPositionFixed = ($el.hasClass("nav-fixed"));
    // if (UI.page!=="home" || $(this).scrollTop()>$el.outerHeight()) {
    //     $el.addClass("nav-fixed");
    // }
    // else {
    //     $el.removeClass("nav-fixed");
    // }
});

window.toggleCovid=function(){
    $("#covid").toggleClass('hide');
    $("#covid").hover(
        function () {
            $('body').css('overflow','hidden');
        },
        function () {
            $('body').css('overflow','auto');
        }
    );
}

window.UI = {
    page: "home",
    date: "",
    filters: [],
    applied_filters: [],
    temp_filters: [],
    previous_filters: [],
    source: axios.CancelToken.source(),
    openSidebar: function () {
        $("#sidebar, body").addClass("active");
        $('#tawkchat-container').hide();
    },
    closeSidebar: function () {
        $(".submenu,.sidebar, body").removeClass("active");
        $('#tawkchat-container').show();
    },
    openSubmenu: function () {
        $(".sidebar, body").addClass("active");
        $('#tawkchat-container').hide();
    },
    closeSubmenu: function () {
        $(".submenu.active").removeClass("active")
        $('#tawkchat-container').show();
    },

    emptyWishlist: function () {
        var quantity = $(".wishlist-counter");
        $.ajax({
            url: route("home.remove"), type: "GET", data: {index: -1}, success: function (data, response) {
                quantity.html(0);
                if (quantity.text() == 0) {
                    $(".wishlist-container").addClass("disabled")
                } else {
                    $(".wishlist-container").removeClass("disabled")
                }
                $(".wishlist").html(data);
            }
        });
    },
    setCurrency: function (el, currency) {
        var val = parseFloat($(el).attr("data-value"));
        var cur = $(el).attr("data-currency");
        $("span[data-hrk]").each(function () {
            var value = ($(this).attr("data-hrk") * 1 * val).toFixed().toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") + " " + cur;
            $(this).html(value)
        })
        $(".currency-value").html(currency);
        if ($(".submenu.active").length)
            $(".submenu.active .closebtn").trigger("click");
        else
            $(".nav-item.active").trigger("click");
        $.ajax({url: route("home.set"), type: "GET", data: {currency: currency}});
        $(".dropdown-content:visible").css('display', 'none');
        $(".dropdown-trigger.manual").removeClass("active");
        setTimeout(function () {
            $(".dropdown-content").removeAttr('style');
        }, 200);
    },
    clearModalFilters: function (s) {
        $("." + s).each(function () {
            $(this).find("input").prop("checked", false);
        })
    },
    toggleWishlist: function (i, name) {
        var wishlist = $('.wishlist-text');
        if ($(".wishlist-container").find("#wishlist_" + i).length) {
            UI.removeFromWishlist(i);
            $('.add-to-wishlist svg').removeClass('active');
            wishlist.text('Add to wishlist');
            toastr.error(name+' has been removed from the wishlist!');
        } else {
            UI.addToWishlist(i)
            $('.add-to-wishlist svg').addClass('active');
            wishlist.text('Remove from wishlist');
            toastr.success(name+' has been added to the wishlist!');
        }
    },

    removeFromWishlist: function (i, name = 'Cruise') {
        var wishlist = $('.wishlist-text');
        $.ajax({
            url: route("home.remove"), type: "GET", data: {index: i}, success: function (data, response) {
                $(".wishlist").html(data);
                var quantity = $(".wishlist-counter");
                quantity.html(quantity.html() * 1 - 1);
                if (quantity.text() == 0) {
                    $(".wishlist-container").addClass("disabled")
                }
                if($(".wishlist_"+i).length){
                    $('.add-to-wishlist svg').removeClass('active');
                    wishlist.text('Add to wishlist');
                    toastr.error(name+' has been removed from the wishlist!');
                }
            }
        });
    },

    expandDetails:function(id){
      $('#'+id).toggleClass('active');
    },

    addToWishlist: function (i) {
        var quantity = $(".wishlist-counter");
        $.ajax({
            url: route("home.add"), type: "GET", data: {index: i}, success: function (data, response) {
                $(".wishlist").html(data);
                quantity.html(quantity.html() * 1 + 1);
                $(".wishlist-container").removeClass("disabled")
            }
        });
    },
    cruisesInit: function (initFilters) {
        UI.page = "cruises";

        $(".view-config").on("click", function () {
            if($(window).width() < 768) {
                $(".results").addClass("loading");
            }
            if ($(this).parent().hasClass("active")) return;
            let detailed;
            $(".view-config").parent().removeClass("active")
            $(this).parent().addClass("active")
            if ($(this).hasClass("card-view")) {
                detailed = 0;
                $(".card").removeClass("detailed")
                $('.card-content .discount:not(.hide)').removeClass('hide-xl');
                $('.card-content .discount.hide').removeClass('show-xl');
                $('.card-content .prices:not(.hide)').removeClass('hide-xl');
                $('.card-content .prices.hide').removeClass('show-xl');
            } else {
                $(".card").addClass("detailed");
                $('.card-content .discount:not(.hide)').addClass('hide-xl');
                $('.card-content .discount.hide').addClass('show-xl');
                $('.card-content .prices:not(.hide)').addClass('hide-xl');
                $('.card-content .prices.hide').addClass('show-xl');
                detailed = 1;

            }
            $.ajax({
                url: route("home.set_view"),
                type: "GET",
                data: {detailed: detailed},
                success: function (data, response) {
                    // $(".wishlist-container").html(data);
                }
            });
            if($(window).width() < 768) {
                setTimeout(function () {
                    $(".results").removeClass("loading");
                }, 500);
            }
        });


        $(function () {
            window.onpopstate = function (event) {
                if (event.state && event.state.filters) {
                    UI.resetToFilters(JSON.parse(event.state.filters));
                    UI.applyFilters(true);
                } else {
                    UI.resetFilters(true)
                }

            };
            // var anim;
            //
            // anim = lottie.loadAnimation({
            //     container: $("#lottie")[0],
            //     renderer: 'svg',
            //     loop: true,
            //     autoplay: true,
            //     rendererSettings: {
            //         progressiveLoad: false,
            //     },
            //     path: '/assets/ch-loading.json'
            // });
            var range_element = $("#price-range");
            range_element.slider({
                range: true,
                min: range_element.data().min,
                max: range_element.data().max,
                step: range_element.data().step,
                values: [range_element.data().min, range_element.data().max],
                slide: function (event, ui) {
                    $("#price_from").val(ui.values[0])
                    $("#price_to").val(ui.values[1])
                    range_element.attr("data-from", ui.values[0]);
                    range_element.data("from", ui.values[0]);
                    range_element.attr("data-hrk-from", ui.values[0] * range_element.data().currency_value);
                    range_element.data("hrk-from", ui.values[0] * range_element.data().currency_value);
                    range_element.attr("data-hrk-to", ui.values[1] * range_element.data().currency_value);
                    range_element.data("hrk-to", ui.values[1] * range_element.data().currency_value);
                    range_element.attr("data-to", ui.values[1]);
                    range_element.data("to", ui.values[1]);
                    $(".price_from").text(ui.values[0] + " " + range_element.data().currency)
                    $(".price_to").text(ui.values[1] + " " + range_element.data().currency)
                },
                change: function (event, ui) {
                    $("#price_from").val(ui.values[0])
                    $("#price_to").val(ui.values[1])
                    range_element.attr("data-from", ui.values[0]);
                    range_element.data("from", ui.values[0]);
                    range_element.attr("data-hrk-from", ui.values[0] * range_element.data().currency_value);
                    range_element.data("hrk-from", ui.values[0] * range_element.data().currency_value);
                    range_element.attr("data-hrk-to", ui.values[1] * range_element.data().currency_value);
                    range_element.data("hrk-to", ui.values[1] * range_element.data().currency_value);
                    range_element.attr("data-to", ui.values[1]);
                    range_element.data("to", ui.values[1]);
                    $(".price_from").text(ui.values[0] + " " + range_element.data().currency)
                    $(".price_to").text(ui.values[1] + " " + range_element.data().currency)

                }
            });
            $("#price_from").val(range_element.slider("values", 0))
            $(".price_from").text(range_element.slider("values", 0) + " " + range_element.data().currency)
            $("#price_to").val(range_element.slider("values", 1))
            $(".price_to").text(range_element.slider("values", 1) + " " + range_element.data().currency)
            UI.initFiltersWatchers();
            $(".box.expendable > label").on("click", function () {
                $(this).parent().toggleClass("active");
            })
            UI.resetToInitFilters(initFilters.filters);
           // UI.applyFilters(true);
        });

        UI.filters = [];
        UI.date = initFilters.month;
        initFilters.filters.forEach(filter => {
            if (filter.name == "month") UI.date = filter.value;
            else {
                UI.filters.push({
                    name: filter.name,
                    selector: filter.selector,
                    type: filter.type,
                    confirmation: filter.confirmation,
                    expendable: filter.expendable,
                    value: filter.value
                });
            }
        });

        let height = 0;
        $(".card").each(function () {
            if ($(this).find('.left').height() > height) {
                height = $(this).find('.left').height();
            }
        });
        $(".card").find('.left').each(function () {
            $(this).height(height);
        })

        let helpModal = $('.help-modal'),
            helpSection = $('.help-section'),
            helpModalpos = helpModal.offset().top,
            helpSectionpos = helpSection.offset().top;
        window.addEventListener("scroll", event => {
            if($(window).scrollTop() > helpModalpos-132){
                if(!helpModal.hasClass('active')) helpModal.addClass('active');
            }else if ($(window).scrollTop() < helpModalpos){
                if(helpModal.hasClass('active')) helpModal.removeClass('active');
            }

            if(helpModal.offset().top+helpModal.height() > helpSectionpos - $(window).height() + 110){
                if(!helpModal.hasClass('hide')){
                    helpModal.css('opacity', 0);
                    setTimeout(function () {
                        helpModal.addClass('hide');
                    }, 300)
                }
            }else{
                if(helpModal.hasClass('hide')){
                    helpModal.removeClass('hide');
                    helpModal.css('opacity', 1);
                }
            }
        });

        let lmdBox = $('.last-minute-hover-box'),
            closeBtn = $('.close-hover-box');

        closeBtn.on('click', function () {
            lmdBox.fadeOut(400);
        });
    },
    showFilters: function (e) {

        UI.applied_filters = JSON.parse(UI.saveCurrentFilters());

        var el = $("#" + e);
        $("body").addClass("active")
        if ($(window).innerWidth() < 620) {
            el.toggleClass("active")
        } else el.toggleClass("active").animate({opacity: 1}, 400, function () {
        });
    },
    hideFilters: function () {
        UI.resetToFilters(UI.applied_filters);
        UI.closeFilters();
    },
    closeFilters: function (apply = false) {
        var el = $(".modal.active");
        if ($(window).innerWidth() < 620) {
            $("body").removeClass("active modal-active")
            el.removeClass("active")
        } else if (apply) {
            $("body").removeClass("active modal-active")
            el.removeClass("active")
        } else {
            $("body").removeClass("active modal-active")
            el.removeClass("active")

        }
    },
    lastMinuteInit: function(){
        UI.page = "last minute deals";

        $(".view-config").on("click", function () {
            if($(window).width() < 768) {
                $(".results").addClass("loading");
            }
            if ($(this).parent().hasClass("active")) return;
            let detailed;
            $(".view-config").parent().removeClass("active")
            $(this).parent().addClass("active")
            if ($(this).hasClass("card-view")) {
                detailed = 0;
                $(".card").removeClass("detailed")
                $('.card-content .discount:not(.hide)').removeClass('hide-xl');
                $('.card-content .discount.hide').removeClass('show-xl');
                $('.card-content .prices:not(.hide)').removeClass('hide-xl');
                $('.card-content .prices.hide').removeClass('show-xl');
            } else {
                $(".card").addClass("detailed");
                $('.card-content .discount:not(.hide)').addClass('hide-xl');
                $('.card-content .discount.hide').addClass('show-xl');
                $('.card-content .prices:not(.hide)').addClass('hide-xl');
                $('.card-content .prices.hide').addClass('show-xl');
                detailed = 1;

            }
            $.ajax({
                url: route("home.set_view"),
                type: "GET",
                data: {detailed: detailed},
                success: function (data, response) {
                    // $(".wishlist-container").html(data);
                }
            });
            if($(window).width() < 768) {
                setTimeout(function () {
                    $(".results").removeClass("loading");
                }, 500);
            }
        });

        let height = 0;
        $(".card").each(function () {
            if ($(this).find('.left').height() > height) {
                height = $(this).find('.left').height();
            }
        });
        $(".card").find('.left').each(function () {
            $(this).height(height);
        })
    },

    cruiseAndStayInit: function(){
        UI.page = "cruise and stay";

        $(".view-config").on("click", function () {
            if($(window).width() < 768) {
                $(".results").addClass("loading");
            }
            if ($(this).parent().hasClass("active")) return;
            let detailed;
            $(".view-config").parent().removeClass("active")
            $(this).parent().addClass("active")
            if ($(this).hasClass("card-view")) {
                detailed = 0;
                $(".card").removeClass("detailed")
                $('.card-content .discount:not(.hide)').removeClass('hide-xl');
                $('.card-content .discount.hide').removeClass('show-xl');
                $('.card-content .prices:not(.hide)').removeClass('hide-xl');
                $('.card-content .prices.hide').removeClass('show-xl');
            } else {
                $(".card").addClass("detailed");
                $('.card-content .discount:not(.hide)').addClass('hide-xl');
                $('.card-content .discount.hide').addClass('show-xl');
                $('.card-content .prices:not(.hide)').addClass('hide-xl');
                $('.card-content .prices.hide').addClass('show-xl');
                detailed = 1;

            }
            $.ajax({
                url: route("home.set_view"),
                type: "GET",
                data: {detailed: detailed},
                success: function (data, response) {
                    // $(".wishlist-container").html(data);
                }
            });
            if($(window).width() < 768) {
                setTimeout(function () {
                    $(".results").removeClass("loading");
                }, 500);
            }
        });

        let height = 0;
        $(".card").each(function () {
            if ($(this).find('.left').height() > height) {
                height = $(this).find('.left').height();
            }
        });
        $(".card").find('.left').each(function () {
            $(this).height(height);
        })
    },

    initFiltersWatchers: function () {
        UI.filters.forEach(filter => {
            $(filter.selector).on("change slidestop", function () {
                if (!filter.confirmation && $(window).innerWidth() >= 1200) {
                    UI.applyFilters()
                }
            })
        })
    },
    reset_applied_filter: function (name, value = false) {
        UI.filters.forEach(filter => {
            if (filter.name == name) {
                switch (filter.type) {
                    case "range":
                        $(filter.selector).slider("option", "values", [$(filter.selector).data().min, $(filter.selector).data().max])
                        break;
                    case "checkbox":
                        $(filter.selector + "[value=" + value + "]").prop("checked", false)
                        break;
                    case "radio":
                        $(filter.selector).filter('[value=0]').prop("checked", true)
                        break;
                    case "hidden":
                        $('input[name="recommended"]').val(0);
                        break;
                    default:
                        break;
                }
            }
        })

        UI.applyFilters();
    },
    applyFilters: function (pop = false) {
        UI.previous_filters = UI.temp_filters;
        UI.closeFilters(true);
        UI.temp_filters = JSON.parse(UI.saveCurrentFilters());
        UI.applied_filters = JSON.parse(UI.saveCurrentFilters());
        // console.log(UI.applied_filters);
        // console.log(UI.temp_filters);
        // console.log(UI.temp_filters[2].value);

        let active_filters_html = "";
        let i = 0;
        let appends = {};
        let cruises_h1 = document.getElementById('cruises_points');
        let start = $('input[name="start"]:checked').parent().text().trim();
        let finish = $('input[name="finish"]:checked').parent().text().trim();
        if(start !== 'Any port' && finish !== 'Any port'){
            cruises_h1.innerHTML= "Cruises from " + start + " to " + finish;
        }
        else if(start === 'Any port' && finish !== 'Any port'){
            cruises_h1.innerHTML='Cruises to ' + finish;
        }
        else if(start !== 'Any port' && finish === 'Any port'){
            cruises_h1.innerHTML='Cruises from ' + start;
        }
        else{
            cruises_h1.innerHTML = 'All cruises';
        }

        appends["month"] = UI.date;
        appends["ajax"]=true;
        UI.applied_filters.forEach(filter => {
            switch (filter.type) {
                case "range":
                    var val = $(filter.selector).slider("option", "values");
                    if (val[0] != $(filter.selector).data().min || val[1] != $(filter.selector).data().max) {
                        appends[filter.name] = encodeURIComponent([$(filter.selector).data("hrk-from"), $(filter.selector).data("hrk-to")]);
                        i++;
                        active_filters_html += '<div class="active_filter" ><span>' + val[0] + ' - ' + val[1] + " " + $(filter.selector).data().currency + '</span><svg  class="close" onclick="UI.reset_applied_filter(\'' + filter.name + '\')" xmlns="http://www.w3.org/2000/svg" width="16.97" height="16.973" viewBox="0 0 16.97 16.973">\n' +
                            '\n' +
                            '    <g transform="translate(-276.515 -27.514)">\n' +
                            '        <line style="fill:none;stroke:#fff;stroke-width:2px;" x2="22" transform="translate(277.222 28.222) rotate(45)"/>\n' +
                            '        <line style="fill:none;stroke:#fff;stroke-width:2px;" x2="22" transform="translate(277.222 43.778) rotate(-45)"/>\n' +
                            '    </g>\n' +
                            '</svg></div>';
                    }
                    break;
                case "checkbox":
                    var tempVal = "";
                    var hiddenvalue = "";
                    var list = "";
                    var length = $(filter.selector + ":checked").length;
                    var value = [];
                    $(filter.selector + ":checked").each(function () {
                        let currentvalue = $(this).val();
                        value.push($(this).val());
                        tempVal = $(this).parent().text();

                        hiddenvalue += tempVal + ", ";
                        var active_filter = '<div class="active_filter" ><span>' + tempVal + (filter.confirmation ? " included" : "") + '</span><svg  class="close" onclick="UI.reset_applied_filter(\'' + filter.name + '\',\'' + currentvalue + '\')" xmlns="http://www.w3.org/2000/svg" width="16.97" height="16.973" viewBox="0 0 16.97 16.973">\n' +
                            '\n' +
                            '    <g transform="translate(-276.515 -27.514)">\n' +
                            '        <line style="fill:none;stroke:#fff;stroke-width:2px;" x2="22" transform="translate(277.222 28.222) rotate(45)"/>\n' +
                            '        <line style="fill:none;stroke:#fff;stroke-width:2px;" x2="22" transform="translate(277.222 43.778) rotate(-45)"/>\n' +
                            '    </g>\n' +
                            '</svg></div>';
                        list += active_filter;
                        active_filters_html += active_filter;

                    });

                    if (filter.expendable) {
                        $("." + filter.name + "-value").text(hiddenvalue.slice(0, -2));
                    }
                    if (filter.confirmation) {
                        $("." + filter.name + "-list").html(list)
                        $("." + filter.name + "-counter").text(length)
                        if (length) {
                            $("." + filter.name + "-counter").removeClass("hide");
                            $("." + filter.name + "-list").show()
                        } else {
                            $("." + filter.name + "-counter").addClass("hide");
                            $("." + filter.name + "-list").hide()
                        }
                    }
                    if (length) {
                        i++;
                        appends[filter.name] = encodeURIComponent(value)
                    }
                    break;
                case "radio":
                    if ($(filter.selector + ":checked").val() != 0) {
                        i++;
                        appends[filter.name] = encodeURIComponent($(filter.selector + ":checked").val());
                        active_filters_html += '<div class="active_filter" ><span >' + $(filter.selector + ":checked").data().label + ": " + $(filter.selector + ":checked").parent().text() + '</span><svg  class="close" onclick="UI.reset_applied_filter(\'' + filter.name + '\')" xmlns="http://www.w3.org/2000/svg" width="16.97" height="16.973" viewBox="0 0 16.97 16.973">\n' +
                            '\n' +
                            '    <g transform="translate(-276.515 -27.514)">\n' +
                            '        <line style="fill:none;stroke:#fff;stroke-width:2px;" x2="22" transform="translate(277.222 28.222) rotate(45)"/>\n' +
                            '        <line style="fill:none;stroke:#fff;stroke-width:2px;" x2="22" transform="translate(277.222 43.778) rotate(-45)"/>\n' +
                            '    </g>\n' +
                            '</svg></div>'
                    }
                    if (filter.expendable) {
                        $("." + filter.name + "-value").text($(filter.selector + ":checked").parent().text());
                    }
                    break;
                case "hidden":
                    if($('input[name="recommended"]').val() == "1"){
                        i++;
                        appends[filter.name] = encodeURIComponent($("input[name="+filter.name+"]").val());
                        active_filters_html += '<div class="active_filter" ><span>' + $("input[name="+filter.name+"]").data().label + '</span><svg  class="close" onclick="UI.reset_applied_filter(\'' + filter.name + '\')" xmlns="http://www.w3.org/2000/svg" width="16.97" height="16.973" viewBox="0 0 16.97 16.973">\n' +
                            '\n' +
                            '    <g transform="translate(-276.515 -27.514)">\n' +
                            '        <line style="fill:none;stroke:#fff;stroke-width:2px;" x2="22" transform="translate(277.222 28.222) rotate(45)"/>\n' +
                            '        <line style="fill:none;stroke:#fff;stroke-width:2px;" x2="22" transform="translate(277.222 43.778) rotate(-45)"/>\n' +
                            '    </g>\n' +
                            '</svg></div>'
                    }
                    break;
                default:
                    break;
            }
        })
        $(".active-filters .filter-list").html(active_filters_html);
        $(".results").addClass("loading");
        if (i > 0) {
            $(".reset-filters").attr("disabled", false);
            $(".active-filters").removeClass("hide-xl");
            $(".filters-counter").html("(" + i + ")").removeClass("hide");
            $(".filter-trigger").addClass("active");
        } else {
            $(".reset-filters").attr("disabled", true);
            $(".active-filters").addClass("hide-xl");
            $(".filters-counter").html(i).addClass("hide");
            $(".filter-trigger").removeClass("active");
        }
        UI.source.cancel('Operation canceled by the user.');
        UI.source = axios.CancelToken.source();
        axios.get('', {
            cancelToken: UI.source.token,
            params: appends
        }).then(function (response) {
            if(response.data.trips.filtered_ids != false){
                $('input[name="destinations"]').prop('checked', false);
                $.each(response.data.trips.filtered_ids, function ($i, $v) {
                    $('input[name="destinations"][value="'+$v+'"]').prop('checked', 'checked');
                });

                $('.active_filter').each(function () {
                    var sd = $(this).find('.close').attr('onclick').toString().replace(/[^0-9]/gi, ''); // Replace everything that is not a number with nothing
                    if($.inArray(parseInt(sd, 10).toString(), response.data.trips.filtered_ids) < 0){
                        $(this).remove();
                    }
                });
            }

            $(".results .cards").html(response.data.html)
            $(".results-number .number").text(response.data.trips.total)
            if (response.data.trips.current_page === response.data.trips.last_page) $(".load_mode").addClass("hide")
            let filteredURL=response.request.responseURL.replace('&ajax=true', '');
            if (!pop) window.history.pushState({filters: JSON.stringify(UI.applied_filters)}, "Filter change", filteredURL)
            // UI.saveCurrentFilters();
            $(".results").removeClass("loading");
        }).catch(function (thrown) {
            if (axios.isCancel(thrown)) {
            } else {
                $(".results").removeClass("loading");
            }
        });

    },
    loadMore: function () {
        $(".results").addClass("loading");

        var loadUrl= window.location.href;
        if(!loadUrl.includes("?")){
            loadUrl+="?";
        }else{
            loadUrl+="&";
        }
        axios.get(loadUrl + "page=" + $(".load_more").data().offset, {}).then(function (response) {
            $(".trips_container").append(response.data.html)
            $(".load_more").data("offset", response.data.trips.current_page + 1)
            if (response.data.trips.current_page === response.data.trips.last_page) $(".load_more").addClass("hide")
            $(".results").removeClass("loading");
        }).catch(function (thrown) {
            if (axios.isCancel(thrown)) {
                console.log('Request canceled', thrown.message);
            } else {
                $(".results").removeClass("loading");
            }
        });


    },
    applyModalFilters: function (el) {
        UI.temp_filters = JSON.parse(UI.saveCurrentFilters(true));

        UI.closeModalFilters(el);
    },
    showModalFilters: function (e, bigScreen = false) {
        var el = $("#" + e);
        UI.temp_filters = JSON.parse(UI.saveCurrentFilters());

        if (bigScreen) UI.applied_filters = UI.temp_filters;
        if ($(window).innerWidth() < 620) {
            el.toggleClass("active")
        } else {
            $("body").addClass("active modal-active")
            el.toggleClass("active").animate({opacity: 1}, 400)
        }
    },
    hideModalFilters: function (el) {
        UI.resetToFilters(UI.temp_filters);
        UI.closeModalFilters(el);
    },
    closeModalFilters: function (el) {
        var el = $("#" + el)
        if ($(window).innerWidth() < 752) {
            el.removeClass("active");
        } else {
            el.removeClass("active")
            if ($(window).innerWidth > 1199) $("body").removeClass("active modal-active")
        }
        ;
    },
    saveCurrentFilters: function (fromModal = false) {
        var temp_filters = [];
        UI.filters.forEach(filter => {
            switch (filter.type) {
                case "range":
                    filter.value = $(filter.selector).slider("option", "values")
                    temp_filters.push(filter)
                    break;
                case "checkbox":
                    var tempArray = [];
                    var length = $(filter.selector + ":checked").length;
                    $(filter.selector + ":checked").each(function () {
                        tempArray.push($(this).val());
                    });
                    if (filter.confirmation) {
                        $("." + filter.name + "-counter").text(length)
                        if (length) {
                            $("." + filter.name + "-counter").removeClass("hide");
                        } else $("." + filter.name + "-counter").addClass("hide")
                    }
                    filter.value = tempArray
                    temp_filters.push(filter)
                    break;
                case "radio":
                    filter.value = $(filter.selector + ":checked").val()
                    temp_filters.push(filter)
                    break;
                case "hidden":
                    filter.value = $("input[name='recommended']").val()
                    temp_filters.push(filter)
                    break;
                default:
                    break;
            }
        })
        return JSON.stringify(temp_filters);
    },
    resetToInitFilters: function (filters) {
        var active_filters_html = "";
        var i = 0;
        filters.forEach(filter => {
            if (filter.value) {
                switch (filter.type) {
                    case "range":
                        var range_element = $(filter.selector);
                        var from = (filter.value[0] / range_element.data().currency_value).toFixed();
                        var to = (filter.value[1] / range_element.data().currency_value).toFixed();
                        range_element.slider("option", "values", [from, to])
                        active_filters_html += '<div class="active_filter" ><span><span data-hrk="' + $(filter.selector).data("hrk-from") + '">' + from + '</span> - <span data-hrk="' + $(filter.selector).data("hrk-to") + '">' + to + "</span> " + $(filter.selector).data().currency + '</span><svg  class="close" onclick="UI.reset_applied_filter(\'' + filter.name + '\')" xmlns="http://www.w3.org/2000/svg" width="16.97" height="16.973" viewBox="0 0 16.97 16.973">\n' +
                            '\n' +
                            '    <g transform="translate(-276.515 -27.514)">\n' +
                            '        <line style="fill:none;stroke:#fff;stroke-width:2px;" x2="22" transform="translate(277.222 28.222) rotate(45)"/>\n' +
                            '        <line style="fill:none;stroke:#fff;stroke-width:2px;" x2="22" transform="translate(277.222 43.778) rotate(-45)"/>\n' +
                            '    </g>\n' +
                            '</svg></div>'
                        i++;
                        break;
                    case "checkbox":
                        var tempVal = "";
                        var hiddenvalue = "";
                        var list = "";

                        var value = [];
                        $(filter.selector).prop("checked", false)
                        $(filter.selector).filter(function () {
                            return $.inArray(this.value, filter.value) >= 0;
                        }).prop('checked', true);
                        var length = $(filter.selector + ":checked").length;
                        $(filter.selector + ":checked").each(function () {
                            value.push($(this).val());
                            let tempvalue = $(this).val();
                            tempVal = $(this).parent().text();
                            hiddenvalue += tempVal + ", ";
                            var active_filter = '<div class="active_filter" ><span>' + tempVal + (filter.confirmation ? " included" : "") + '</span><svg  class="close" onclick="UI.reset_applied_filter(\'' + filter.name + '\',\'' + tempvalue + '\')" xmlns="http://www.w3.org/2000/svg" width="16.97" height="16.973" viewBox="0 0 16.97 16.973">\n' +
                                '\n' +
                                '    <g transform="translate(-276.515 -27.514)">\n' +
                                '        <line style="fill:none;stroke:#fff;stroke-width:2px;" x2="22" transform="translate(277.222 28.222) rotate(45)"/>\n' +
                                '        <line style="fill:none;stroke:#fff;stroke-width:2px;" x2="22" transform="translate(277.222 43.778) rotate(-45)"/>\n' +
                                '    </g>\n' +
                                '</svg></div>';
                            list += active_filter;
                            active_filters_html += active_filter;

                        });
                        if (filter.expendable) {
                            $("." + filter.name + "-value").text(hiddenvalue.slice(0, -2));
                        }
                        if (filter.confirmation) {
                            $("." + filter.name + "-list").html(list)
                            $("." + filter.name + "-counter").text(length)
                            if (length) {
                                $("." + filter.name + "-counter").removeClass("hide");
                                $("." + filter.name + "-list").show()
                            } else {
                                $("." + filter.name + "-counter").addClass("hide");
                                $("." + filter.name + "-list").hide()
                            }
                        }
                        if (length) {
                            i++;
                        }
                        break;
                    case "radio":
                        $(filter.selector).filter('[value=' + filter.value + ']').prop("checked", true)
                        i++;

                        active_filters_html += '<div class="active_filter" ><span>' + $(filter.selector + ":checked").data().label + ": " + $(filter.selector + ":checked").parent().text() + '</span><svg  class="close" onclick="UI.reset_applied_filter(\'' + filter.name + '\')" xmlns="http://www.w3.org/2000/svg" width="16.97" height="16.973" viewBox="0 0 16.97 16.973">\n' +
                            '\n' +
                            '    <g transform="translate(-276.515 -27.514)">\n' +
                            '        <line style="fill:none;stroke:#fff;stroke-width:2px;" x2="22" transform="translate(277.222 28.222) rotate(45)"/>\n' +
                            '        <line style="fill:none;stroke:#fff;stroke-width:2px;" x2="22" transform="translate(277.222 43.778) rotate(-45)"/>\n' +
                            '    </g>\n' +
                            '</svg></div>'
                        if (filter.expendable) {
                            $("." + filter.name + "-value").text($(filter.selector + ":checked").parent().text());
                        }
                        break;
                    case "hidden":
                        $("input[name='recommended']").val(0);
                        break;
                    default:
                        break;
                }
            }
        })

        if (i > 0) {
            $(".reset-filters").attr("disabled",false)
            $(".active-filters").removeClass("hide-xl");
            $(".filters-counter").html("(" + i + ")").removeClass("hide")
            $(".filter-trigger").addClass("active");
        } else {
            $(".reset-filters").attr("disabled",true)
            $(".active-filters").addClass("hide-xl");
            $(".filters-counter").html(i).addClass("hide")
            $(".filter-trigger").removeClass("active");
        }
    },
    resetToFilters: function (filters) {
        filters.forEach(filter => {
            switch (filter.type) {
                case "range":
                    $(filter.selector).slider("option", "values", filter.value)
                    break;
                case "checkbox":
                    $(filter.selector).prop("checked", false)
                    $(filter.selector).filter(function () {
                        return $.inArray(this.value, filter.value) >= 0;
                    }).prop('checked', true);
                    break;
                case "radio":
                    $(filter.selector).filter('[value=' + filter.value + ']').prop("checked", true)
                    break;
                case "hidden":
                    $("input[name='recommended']").val(0);
                    break;
                default:
                    break;
            }
        })
    },
    resetFilters: function (pop = false) {
        UI.filters.forEach(filter => {

            switch (filter.type) {
                case "range":
                    $(filter.selector).slider("option", "values", [$(filter.selector).data().min, $(filter.selector).data().max])
                    break;
                case "checkbox":
                    $(filter.selector).prop("checked", false)
                    break;
                case "radio":
                    $(filter.selector).filter('[value=0]').prop("checked", true)
                    break;
                case "hidden":
                    $("input[name='recommended']").val(0);
                    break;
                default:
                    break;
            }
        })
        UI.temp_filters = JSON.parse(UI.saveCurrentFilters())
        UI.applied_filters = JSON.parse(UI.saveCurrentFilters())
        UI.applyFilters(pop);
        $("html, body").animate({scrollTop: 0}, 1000);
    },
    loadPreviousFilters: function(){
        UI.resetToFilters(UI.previous_filters);
        UI.applyFilters(true);
        $("html, body").animate({scrollTop: 0}, 1000);
    },
    loadRecommendedFilter: function(){
        UI.resetFilters();
        $("input[name='recommended']").val(1);
        UI.applied_filters = JSON.parse(UI.saveCurrentFilters())
        UI.applyFilters();
        $("html, body").animate({scrollTop: 0}, 1000);
    },
    expand: function (id) {
        $(id).parent().toggleClass("active");
        $(id).parent().toggleClass("active-mobile");
    },
    homeInit: function(){
        let homeNav = $('.home-navigation-wrapper');
        window.addEventListener("scroll", event => {
            if($(window).scrollTop() > 50){
                homeNav.addClass('home-nav-fixed');
            }else{
                homeNav.removeClass('home-nav-fixed');
            }
        });


        var search = $('#search'),
            searchBtn = $('#search button');

        // searchBtn.on('click', function (e) {
        //     e.preventDefault();
        // });
    },
    cruiseInit: function (locations) {
        $(".shares").jsSocials({
            showLabel: false,
            showCount: false,
            shares: [{share:"twitter",logo:"/assets/twitter.svg"}, {share:"facebook",logo:"/assets/facebook_share.svg"}]
        });
        // let mainNavLinks = document.querySelectorAll(".sticky ul li a");
        let mainNavLinks = document.querySelectorAll(".nav-second .nav-item a");

        let border = $(".border")

        // let active = $(".sticky ul li a.active");
        let active = $(".nav-second .nav-item a.active");

       // var navSticky = $(".cruise-container nav.sticky")
         var navSticky = $(".cruise-container .nav-second")

        // let prvi = $("#route");
        let prvi = $("#overview");

        // let zadnji = $("#prices");
        let zadnji = $("#gallery");
        border.width(active[0].offsetWidth).css({left: active.position().left + navSticky.scrollLeft()});
        window.addEventListener("scroll", event => {
            var mainNav = $(".navigation-wrapper");
            let offset = navSticky.outerHeight();
            let fromTop = window.scrollY;
            // console.log(navSticky[0].offsetTop, $(mainNav).outerHeight(), fromTop);
            // console.log(navSticky[0].offsetHeight);
            if ($(window).width() > 1199) {
                if (navSticky[0].offsetTop - $(mainNav).outerHeight() <= fromTop && navSticky[0].offsetTop + navSticky[0].offsetHeight > fromTop) {
                    if (!mainNav.hasClass('hidden'))
                        mainNav.addClass('hidden');
                    if (!navSticky.hasClass('active'))
                        navSticky.addClass("active");
                } else {
                    if (mainNav.hasClass('hidden'))
                        mainNav.removeClass('hidden');
                    if (navSticky.hasClass('active'))
                        navSticky.removeClass("active");
                }
            } else {
                if (navSticky[0].offsetTop - $(mainNav).outerHeight() <= fromTop && navSticky[0].offsetTop + navSticky[0].offsetHeight > fromTop) {
                    if (!mainNav.hasClass('hidden'))
                        mainNav.addClass('hidden');
                    if (!navSticky.hasClass('active'))
                        navSticky.addClass("active");
                } else {
                    if (mainNav.hasClass('hidden'))
                        mainNav.removeClass('hidden');
                    if (navSticky.hasClass('active'))
                        navSticky.removeClass("active");
                }
            }

            mainNavLinks.forEach(link => {
                let section = document.querySelector(link.hash);
                if (
                    $(section).offset().top - offset - 80 <= fromTop &&
                    $(section).offset().top - offset - 80 + section.offsetHeight > fromTop
                ) {
                    link.classList.add("active");
                    active = $(link);
                    let position2 = active.parent().position().left + navSticky.scrollLeft();
                    navSticky.stop(true, true).animate({scrollLeft: position2}, 1000)
                    border.width(active[0].offsetWidth).css({left: active.position().left + navSticky.scrollLeft()});
                } else if (link == prvi[0] && prvi[0].offset().top - offset > fromTop) {
                    // navSticky.scrollLeft(position);
                    prvi[0].classList.add("active");
                    active = $(link);
                } else if (link == zadnji[0] && zadnji[0].offset().top - 5 - offset < fromTop) {
                    // navSticky.scrollLeft(position);
                    zadnji[0].classList.add("active");

                    active = $(link);
                } else {
                    link.classList.remove("active");
                }
            });
            let sticky = $('.sticky-booking-container');
            // console.log($(window).scrollTop(), sticky.offset().top - 150);
            if ($(window).scrollTop() >= sticky.offset().top - 150 && $(window).width() > 1199) {
                sticky.css({'visibility': 'visible', 'opacity': 1});
            } else if ($(window).scrollTop() < sticky.offset().top && $(window).width() > 1199) {
                sticky.css({'visibility': 'hidden', 'opacity': 0});
            }

            // if ($(window).scrollTop() >= $('#prices').offset().top - sticky.outerHeight() - 100 && $(window).width() > 1199) {
            //     sticky.css({'visibility': 'hidden', 'opacity': 0});
            // }
        }, {passive:true});

        $(".nav-second .nav-item a, .discount-card .button").on("click", function (e) {
            e.preventDefault();
            let offset = $(".nav-second").outerHeight();
            var y = ($(e.target.hash).offset().top - offset);

            $('html, body').animate({
                scrollTop: ($(e.target.hash).offset().top - 30 - offset)
            }, 400, "linear", function () {

                // Add hash (#) to URL when done scrolling (default click behavior)
                // window.location.hash = e.target.hash;
            });

        });
        //slider kartica
        var settings = {
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: false,
            dots: true,
            infinite: true,
            fade: true,
            rows: 0,
            slide: ".picture",

        };

        var sl = $('.card-header').not('.slick-initialized').slick(settings);

        var expandBtn = $('#itinerary .subsection .expand-button');
        expandBtn.on('click', function () {
            if ($(this).text() == 'expand all') {
                $(this).text('collapse all');
            } else {
                $(this).text('expand all');
            }
            var subsection = $(this).closest('.subsection');
            if (subsection.children('.expendable').length != subsection.children('.active').length) {
                subsection.children('.expendable').each(function () {
                    $(this).addClass('active');
                });
            } else {
                subsection.children('.expendable').each(function () {
                    $(this).removeClass('active');
                });
            }
        })
        var expandSingleBtn = $('.title.day');
        expandSingleBtn.on('click', function () {
            var subsection = $(this).closest('.subsection');
            var expandBtn = $(this).closest('.expendable').siblings('.main-title').children('.expand-button');

            setTimeout(function () {
                if (subsection.children('.expendable').length == subsection.children('.active').length) {
                    expandBtn.text('collapse all');
                } else {
                    expandBtn.text('expand all');
                }
            }, 250);
        })

        let modal = $('.inquiry-modal');
        let paymentModal = $('.payment-conditions-modal');
        let supplementModal = $('.supplement-modal');
        let flexibleBookingModal = $('.flexible-booking-modal');
        $('.inquiry-button').on('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            $('body').addClass('active');
            modal.addClass('active');
            $('[data-toggle="datepicker"]').datepicker('hide');
            setTimeout(function () {
                modal.css('opacity', 1);
            }, 10);
        });


        $('.date-inquiry-button').on('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            $('body').addClass('active');
            modal.addClass('active');
            $("#dep_date").val($(this).data('date'))
            $('[data-toggle="datepicker"]').datepicker('hide').datepicker('update');
            setTimeout(function () {
                modal.css('opacity', 1);
            }, 10);
        });
        //
        $('.payment-link').on('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            $('body').addClass('active');
            paymentModal.addClass('active');
            setTimeout(function () {
                paymentModal.css('opacity', 1);
            }, 10);
        });

        $('.supplement-link').on('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            $('body').addClass('active');
            supplementModal.addClass('active');
            setTimeout(function () {
                supplementModal.css('opacity', 1);
            }, 10);
        });

        $('.flexible-booking-link').on('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            $('body').addClass('active');
            flexibleBookingModal.addClass('active');
            setTimeout(function () {
                flexibleBookingModal.css('opacity', 1);
            }, 10);
        });

        $('body').on('click', function () {
            if (modal.hasClass('active')) {
                modal.removeClass('active');
                modal.css('opacity', 0);
            }
            if (paymentModal.hasClass('active')) {
                paymentModal.removeClass('active');
                paymentModal.css('opacity', 0);
            }

            if (supplementModal.hasClass('active')) {
                supplementModal.removeClass('active');
                supplementModal.css('opacity', 0);
            }

            if (flexibleBookingModal.hasClass('active')) {
                flexibleBookingModal.removeClass('active');
                flexibleBookingModal.css('opacity', 0);
            }
        });

        $('.close-button').on('click', function () {
            modal.removeClass('active');
            $('body').removeClass('active');
            $(modal.find('input, textarea')).each(function () {
                let error = $(this).siblings('.error-message');
                $(this).removeClass('error');
                error.removeClass('error-show');
            })
            modal.css('opacity', 0);
        });

        $('.pcm-close-button').on('click', function () {
            paymentModal.removeClass('active');
            $('body').removeClass('active');
            paymentModal.css('opacity', 0);
        });

        modal.on('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            if (!e.target.matches('#dep_date')) {
                $('[data-toggle="datepicker"]').datepicker('hide');
            }
        });

        paymentModal.on('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
        });

        inputErrorHandler();

        $('[data-toggle="datepicker"]').datepicker({
            autoShow: false,
            autoHide: true,
            format: 'dd.mm.yyyy',
            startDate: new Date(),
        });
        $('[data-toggle="datepicker"]').datepicker('hide');
        // $('[data-toggle="datepicker"], .datepicker-panel').click(function (e) {
        //     e.stopPropagation(); // This is the preferred method.
        //     return false;        // This should not be used unless you do not want
        //                          // any click events registering inside the div
        // });



        var yearCont = $('.year-container.active');
        var yearMap = $('.map-container');
        var year = yearMap.attr('data-year');


        // if(locations.length > 0){
        //     UI.initMap(locations, false, 'map-'+year);
        // }

        let timeTrigger = $('.price-list-item .time');

        timeTrigger.on('click', function () {
            $(this).closest('.price-list-item').find('form .button').trigger('click');
        });

        let arrowUp = $('svg.arrowUp'),
            arrowDown = $('svg.arrowDown'),
            paxInput = $('input#pax'),
            count = 0;

        if(paxInput.val() == "") count = 0;
        arrowUp.on('click', function () {
            count = count + 1;
            paxInput.val(count);
        });

        arrowDown.on('click', function () {
            count = count - 1;
            if(count < 0){
                count = 0;
            }
            paxInput.val(count);
        });
            // console.log("inicijaliziram selectove:", $('#country'))
        if (navigator.userAgent.match(/(iPod|iPhone|iPad)/i)) {
            $('#country').selectric({
                arrowButtonMarkup: '<svg xmlns="http://www.w3.org/2000/svg" width="11.07" height="3.778" viewBox="0 0 11.07 3.778">\n' +
                    '  <g id="choose_month_strelica" data-name="choose month strelica" transform="translate(0.675 0.675)">\n' +
                    '    <path id="Path_29" data-name="Path 29" d="M504,720l4.86,2.539,4.86-2.539" transform="translate(-504 -720)" fill="none" stroke="#414141" stroke-linecap="round" stroke-width="1"/>\n' +
                    '  </g>\n' +
                    '</svg>\n',
                disableOnMobile: false,
                nativeOnMobile: true,
            });
        } else {
            $('#country').selectric({
                arrowButtonMarkup: '<svg xmlns="http://www.w3.org/2000/svg" width="11.07" height="3.778" viewBox="0 0 11.07 3.778">\n' +
                    '  <g id="choose_month_strelica" data-name="choose month strelica" transform="translate(0.675 0.675)">\n' +
                    '    <path id="Path_29" data-name="Path 29" d="M504,720l4.86,2.539,4.86-2.539" transform="translate(-504 -720)" fill="none" stroke="#414141" stroke-linecap="round" stroke-width="1"/>\n' +
                    '  </g>\n' +
                    '</svg>\n',
                disableOnMobile: false,
                nativeOnMobile: false
            });
        }


    },
    shipSearch: function(){
      let filter=$(".sticky ul li a.active").data("filter-type");
      let search=$("#search-input").val().toLowerCase(),
        count = 0,
        emptyState = $('.empty-state');
        $(emptyState).fadeOut(400);
        $(".card.column").fadeOut(400);
        setTimeout(function(){
            $(".card.column").each(function () {
                if ($(this).data("name").indexOf(search) > -1 && ($(this).data('filter') === filter || filter === 0)) {
                    $(this).fadeIn(400);
                    count = count + 1;
                }
            });
            if(count == 0){
                $(emptyState).fadeIn(400);
            }
        },400);

        // setTimeout(function () {
        //     $(".parallax-window").parallax({
        //         calibrateX: true,
        //         calibrateY: true
        //     });
        //
        //     $(window).trigger('resize').trigger('scroll');
        // }, 500);
        //
        // $(window).trigger('resize').trigger('scroll');
    },
    shipsInit: function (month) {
        UI.page = "ships";
        UI.date = month;
        let mainNavLinks = document.querySelectorAll(".sticky ul li a");
        let border = $(".border")
        let active = $(".sticky ul li a.active");
        var navSticky = $(".ships-container nav.sticky");
        border.width(active[0].offsetWidth).css({left: active.position().left + navSticky.scrollLeft() - 3.171875});
        //slider kartica
        var settings = {
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: false,
            dots: true,
            infinite: true,
            fade: true,
            rows: 0,
            slide: ".img-wrapper",

        };
        let inputTimer=null;
        // var sl =  $('.card-header').not('.slick-initialized').slick(settings);
        $(".sticky ul li a").on("click", function (e) {
            let $this = $(this);
            e.preventDefault();
            $(mainNavLinks).removeClass('active');
            $(this).addClass('active');
            let position2 = $(this).parent().position().left + navSticky.scrollLeft();
            navSticky.stop(true, true).animate({scrollLeft: position2}, 1000)
            border.width($(this)[0].offsetWidth).css({left: $(this).position().left + navSticky.scrollLeft()});
            UI.shipSearch();


        });


        $('input#search-input').on('keyup keydown', function () {
            if ($(this).val().length != 0 && !$('.search-icon').hasClass('delete')) {
                $(".ship-search-container").find('.search-icon').remove();
                $(".ship-search-container").append('<svg onclick="UI.clearSearch()" xmlns="http://www.w3.org/2000/svg" width="25.707" height="25.707" viewBox="0 0 25.707 25.707" class="search-icon delete">\n' +
                    '  <g transform="translate(0.354 0.354)">\n' +
                    '    <line id="Line_44" data-name="Line 44" x2="35.355" transform="rotate(45)" fill="none" stroke="#9e9e9e" stroke-width="1"/>\n' +
                    '    <line id="Line_498" data-name="Line 498" x2="35.355" transform="translate(0 25) rotate(-45)" fill="none" stroke="#9e9e9e" stroke-width="1"/>\n' +
                    '  </g>\n' +
                    '</svg>\n');
            } else if ($(this).val().length == 0) {
                $(".ship-search-container").find('.search-icon').remove();
                $(".ship-search-container").append('<svg xmlns="http://www.w3.org/2000/svg" width="25.572" height="25.354" viewBox="0 0 25.572 25.354" class="search-icon">\n' +
                    '  <g transform="translate(-4.266 -4.267)">\n' +
                    '    <g id="Ellipse_131" data-name="Ellipse 131" transform="translate(4.266 4.266)" fill="none" stroke="#9e9e9e" stroke-width="1">\n' +
                    '      <circle cx="10.089" cy="10.089" r="10.089" stroke="none"/>\n' +
                    '      <circle cx="10.089" cy="10.089" r="9.589" fill="none"/>\n' +
                    '    </g>\n' +
                    '    <line id="Line_494" data-name="Line 494" x2="7.895" y2="7.895" transform="translate(21.59 21.371)" fill="none" stroke="#9e9e9e" stroke-width="1"/>\n' +
                    '  </g>\n' +
                    '</svg>\n');
            }
            // $('.ships_container').removeAttr('style');
            window.clearTimeout(inputTimer);
            inputTimer = window.setTimeout(UI.shipSearch, 300);


        });


        let emptyState = $('.empty-state');
        $(emptyState).fadeOut(400);
    },
    shipInit: function (month) {
        UI.page = "ship";
        UI.date = month;
        //slider kartica
        var settings = {
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: false,
            dots: true,
            infinite: true,
            fade: true,
            rows: 0,
            slide: ".cover-img",

        };



        var sl = $('.gallery-container').not('.slick-initialized').slick(settings);
        var sl2 = $('.card-header').not('.slick-initialized').slick(settings);
        $(window).on('resize orientationchange', function () {
            $('.card-header img').css('width', '100%');
        });

        $('#dep_date').on('click', function (e) {
            console.log('klik');
            e.preventDefault();
            e.stopPropagation();

            $("#dep_date").val($(this).data('date'))
            $('[data-toggle="datepicker"]').datepicker('show').datepicker('update');
            setTimeout(function () {

            }, 10);
        });

        $('#charter-img, #charter-img-jpg').on('click', function (){
            console.log($(this).attr('src'))
;            var imageUrl = $(this).attr('src');
            $('.img-overlay').html('<img class="charter-image" src="' + imageUrl + '">');
            $(".img-overlay").fadeTo(1, 1, function() {
                $(this).css('display', 'flex');
            });
        });

        $('.img-overlay').click(function (){
            $(this).fadeOut();
        });

        let arrowUp = $('svg.arrowUp'),
            arrowDown = $('svg.arrowDown'),
            arrowUpPax = $('svg.arrowUpPax'),
            arrowDownPax = $('svg.arrowDownPax'),
            arrowUpCab = $('svg.arrowUpCab'),
            arrowDownCab = $('svg.arrowDownCab'),
            durationInput = $('input#duration'),
            paxInput = $('input#pax'),
            cabInput = $('input#cabins'),
            count = 2,
            countPax = 2,
            countCab = 2;

        if(durationInput.val() == "") count = 1;
        if(paxInput.val() == "") countPax = 1;
        if(cabInput.val() == "") countCab = 1;
        arrowUp.on('click', function () {
            count = count + 1;
            durationInput.val(count);

        });

        arrowDown.on('click', function () {
            count = count - 1;
            if(count < 2){
                count = 2;
            }
           durationInput.val(count);
        });

        arrowUpPax.on('click', function () {
            countPax = countPax + 1;
            paxInput.val(countPax);
            console.log('klik gore');
        });

        arrowDownPax.on('click', function () {
            countPax = countPax - 1;
            if(countPax < 2){
                countPax = 2;
            }
           paxInput.val(countPax);
        });

        arrowUpCab.on('click', function () {
            countCab = countCab + 1;
            cabInput.val(countCab);
            console.log('klik gore');
        });

        arrowDownCab.on('click', function () {
            countCab = countCab - 1;
            if(countCab < 2){
                countCab = 2;
            }
           cabInput.val(countCab);
        });



    },
    destinationsInit: function (month) {
        UI.page = "ships";
        UI.date = month;
        let inputTimer=null;
        $('input#search-input').on('keyup keydown', function () {
            if ($(this).val().length != 0 && !$('.search-icon').hasClass('delete')) {
                $(".destination-search-container").find('.search-icon').remove();
                $(".destination-search-container").append('<svg onclick="UI.clearSearch()" xmlns="http://www.w3.org/2000/svg" width="25.707" height="25.707" viewBox="0 0 25.707 25.707" class="search-icon delete">\n' +
                    '  <g transform="translate(0.354 0.354)">\n' +
                    '    <line id="Line_44" data-name="Line 44" x2="35.355" transform="rotate(45)" fill="none" stroke="#9e9e9e" stroke-width="1"/>\n' +
                    '    <line id="Line_498" data-name="Line 498" x2="35.355" transform="translate(0 25) rotate(-45)" fill="none" stroke="#9e9e9e" stroke-width="1"/>\n' +
                    '  </g>\n' +
                    '</svg>\n');
            } else if ($(this).val().length == 0) {
                $(".destination-search-container").find('.search-icon').remove();
                $(".destination-search-container").append('<svg xmlns="http://www.w3.org/2000/svg" width="25.572" height="25.354" viewBox="0 0 25.572 25.354" class="search-icon">\n' +
                    '  <g transform="translate(-4.266 -4.267)">\n' +
                    '    <g id="Ellipse_131" data-name="Ellipse 131" transform="translate(4.266 4.266)" fill="none" stroke="#9e9e9e" stroke-width="1">\n' +
                    '      <circle cx="10.089" cy="10.089" r="10.089" stroke="none"/>\n' +
                    '      <circle cx="10.089" cy="10.089" r="9.589" fill="none"/>\n' +
                    '    </g>\n' +
                    '    <line id="Line_494" data-name="Line 494" x2="7.895" y2="7.895" transform="translate(21.59 21.371)" fill="none" stroke="#9e9e9e" stroke-width="1"/>\n' +
                    '  </g>\n' +
                    '</svg>\n');
            }
            let $this = $(this);

            let search=$("#search-input").val().toLowerCase(),
            emptyState = $('.empty-state'),
            count = 0;
            $(emptyState).fadeOut(400);
            window.clearTimeout(inputTimer);
            inputTimer = window.setTimeout(function(){
                $(".card.column").fadeOut(400)
                setTimeout(function(){
                    $(".card.column").each(function () {
                        if ($(this).data("name").indexOf(search) > -1 ) {
                            $(this).fadeIn(400);
                            count += 1;
                        }
                    });

                    if(count == 0){
                        $(emptyState).fadeIn(400);
                    }
                },400);
            }, 300);





            setTimeout(function () {
                $(".parallax-window").parallax({
                    calibrateX: true,
                    calibrateY: true
                });

                $(window).trigger('resize').trigger('scroll');
            }, 500);

            $(window).trigger('resize').trigger('scroll');
        });

        let emptyState = $('.empty-state');
        $(emptyState).fadeOut(400);

    },
    destinationInit: function (locations) {
        UI.page = "destination";
        //slider kartica
        var settings = {
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: false,
            dots: true,
            infinite: true,
            fade: true,
            rows: 0,
            slide: ".cover-img",

        };

        var sl = $('.gallery-container').not('.slick-initialized').slick(settings);
        var sl2 = $('.card-header').not('.slick-initialized').slick(settings);
        $(window).on('resize orientationchange', function () {
            $('.card-header img').css('width', '100%');
        });
        UI.initMap(locations,"destination");
    },
    initMap: function (locations = false, page=false, mapId = false) {

        var content;
        var mapEl;
        var myLatLng = {
            lat: 44.57521884993711, lng: 17.13579848851191
        };
        if(locations.length==1) myLatLng={lat:locations[0].latitude,lng:locations[0].longitude};
        if(mapId == false){
           mapEl = document.getElementById('map');
        }else{
           mapEl = document.getElementById(mapId);
        }
        var map = new google.maps.Map(mapEl, {
            zoom: page=='ports' ? 6 : 7,
            center: myLatLng,
            disableDefaultUI: true,
            gestureHandling: 'cooperative',
        });

        if (page == "destination") {
            map.zoom = 12;
        }
        else if (window.innerWidth < 1150) {
            map.zoom = 5.6;
        }


        // Create a div to hold the control.
        var fullscreenControlDiv = document.createElement('button');
        fullscreenControlDiv.setAttribute("class", "fullscreenControlDiv");
        fullscreenControlDiv.style.background = "white";
        fullscreenControlDiv.style.padding = "8px";
        fullscreenControlDiv.style.margin = "10px";
        fullscreenControlDiv.style.border = "none";
        fullscreenControlDiv.style.borderRadius = "3px";
        fullscreenControlDiv.style.lineHeight = "0";
        fullscreenControlDiv.index = 1;
        map.controls[google.maps.ControlPosition.TOP_RIGHT].push(fullscreenControlDiv);
        google.maps.event.addDomListener(fullscreenControlDiv, 'click', function () {
            map.fullscreenchange;
        });
        fullscreenControlDiv.addEventListener('click', function () {
            document.getElementsByClassName("gm-fullscreen-control")[0].click();
        });
        // Set CSS for the control border
        var fullscreenControlUI = document.createElement('img');
        fullscreenControlUI.setAttribute("src", "/assets/google_map_view.svg");
        fullscreenControlDiv.appendChild(fullscreenControlUI);

        var zoomControlDiv = document.createElement('div');
        zoomControlDiv.index = 1;
        zoomControlDiv.setAttribute("class", "zoomControlDiv");
        // $(fullscreenControlDiv).addClass('gm-control-active gm-fullscreen-control');
        map.controls[google.maps.ControlPosition.BOTTOM_RIGHT].push(zoomControlDiv);
        // Set CSS for the control border
        var zoomDivUI = document.createElement('button');
        zoomDivUI.style.background = "white";
        zoomDivUI.style.display = "block";
        zoomDivUI.style.padding = "12px";
        zoomDivUI.style.margin = "10px";
        zoomDivUI.style.border = "none";
        zoomDivUI.style.borderRadius = "3px";
        zoomDivUI.style.lineHeight = "0";
        zoomControlDiv.appendChild(zoomDivUI);
        google.maps.event.addDomListener(zoomDivUI, 'click', function () {
            map.setZoom(map.getZoom() + 1);
        });

        var zoomPlusUI = document.createElement('img');
        zoomPlusUI.style.width = "16px";
        zoomPlusUI.style.height = "16px";
        zoomPlusUI.style.display = "block";
        zoomPlusUI.setAttribute("src", "/assets/google_maps_plus.svg");
        zoomDivUI.appendChild(zoomPlusUI);

        var zoomDiv2UI = document.createElement('button');
        zoomDiv2UI.style.background = "white";
        zoomDiv2UI.style.display = "block";
        zoomDiv2UI.style.padding = "12px";
        zoomDiv2UI.style.margin = "10px";
        zoomDiv2UI.style.border = "none";
        zoomDiv2UI.style.borderRadius = "3px";
        zoomDiv2UI.style.lineHeight = "0";
        zoomControlDiv.appendChild(zoomDiv2UI);
        google.maps.event.addDomListener(zoomDiv2UI, 'click', function () {
            map.setZoom(map.getZoom() - 1);
        });

        var image = {
            url: "/assets/pin.png",
            scaledSize: new google.maps.Size(11, 16),
        };
        if(locations != false) {
            locations.forEach(function ($location) {
                new google.maps.Marker({
                    position: {lat: parseFloat($location.latitude), lng: parseFloat($location.longitude)},
                    icon: new google.maps.MarkerImage("/assets/map-pin.svg"),
                    map: map,
                    optimized: false,
                });
            });
        }

        var zoomMinusUI = document.createElement('img');
        zoomMinusUI.style.width = "16px";
        zoomMinusUI.style.height = "16px";
        zoomMinusUI.setAttribute("src", "/assets/google_maps_line.svg");

        zoomDiv2UI.appendChild(zoomMinusUI);

    },
    portsInit: function (locations) {
        UI.page = "ports";
        UI.initMap(locations,"ports")
    },
    blogsInit: function (month=false) {
        UI.page = "blogs";

        var settings = {
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: false,
            dots: false,
            infinite: true,
            mobileFirst: true,
            rows: 0,
            centerMode: true,
            centerPadding: "calc(50% - 176px)",
            responsive: [
                {
                    breakpoint: 809,
                    settings: {
                        centerPadding: "calc(50% - 250px)",
                    }
                },
                {
                    breakpoint: 1199,
                    settings: {
                        centerMode: false,
                        slidesToShow: 3,
                        slidesToScroll: 3,
                    }
                },
                {
                    breakpoint: 1919,
                    settings: {
                        centerMode: false,
                        vertical: true,
                        slidesToShow: 3,
                        slidesToScroll: 3,
                    }
                },
            ]
        };

        var sl = $('#stories-slider').not('.slick-initialized').slick(settings);
    },
    blogInit: function (month=false) {
        UI.page = "blog";


        var settings = {
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: false,
            dots: false,
            infinite: true,
            mobileFirst: true,
            rows: 0,
            centerMode: true,
            centerPadding: "calc(50% - 176px)",
            responsive: [
                {
                    breakpoint: 809,
                    settings: {
                        centerPadding: "calc(50% - 250px)",
                    }
                },
                {
                    breakpoint: 1199,
                    settings: {
                        centerMode: false,
                        slidesToShow: 3,
                        slidesToScroll: 3,
                    }
                },
                {
                    breakpoint: 1919,
                    settings: {
                        centerMode: false,
                        vertical: true,
                        slidesToShow: 3,
                        slidesToScroll: 3,
                    }
                },
            ]
        };

        var sl = $('#stories-slider').not('.slick-initialized').slick(settings);
    },
    bookingInit: function (month=false) {
        UI.page = "booking";

        let modal = $('.tour-info-modal');
        let boatModal = $('.boat-modal');
        let priceShow = $('.total-amount-value');
        let price = $('input[name="total_price"]');
        let closeBtn = $('.tour-info-modal .card-close');
        let closeBtn2 = $('.boat-modal .card-close');

        // if (priceShow.length > -1) {
        //     let ldc = $('.ldg');
        //     let mdc = $('.mdg');
        //     let sc = $('.sg');
        //     let ldcCount = ldc.find('.count-data').last().text();
        //     let mdcCount = mdc.find('.count-data').last().text();
        //     let scCount = sc.find('.count-data').last().text();
        //     let ldcPrice = ldc.find('.individual-price-data').last().text();
        //     let mdcPrice = mdc.find('.individual-price-data').last().text();
        //     let scPrice = sc.find('.individual-price-data').last().text();
        //     let priceNumber = priceShow.find('.price-data');
        //     console.log(parseInt(ldcCount) * parseInt(ldcPrice) + parseInt(mdcCount) * parseInt(mdcPrice) + parseInt(scCount) * parseInt(scPrice));
        //     priceNumber.text(parseInt(ldcCount) * parseInt(ldcPrice) + parseInt(mdcCount) * parseInt(mdcPrice) + parseInt(scCount) * parseInt(scPrice));
        //
        //     setTimeout(function () {
        //         price.val(priceShow.first().text());
        //     }, 500);
        //
        // }

        $('.expand-info').on('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            $('body').addClass('active');
            modal.addClass('active');
            setTimeout(function () {
                modal.css('opacity', 1);
            }, 10);
        });


        $('body').on('click', function () {
            if (modal.hasClass('active')) {
                modal.removeClass('active');
                modal.css('opacity', 0);
            }
        });

        modal.on('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
        });

        $(window).on('resize', function () {
            if ($(this).width() > 1199) {
                if (modal.hasClass('active')) {
                    modal.removeClass('active');
                }
                $('body').removeClass('active');
            }
        });

        closeBtn.on('click', function () {
            modal.removeClass('active');
            $('body').removeClass('active');
        });

        closeBtn2.on('click', function () {
            boatModal.removeClass('active');
            $('body').removeClass('active');
        });

        $('.expand-info-boat').on('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            $('body').addClass('active');
            boatModal.addClass('active');
            setTimeout(function () {
                boatModal.css('opacity', 1);
            }, 10);
        });

        $('body').on('click', function () {
            if (boatModal.hasClass('active')) {
                boatModal.removeClass('active');
                boatModal.css('opacity', 0);
            }
        });

        boatModal.on('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
        });

        $(window).on('resize', function () {
            if ($(this).width() > 1199) {
                if (boatModal.hasClass('active')) {
                    boatModal.removeClass('active');
                }
                $('body').removeClass('active');
            }
        });

        if (navigator.userAgent.match(/(iPod|iPhone|iPad)/i)) {
            $('select').selectric({
                arrowButtonMarkup: '<svg xmlns="http://www.w3.org/2000/svg" width="11.07" height="3.778" viewBox="0 0 11.07 3.778">\n' +
                    '  <g id="choose_month_strelica" data-name="choose month strelica" transform="translate(0.675 0.675)">\n' +
                    '    <path id="Path_29" data-name="Path 29" d="M504,720l4.86,2.539,4.86-2.539" transform="translate(-504 -720)" fill="none" stroke="#414141" stroke-linecap="round" stroke-width="1"/>\n' +
                    '  </g>\n' +
                    '</svg>\n',
                disableOnMobile: false,
                nativeOnMobile: true,
            });
        } else {
            $('select').selectric({
                arrowButtonMarkup: '<svg xmlns="http://www.w3.org/2000/svg" width="11.07" height="3.778" viewBox="0 0 11.07 3.778">\n' +
                    '  <g id="choose_month_strelica" data-name="choose month strelica" transform="translate(0.675 0.675)">\n' +
                    '    <path id="Path_29" data-name="Path 29" d="M504,720l4.86,2.539,4.86-2.539" transform="translate(-504 -720)" fill="none" stroke="#414141" stroke-linecap="round" stroke-width="1"/>\n' +
                    '  </g>\n' +
                    '</svg>\n',
                disableOnMobile: false,
                nativeOnMobile: false
            });
        }


        var settings = {
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: false,
            dots: true,
            infinite: true,
            fade: true,
            rows: 0,


        };

        var sl = $('.card-header .show-l').not('.slick-initialized').slick(settings);

        inputErrorHandler();
    },
    contactInit: function (month=false) {
        UI.page = "booking";

        let modal = $('.contact-info-modal');

        $('.expand-info').on('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            $('body').addClass('active');
            modal.addClass('active');
            setTimeout(function () {
                modal.css('opacity', 1);
            }, 10);
        });

        $('body').on('click', function () {
            if (modal.hasClass('active')) {
                modal.removeClass('active');
                modal.css('opacity', 0);
            }
        });

        modal.on('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
        });

        $(window).on('resize', function () {
            if ($(this).width() > 1199) {
                if (modal.hasClass('active')) {
                    modal.removeClass('active');
                }
                $('body').removeClass('active');
            }
        });

        inputErrorHandler();
    },
    sendMail: function () {
        let form;
        if($form.length > 0){
            form = $($form);
        }else{
            form = false;
        }
        let overlay = $('.modal-overlay');
        $('input, textarea, select').each(function () {
            $(this).removeClass('error').siblings('.error-message').removeClass('error-show').removeAttr('style');
        });
        // console.log(serializeForm(form))
        // return;
        // overlay.addClass('active');

        $.ajax({
            type: 'POST',
            url: $sendUrl,
            data: serializeForm(form),
        }).done(function (data) {
            refreshReCaptchaV3('contact_recaptcha', 'contact_us');
            if (data.response == "error") {
                $.map(data.validator, function (val, key) {
                    form.find('input[name="'+key+'"], textarea[name="'+key+'"], select[name="'+key+'"]').addClass('error').siblings('.error-message').addClass('error-show');
                    if (key == "g-recaptcha-response") {
                        toastr.error('Security error: refresh the page!');
                    }
                    overlay.removeClass('active');
                });
            } else {
                toastr.success('Your email has been sent successfully!')
                refreshReCaptchaV3('contact_recaptcha', 'contact_us');
                overlay.removeClass('active');
                form.trigger('reset');
                $('.close-button').trigger('click');
            }
        }).fail(function (a, b, c) {
                refreshReCaptchaV3('contact_recaptcha', 'contact_us');
                overlay.removeClass('active');
            }
        )
    },
    checkInquiry:function(e) {
        e.preventDefault();
        let overlay = $('.modal-overlay');
        overlay.addClass('active');
        let errors=false;
        $('input, textarea').each(function () {
            $(this).removeClass('error').siblings('.error-message').removeClass('error-show').removeAttr('style');
        });
        $.ajax({
            type: 'POST',
            url: '/booking-inquiry/checkInquiry',
            data: serializeForm($('#form_step_2'))
        }).done(function (data) {
            // refreshReCaptchaV3('booking_recaptcha', 'contact_us');
            if (data.response == "error") {
                overlay.removeClass('active');
                errors=true;
                let msg=""
                $.map(data.validator, function (val, key) {
                    $('input[name="'+key+'"], textarea[name="'+key+'"]').addClass('error').siblings('.error-message').addClass('error-show');
                    if (key == "g-recaptcha-response") {
                        toastr.error('Security error: refresh the page!');
                    }
                });
            }
            else{
                e.target.submit();
            }
        });
    },
    newsletterControl: function(){
        let overlay = $('.modal-overlay');
        $('#newsletter_form input, #newsletter_form textarea').each(function () {
            $(this).removeClass('error').siblings('.error-message').removeClass('error-show').removeAttr('style');
        });
        overlay.addClass('active');
        $.ajax({
            type: 'POST',
            url: $newsletterUrl,
            data: serializeForm(news_id),
        }).done(function (data) {
          // refreshReCaptchaV3('newsletter_recaptcha', 'contact_us');
            if (data.response == "error") {
                $.map(data.validator, function (val, key) {
                    news_id.find('input[name="'+key+'"], textarea[name="'+key+'"]').addClass('error').siblings('.error-message').addClass('error-show');
                    if (key == "g-recaptcha-response") {
                        toastr.error('Security error: refresh the page!');
                    }
                    overlay.removeClass('active');
                });

                if(data.message){
                    toastr.error(data.message);
                    news_id.find('input[name="email"]').addClass('error');
                }
            } else {
              // refreshReCaptchaV3('newsletter_recaptcha', 'contact_us');
                overlay.removeClass('active');
                if(data.message){
                    toastr.success(data.message);
                    news_id.trigger('reset');
                }
            }
        }).fail(function (a, b, c) {
             //  refreshReCaptchaV3('newsletter_recaptcha', 'contact_us');
                overlay.removeClass('active');
            }
        )
    },
    clearSearch: function () {
        $('input#search-input').val('').trigger("keyup");
    },
    checkPeople: function(){
        let check=false;
        $("select").each(function(){
            if($(this).val()>0) check=true;
        })
        if(!check) toastr.error("Please select at least one cabin")
        return check;
    },
    formSubmit: function (id) {
        let priceForm = $('.priceForm'),
            idInput = priceForm.find('input[name="id"]');

        idInput.val(id);
        priceForm.find('button').trigger('click');
    },

    cookie_consent: function(accept_all = false) {
        $.ajax({
            url: route("cookie-consent"), type: "POST", data: {'accept_all': accept_all, '_token': $('.cookie-consent-modal input[name="_token"]').val()}
        }).done(function (response){
            console.log(response)
        }).fail(function (jqXhr, textStatus, errorThrown) {
            console.log(errorThrown);
        });
    }
};
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$(document).ready(function () {

    $('input[type="number"]').each(function () {
        $(this).onkeydown = function(e) {
            if(!((e.keyCode > 95 && e.keyCode < 106)
                || (e.keyCode > 47 && e.keyCode < 58)
                || e.keyCode == 8)) {
                return false;
            }
        };
    });

    // Select all links with hashes

    $('a.button.primary[href*="#prices"]')
    // Remove links that don't actually link to anything
        .not('[href="#"]')
        .not('[href="#0"]')
        .click(function (event) {
            // On-page links
            if (
                location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '')
                &&
                location.hostname == this.hostname
            ) {
                // Figure out element to scroll to
                var target = $(this.hash);
                target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
                // Does a scroll target exist?
                if (target.length) {
                    // Only prevent default if animation is actually gonna happen
                    event.preventDefault();
                    $('html, body').animate({
                        scrollTop: target.offset().top
                    }, 1000, function () {
                        // Callback after animation
                        // Must change focus!
                        var $target = $(target);
                        $target.focus();
                        if ($target.is(":focus")) { // Checking if the target was focused
                            return false;
                        } else {
                            $target.attr('tabindex', '-1'); // Adding tabindex for elements not focusable
                            $target.focus(); // Set focus again
                        }
                        ;
                    });
                }
            }
        });

    lightbox.option({
        "disableScrolling": true,
        "wrapAround": true,

    })
    $(".dropdown-trigger.manual").on("click", function (e) {
        e.preventDefault();
        e.stopPropagation();
        if ($(this).parent().find(".dropdown-content").is(":visible")) {
            $(".dropdown-content:visible").fadeOut();
            $(this).removeClass("active");
        } else {
            $(".dropdown-content:visible").fadeOut();
            $(this).parent().find(".dropdown-content").fadeIn();
            $(this).addClass("active");
            if ($(this).parent().hasClass("active")) $(this).children().find(".dropdown-content a").focus()
        }
    })
    $(".submenu-trigger").on("click", function (e) {
        e.preventDefault();
        e.stopPropagation();
        $("#" + $(this).data("target")).addClass("active");
    })
    $(".modal-trigger").on("click", function (e) {
        e.preventDefault();
        e.stopPropagation();
        $("#" + $(this).data("target") + ", body").addClass("active");
        $('#tawkchat-container').hide();
    })

    setTimeout(function () {
        $('#monthpicker-trigger').val($('.month-picker').val());
    }, 100)

    var monthPicker = $(".month-picker").monthpicker();
    var monthPickTrig = $('#monthpicker-trigger'),
        mainSearchBtn = $('#main_search button.primary');


    monthPicker.bind('monthpicker-click-month', function (e, month, year) {
        var mainPicker = $($(".month-picker"))
        mainPicker.monthpicker("setValue", $(this).data("monthpicker").settings)
        $("#monthpicker-trigger").val($(this).val())
        $("input[name=month]").val($(this).monthpicker("getDate"));
        $(".modal.active").children().find(".modal-close").trigger("click");
       // mainSearchBtn.trigger('click');
      //  console.log(e);
        if(e.target.id!="price-monthpicker") $('#main_search').submit();
    })

    mainSearchBtn.on('click', function (e) {
        if(monthPickTrig.val() == 'Choose month'){
            e.preventDefault();
            toastr.error('Please choose a month.');
        }
    });




    $(".price-picker").monthpicker();
    $('.price-picker').monthpicker().bind('monthpicker-click-month', function (e, month, year) {
        var price_date = $(this).monthpicker("getDate");
        var dates = $(this).data("monthpicker").settings.events_months
        // if (dates && dates.indexOf(price_date) == 0) $(".previous-month").addClass("disabled");
        // else $(".previous-month").removeClass("disabled")
        // if (dates && dates.indexOf(price_date) == dates.length - 1) $(".next-month").addClass("disabled");
        // else $(".next-month").removeClass("disabled")
        $(".price-list-item").each(function () {
            if ($(this).data("date").indexOf(price_date) === -1) {
                $(this).addClass("hide")
            } else {
                $(this).removeClass("hide")
            }
        })
    })





    var settings = {
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: false,
        dots: true,
        infinite: true,
        mobileFirst: true,
        rows: 0,
        responsive: [

            {
                breakpoint: 751,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2,
                }
            },
            {
                breakpoint: 1199,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3,
                }
            },
            {
                breakpoint: 1919,
                settings: {
                    slidesToShow: 4,
                    slidesToScroll: 4,
                }
            },
        ]
    };

    var sl = $('#featured_slider').not('.slick-initialized').slick(settings);

    var settings2 = {
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: false,
        dots: false,
        infinite: false,
        mobileFirst: true,
        rows: 0,
        responsive: [

            {
                breakpoint: 751,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2,
                }
            },
            {
                breakpoint: 1199,
                settings: {
                    arrows:true,
                    slidesToShow: 3,
                    slidesToScroll: 3,
                }
            },
            {
                breakpoint: 1919,
                settings: {
                    arrows:true,
                    slidesToShow: 3,
                    slidesToScroll: 3,
                }
            },
        ]
    };

    var sl2 = $('#gallery_slider').not('.slick-initialized').slick(settings2);

    $("input[name=ship_search]").on("change keyup", function () {
        $(".ship-item").each(function () {
            if ($(this).find(".title").text().toLowerCase().indexOf($("input[name=ship_search]").val()) === -1) {
                $(this).addClass("hide")
            } else {
                $(this).removeClass("hide")
            }
        })
    })
    let filtered = false;
    if($(window).width() < 769){
        if (filtered === false) {
            sl.slick('slickFilter', '.show-mobile');
            filtered = true;
        }
    }else{
        if(filtered === true) {
            sl.slick('slickUnfilter');
            filtered = false;
        }
    }
    $(window).on('resize', function () {
        if($(window).width() < 769){
            if (filtered === false) {
                sl.slick('slickFilter', '.show-mobile');
                filtered = true;
            }
        }else{
            if(filtered === true) {
                sl.slick('slickUnfilter');
                filtered = false;
            }
        }
    });



    $("input[name=destination_search]").on("change keyup", function () {
        $(".destination-item").each(function () {
            if ($(this).find(".title").text().toLowerCase().indexOf($("input[name=destination_search]").val()) === -1) {
                $(this).addClass("hide")
            } else {
                $(this).removeClass("hide")
            }
        })
    })
    $(window).on("click", function (e) {
        // if (!e.target.matches('.dropdown-trigger') && !e.target.matches('.dropdown-content')) {
        //     $(".dropdown-content:visible").fadeOut();
        // }
    })
    // $(window).on("load resize scroll", function() {
    //     $(".parallax").each(function() {
    //         var windowTop = $(window).scrollTop();
    //         var elementTop = $(this).offset().top;
    //         var leftPosition = elementTop - windowTop ;
    //         if(leftPosition<0)
    //             $(this).css({ backgroundPositionY: -1*leftPosition%50});
    //     });
    // });

    function onElementHeightChange(elm, callback) {
        var lastHeight = elm.clientHeight, newHeight;
        (function run() {
            newHeight = elm.clientHeight;
            if (lastHeight != newHeight)
                callback();
            lastHeight = newHeight;

            if (elm.onElementHeightChangeTimer)
                clearTimeout(elm.onElementHeightChangeTimer);

            elm.onElementHeightChangeTimer = setTimeout(run, 200);
        })();
    }


    onElementHeightChange(document.body, function () {
        if ($('.parallax-window').length > -1) {
            setTimeout(function () {
                $(".parallax-window").parallax({
                    calibrateX: true,
                    calibrateY: true
                });

                $(window).trigger('resize').trigger('scroll');
            }, 500);

            $(window).trigger('resize').trigger('scroll');
        }
    });
    let blogSection = $('.blog-section')
    if (blogSection.length > -1) {

        var blogSettings = {
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: true,
            dots: false,
            infinite: true,
            mobileFirst: true,
            rows: 0,
        };


        var blogs = blogSection.not('.slick-initialized').slick(blogSettings);

        blogSection.find('.arrow-prev').on('click', function () {
            blogSection.find('.slick-prev').click();
        });
        blogSection.find('.arrow-next').on('click', function () {
            blogSection.find('.slick-next').click();
        });

    }


    news_id.find('.button').on('click', function (e) {
        e.preventDefault();
        inputErrorHandler();
        UI.newsletterControl();
    });

    let cookieModal = $('.cookie-consent-modal');

    $('.cookie-consent-buttons button, .cookie-consent-modal .close-button').on('click', function (e) {
        if(cookieModal.is(':visible') && $(this).hasClass('all')) {
            UI.cookie_consent(true);
        }else if(cookieModal.is(':visible')){
            UI.cookie_consent(false);
        }
        cookieModal.addClass('scale-out-br');
        setTimeout(function () {
            cookieModal.addClass('hide')
        }, 500);
    });

    let cookieUpdateBtn = $('.consent-update-button');

    cookieUpdateBtn.on('click', function () {
        cookieModal.removeClass('hide scale-out-br').removeAttr('style');
    });
})

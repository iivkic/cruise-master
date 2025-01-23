import $ from "jquery";
import moment from 'moment';

window.mtz_methods = {
    init: function (options) {

        return this.each(function () {
            var
                $this = $(this),
                data = $this.data('monthpicker'),
                month = (new Date()).getMonth(),
                year = (options && options.year) ? options.year : (new Date()).getFullYear(),
                events = (options && options.events) ? options.events : null,
                customPattern='mmm yyyy',
                settings = $.extend({
                    pattern: customPattern,
                    selectedMonth: null,
                    inline: false,
                    selectedMonthName: '',
                    selectedFullMonthName: '',
                    selectedYear: month < 10 ? year : year+1,
                    startYear: year,
                    finalYear: year + 2,
                    monthNames: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                    monthFullNames: ["January", "February", "March", "April", "May", "June",
                        "July", "August", "September", "October", "November", "December"
                    ],
                    id: "monthpicker_" + (Math.random() * Math.random()).toString().replace('.', ''),
                    openOnFocus: true,
                    events: events,
                    events_dates:null,
                    disabledMonths: {}
                }, options);

            settings.dateSeparator = settings.pattern.replace(/(mmmm|mmm|mm|m|yyyy|yy|y)/ig, '');

            // If the plugin hasn't been initialized yet for this element
            if (!data) {
                $(this).data('monthpicker', {
                    'target': $this,

                    'settings': settings
                });

                if (settings.openOnFocus === true) {
                    $this.on('focus', function () {
                        $this.monthpicker('show');
                    });
                }

                $this.monthpicker('parseInputValue', settings);
                $this.monthpicker('mountWidget', settings);

                $this.monthpicker('setValue', settings);

                $this.on('monthpicker-click-month', function (e, month, year) {
                    $this.monthpicker('setValue', settings);
                    if (!settings.inline) $this.monthpicker('hide');
                });

                // hide widget when user clicks elsewhere on page
                $this.addClass("mtz-monthpicker-widgetcontainer");
                if (!settings.inline) {
                    $(document).unbind("mousedown.mtzmonthpicker").on("mousedown.mtzmonthpicker", function (e) {

                        if ((!e.target.className || e.target.className.toString().indexOf('mtz-monthpicker') < 0) && (!e.target.className.baseVal || e.target.className.baseVal.toString().indexOf('mtz-monthpicker') < 0)) {
                            $(this).monthpicker('hideAll');
                        }
                    });
                } else {
                    $this.monthpicker('show');
                }
            }
        });
    },

    show: function () {
        $(this).monthpicker('hideAll');
        var widget = $('#' + this.data('monthpicker').settings.id);
        // widget.css("top", this.offset().top  + this.outerHeight());
        // if ($(window).width() > (widget.width() + this.offset().left) ){
        //     widget.css("left", this.offset().left);
        // } else {
        //     widget.css("left", this.offset().left - widget.width());
        // }
        widget.show();
        widget.addClass("active")
        widget.find('select').focus();
        this.trigger('monthpicker-show');
    },

    hide: function () {
        var widget = $('#' + this.data('monthpicker').settings.id);
        if (widget.is(':visible')) {
            widget.removeClass("active")
            setTimeout(() => {
                widget.hide()
            }, 200);

            // this.trigger('monthpicker-hide');
        }
    },

    hideAll: function () {
        $(".mtz-monthpicker-widgetcontainer").each(function () {
            if (typeof ($(this).data("monthpicker")) != "undefined" && !$(this).data("monthpicker").settings.inline) {
                $(this).monthpicker('hide');
            }
        });
    },

    setValue: function (settings) {

        var
            month = settings.selectedMonth,
            year = parseInt(settings.selectedYear);
        if (!month || !year) {
            this.val("");
            return;
        }
        settings.selectedMonthName = settings.monthNames[month - 1];
        settings.selectedFullMonthName = settings.monthFullNames[month - 1];
        if(settings.pattern.indexOf('mmmm') >= 0) {
            month = settings.selectedFullMonthName;
        }

        else if(settings.pattern.indexOf('mmm') >= 0) {
            month = settings.selectedMonthName;
        } else if(settings.pattern.indexOf('mm') >= 0 && settings.selectedMonth < 10) {
            month = '0' + settings.selectedMonth;
        }

        if(settings.pattern.indexOf('yyyy') < 0) {
            year = year.toString().substr(2,4);
        }

        if (settings.pattern.indexOf('y') > settings.pattern.indexOf(settings.dateSeparator)) {
            this.val(month + settings.dateSeparator + year);
        } else {
            this.val(year + settings.dateSeparator + month);
        }


        this.data('monthpicker').settings.selectedMonth=settings.selectedMonth;
        this.data('monthpicker').settings.selectedYear=settings.selectedYear;
        $(this).parent().find("input[name=month]").val($(this).monthpicker("getDate"))
        this.change();
    },

    disableMonths: function (months) {
        // console.log("ovo cu disejblat", months)
        var
            settings = this.data('monthpicker').settings,
            container = $('#' + settings.id);

        settings.disabledMonths = months;
        // console.log('kurcina', months)

        container.find('.mtz-monthpicker-month').each(function () {
            var m = parseInt($(this).data('month'));
            if ($.inArray(m, months) >= 0) {
                // console.log("ovo je bas u funkciji?")
                $(this).addClass('ui-state-disabled');
            } else {
                $(this).removeClass('ui-state-disabled');
            }
        });
    },

    mountWidget: function (settings) {
        var
            monthpicker = this,
            container = $('<div id="' + settings.id + '" class="ui-datepicker ui-widget ui-widget-content ui-helper-clearfix ui-corner-all mtz-monthpicker" />'),
            header = $('<div class="ui-datepicker-header ui-widget-header ui-helper-clearfix ui-corner-all mtz-monthpicker" />'),
            title = $('<div class="mtz-monthpicker mtz-header"></div>'),
            prev = $('<svg class="mtz-monthpicker arrow2 arrow_prev" xmlns="http://www.w3.org/2000/svg" width="23.414" height="17.414" viewBox="0 0 23.414 17.414">\n' +
                '\n' +
                '    <g class="mtz-monthpicker" transform="translate(-14.586 -27.293)">\n' +
                '        <path class="mtz-monthpicker" style="fill:none;stroke:#1D374F;;stroke-width:2px;" d="M2798.638-72.778l-8,8,8,8" transform="translate(-2774.638 100.777)"/>\n' +
                '        <line class="mtz-monthpicker" style="fill:none;stroke:#1D374F;;stroke-width:2px;" x2="22" transform="translate(16 36)"/>\n' +
                '    </g>\n' +
                '</svg>'),
            next = $('<svg class="mtz-monthpicker arrow2 arrow_next" xmlns="http://www.w3.org/2000/svg" width="23.414" height="17.414" viewBox="0 0 23.414 17.414">\n' +
                '\n' +
                '    <g class="mtz-monthpicker" transform="translate(-14.586 -27.293)">\n' +
                '        <path class="mtz-monthpicker" style="fill:none;stroke:#1D374F;;stroke-width:2px;" d="M2798.638-72.778l-8,8,8,8" transform="translate(-2774.638 100.777)"/>\n' +
                '        <line class="mtz-monthpicker" style="fill:none;stroke:#1D374F;;stroke-width:2px;" x2="22" transform="translate(16 36)"/>\n' +
                '    </g>\n' +
                '</svg>'),
            combo = $('<input readonly  type="text" class="mtz-monthpicker mtz-monthpicker-year" />'),
            table = $('</div><table class="mtz-monthpicker" />'),
            tbody = $('<tbody class="mtz-monthpicker" />'),
            tr = $('<tr class="mtz-monthpicker" />'),
            td = '',
            selectedYear = settings.selectedYear,
            option = null,
            attrSelectedYear = $(this).data('selected-year'),
            attrStartYear = $(this).data('start-year'),
            attrFinalYear = $(this).data('final-year'),
            attrInline = $(this).data('inline'),
            attrEvents = $(this).data('events');

        if (attrSelectedYear) {
            settings.selectedYear = attrSelectedYear;
        }
        if (attrInline) {
            settings.inline = attrInline;
        }

        if (attrStartYear) {
            settings.startYear = attrStartYear;
        }

        if (attrFinalYear) {
            settings.finalYear = attrFinalYear;
        }

        if (settings.inline) {
            container.css({
                zIndex: 999,
                whiteSpace: 'nowrap',
                maxWidth: '250px',
                overflow: 'hidden',
                textAlign: 'center',
                display: 'block',
                margin: "0 auto",
                padding: "27px 0",
                border: "none"
            });
            monthpicker.css({
                display: "none"
            })
        } else {
            container.css({
                position: 'absolute',
                zIndex: 999999,
                whiteSpace: 'nowrap',
                width: '100%',
                overflow: 'hidden',
                textAlign: 'center',
                display: 'none',
                left: 0
            });
        }

        if (settings.selectedYear == settings.startYear) prev.addClass("disabled")
        if (settings.selectedYear == settings.finalYear) next.addClass("disabled")
        if (attrEvents) {
            var temp_events = attrEvents.map(function (a) {
                return a.date
            }).sort(function (a, b) {
                a=a.replace(/ /g,"T")
                b=b.replace(/ /g,"T")
                a = new Date(a);
                b = new Date(b);
                return a < b ? -1 : a > b ? 1 : 0;
            })
            var temp_years = temp_events.map(function (a) {
                return new Date(a.replace(/ /g,"T")).getFullYear()
            }).filter(function (el, index, arr) {
                return index == arr.indexOf(el);
            });
            var temp_months = {};
            temp_years.forEach((year) => {
                temp_months[year.toString()] = temp_events.filter(function (a) {
                    return a.indexOf(year) > -1
                }).map(a => parseInt(a.substr(5, 2))).filter(function (el, index, arr) {
                    return index == arr.indexOf(el);
                }).sort(function (a, b) {
                    return a < b ? -1 : a > b ? 1 : 0;
                });
            })
            settings.startYear = temp_years[0];
            settings.finalYear = temp_years[temp_years.length - 1];
            settings.events_months=temp_events.map(function (a) {
                return a.substr(0,7)
            }).filter(function (el, index, arr) {
                return index == arr.indexOf(el);
            });
            settings.events = temp_months;
        }
        combo.on('change', function () {

            var months = $(this).parent().parent().parent().find('td[data-month]');
            months.removeClass('ui-state-active');
            var year_temp = $(this).val();
            if (settings.events) {
                months.each(function () {
                    if ($.inArray($(this).data("month"), settings.events[year_temp]) >= 0) {
                        $(this).removeClass("ui-state-disabled")
                    } else $(this).addClass("ui-state-disabled")
                })
            }
            $("table.mtz-monthpicker").fadeTo("fast", 0, function () {
                $(this).fadeTo("slow", 1)
            });
            if ($(this).val() == settings.selectedYear) {
                months.filter('td[data-month=' + settings.selectedMonth + ']').addClass('ui-state-active');
            }
            if (settings.startYear == $(this).val()) prev.addClass("disabled")
            if (settings.finalYear == $(this).val()) next.addClass("disabled")
            if ($(this).val() != settings.startYear) prev.removeClass("disabled")
            if ($(this).val() != settings.finalYear) next.removeClass("disabled")
            monthpicker.trigger('monthpicker-change-year', $(this).val());
        });
        prev.on("click", function () {
            if ($(this).hasClass("disabled")) return;
            combo.val(combo.val() - 1);
            combo.trigger("change");
        })
        next.on("click", function () {
            if ($(this).hasClass("disabled")) return;
            combo.val(combo.val() * 1 + 1);
            combo.trigger("change");
        })

        // mount years combo
        // for (var i = settings.startYear; i <= settings.finalYear; i++) {
        //     var option = $('<option class="mtz-monthpicker" />').attr('value', i).append(i);
        //     if (settings.selectedYear == i) {
        //         option.attr('selected', 'selected');
        //     }
        //     combo.append(option);
        // }
        combo.val(settings.selectedYear)
        title.append(prev).append(combo).append(next)
        header.append(title).appendTo(container);

        // mount months table
        for (var i = 1; i <= 12; i++) {
            td = $('<td class="ui-state-default mtz-monthpicker mtz-monthpicker-month" style="padding:5px;cursor:default;" />').attr('data-month', i);
            if (settings.selectedMonth == i) {
                td.addClass('ui-state-active');
            }
            if (settings.events) {
                if ($.inArray(i, settings.events[settings.selectedYear]) >= 0) {
                    td.removeClass('ui-state-disabled');
                } else {
                    td.addClass('ui-state-disabled');
                }
            }
            td.append(settings.monthNames[i - 1]);
            tr.append(td).appendTo(tbody);
            if (i % 3 === 0) {
                tr = $('<tr class="mtz-monthpicker" />');
            }
        }

        tbody.find('.mtz-monthpicker-month').on('click', function () {
            var m = parseInt($(this).data('month'));
            if (!$(this).hasClass("ui-state-disabled")) {
                settings.selectedYear = $(this).closest('.ui-datepicker').find('.mtz-monthpicker-year').first().val();
                settings.selectedMonth = $(this).data('month');
                settings.selectedMonthName = $(this).text();
                settings.selectedFullMonthName = settings.monthFullNames[m - 1];
                monthpicker.trigger('monthpicker-click-month', [$(this).data('month'), settings.selectedYear]);
                $(this).closest('table').find('.ui-state-active').removeClass('ui-state-active');
                $(this).addClass('ui-state-active');
            }
        });

        table.append(tbody).appendTo(container);

        container.appendTo(monthpicker.parent()[0]);

    },

    destroy: function () {
        return this.each(function () {
            $(this).removeClass('mtz-monthpicker-widgetcontainer').unbind('focus').removeData('monthpicker');
        });
    },

    getDate: function () {
        var settings = this.data('monthpicker').settings;
        if (settings.selectedMonth && settings.selectedYear) {
            return settings.selectedYear + "-" + (settings.selectedMonth < 10 ? "0" + settings.selectedMonth : settings.selectedMonth);
        } else {
            return null;
        }
    },
    nextMonth: function (target) {

        var settings = this.data('monthpicker').settings;
        if (settings.events) {
            var index = settings.events[settings.selectedYear].indexOf(settings.selectedMonth);
            if (index < settings.events[settings.selectedYear].length - 1) {
                settings.selectedMonth = settings.events[settings.selectedYear][index + 1]
            } else if(index == settings.events[settings.selectedYear].length - 1){
                settings.selectedMonth = settings.events[settings.startYear][0]
            } else if (settings.events[settings.selectedYear * 1 + 1]) {
                settings.selectedYear = settings.selectedYear * 1 + 1;
                settings.selectedMonth = settings.events[settings.selectedYear][0]
            } else {
                return;
            }
        } else {
            settings.selectedMonth = settings.selectedMonth % 12 + 1
            settings.selectedYear = settings.selectedMonth % 12 == 1 ? settings.selectedYear * 1 + 1 : settings.selectedYear;
        }
        $(this).trigger('monthpicker-click-month', [settings.selectedMonth, settings.selectedYear]);
    },
    previousMonth: function (target) {
        var settings = this.data('monthpicker').settings;
        if (settings.events) {
            var index = settings.events[settings.selectedYear].indexOf(settings.selectedMonth);
            if (index !==0) {
                settings.selectedMonth = settings.events[settings.selectedYear][index - 1]
            } else if(index == 0){
                settings.selectedMonth = settings.events[settings.selectedYear][settings.events[settings.finalYear].length - 1]
            } else if (settings.events[settings.selectedYear - 1]) {
                settings.selectedYear = settings.selectedYear - 1;
                settings.selectedMonth = settings.events[settings.selectedYear][settings.events[settings.selectedYear].length-1]
            } else {
                return;
            }
        } else {
            settings.selectedYear = settings.selectedMonth - 1 == 0 ? settings.selectedYear * 1 - 1 : settings.selectedYear;
            settings.selectedMonth = settings.selectedMonth - 1 == 0 ? 12 : settings.selectedMonth - 1;
        }
        $(this).trigger('monthpicker-click-month', [settings.selectedMonth, settings.selectedYear]);
    },

    parseInputValue: function (settings) {

        if (this.val()) {

            if (settings.dateSeparator) {
                var val = this.val().toString().split(settings.dateSeparator);

                if (settings.pattern.indexOf('m') === 0) {
                    settings.selectedMonth = val[0];
                    settings.selectedYear = val[1];
                } else {
                    settings.selectedMonth = val[1];
                    settings.selectedYear = val[0];
                }



            }
            var m = parseInt(settings.selectedMonth);

            if ($.inArray(m, settings.disabledMonths) < 0 ) {
                // settings.selectedYear = $(this).closest('.ui-datepicker').find('.mtz-monthpicker-year').first().val();
                settings.selectedMonth = m;
                settings.selectedMonthName = $(this).text();
                settings.selectedFullMonthName = settings.monthFullNames[m - 1];
            }
        }
        // else{
        //     settings.selectedYear=new Date().getFullYear();
        //     settings.selectedMonth=new Date().getMonth()+1;
        //     settings.selectedFullMonthName = settings.monthFullNames[settings.selectedMonth - 1];
        // }
    },

    // search: function (i) {
    //
    //     var my = $("#m-"+i).val();
    //
    //     console.log(my);
    //
    //
    // }



}
;
window.$.fn.monthpicker = function (method) {
    if (mtz_methods[method]) {
        return mtz_methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
    } else if (typeof method === 'object' || !method) {
        return mtz_methods.init.apply(this, arguments);
    } else {
        $.error('Method ' + method + ' does not exist on jQuery.mtz.monthpicker');
    }
};

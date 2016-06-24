var $ = require("jquery");
var moment = require("moment");
var _ = require("lodash");
var modernizr = require("modernizr");

$.widget("cawa.fields-datetime", $.cawa.widget, {

    options: {
        plugin: {
            locale: $.locale(),
            // stepping: 15,
            showTodayButton: true,
            showClose: true,
            sideBySide: false,
            widgetParent: 'body'
        }
    },

    _create: function() {
        // Disabled on touch & non supported device
        if (modernizr.touchevents) {
            return;
        }

        var name = this.element.attr("name");
        var inputHidden = $('<input />').attr('type', 'hidden').attr('name', name);
        inputHidden.insertBefore(this.element);

        var type = "datetime";

        // input type date, reduce picker format to date
        if (this.element.attr("type") == "date") {
            this.options.plugin.format = moment().localeData().longDateFormat('L');

            type = "date";
        } else if (this.element.attr("type") == "time") {
            this.options.plugin.format = moment().localeData().longDateFormat('LT');
            this.options.plugin.showTodayButton = false;

            type = "time";
        }

        // required
        if (!this.element.prop("required")) {
            this.options.plugin.showClear = true;
        }

        // linked
        if (this.options.minSelector) {
            this.options.plugin.useCurrent = false;
        }

        // default value
        var datepickerOptions = $.extend(true, {}, this.options.plugin);

        if (this.element.attr("value")) {
            var defaultValue;

            if (type == "time") {
                defaultValue = moment("1970-01-01 " + this.element.attr("value"), "YYYY-MM-DD hh:mm:ss");
            } else {
                defaultValue = moment(this.element.attr("value"), "YYYY-MM-DD hh:mm:ss");
            }

            datepickerOptions = $.extend(true, {}, datepickerOptions, {defaultDate: defaultValue});
        }

        // events
        this.element.bind('dp.change', function (jqEvent)
        {
            var val;
            if (type == "date") {
                val = (jqEvent.date && !_.isNull(jqEvent.date) ? jqEvent.date.format('YYYY-MM-DD') : '');
            } else if (type == "time") {
                val = (jqEvent.date && !_.isNull(jqEvent.date) ? jqEvent.date.format('HH:mm:ss') : '');
            } else {
                val = (jqEvent.date && !_.isNull(jqEvent.date) ? jqEvent.date.format('YYYY-MM-DD HH:mm:ss') : '');
            }

            inputHidden.val(val);
        });

        this.element.bind('dp.error', function ()
        {
            inputHidden.val('');
        });

        // position
        $('body').css('position', 'relative');
        this.element.on('dp.show', function (event)
        {
            var datepicker = $("body").find('.bootstrap-datetimepicker-widget:last');
            var top = $(this).offset().top + $(this).outerHeight();
            var left = $(this).offset().left;
            datepicker.css({
                'z-index': 1100,
                'top': top + 'px',
                'left': left + 'px',
                'bottom': 'auto',
                'right': 'auto'
            });
        });


        // input modification
        if (this.element.attr("type") != "text") {
            this.element.attr("data-type", this.element.attr("type"));
            this.element.attr("type", "text");
        }

        this.element.removeAttr("name");
        this.element.removeAttr("value");

        /* plugin */
        this.element.datetimepicker(datepickerOptions);
        this.element.closest(".cawa-fields-datetime-group").addClass("init");

        // linked events
        if (this.options.minSelector) {

            var min = $(this.options.minSelector);
            var max = this.element;

            $(document).on("dp.change", min, function (e) {
                if (max.data("DateTimePicker")) {
                    max.data("DateTimePicker").minDate(e.date);
                }
            });

            $(document).on("dp.change", max, function (e) {
                if (min.data("DateTimePicker")) {
                    min.data("DateTimePicker").maxDate(e.date);
                }
            });

            setTimeout(function()
            {
                max.data("DateTimePicker").minDate(min.data("DateTimePicker").date());
                min.data("DateTimePicker").maxDate(max.data("DateTimePicker").date());
            }, 100);
        }
    }
});


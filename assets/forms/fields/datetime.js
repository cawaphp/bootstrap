require([
    "jquery",
    "moment",
    "modernizr",
    "cawaphp/cawa/assets/widget",
    "datetimepicker/build/jquery.datetimepicker.full"
], function($, moment, _, modernizr)
{
    $.widget("cawa.fields-datetime", $.cawa.widget, {

        options: {
            plugin: {
                lazyInit: false,
                scrollMonth : false
            }
        },

        _create: function() {
            var options = this.options.plugin;
            var element = this.element;

            // Disabled on touch & non supported device
            if (window.Modernizr.touchevents) {
                element.closest(".cawa-fields-datetime-group").addClass("init");
                return;
            }

            var name = element.attr("name");
            var inputHidden = $('<input />').attr('type', 'hidden').attr('name', name);
            inputHidden.insertBefore(element);

            var type = "datetime";

            // formatting
            options.formatTime = moment().localeData().longDateFormat('LT');
            options.formatDate = moment().localeData().longDateFormat('L');

            if (element.attr("type") == "date") {
                options.timepicker = false;
                options.format = moment().localeData().longDateFormat('L');
                type = "date";
            } else if (element.attr("type") == "time") {
                options.datepicker = false;
                var minDate = new Date();
                minDate.setHours(0);
                minDate.setMinutes(0);
                minDate.setSeconds(0);
                minDate.setMilliseconds(0);
                options.defaultTime = '00:00';
                options.minDate = minDate;
                options.format = moment().localeData().longDateFormat('LT');
                type = "time";
            } else {
                options.format = moment().localeData().longDateFormat('LLL');
            }

            // l18n
            options.hours12 = moment().localeData().longDateFormat('LLLL').indexOf('A') > 0;
            options.dayOfWeekStart = moment().localeData().firstDayOfWeek();

            // required
            if (!element.prop("required")) {
                options.allowBlank = true;
            }

            // default value
            if (element.attr("value")) {
                var currentVal;
                if (type == 'time') {
                    currentVal = moment("1970-01-01 " + element.attr("value"), "YYYY-MM-DDThh:mm:ss");
                } else {
                    currentVal = moment(element.attr("value"), "YYYY-MM-DDThh:mm:ss");
                }

                options.value = currentVal.format(options.format);
                element.attr("value", options.value);
            } else {
                options.defaultDate = false;
            }

            // allowDates formatting
            if (this.options.allowDates) {
                options.allowDates = [];
                $.each(this.options.allowDates, function(key, value)
                {
                    options.allowDates.push(moment(value).format(options.formatDate));
                });
            }

            // minDate formatting
            if (this.options.minDate) {
                options.minDate = moment(this.options.minDate).format(options.formatDate);
            }

            // highlightedDates formatting
            if (this.options.highlightedDates) {
                options.highlightedDates = [];
                $.each(this.options.highlightedDates, function(key, value)
                {
                    options.highlightedDates.push(moment(value).format(options.formatDate));
                });
            }


            // events
            options.onChangeDateTime = function(datepicker, input)
            {
                var val = moment(input.val(), options.format);

                if (!val.isValid()) {
                    inputHidden.val('');
                } else {

                    var hiddenVal;
                    if (type == "date") {
                        hiddenVal = val.format('YYYY-MM-DD');
                    } else if (type == "time") {
                        hiddenVal = val.format('HH:mm:ss');
                    } else {
                        hiddenVal = val.format('YYYY-MM-DD HH:mm:ss');
                    }

                    inputHidden.val(hiddenVal);
                    inputHidden.trigger('change');
                }
            };

            // input modification
            element.attr("data-type", element.attr("type"));
            element.attr("type", "text");

            element.removeAttr("name");

            /* plugin */
            element.datetimepicker(options);
            element.datetimepicker('validate');
            element.closest(".cawa-fields-datetime-group").addClass("init");

            // linked events
            if (this.options.linkedMin) {

                var min = $(this.options.linkedMin);
                var max = $(element);

                min.on("change", function (e) {
                    if (type == "time") {
                        max.datetimepicker('setOptions', {minTime: min.datetimepicker('getValue')});
                    } else {
                        max.datetimepicker('setOptions', {minDate: min.datetimepicker('getValue')});
                    }
                });

                max.on("change", function (e) {
                    if (type == "time") {
                        min.datetimepicker('setOptions', {minTime: max.datetimepicker('getValue')});
                    } else {
                        min.datetimepicker('setOptions', {maxDate: max.datetimepicker('getValue')});
                    }
                });
            }

            // ugly hack for inline
            if (options.inline == true) {
                element.parent().find('.xdsoft_next').trigger('touchend');
                element.parent().find('.xdsoft_prev').trigger('touchend');

                if (!element.attr("value")) {
                    window.setTimeout(function()
                    {
                        element.parent().find('.xdsoft_current').removeClass('xdsoft_current');
                    }, 10);
                }
            }
        },

        _destroy: function()
        {
            this._super();
            this.element.datetimepicker('destroy');
        }
    });
});

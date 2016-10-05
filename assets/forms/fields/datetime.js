require([
    "jquery",
    "moment",
    "lodash",
    "modernizr",
    "cawaphp/cawa/assets/widget",
    "datetimepicker/build/jquery.datetimepicker.full"
], function($, moment, _, modernizr)
{
    $.widget("cawa.fields-datetime", $.cawa.widget, {

        options: {
            plugin: {
                lazyInit: false
            }
        },

        _create: function() {
            var options = this.options.plugin;

            // Disabled on touch & non supported device
            if (modernizr.touchevents) {
                return;
            }

            var name = this.element.attr("name");
            var inputHidden = $('<input />').attr('type', 'hidden').attr('name', name);
            inputHidden.insertBefore(this.element);

            var type = "datetime";

            // formatting
            options.formatTime = moment().localeData().longDateFormat('LT');
            options.formatDate = moment().localeData().longDateFormat('L');

            if (this.element.attr("type") == "date") {
                options.timepicker = false;
                options.format = moment().localeData().longDateFormat('L');
                type = "date";
            } else if (this.element.attr("type") == "time") {
                options.datepicker = false;
                options.step = 5;
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

            // weekdays disabled
            if (this.options.disabledWeekdays) {
                options.disabledWeekDays = this.options.disabledWeekdays;
            }

            // required
            if (!this.element.prop("required")) {
                options.allowBlank = true;
            }

            // default value
            if (this.element.attr("value")) {
                var currentVal;
                if (type == 'time') {
                    currentVal = moment("1970-01-01 " + this.element.attr("value"), "YYYY-MM-DDThh:mm:ss");
                } else {
                    currentVal = moment(this.element.attr("value"), "YYYY-MM-DDThh:mm:ss");
                }

                options.value = currentVal.format(options.format);
                this.element.attr("value", options.value);
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
            this.element.attr("data-type", this.element.attr("type"));
            this.element.attr("type", "text");

            this.element.removeAttr("name");

            /* plugin */
            this.element.datetimepicker(options);
            this.element.datetimepicker('validate');
            this.element.closest(".cawa-fields-datetime-group").addClass("init");

            // linked events
            if (this.options.linkedMin) {

                var min = $(this.options.linkedMin);
                var max = $(this.element);

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
        },

        _destroy: function()
        {
            this.element.datetimepicker('destroy');
        }
    });
});

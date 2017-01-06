require([
    "jquery",
    "cawaphp/cawa/assets/widget"
], function ($)
{
    $.widget("cawa.fields-number", $.cawa.widget, {
        _create: function ()
        {
            var self = this;
            var element = this.element;
            var input = element.find('input[type="number"]');
            var step = Number(input.attr('step') || 1);

            element.find('.input-group-btn button').on('click', function (event)
            {
                event.preventDefault();
                var button = $(this);

                var val = Number(input.val());
                if (button.data('action') === '+') {
                    val += step;
                } else {
                    val -= step;
                }

                input.val(val);
                input.trigger('change');
                self._disableButton();
            });

            self._disableButton();
        },

        _disableButton: function ()
        {
            var input = this.element.find('input[type="number"]');
            var step = Number(input.attr('step') || 1);
            var min = input.attr('min') ?  Number(input.attr('min')) : null;
            var max = input.attr('max') ? Number(input.attr('max')) : null;
            var val = Number(input.val());

            var minus = this.element.find('.input-group-btn button[data-action="-"]');
            var plus = this.element.find('.input-group-btn button[data-action="+"]');

            if (min && val - step < min) {
                minus.prop('disabled', true);
            } else {
                minus.prop('disabled', false);
            }

            if (max && val + step > max) {
                plus.prop('disabled', true);
            } else {
                plus.prop('disabled', false);
            }
        }
    });
});



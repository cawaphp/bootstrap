require([
    "jquery",
    "cawaphp/cawa/assets/widget"
], function($)
{
    $.widget("cawa.fields-multiple-group", $.cawa.widget, {
        _create: function() {
            var element = $(this.element);

            this._addListeners(element);
            this._disabledFirstRow();
        },

        _addListeners: function(element)
        {
            var self = this;

            element.find("a[data-action='+']").on("click", $.proxy(self._onPlus, self));
            element.find("a[data-action='-']").on("click", $.proxy(self._onMinus, self));
        },

        _disabledFirstRow: function()
        {
            var element = $(this.element);
            element.find("a[data-action='-']").prop("disabled", "");

            if (element.find("a[data-action='-']").length == 1) {
                element.find("a[data-action='-']").first().prop("disabled", "disabled");
            }
        },

        _onPlus: function(event)
        {
            event.preventDefault();

            var clone = $(this.options.clone);
            var finalClone = clone.find(".cawa-fields-multiple-group .input-group").first();

            // clear value
            var inputs = finalClone.find('input, select');

            inputs
                .not('[type="checkbox"]')
                .not('[type="radio"]')
                .val('');

            finalClone.find('input[type="checkbox"], input[type="radio"]')
                .prop('checked', false);

            // handle id & label
            inputs.each(function(key, value) {
                value = $(value);
               if (value.attr('id')) {
                   var uid = 'uid-' + Math.round(Math.random() * Math.pow(10, 10));
                   var label = finalClone.find('label[for="' + value.attr('id') + '"]');

                   if (label) {
                       label.attr('for', uid);
                   }

                   value.attr('id', uid);
               }
            });

            this._addListeners(finalClone);

            this.element.append(finalClone);

            $(document).trigger("cw.refresh");

            this._disabledFirstRow();
        },

        _onMinus: function(event)
        {
            event.preventDefault();

            var element = $(this.element);
            var length = element.find(".input-group").length;
            var remove = $(event.target).closest(".input-group");

            if (length > 1) {
                remove.remove();
            }

            this._disabledFirstRow();
        }
    });
});

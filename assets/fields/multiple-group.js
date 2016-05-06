var $ = require("jquery");

$.widget("cawa.fields-multiple-group", $.cawa.widget, {
    _create: function() {
        var element = $(this.element);

        this._addListeners(element);
        this._disabledFirstRow();
    },

    _addListeners: function(element)
    {
        var self = this;

        element.find("button[data-action='+']").on("click", $.proxy(self._onPlus, self));
        element.find("button[data-action='-']").on("click", $.proxy(self._onMinus, self));
    },

    _disabledFirstRow: function()
    {
        var element = $(this.element);
        element.find("button[data-action='-']").prop("disabled", "");

        if (element.find("button[data-action='-']").length == 1) {
            element.find("button[data-action='-']").first().prop("disabled", "disabled");
        }
    },

    _onPlus: function(event)
    {
        event.preventDefault();

        var clone = $(this.options.clone);
        var finalClone = clone.find(".cawa-fields-multiple-group .input-group").first();

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
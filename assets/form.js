var $ = require("jquery");

$.widget("cawa.form", $.cawa.widget, {

    options:
    {
        plugins: {
            focusCleanup : false,
            focusInvalid : true,

            // bootstrap
            errorElement: "span",
            errorClass: "help-block has-error",
            validClass: "has-success"
        }
    },

    _initOptions: function()
    {
        var self = this;

        return {
            plugins: {
                onfocusout : $.proxy(self._elementFocusOut, self),
                onclick : $.proxy(self._elementClick, self),
                onkeyup : $.proxy(self._elementKeyUp, self),

                highlight: self._highlightError,
                unhighlight: self._unhighlightError,
                success: self._highlightSuccess,
                errorPlacement: self._errorPlacement,
                submitHandler: $.proxy(self._submit, self)
            }
        };
    },

    _elementFocusOut: function (element, event)
    {
        $.validator.defaults.onfocusout.apply(this.validator, arguments);
    },

    _elementClick: function (element, event)
    {
        $.validator.defaults.onclick.apply(this.validator, arguments);
    },

    _elementKeyUp: function (element, event)
    {
        if (event.keyCode === 9 && this.validator.elementValue(element) === "")
        {
          return false;
        }

        $.validator.defaults.onkeyup.apply(this.validator, arguments);
    },

    validator : null,

    _create: function()
    {
        var element = $(this.element);
        element.validate(this.options.plugins);
        this.validator = this.element.data('validator');

        var first = element.find(":input:enabled:visible:first").first();
        var type = first.attr("data-type") ? first.attr("data-type") : first.attr("type");

        if (type != "time" && type != "date" && type != "datetime-local") {
            first.focus();
        }
    },


    _submit: function (element)
    {
        element = $(element);
        var self = this;

        element.find(":submit").prop('disabled', 'disabled');

        return $.proxy(self._submitRequest, self)();
    },

    _submitRequest: function()
    {
        return true;
    },

    _highlightSuccess: function (element, errorClass, validClass)
    {
        var hightlight = null;
        if (element.parent('.checkbox').length || element.parent('.radio').length) {
            hightlight = $(element).parent();
        } else if ($(element).prev(".input-group").length) {
            hightlight = $(element).prev(".input-group");
        } else {
            hightlight = $(element)
                .closest('.form-group');
        }

        hightlight.removeClass('has-error')
            .addClass('has-success');

        element.remove();
    },

    _highlightError: function (element, errorClass, validClass)
    {
        var hightlight = null;

        if ($(element).prop('type') === 'checkbox' || $(element).prop('type') === 'radio') {
            hightlight = $(element).closest("." + $(element).prop('type'));
        } else {
            hightlight = $(element).closest('.form-group');
        }

        hightlight
            .addClass('has-error')
            .removeClass('has-success');
    },

    _unhighlightError: function (element, errorClass, validClass)
    {
        $(element)
            .closest('.form-group')
            .removeClass('has-error')
        ;

        $("#" + element.id + "-error").remove();
    },

    _errorPlacement: function (error, element)
    {
        var errorSpan = null;

        if (element.parent('.input-group').length || element.prop('type') === 'checkbox' || element.prop('type') === 'radio') {
            errorSpan = error.insertAfter(element.parent());
        } else {
            errorSpan = error.insertAfter(element);
        }
    }
});


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
                showErrors: $.proxy(self._showErrors, self),
                errorPlacement: $.proxy(self._errorPlacement, self),
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
        if (event.keyCode === 9 && this.validator.elementValue(element) === "") {
            return false;
        }

        $.validator.defaults.onkeyup.apply(this.validator, arguments);
    },

    validator : null,
    isErrorInit : false,

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
        if (element.parent('.radio').length) {

        } else if (element.parent('.checkbox').length) {
            hightlight = $(element).parent();
        } else if ($(element).prev(".input-group").length) {
            hightlight = $(element).prev(".input-group");
        } else {
            hightlight = $(element)
                .closest('.form-group');
        }

        if (hightlight) {
            hightlight.removeClass('has-error')
                .addClass('has-success');
        }

        element.remove();
    },

    _highlightError: function (element, errorClass, validClass)
    {
        var hightlight = null;

        if ($(element).prop('type') === 'radio') {

        } else if ($(element).prop('type') === 'checkbox') {
            hightlight = $(element).closest("." + $(element).prop('type'));
        } else {
            hightlight = $(element).closest('.form-group');
        }

        if (hightlight) {
            hightlight
                .addClass('has-error')
                .removeClass('has-success');
        }
    },

    _unhighlightError: function (element, errorClass, validClass)
    {
        $(element)
            .closest('.form-group')
            .removeClass('has-error')
        ;

        $("#" + element.id + "-error").remove();
    },

    _showErrors: function (errorMap, errorList)
    {
        if (
            (!this.element.hasClass('form-inline') && this.isErrorInit == false) ||
            this.element.hasClass('form-inline')
        ) {
            this.validator.defaultShowErrors();
        }

        if (this.element.hasClass('form-inline')) {
            // popover for inline form
            $.each(this.validator.successList, function (index, value)
            {
                return $(value).popover("hide");
            });

            return $.each(errorList, function (index, value)
            {
                var popover;
                popover = $(value.element).popover({
                    trigger: "manual",
                    placement: "top",
                    animation: false,
                    content: value.message,
                    template: "<div class=\"popover\">" +
                        "<div class=\"arrow\"></div>" +
                        "<div class=\"popover-inner\">" +
                        "<div class=\"popover-content has-error\"><p></p></div>" +
                        "</div></div>"
                });
                popover.data("bs.popover").options.content = value.message;

                return $(value.element).popover("show");
            });
        }
    },

    _errorPlacement: function (error, element)
    {
        var errorSpan = null;

        if (!this.element.hasClass('form-inline')) {
            if (element.parent('.input-group').length ||
                element.prop('type') === 'checkbox' ||
                element.prop('type') === 'radio'
            ) {
                errorSpan = error.insertAfter(element.parent());
            } else if (element.hasClass("cawa-fields-image")){
                errorSpan = error.insertAfter(element.closest(".file-input").parent());
            } else if (element.hasClass("select2-hidden-accessible")){
                errorSpan = error.insertAfter(element.parent().find("span.select2"));
            } else {
                errorSpan = error.insertAfter(element);
            }
        }
    }
});


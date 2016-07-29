require([
    "jquery",
    "../../../lang/fields-creditcard",
    "modernizr",
    "jquery.payment",
    "cawaphp/cawa/assets/widget"
], function($, locale, modernizr)
{
    $.widget("cawa.fields-creditcard", $.cawa.widget, {
        _create: function() {
            var element = $(this.element);

            if (modernizr.touchevents) {
                element.attr("type", "tel");
            }

            element.attr("data-rule-credit-card", "true");
            element.payment('formatCardNumber');
        },

        getCardType : function ()
        {
            return $.payment.cardType(this.element.val());
        }
    });

    if ($.validator) {
        $.validator.addMethod("credit-card", function (value, element)
        {
            if (this.optional(element) && value == "") {
                return true;
            }

            var isValid = $.payment.validateCardNumber(value);

            if (isValid) {
                return isValid;
            }

            $.validator.messages["credit-card"] = locale[$.locale()]["invalidCreditCard"];

            return isValid;

        }, $.validator.messages.required);
    }
});


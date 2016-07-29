require([
    "jquery",
    "../../../lang/fields-creditcard",
    "modernizr",
    "jquery.payment",
    "cawaphp/cawa/assets/widget"
], function($, locale, modernizr)
{
    $.widget("cawa.fields-creditcard-expiry", $.cawa.widget, {
        _create: function() {
            var element = $(this.element);

            if (modernizr.touchevents) {
                element.attr("type", "tel");
            }

            element.attr("data-rule-credit-card-expiry", "true");
            element.payment('formatCardExpiry');
        }
    });

    if ($.validator) {
        $.validator.addMethod("credit-card-expiry", function (value, element)
        {
            if (this.optional(element) && value == "") {
                return true;
            }

            var expiry = $.payment.cardExpiryVal(value);
            var isValid = $.payment.validateCardExpiry(expiry.month, expiry.year);

            if (isValid) {
                return isValid;
            }

            $.validator.messages["credit-card-expiry"] = locale[$.locale()]["invalidExpiry"];

            return isValid;

        }, $.validator.messages.required);
    }
});


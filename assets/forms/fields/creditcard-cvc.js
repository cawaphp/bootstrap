require([
    "jquery",
    "../../../lang/fields-creditcard",
    "modernizr",
    "jquery.payment",
    "cawaphp/cawa/assets/widget"
], function($, locale, modernizr)
{
    $.widget("cawa.fields-creditcard-cvc", $.cawa.widget, {
        _create: function() {
            var element = $(this.element);

            if (window.Modernizr.touchevents) {
                element.attr("type", "tel");
            }

            element.attr("data-rule-credit-card-cvc", "true");
            element.payment('formatCardCVC');
        },

        getCreditCartField: function()
        {
            if (!this.options.creditcardFields) {
                return null;
            }

            return $(this.element).closest('form').find('#' + this.options.creditcardFields);
        }
    });

    if ($.validator) {
        $.validator.addMethod("credit-card-cvc", function (value, element)
        {
            if (this.optional(element) && value == "") {
                return "dependency-mismatch";
            }

            var cardType = null;
            var creditCartField = $(element)["fields-creditcard-cvc"]("getCreditCartField");

            if (creditCartField) {
                cardType = creditCartField["fields-creditcard"]("getCardType");
            }

            var isValid = $.payment.validateCardCVC(value, cardType);

            if (isValid) {
                return isValid;
            }

            $.validator.messages["credit-card-cvc"] = locale[$.locale()]["invalidCvc"];

            return isValid;

        }, $.validator.messages.required);
    }
});


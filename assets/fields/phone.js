var $ = require("jquery");
var locale = require("../../lang/fields-phone");
var _ = require('lodash');

$.widget("cawa.fields-phone", $.cawa.widget, {

    options: {
        country: 'fr',
        plugin : {
            preferredCountries: []
        }
    },

    _inputHidden: null,
    _country: null,

    _create: function() {
        var self = this;
        var element = $(this.element);

        var pluginOptions = $.extend(true, {}, self.options.plugin, {
            initialCountry: self.options.country
            // separateDialCode: true // display +33
        });

        var name = element.attr("name");
        self._inputHidden = $('<input />').attr('type', 'hidden').attr('name', name);
        self._inputHidden.insertBefore(this.element);
        element.attr("name", false);

        element.attr("data-rule-phone", "true");

        element.intlTelInput(pluginOptions);
        element.intlTelInput("handleUtils");
        self._country = element.intlTelInput("getSelectedCountryData")["iso2"];
        element.on('change paste keyup', $.proxy(self._updateHidden, self));
        element.on("countrychange", function(e, countryData) {
            self._country = countryData.iso2;
            self._updateMask(countryData.iso2);
            self._updateHidden();
        });

        self._updateMask();
        self._updateHidden();
    },

    _updateHidden: function()
    {
        this._inputHidden.val(this.element.intlTelInput("getNumber"));
    },

    _updateMask: function() {
        var mask = window.intlTelInputUtils.getExampleNumber(this._country, true, intlTelInputUtils.numberType.MOBILE);
        mask = mask.replace(/[0-9]/g, 0);
        $(this.element).unmask();
        $(this.element).mask(mask);
    }
});

if (jQuery.validator) {
    jQuery.validator.addMethod("phone", function (value, element)
    {
        if (this.optional(element) && value == "") {
            return true;
        }

        if ($(element).intlTelInput("isValidNumber")) {
            return true;
        }

        var error  = $(element).intlTelInput("getValidationError");
        var key = _.invert(intlTelInputUtils.validationError)[error];

        $.validator.messages.phone = locale[$.locale()][key];

        return $(element).intlTelInput("isValidNumber");
    }, $.validator.messages.phone);
}

var $ = require("jquery");
var locale = require("../../lang/fields-google-place");
var GoogleMapsLoader = require('google-maps');
var log = require("log").getLogger("Cawa Field Google Place");

$.widget("cawa.fields-googleplace", $.cawa.widget, {

    _forms : {
        street_number: ["number", 'short_name'],
        route: ["street", 'long_name'],
        locality: ["city", 'long_name'],
        administrative_area_level_1: ["state", 'short_name'],
        country: ["country", 'short_name'],
        postal_code: ["zipcode", 'short_name']
    },
    _google: null,
    _autocomplete: null,
    _create: function()
    {
        if (!this.options.key) {
            throw new Error("Missing mandatory GoogleMap Api Key");
        }

        var self = this;

        GoogleMapsLoader.KEY = this.options.key;
        GoogleMapsLoader.LIBRARIES = ['geometry', 'places'];
        GoogleMapsLoader.LANGUAGE = $.locale();

        GoogleMapsLoader.load(function(google) {
            self._google = google;
            self._initAutocomplete();
            self.element.on("focus", $.proxy(self._geolocate, self));
        });
    },

    _initAutocomplete: function ()
    {
        var self = this;

        self._autocomplete = new this._google.maps.places.Autocomplete(
            self.element[0],
            {types: ['geocode']}
        );

        self._autocomplete.addListener("place_changed", $.proxy(self.__fillInput, self));
        self.element.attr("data-rule-google-place", "true");
        self.element.on("keydown", function (event)
        {
            if (event.which == 13) {
                return false;
            }
        });
    },

    _getName : function()
    {
        return this.element.attr("name").substr(0, this.element.attr("name").indexOf("["));
    },

    _getField: function(name)
    {
        return $(this.element[0].form).find('input[name=' + this._getName() + '\\[' + name + '\\]]')
    },

    isValid: function()
    {
        return this._getField("lat").val() != "" &&
            this._getField("long").val() != "";
    },

    __fillInput: function ()
    {
        var self = this;
        var element = this.element;
        var name = this._getName();
        var form = $(this.element[0].form);


        // clean up
        $.each(form[0].elements, function(key, input) {
            input = $(input);
            if (input.attr("name") && (input.attr("name") + "[").indexOf("") == 0) {
                input.val("");
            }
        });

        var place = this._autocomplete.getPlace();
        if (!place || !place.geometry || !place.geometry.location) {
            return ;
        }

        element.val(place.formatted_address);

        self._getField("lat").val(place.geometry.location.lat());
        self._getField("long").val(place.geometry.location.lng());

        log.debug("Find a location :", place.formatted_address,
            "(" + place.geometry.location.lat() + ","  + place.geometry.location.lng() + ")"
        );

        $(place.address_components).each(function(key, addressComponent) {
            var addressType = addressComponent.types[0];

            if (self._forms[addressType])
            {
                self._getField(self._forms[addressType][0])
                    .val(addressComponent[self._forms[addressType][1]]);
            }
        });
    },

    _geolocate: function ()
    {
        var self = this;

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function (position)
            {
                var geolocation = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };

                var circle = new self._google.maps.Circle({
                    center: geolocation,
                    radius: position.coords.accuracy
                });

                self._autocomplete.setBounds(circle.getBounds());
            });
        }
    }
});

if (jQuery.validator) {
    jQuery.validator.addMethod("google-place", function (value, element)
    {
        if (this.optional(element) && value == "") {
            return true;
        }

        var isValid = $(element)["fields-googleplace"]("isValid");

        if (isValid) {
            return isValid;
        }

        $.validator.messages["google-place"] = locale[$.locale()]["invalid"];

        return isValid;

    }, $.validator.messages.required);
}


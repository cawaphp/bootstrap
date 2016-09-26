require([
    "jquery",
    "../../../lang/fields-google-place",
    "google-maps",
    "log",
    "cawaphp/cawa/assets/widget"
], function($, locale, GoogleMapsLoader, log)
{
    log = log.getLogger("Cawa Field Google Place");

    $.widget("cawa.fields-googleplace", $.cawa.widget, {

        options: {
            geolocate: false,
        },

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
        _value: null,
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
                if (self.options.geolocate) {
                    self.element.on("focus", $.proxy(self._geolocate, self));
                }
            });
        },

        _initAutocomplete: function ()
        {
            var self = this;
            var types = self.options.types ? self.options.types : (self.options.type ? [self.options.type] : []);

            self._autocomplete = new this._google.maps.places.Autocomplete(
                self.element[0],
                {types: types}
            );

            self._autocomplete.addListener("place_changed", $.proxy(self._fillInput, self));
            self.element.attr("data-rule-google-place", "true");

            self._value = self.element.val();

            // prevent form submission on enter
            self.element.on("keydown", function (event)
            {
                if (event.which == 13) {
                    return false;
                }
            });

            // reset input if value change
            self.element.on("keyup", function ()
            {
                if (self.element.val() != self._value) {
                    self._resetInput();
                }
            });
        },

        _getName : function()
        {
            return this.element.attr("name").substr(0, this.element.attr("name").indexOf("["));
        },

        _getField: function(name)
        {
            return $(this.element[0].form).find('[name=' + this._getName() + '\\[' + name + '\\]]')
        },

        isValid: function()
        {
            return this._getField("data").val() != "" ;
        },

        _resetInput: function()
        {
            var self = this;
            var form = $(this.element[0].form);
            var name = this._getName();

            $.each(form[0].elements, function(key, input) {
                input = $(input);
                if (input.attr("name") &&
                    (input.attr("name") + "[").indexOf(name + "[") == 0 &&
                    input.attr("name").indexOf("[text]") < 0
                ) {
                    input.val("");
                }
            });
        },

        _fillInput: function ()
        {
            var self = this;
            var element = this.element;

            var place = this._autocomplete.getPlace();
            var valid = true;
            if (!place || !place.geometry || !place.geometry.location) {
                valid = false;
            }

            if (self.element.val() == self._value && !valid) {
                return;
            }

            self._resetInput();
            self._value = self.element.val();

            if (!valid) {
                return ;
            }

            element.val(place.formatted_address);
            self._value = place.formatted_address;

            self._getField("data").val(JSON.stringify(place));
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

            $(self._getField("data")[0].form).valid();
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

                    self._getField("lat").val(geolocation.lat);
                    self._getField("long").val(geolocation.lng);
                    self._getField("data").val(JSON.stringify({
                        geometry: {
                            location : {
                                lat : geolocation.lat,
                                lng : geolocation.lng
                            }
                        }
                    }));

                    self._getField("text").attr("placeholder", locale[$.locale()]["myPosition"]);
                });
            }
        }
    });

    if ($.validator) {
        $.validator.addMethod("google-place", function (value, element)
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
});



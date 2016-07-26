require([
    "jquery",
    "jstree",
    "cawaphp/cawa/assets/widget"
], function($)
{
    $.widget("cawa.fields-tree", $.cawa.widget, {

        options: {
            plugin: {
                core: {

                    data: null,
                    animation: false,
                    themes : {
                        icons: false
                    }
                },
                plugins : ["checkbox"]
            }
        },

        _create: function() {
            var self = this;
            var element = this.element;
            var name = $(this.element).prop('name');
            var tree = $(this.element).closest('.form-group').find('div.tree');
            var options = self.options.plugin;

            this.element.removeAttr("name");

            tree.jstree(options);

            tree.on("changed.jstree", function (e, data) {
                element.parent().find('input[type="hidden"]').remove();

                $.each(data.selected, function(key, value)
                {
                    if (value.substr(0, 1) !== "_") {
                        element.parent().append($('<input type="hidden" />').attr('name', name).attr('value', value));
                    }
                })
             });
        }
    });
});



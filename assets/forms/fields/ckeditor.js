require([
    "jquery",
    "ckeditor",
    "modernizr",
    "cawaphp/cawa/assets/widget"
], function($, ckeditor, modernizr)
{
    /**
     * base64imagedrop that work
     */
    ckeditor.plugins.add('base64imagedrop', {
        init: function (editor) {
            editor.on('instanceReady', function(event) {
                var editableElement = editor.editable ? editor.editable() : editor.document;
                editableElement.on("dragOver", function()
                {

                }, null, {editor: editor});

                editableElement.on("drop", function(event)
                {
                    var eventDrop = event.data.$;
                    //Get dropped file
                    var file = eventDrop.dataTransfer.files[0];

                    //Return if file is not an image
                    if (!file || !file["type"] || file["type"].match(/^image/) < 0) {
                        return true;
                    }

                    eventDrop.preventDefault();

                    //Read file as data url (base64) and insert it as an image
                    var fr = new FileReader();
                    fr.onload = (function(f) {
                        return function(e) {
                            var elem = editor.document.createElement('img', {
                                attributes: {
                                    src: e.target.result
                                }
                            });

                            // We use a timeout callback to prevent a bug where insertElement inserts at first caret
                            // position
                            setTimeout(function () {
                                editor.insertElement(elem);
                            }, 10);

                        };
                    })(file);
                    fr.readAsDataURL(file);
                }, null, {editor: editor});
            });
        }
    });

    $.widget("cawa.fields-ckeditor", $.cawa.widget, {
        options: {
            disabledOnTouch: true,
            image: {
                enabled: false,
                responsive: true
            },
            originalCss: true,
            removePlugins: [
                'elementspath'
            ],
            extraPlugins: [
                'confighelper'
            ],
            plugin : {
                customConfig: false,
                stylesSet: false,
                defaultLanguage: $.locale(),
                language: $.locale(),
                on: {

                },
                format_tags: 'p;h2;h3;h4;h5;h6', //'p;h1;h2;h3;h4;h5;h6;pre;address;div'
                toolbar: [
                    /*
                    { name: 'document', items: [ 'Source', '-', 'Save', 'NewPage', 'Preview', 'Print', '-', 'Templates' ] },
                    { name: 'clipboard', items: [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ] },
                    { name: 'editing', items: [ 'Find', 'Replace', '-', 'SelectAll', '-', 'Scayt' ] },
                    { name: 'forms', items: [ 'Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField' ] },
                    '/',
                    { name: 'basicstyles', items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'CopyFormatting', 'RemoveFormat' ] },
                    { name: 'paragraph', items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', 'Language' ] },
                    { name: 'links', items: [ 'Link', 'Unlink', 'Anchor' ] },
                    { name: 'insert', items: [ 'Image', 'Flash', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe' ] },
                    '/',
                    { name: 'styles', items: [ 'Styles', 'Format', 'Font', 'FontSize' ] },
                    { name: 'colors', items: [ 'TextColor', 'BGColor' ] },
                    { name: 'tools', items: [ 'Maximize', 'ShowBlocks' ] },
                    { name: 'about', items: [ 'About' ] }
                    */

                    { name: 'basicstyles', items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat' ] },
                    { name: 'paragraph', items: [ 'NumberedList', 'BulletedList', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight'] },
                    { name: 'insert', items: ['base64image', 'Blockquote', 'Format', 'Table'] },
                    { name: 'links', items: [ 'Link', 'Unlink'] },
                    { name: 'tools', items: [ 'Undo', 'Redo', '-', 'Maximize', /*'ShowBlocks', */'Source'] }
                ],
                disallowedContent: 'div'
            }
        },

        /**
         * @type CKEDITOR.editor
         */
        _instance: null,

        /**
         * @private
         */
        _create: function()
        {
            var self = this;
            var element = $(this.element);
            var options = self._ckeditorOption();

            if (element[0].isContentEditable || element.attr('contenteditable') != undefined) {
                this._instance = ckeditor.inline(self.element.get(0), options);
            }
            else {
                this._instance = ckeditor.replace(element[0], options);
            }

            this._instance.on("blur", this._instance.updateElement);
            this._instance.on("change", this._instance.updateElement);
            this._instance.on("paste", this._instance.updateElement);
        },

        /**
         * @private
         */
        _ckeditorOption : function()
        {
            var self = this;
            var element = $(this.element);
            var options = self.options.plugin;
            var removePlugins = self.options.removePlugins;
            var extraPlugins = self.options.extraPlugins;

            options.readOnly = !!element.attr('readonly') || !!element.attr('disabled');

            if (self.options.image.enabled) {
                extraPlugins.push('base64image');
                extraPlugins.push('pastebase64');
                extraPlugins.push('base64imagedrop');

                options.extraAllowedContent = 'img[data-src-name]';
            }

            if (element.attr('placeholder')) {
                options.placeholder = element.attr('placeholder');
            }

            if (self.options.disabledOnTouch === true && window.Modernizr.touchevents) {
                removePlugins.push('toolbar');
            }

            if (self.options.originalCss && options.contentsCss) {
                options.contentsCss.unshift(ckeditor.getUrl('contents.css'));
            }

            options.extraPlugins = extraPlugins.join(',');
            options.removePlugins = removePlugins.join(',');

            if (self.options.image.enabled && self.options.image.responsive) {
                options.on.instanceReady = self._imageResponsive;
            }

            return options;
        },

        _imageResponsive : function(ev)
        {
            ev.editor.dataProcessor.htmlFilter.addRules( {
                elements : {
                    img: function(el) {
                        el.addClass('img-responsive');

                        delete el.attributes.width;
                        delete el.attributes.height;
                        delete el.attributes.style;
                        delete el.attributes.hspace;
                        delete el.attributes.vspace;
                        delete el.attributes.alt;
                        delete el.attributes.border;

                        return el;
                    }
                }
            });
        }
    });
});



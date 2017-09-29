if (!RedactorPlugins) var RedactorPlugins = {};

(function ($, elFinder, RedactorPlugins) {
    RedactorPlugins.elfinderImage = function () {
        return {
            init: function () {
                if (!this.opts.elfinderImageUrl) return;
                var button = this.button.add('elfinderImage', this.lang.get('image'));
                this.button.setAwesome('elfinderImage', 'fa-picture-o');
                elFinder.register("load-redactor-image", this.elfinderImage.insert);
                // this.modal.addCallback('image', this.elfinderImage.load);
                this.button.addCallback(button, this.elfinderImage.load);
            },
            load: function () {
                elFinder.openManager({
                    "url": this.opts.elfinderImageUrl,
                    "width": "auto",
                    "height": "auto",
                    "id": "load-redactor-image"
                });
            },
            insert: function (file, id) {
                var self = this;
                self.image.insert('<img src="' + file.url + '">');
                return true;
            }
        };
    };
})(jQuery, mihaildev.elFinder, RedactorPlugins);
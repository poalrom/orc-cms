app.modules.loader = (($, app) => {
    return {
        overlay: '<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>',
        overlaySelector: 'body > .overlay',
        bodyLoaderClass: 'body-loader',
        show() {
            $('body').addClass(this.bodyLoaderClass).append(this.overlay);
        },

        hide() {
            $(this.overlaySelector).remove();
            $('body').removeClass(this.bodyLoaderClass);
        }
    }
    ;
})(jQuery, app);
app.modules.saveAll = (($, app) => {
    return {
        saveAllSelector: '.save-all',
        saveAllButton: null,
        init() {
            this.saveAllButton = $(this.saveAllSelector);
            this.bindEvents();
        },
        bindEvents() {
            let self = this;
            this.saveAllButton.click((event) => {
                event.preventDefault();
                $.post('#',$('input[name*="[order]"]').serialize(), function (data) {
                    const orders = data.orders || [];
                    for (let order in orders){
                        $('input[name*="['+order+'][order]"]').val(orders[order]);
                    }

                    setTimeout(function () {
                        app.modules.loader.hide();
                        app.modules.notification.show(data);
                    }, 1000);
                });
            });
        }
    };
})(jQuery, app);
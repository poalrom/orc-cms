app.modules.notification = (($, app) => {
    return {
        icons: {
            default: 'fa fa-flag',
            success: 'fa fa-thumbs-o-up',
            danger: 'fa fa-exclamation-triangle'
        },
        show(data) {
            if (typeof data === 'string') {
                data = JSON.parse(data);
            }
            const iconType = data.hasOwnProperty('type') && this.icons.hasOwnProperty(data.type) ? data.type : 'default';

            $.notify({
                icon: this.icons[iconType],
                message: data.message
            }, {
                type: data.type,
                placement: {
                    from: "bottom",
                    align: "right"
                },
                newest_on_top: true
            });
        }
    };
})(jQuery, app);
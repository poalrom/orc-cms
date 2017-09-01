app.modules.notification = (() => {
    return {
        init() {
            alertify.set('notifier','position', 'top-right');
        },
        show(data) {
            if (typeof data === 'string') {
                data = JSON.parse(data);
            }

            alertify.notify(data.message || '', data.type || 'success');
        }
    };
})();
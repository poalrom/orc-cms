const app = {
    modules: {},
    cookies: null,
    init(cookies) {
        this.cookies = cookies;
        for (let module in this.modules) {
            if (!this.modules.hasOwnProperty(module)) {
                continue;
            }
            if (typeof this.modules[module].init === 'function') {
                this.modules[module].init();
            }
        }
    }
};

jQuery(document).ready(() => {
    app.init(Cookies);
});
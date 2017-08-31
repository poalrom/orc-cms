app.modules.sidebar = (($, app) => {
    return {
        sidebar: null,
        sidebarSelector: '.sidebar-mini',
        sidebarCollapsedClass: 'sidebar-collapse',
        sidebarToggle: null,
        sidebarToggleSelector: '.sidebar-toggle',
        init() {
            this.sidebar = $(this.sidebarSelector);
            this.sidebarToggle = $(this.sidebarToggleSelector);
            this.bindEvents();
        },
        bindEvents() {
            let self = this;
            this.sidebarToggle.click(() => {
                app.cookies.set('isSidebarCollapsed', self.sidebar.hasClass(self.sidebarCollapsedClass));
            });
        }
    };
})(jQuery, app);
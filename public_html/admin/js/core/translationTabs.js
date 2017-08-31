app.modules.saveAll = (($, app) => {
    return {
        translatableFormsSelector: '.translatable-form',
        translatableForms: null,
        translationTabsSelector: '#translation_tabs [role="tab"]',
        translationTabs: null,
        init() {
            this.translatableForms = $(this.translatableFormsSelector);
            this.translationTabs = this.translatableForms.find(this.translationTabsSelector);
            this.bindEvents();
        },
        bindEvents() {
            let highlightTabs = this.highlightTabs.bind(this);
            this.translatableForms.on('afterValidate', highlightTabs);
        },

        highlightTabs(){
            this.translationTabs.each((i, el) => {
                let $el = $(el),
                    $tab = $($el.attr('href'));
                if ($tab.find('.has-error').length > 0){
                    $el.addClass('bg-red-active');
                } else {
                    $el.removeClass('bg-red-active');
                }
            });
        }
    };
})(jQuery, app);
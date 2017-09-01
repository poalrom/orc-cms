<?php

return [
    // Common routes
    'admin/login' => \admin\controllers\core\LoginController::LOGIN_PAGE_ROUTE,
    'admin/logout' => \admin\controllers\core\LoginController::LOGOUT_PAGE_ROUTE,
    'admin/forbidden' => \admin\controllers\core\LoginController::FORBIDDEN_PAGE_ROUTE,
    'admin/core/main/error' => \admin\controllers\core\MainController::ERROR_ROUTE,
    'admin/main' => \admin\controllers\core\MainController::MAIN_PAGE_ROUTE,

    // Language
    'admin/lang/<action>' => \admin\controllers\core\LangController::LANG_ROUTE,

    // Front menu
    'admin/menu/<action>' => \admin\controllers\core\MenuController::MENU_ROUTE,
    'admin/menu-items/<action>' => \admin\controllers\core\MenuLinkController::MENU_ITEM_ROUTE,

    // Widgets
    'admin/widget/<action>' => \admin\controllers\core\WidgetController::WIDGET_ROUTE,
    'admin/widget/<widget_name>/<controller>/<action>' => \admin\controllers\core\WidgetController::WIDGET_ITEM_ROUTE,

    // File
    'admin/file/<action>' => \admin\controllers\core\FileController::FILE_ROUTE,

    // Redirects
    'admin/redirects/<action>' => \admin\controllers\core\RedirectsController::REDIRECT_ROUTE,
];
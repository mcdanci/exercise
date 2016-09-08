<?php
// reference: https://blog.longwin.com.tw/2007/09/gettext_php_i18n_2007/
define('PACKAGE_DOMAIN', 'app');

// initialize settings
// set L10n to Chinese
putenv('LC_ALL=' . $_GET['locale']);

// specify location of translation tables
bindtextdomain(PACKAGE_DOMAIN, 'locale');

textdomain(PACKAGE_DOMAIN);

// looking for in ./locale/zh_HK/LC_MESSAGES/app.mo

// print test messages
echo gettext('It just a test.') . "\n<br />";
echo _("It's another test.") . "\n";

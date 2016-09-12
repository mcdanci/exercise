<?php
require_once 'gettext.class.php';

use mcdanci\execise\php_g11n\gettext;

// initialize settings
define('PACKAGE_DOMAIN', 'app');

$realLc = array();

// set locale settings for client
if ($_GET['lc_spoken'] || $_COOKIE['lc_spoken']) {
    if ($_COOKIE['lc_spoken']) { // 需要校驗
        if (! gettext::checkLcStr($_COOKIE['lc_spoken'], LC_SPOKEN)) {
            $realLc['spoken'] = gettext::getLcCorrect($_COOKIE['lc_spoken'], LC_SPOKEN);
            setcookie('lc_spoken', $realLc['spoken']);
        } else {
            $realLc['spoken'] = $_COOKIE['lc_spoken'];
        }
    } else { // 或許需要變更設定
        if ($_GET['lc_spoken'] != $_COOKIE['lc_spoken']) {
            if (gettext::checkLcStr($_GET['lc_spoken'], LC_SPOKEN)) {
                $realLc['spoken'] = $_GET['lc_spoken'];
                setcookie('lc_spoken', $realLc['spoken']);
            } else {
                $realLc['spoken'] = gettext::getLcCorrect($_GET['lc_spoken'], LC_SPOKEN);
                setcookie('lc_spoken', $realLc['spoken']);
            }
        }
    }

    // set spoken L10n environmental var
    ///putenv('LC_ALL=' . gettext::mapL10n($realLc['spoken']));
}
if ($_GET['lc_written'] || $_COOKIE['lc_written']) {
    if ($_COOKIE['lc_written']) { // 需要校驗
        if (! gettext::checkLcStr($_COOKIE['lc_written'])) {
            $realLc['written'] = gettext::getLcCorrect($_COOKIE['lc_written']);
            setcookie('lc_written', $realLc['written']);
        } else {
            $realLc['written'] = $_COOKIE['lc_written'];
        }
    } else { // 或許需要變更設定
        if ($_GET['lc_written'] != $_COOKIE['lc_written']) {
            if (gettext::checkLcStr($_GET['lc_written'])) {
                $realLc['written'] = $_GET['lc_written'];
                setcookie('lc_written', $realLc['written']);
            } else {
                $realLc['written'] = gettext::getLcCorrect($_GET['lc_written']);
                setcookie('lc_written', $realLc['written']);
            }
        }
    }

    // set written L10n environmental var
    putenv('LC_ALL=' . gettext::mapL10n($realLc['written']));
}

// specify location of translation tables
bindtextdomain(PACKAGE_DOMAIN, 'locale');

textdomain(PACKAGE_DOMAIN);

// looking for translation in ./locale

// print test messages
echo gettext('It just a test.') . "\n<br />";
echo _("It's another test.") . "\n";

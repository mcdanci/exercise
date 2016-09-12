<?php
namespace mcdanci\execise\g11n_gettext;
// reference: https://blog.longwin.com.tw/2007/09/gettext_php_i18n_2007/
// failback logic
define('LC_WITTEN', 0);
define('LC_SPOKEN', 1);

$lcList[LC_WITTEN] = array(
    'en' => 'en_GB',
    'en-US' => 'en_US',
    'zh' => 'zh_TW',
    'zh-cmn-Hans' => 'zh_CN',
    'zh-yue' => 'zh_HK',
);

function lcStrCut($lcString)
{
    $pos = strrpos($lcString, '-');

    if ($pos !== false) {
        return substr($lcString, 0, $pos);
    } else {
        return false;
    }
}

// check locale value
function checkLcVal($lcString, $type = LC_WITTEN)
{
    in_array($lcString, $lcList[$type]);
}

function getLcCorrect($lcString, $type = LC_WITTEN)
{
    if (! $lcString) {
        return reset($lcList[$type]);
    } elseif (checkLcVal($lcString, $type)) {
        return $lcString;
    } else {
        getLcCorrect(lcStrCut($lcString), $type);
    }
}

// initialize settings
define('PACKAGE_DOMAIN', 'app');

// set locale settings for client
if ($_GET['lc_spoken'] && $_COOKIE['lc_spoken'] != $_GET['lc_spoken']) {
    setcookie(['lc_spoken'], $_GET['lc_spoken']);
}

if ($_GET['lc_written'] && $_COOKIE['lc_written'] != $_GET['lc_written']) {
    setcookie(['lc_written'], $_GET['lc_written']);
}


// set L10n to Chinese
putenv('LC_ALL=' . $_GET['locale']);

// specify location of translation tables
bindtextdomain(PACKAGE_DOMAIN, 'locale');

textdomain(PACKAGE_DOMAIN);

// looking for in ./locale/zh_HK/LC_MESSAGES/app.mo

// print test messages
echo gettext('It just a test.') . "\n<br />";
echo _("It's another test.") . "\n";

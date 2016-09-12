<?php
namespace mcdanci\execise\php_g11n;

$lcList = array(
    LC_SPOKEN => array(
        'en' => 'en_GB',
        'en-US' => 'en_US',
        'zh' => 'zh_TW',
        'zh-yue' => 'zh_HK',
    ),
    LC_WRITTEN => array(
        'en' => 'en_GB',
        'en-US' => 'en_US',
        'zh' => 'zh_TW',
        'zh-cmn-Hans' => 'zh_CN',
        'zh-yue' => 'zh_HK',
    ),
);

/**
 * Cut locale string one of the failback logic.
 * @param $lcString
 * @return bool | string
 */
function cutLcStr($lcString)
{
    $pos = strrpos($lcString, '-');
    if ($pos === false) {
        return false;
    } else {
        return substr($lcString, 0, $pos);
    }
}

/**
 * @param string $lcString
 * @param int $type
 */
function checkLcStr($lcString, $type = LC_WRITTEN)
{
    return array_key_exists($lcString, $GLOBALS['lcList'][LC_WRITTEN]);
}

// check and failback logic
/////////////////////////////////////
function getLcCorrect($lcString, $type = LC_WRITTEN)
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

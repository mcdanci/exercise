<?php
namespace mcdanci\execise\php_g11n;

// reference: https://blog.longwin.com.tw/2007/09/gettext_php_i18n_2007/
define('LC_SPOKEN', 0);
define('LC_WRITTEN', 1);

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

class gettext
{
    /**
     * Cut locale string.
     * One of the failback logic
     * @param $lcString
     * @return bool | string
     */
    protected static function cutLcStr($lcString)
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
    public static function checkLcStr($lcString, $type = LC_WRITTEN)
    {
        return array_key_exists($lcString, $GLOBALS['lcList'][$type]);
    }

    /**
     * @param $lcString
     * @param int $type
     * @return mixed
     */
    public static function getLcCorrect($lcString, $type = LC_WRITTEN)
    {
        if (! $lcString) {
            return reset($GLOBALS['lcList'][$type]);
        } elseif (self::checkLcStr($lcString, $type)) {
            return $lcString;
        } else {
            self::getLcCorrect(self::cutLcStr($lcString), $type);
        }
    }

    /**
     * @param $lcString
     * @return mixed
     */
    public static function mapL10n($lcString) {
        return $GLOBALS[$lcString];
    }
}

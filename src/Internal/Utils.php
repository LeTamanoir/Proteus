<?php

declare(strict_types=1);

namespace Proteus\Internal;

class Utils
{
    public static function isPhpKeyword(string $testString): bool
    {
        static $cache = [];
        if (isset($cache[$testString])) {
            return $cache[$testString];
        }
        // First check it's actually a word and not an expression/number
        if (!preg_match('/^[a-z]+$/i', $testString)) {
            return false;
        }
        $tokenised = token_get_all('<?php ' . $testString . '; ?>');
        // tokenised[0] = opening PHP tag, tokenised[1] = our test string
        $cache[$testString] = reset($tokenised[1]) !== T_STRING;
        return $cache[$testString];
    }

    /**
     * Converts a protobuf name to a PHP name
     */
    public static function protoNameToPhpName(string $name): string
    {
        if (self::isPhpKeyword($name)) {
            return self::protoNameToPhpName($name . '_');
        }

        return $name;
    }
}

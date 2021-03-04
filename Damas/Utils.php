<?php

class Utils
{
    public static function letterToNumber(string $letter): int
    {
        return ord(strtolower($letter)) - 96;
    }

    public static function printLn(string $text): void
    {
        echo $text."\n";
    }

    public static function printLnAndInput(string $text): string
    {
        self::printLn($text);

        $handle = fopen("php://stdin", "r");
        $line   = fgets($handle);

        fclose($handle);

        return $line;
    }
}
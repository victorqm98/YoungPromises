<?php


class StandardOutputPrinter implements Printer
{
    public static function printLn(string $text): void
    {
        echo $text."\n";
    }
}
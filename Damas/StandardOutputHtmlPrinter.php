<?php


class StandardOutputHtmlPrinter implements Printer
{
    public static function printLn(string $text): void
    {
        echo "<div>".$text."</div>";
    }
}
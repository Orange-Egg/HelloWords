<?php
namespace libs\utils;
final class DateUtils
{
    public static function getNow(): string
    {
        return now();
    }
}
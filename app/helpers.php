<?php

if (! function_exists('format_money')) {
    function format_money(int $money): string
    {
        $money = $money / 100;

        return "€ {$money}";
    }
}

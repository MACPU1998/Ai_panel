<?php

namespace App\DataProviders;

abstract class CountryDataProvider
{
    public static function data(): array
    {
        return [

            ['id' => '1', 'name' => 'ایران'],

        ];
    }
}

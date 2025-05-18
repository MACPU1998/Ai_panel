<?php

namespace App\DataProviders;

abstract class CountryDataProvider
{
    public static function data(): array
    {
        return [

            ['id' => '103', 'name' => 'iran'],

        ];
    }
}

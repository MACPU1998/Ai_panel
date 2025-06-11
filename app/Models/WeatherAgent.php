<?php

namespace App\Models;

use LarAgent\Agent;

class WeatherAgent extends Agent
{
    protected $provider = 'default';

    protected $model = 'gpt-4o-mini';

    // Tool by classes
    protected $tools = [

    ];

    protected $history = 'in_memory';

    protected $temperature = 0.8;
}

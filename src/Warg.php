<?php

namespace Hadefication\Warg;

use Illuminate\Routing\Router;

class Warg
{

    protected $router;

    public function __construct(Router $route)
    {
        $this->route = $route;
    }

    public function routes()
    {
        $this->route->name('warg')->get('warg/{id}', '\Hadefication\Warg\Http\Controllers\WargController@warg');
        $this->route->name('dewarg')->get('dewarg', '\Hadefication\Warg\Http\Controllers\WargController@dewarg');
    }

    public function test()
    {
        return 'This is not a test!!!';
    }
}

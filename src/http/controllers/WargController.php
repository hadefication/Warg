<?php

namespace Hadefication\Warg\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use Illuminate\Support\ViewErrorBag;
use Illuminate\Routing\Router;

use App\Http\Controllers\Controller;

use Hadefication\Warg\WargBag;

class WargController extends Controller
{
    protected $route;

    public function __construct(Router $route)
    {
        $this->route = $route;
    }

    public function warg($id = null)
    {
        $warg = auth()->user();
        $model = app(config('warg.user'));
        $vessel = app(config('warg.user'))->find($id);

        // Return an error if the vessel doesn't exists
        if (is_null($vessel)) {
            $bag = new MessageBag();
            $bag->add('warg', 'The message!');
            $errors = session()->get('errors', new ViewErrorBag)->put('default', $bag);
            event(new \Hadefication\Warg\Events\VesselMissing($errors))
            return redirect()->back()->with('errors', $errors);
        }

        // Logout the warg
        auth()->logout();

        // Login the vessel
        auth()->login($vessel);

        // Store warg session details
        $wargSession = new WargBag($warg, $vessel);
        session()->put('warg', $wargSession);

        // Add event

        if (is_null(config('warg.redirect.route')) &&
            $this->route->has(config('warg.redirect.route'))) {
            return redirect()->route(config('warg.redirect.route'));
        } else {
            return redirect(config('warg.redirect.uri'));
        }
    }

    public function dewarg()
    {
        $wargSession = session()->pull('warg');

        // Login back the warg
        auth()->login($wargSession->warg());

        // Fire an event

        if (is_null(config('warg.redirect.route')) &&
            $this->route->has(config('warg.redirect.route'))) {
            return redirect()->route(config('warg.redirect.route'));
        } else {
            return redirect(config('warg.redirect.uri'));
        }
    }
}

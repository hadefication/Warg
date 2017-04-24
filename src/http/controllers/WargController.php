<?php

namespace Hadefication\Warg\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use Illuminate\Support\ViewErrorBag;
use Illuminate\Routing\Router;

use App\Http\Controllers\Controller;

use Hadefication\Warg\Support\WargBag;
use Hadefication\Warg\Support\ErrorBag;

use Hadefication\Warg\Events\WargFailed;
use Hadefication\Warg\Events\WargStarted;
use Hadefication\Warg\Events\WargStopped;

class WargController extends Controller
{
    protected $route;
    protected $errorBag;
    protected $model;

    public function __construct(Router $route, ErrorBag $errorBag)
    {
        $this->route = $route;
        $this->errorBag = $errorBag;
        $this->model = app(config('warg.user'));
    }

    public function warg($id = null)
    {
        try {

            $warg = auth()->user();
            $vessel = $this->model->find($id);

            // Verify
            $this->verifySession($warg, $vessel);

            // Logout the warg
            auth()->logout();

            // Login the vessel
            auth()->login($vessel);

            // Store warg session details
            $wargSession = new WargBag($warg, $vessel);
            session()->put('warg', $wargSession);
            event(new WargStarted($wargSession));

            return $this->advance();

        } catch (\Exception $e) {
            logger()->error($e->getMessage(), ['exception' => $e]);
            return $this->backtrack($e->getMessage());
        }

    }

    public function verifySession($warg, $vessel)
    {
        // Bail out if the warh is not authenticated
        if (is_null($warg)) {
            return $this->backtrack(trans('warg.forbidden'));
        }

        // Return an error if the vessel doesn't exists
        if (is_null($vessel)) {
            return $this->backtrack(trans('warg.missing'));
        }

        // Really!?!? Trying to warg to your self?
        if ($warg->id === $vessel->id) {
            return $this->backtrack(trans('warg.invalid'));
        }

    }

    public function backtrack($message)
    {
        $errors = $this->errorBag->put('warg', $message)->get();
        event(new WargFailed($errors));
        return back()->with('errors', $errors);
    }

    public function dewarg()
    {
        $wargSession = session()->pull('warg');
        auth()->login($wargSession->warg());
        event(new WargStopped($wargSession->warg()));
        return $this->advance();
    }

    public function advance()
    {
        if (is_null(config('warg.redirect.route')) &&
            $this->route->has(config('warg.redirect.route'))) {
            return redirect()->route(config('warg.redirect.route'));
        } else {
            return redirect(config('warg.redirect.uri'));
        }
    }
}

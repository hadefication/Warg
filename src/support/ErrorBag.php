<?php

namespace Hadefication\Warg\Support;

use Illuminate\Support\MessageBag;
use Illuminate\Support\ViewErrorBag;

class ErrorBag
{
    protected $messageBag;

    protected $viewErrorBag;

    public function __construct(MessageBag $messageBag, ViewErrorBag $viewErrorBag)
    {
        $this->messageBag = $messageBag;
        $this->viewErrorBag = $viewErrorBag;
    }

    public function put($key, $message)
    {
        $this->messageBag->add($key, $message);

        return $this;
    }

    public function get()
    {
        return session()->get('errors', $this->viewErrorBag)
                        ->put('default', $this->messageBag);
    }

}

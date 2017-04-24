<?php

namespace Hadefication\Warg\Events;

use Illuminate\Queue\SerializesModels;
use Hadefication\Warg\WargBag;

class WargStopped
{
    use SerializesModels;

    public $warg;

    public function __construct($warg)
    {
        $this->warg = $warg;
    }

}

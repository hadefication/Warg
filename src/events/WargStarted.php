<?php

namespace Hadefication\Warg\Events;

use Illuminate\Queue\SerializesModels;

class WargStarted
{
    use SerializesModels;

    public $wargBag;

    public function __construct($wargBag)
    {
        $this->wargBag = $wargBag;
    }

}

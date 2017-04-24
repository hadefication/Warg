<?php

namespace Hadefication\Warg\Support;

class WargBag
{
    protected $warg;

    protected $vessel;

    public function __construct($warg, $vessel)
    {
        $this->warg = $warg;
        $this->vessel = $vessel;
    }

    public function warg()
    {
        return $this->warg;
    }

    public function vessel()
    {
        return $this->vessel;
    }

    public function hasWarg()
    {
        return !is_null($this->warg);
    }

    public function hasVessel()
    {
        return !is_null($this->vessel);
    }

    public function hasActiveSession()
    {
        return $this->hasWarg() && $this->hasVessel();
    }
}

<?php

namespace Hadefication\Warg\Events;

use Illuminate\Queue\SerializesModels;
class VesselMissing
{
    use SerializesModels;

    public $errors;

    public function __construct($errors)
    {
        $this->errors = $errors;
    }
    
}

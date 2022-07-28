<?php

namespace App\Traits\Models;

/**
 * Trait HasName
 *
 * @package App\Traits
 */
trait HasName
{

    public function getNameDisplayAttribute(): string
    {
        return $this->name_first . ' ' . $this->name_last;
    }

    public function getNameClericalAttribute(): string
    {
        return $this->name_last . ', ' . $this->name_first;
    }



    public function getInitialsAttribute(): string
    {
        return strtoupper(substr($this->name_first, 0, 1) . substr($this->name_last, 0, 1));
    }
}

<?php

namespace App\Livewire;

use Livewire\Component;

class Counter extends Component
{
    public $count = 0; // Property ini otomatis bisa diakses di View

    public function increment()
    {
        $this->count++; // Logic PHP biasa
    }
    public function render()
    {
        return view('livewire.counter');
    }
}

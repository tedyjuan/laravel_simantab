<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')] // arahkan ke layout kamu (yang berisi $slot)
class Dashboard extends Component
{
    public function render()
    {
        return view('livewire.dashboard');
    }
}

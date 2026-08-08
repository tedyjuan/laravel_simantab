<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')] // arahkan ke layout kamu (yang berisi $slot)
class MasterPegawai extends Component
{
    public function render()
    {
        return view('livewire.master-pegawai');
    }
}

<?php

namespace App\View\Components\Application;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\View\Component;

class ModalEmail extends Component
{
    public Collection $positions;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->positions = DB::table('thrm_position')
            ->orderBy('POSITION_NAME_EN')
            ->get(['POSITION_ID', 'POSITION_NAME_EN']);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.application.modal-email');
    }
}

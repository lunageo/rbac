<?php

namespace Luna\Permissions\Views\Components;

use Illuminate\View\Component;

class RoutesTableViewComponent extends Component
{
    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('luna-permissions::components.routes-table');
    }
} 
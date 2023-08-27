<?php

namespace App\Http\Livewire\Jetstream;

use Livewire\Component;

class NavigationMenu extends Component
{
    public $page;

    public function mount($page)
    {
        $this->page = $page;

    }
    /**
     * The component's listeners.
     *
     * @var array
     */
    protected $listeners = [
        'refresh-navigation-menu' => '$refresh',
    ];

    /**
     * Render the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('navigation-menu');
    }
}

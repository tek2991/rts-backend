<?php

namespace App\Http\Livewire;

use LivewireUI\Modal\ModalComponent;

class ConfirmDeleteModal extends ModalComponent
{
    public $route;
    public $model_id;
    public $model_name;
    public $action;
    public $message;

    public function mount($route, $model_id, $model_name, $action)
    {
        $this->route = $route;
        $this->model_id = $model_id;
        $this->model_name = $model_name;
        $this->action = $action;
        $this->message = 'Are you sure you want to ' . $action . ' this ' . $model_name . '?';
    }

    public function render()
    {
        return view('livewire.confirm-delete-modal');
    }
}

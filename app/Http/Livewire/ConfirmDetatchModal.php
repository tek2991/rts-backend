<?php

namespace App\Http\Livewire;

use LivewireUI\Modal\ModalComponent;

class ConfirmDetatchModal extends ModalComponent
{
    public $route;
    public $model_id;
    public $model_name;
    public $detatching_model_id;
    public $detatching_model_name;
    public $action;
    public $message;

    public function mount($route, $model_id, $model_name, $action, $detatching_model_id, $detatching_model_name)
    {
        $this->route = $route;
        $this->model_id = $model_id;
        $this->model_name = $model_name;
        $this->detatching_model_id = $detatching_model_id;
        $this->detatching_model_name = $detatching_model_name;
        $this->action = $action;
        $this->message = 'Are you sure you want to ' . $action . ' this ' . $detatching_model_name . '?';
    }

    public function render()
    {
        return view('livewire.confirm-detatch-modal');
    }
}

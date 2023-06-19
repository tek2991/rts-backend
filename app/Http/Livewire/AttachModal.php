<?php

namespace App\Http\Livewire;

use LivewireUI\Modal\ModalComponent;

class AttachModal extends ModalComponent
{
    public $route;
    public $model_id;
    public $model_name;
    public $attaching_model_name;
    public $attaching_models;

    public function mount($route, $model_id, $model_name, $attaching_model_name)
    {
        $this->route = $route;
        $this->model_id = $model_id;
        $this->model_name = $model_name;
        $this->attaching_model_name = $attaching_model_name;

        // Get all the attaching models
        $this->attaching_models = $this->getAttachingModel();
    }

    public function getAttachingModel()
    {
        // Get the attaching model name
        $attaching_model_name = $this->attaching_model_name;

        // Get the attaching models from namespace App\Models
        $attaching_models = app('App\Models\\' . $attaching_model_name)::all();
        return $attaching_models;
    }

    public function render()
    {
        return view('livewire.attach-modal');
    }
}

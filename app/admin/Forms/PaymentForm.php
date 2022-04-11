<?php

namespace Modules\Panel\Forms;

use Kris\LaravelFormBuilder\Form;
use App\Models\PricingModel;


class PaymentForm extends Form
{
    protected $formOptions = [
        'autocomplete' => 'off',
        'role' => 'presentation',
    ];

    public function buildForm()
    {
        $this->add('username', 'text', [
            'rules' => 'required|min:3'
        ]);
        $this->add('password', 'password', [
            'rules' => 'required|min:3'
        ]);
        $this->add('host', 'text', [
            'rules' => 'required|min:3'
        ]);
        $this->add('port', 'number', [
            'rules' => 'min:3'
        ]);

        $this->add('submit', 'submit', ['attr' => ['class' => 'btn btn-primary']]);
    }
}

<?php


namespace App\Http\Requests;


use App\Http\Resources\Application;
use Illuminate\Foundation\Http\FormRequest;

class MassMailerRequest extends FormRequest
{
    protected Application $application;

    public function setApplication(Application $application): void
    {
        $this->application = $application;
    }

    public function getApplication(): Application
    {
        return $this->application;
    }
}

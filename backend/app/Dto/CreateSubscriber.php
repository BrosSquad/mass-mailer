<?php


namespace App\Dto;


/**
 * Class CreateSubscriber
 * @package App\Dto
 * @property string $name
 * @property string $surname
 * @property string $email
 */
class CreateSubscriber extends Base
{
    protected $name;
    protected $surname;
    protected $email;
}

<?php


namespace App\Dto;


/**
 * Class CreateUser
 *
 * @package App\Dto
 * @property string $surname
 * @property string $email
 * @property string $name
 */
class CreateUser extends Base
{
    protected $name;
    protected $surname;
    protected $email;
}

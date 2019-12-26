<?php


namespace App\Dto;


/**
 * Class CreateUser
 *
 * @package App\Dto
 * @property string $surname
 * @property string $email
 * @property string $name
 * @property string $role
 */
class CreateUser extends Base
{
    protected string $name;
    protected string $surname;
    protected string $email;
    protected string $role;
}

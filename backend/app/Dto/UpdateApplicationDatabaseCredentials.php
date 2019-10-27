<?php


namespace App\Dto;


class UpdateApplicationDatabaseCredentials extends Base
{
    protected $dbName;
    protected $dbHost;
    protected $dbDriver;
    protected $dbUser;
    protected $dbPassword;
    protected $dbTable;
    protected $emailField;
}

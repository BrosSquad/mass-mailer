<?php


namespace App\Dto;


class CreateApplication extends Base
{
    protected $appName;
    protected $dbName;
    protected $dbHost;
    protected $dbDriver;
    protected $dbUser;
    protected $dbPort;
    protected $dbPassword;
    protected $dbTable;
    protected $emailField;
    protected $sendgridKey;
    protected $sendGridNumberOfMessages;
}

<?php


namespace App\Dto;

/**
 * Class CreateApplication
 *
 * @package App\Dto
 * @property string $appName
 * @property string $sendgridKey
 * @property int $sendGridNumberOfMessages
 */
class CreateApplication extends Base
{
    protected $appName;
    protected $sendgridKey;
    protected $sendGridNumberOfMessages;
}

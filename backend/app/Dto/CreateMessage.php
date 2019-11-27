<?php


namespace App\Dto;


/**
 * Class CreateMessage
 * @property string $text
 * @property string $fromEmail
 * @property string $fromName
 * @property string|null $replyTo
 * @property bool $isMjml
 * @property string $subject
 * @package App\Dto
 */
class CreateMessage extends Base
{
    protected $text;
    protected $fromEmail;
    protected $fromName;
    protected $replyTo;
    protected $subject;
    protected $isMjml;
}

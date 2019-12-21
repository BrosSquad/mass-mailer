<?php


namespace App\Dto;


/**
 * Class CreateMessage
 *
 * @package App\Dto
 * @property string $fromEmail
 * @property string $fromName
 * @property string|null $replyTo
 * @property bool $isMjml
 * @property string $subject
 * @property string $text
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

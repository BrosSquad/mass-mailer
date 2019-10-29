<?php


namespace App\Dto;


class CreateMessage extends Base
{
    protected $text;
    protected $fromEmail;
    protected $fromName;
    protected $replyTo;
    protected $subject;
    protected $criteria = [];
}

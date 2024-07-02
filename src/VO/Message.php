<?php

namespace App\VO;

use Symfony\Component\Validator\Constraints as Assert;
readonly class Message
{
    #[Assert\Email(
        message: 'The email {{ value }} is not a valid email.',
    )]
    protected string $email;
    public function __construct(
        private string $name, private string $lastname,
        string $email, private string $message
    )
    {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getLastname(): string
    {
        return $this->lastname;
    }
    public function getEmail(): string
    {
        return $this->email;
    }

    public function getMessage(): string
    {
        return $this->message;
    }
}

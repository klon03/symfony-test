<?php

namespace App\Request\User;

use Symfony\Component\Validator\Constraints as Assert;

class AddUserRequest
{
    #[Assert\NotBlank]
    public string $username;

    #[Assert\NotBlank]
    public string $password;

}

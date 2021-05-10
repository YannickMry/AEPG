<?php

namespace App\Message;

class MailMemberRenewal
{
    private string $email;
    private string $fullName;
    private string $renewalToken;

    public function __construct(string $email, string $fullName, string $renewalToken)
    {
        $this->email = $email;
        $this->fullName = $fullName;
        $this->renewalToken = $renewalToken;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getFullName(): string
    {
        return $this->fullName;
    }

    public function getRenewalToken(): string
    {
        return $this->renewalToken;
    }
}
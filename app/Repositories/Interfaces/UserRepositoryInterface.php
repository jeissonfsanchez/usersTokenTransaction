<?php

namespace App\Repositories\Interfaces;

interface UserRepositoryInterface
{
    public function getUsers($params);

    public function getUserTransaction($params);

    public function getAllUsers($params);
}

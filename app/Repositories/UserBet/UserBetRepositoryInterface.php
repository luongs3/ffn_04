<?php

namespace App\Repositories\UserBet;

interface UserBetRepositoryInterface
{
    public function update($data, $id);
    public function delete($id);
}

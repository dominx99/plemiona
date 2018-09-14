<?php

namespace App\Auth;

use App\Models\User;

class Auth
{
    /**
     * @param integer $user - that's id of user variable
     * @return void
     */
    public function authorize(int $user): void
    {
        $_SESSION['user'] = $user;
    }

    /**
     * @return boolean
     */
    public function check(): bool
    {
        return isset($_SESSION['user']);
    }

    /**
     * @return User
     */
    public function user(): User
    {
        return User::find($_SESSION['user']);
    }

    /**
     * @param string $nick
     * @param string $password
     * @return boolean
     */
    public function attempt(string $nick, string $password): bool
    {
        if (!$user = User::where('nick', $nick)->first()) {
            return false;
        }

        if (!password_verify($password, $user->password)) {
            return false;
        }

        $this->authorize($user->id);

        return true;
    }

    /**
     * @return void
     */
    public function logout(): void
    {
        unset($_SESSION['user']);
    }
}

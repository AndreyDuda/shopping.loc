<?php
/**
 * Created by PhpStorm.
 * User: duda
 * Date: 08.12.18
 * Time: 18:51
 */

namespace frontend\services\auth;

use common\models\User;
use frontend\forms\SignupForm;

class SignupService
{

    public function signup(SignupForm $form): User
    {
        $user = new user();
        $user->createUser(
            $form->username,
            $form->email,
            $form->password
        );

        if (!$user->save()) {
            throw new \RuntimeException('Saving error ...');
        }

        return $user;
    }

}
<?php
/**
 * Created by PhpStorm.
 * User: duda
 * Date: 09.12.18
 * Time: 19:56
 */

namespace services\auth;


use frontend\models\PasswordResetRequestForm;
use common\models\User;
use frontend\models\ResetPasswordForm;

class PasswordResetService
{
    public function request(PasswordResetRequestForm $form): void
    {

        /* @var $user User */
        $user = User::findOne([
            'status' => User::STATUS_ACTIVE,
            'email'  => $form->email,
        ]);

        if (!$user) {
            throw new \DomainException('User is not found');
        }

        $user->requestPasswordResset();

        if (!$user->save()) {
            throw new \RuntimeException('Saving error.');
        }

        $send = \Yii::$app
            ->mailer
            ->compose(
                ['html' => 'passwordResetToken-html', 'text' => 'passwordResetToken-text'],
                ['user' => $user]
            )
            ->setFrom([\Yii::$app->params['supportEmail'] => \Yii::$app->name . ' robot'])
            ->setTo($user->email)
            ->setSubject('Password reset for ' . \Yii::$app->name)
            ->send();

        if ($send) {
            throw new \RuntimeException('Sending error.');
        }
    }

    public function validateToken($token): void
    {
        if (empty($token) || !is_string($token)) {
            throw new \DomainException('Password reset token can not be blank');
        }
        if (!User::findByPasswordResetToken($token)) {
            throw new \DomainException('Wrong password reset token');
        }
    }

    public function reset(string $token, ResetPasswordForm $form): void
    {
        $user = User::findByPasswordResetToken($token);

        if (!$user) {
            throw new \DomainException('User is not found');
        }

        $user->resetPassword($form->password);

        if (!$user->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

}
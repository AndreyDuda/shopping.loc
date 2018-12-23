<?php
/**
 * Created by PhpStorm.
 * User: duda
 * Date: 01.12.18
 * Time: 22:17
 */

namespace common\bootstrap;

use services\auth\PasswordResetService;
use yii\base\BootstrapInterface;

class SetUp implements BootstrapInterface
{
    public function bootstrap($app)
    {
        $container = \Yii::$container;

        $container->setSingleton(PasswordResetService::class, [], [
            [$app->params['supportEmail'] => $app->name . ' robot']
        ]);
    }

}
<?php

return [
    'class' => 'yii\web\UrlManager',
    'hostInfo' => $params['backendHostInfo'],
    'enablePrettyUrl' => true,
    'showScriptName'  => false,
    'rules' => [
        ''                  => 'site/index',
        '<_a:login|logout>' => 'site/<_a>'
    ],

];


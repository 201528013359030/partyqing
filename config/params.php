<?php

return [
    'adminEmail' => 'admin@example.com',
    'wechat' =>[
        'options'=>[
            'token'=>'qifahao_TELPO', //填写你设定的key
            'appid'=>'wx2841427ccd2e3857',//???发???凭???
            'appsecret'=>'439551496c4602a502bd1d2c4d370a76', //???发???凭???
            'debug'=>true,
            'logcallback'=>'./log.text' 
        ],
    ],
    'path'=>'http://'.$_SERVER['HTTP_HOST'],
    'menu'=>[
        '01'=>['main'=>'公告',
            'img'=>'images/mainmenu01.png',
            'sub'=>[
                '01'=>['name'=>'发布公告','url'=>'index.php?r=admin/main/create'],
                '02'=>['name'=>'查看公告','url'=>'index.php?r=admin/noticelist/index'],
                '03'=>['name'=>'用户管理','url'=>'index.php?r=admin/noticeuser/index'],
            ]
        ]
    ],
    'urlSubflag'=>'&subflag=0101',
    'receiverType'=>['其它','全部老师','全部学生','全部师生','其它'],
];

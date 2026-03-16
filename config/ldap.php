<?php

return [
    'connections' => [
        'default' => [
            'auto_connect' => true,
            'connection' => Adldap\Connections\Ldap::class,
            'settings' => [
                'schema' => Adldap\Schemas\ActiveDirectory::class,
                'hosts' => ['10.0.1.55'],
                'port' => 389,
                'base_dn' => 'OU=Usuarios,OU=Hospital Daher Lago Sul (PRD),DC=hdls,DC=home',
                'username' => 'desenvolvimento',
                'password' => 'desenvolvimento@123',
                'timeout' => 5,
                'follow_referrals' => true,
                'use_ssl' => false,
                'use_tls' => false,
            ],
        ],
    ],
];

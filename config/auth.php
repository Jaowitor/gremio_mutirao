<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Padrões de Autenticação
    |--------------------------------------------------------------------------
    |
    | Esta opção define o "guard" de autenticação padrão e o "broker" de
    | redefinição de senha para sua aplicação. Você pode alterar esses
    | valores conforme necessário, mas eles são um ótimo começo para
    | a maioria das aplicações.
    |
    */

    'defaults' => [
        'guard' => env('AUTH_GUARD', 'web'),
        'passwords' => env('AUTH_PASSWORD_BROKER', 'users'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Guards de Autenticação
    |--------------------------------------------------------------------------
    |
    | Aqui você pode definir todos os guards de autenticação para sua aplicação.
    | Uma configuração padrão já foi definida para você, utilizando o storage
    | de sessão e o provider Eloquent.
    |
    | Todos os guards de autenticação possuem um provider de usuários, que
    | define como os usuários são realmente recuperados do banco de dados
    | ou de outro sistema de armazenamento utilizado pela aplicação.
    | Normalmente, o Eloquent é utilizado.
    |
    | Suportados: "session"
    |
    */

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Providers de Usuários
    |--------------------------------------------------------------------------
    |
    | Todos os guards de autenticação possuem um provider de usuários, que
    | define como os usuários são realmente recuperados do banco de dados
    | ou de outro sistema de armazenamento utilizado pela aplicação.
    | Normalmente, o Eloquent é utilizado.
    |
    | Se você tiver múltiplas tabelas ou modelos de usuários, pode configurar
    | múltiplos providers para representar cada modelo/tabela. Esses providers
    | podem então ser atribuídos a qualquer guard de autenticação extra que
    | você tenha definido.
    |
    | Suportados: "database", "eloquent"
    |
    */

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => env('AUTH_MODEL', App\Models\User::class),
        ],

        // 'users' => [
        //     'driver' => 'database',
        //     'table' => 'users',
        // ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Redefinição de Senhas
    |--------------------------------------------------------------------------
    |
    | Estas opções de configuração especificam o comportamento da funcionalidade
    | de redefinição de senha do Laravel, incluindo a tabela utilizada para
    | armazenar os tokens e o provider de usuários que será chamado para
    | realmente recuperar os usuários.
    |
    | O tempo de expiração é o número de minutos que cada token de redefinição
    | será considerado válido. Este recurso de segurança mantém os tokens com
    | vida curta para que tenham menos tempo de serem adivinhados. Você pode
    | alterar conforme necessário.
    |
    | A configuração de throttle é o número de segundos que um usuário deve
    | esperar antes de gerar mais tokens de redefinição de senha. Isso evita
    | que o usuário gere rapidamente uma grande quantidade de tokens.
    |
    */

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => env('AUTH_PASSWORD_RESET_TOKEN_TABLE', 'password_reset_tokens'),
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Tempo de Expiração da Confirmação de Senha
    |--------------------------------------------------------------------------
    |
    | Aqui você pode definir a quantidade de segundos antes que a confirmação
    | de senha expire e os usuários sejam solicitados a digitar novamente sua
    | senha na tela de confirmação. Por padrão, o tempo limite é de três horas.
    |
    */

    'password_timeout' => env('AUTH_PASSWORD_TIMEOUT', 10800),
];

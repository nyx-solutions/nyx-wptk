# NYX / WordPress Toolkit

Conjunto de ferramentas para gerenciamento de sites e blogs no WordPress.

## Instalação

## Uso

### Ambiente

O plugin reconhece as constantes de ambiente abaixo:

- `ENV_IS_DEVELOPMENT`
- `ENV_IS_STAGING`
- `ENV_IS_PRODUCTION`

Se nenhuma estiver disponível, o plugin assumirá que o ambiente é de produção  `ENV_IS_PRODUCTION`.

### Componentes

Os componentes são ativados por padrão, entretanto, você pode alterar o esse comportamento através do filtro
`nyx_wptk_default_behavior`, conforme abaixo:

```php

use nyx\NyxWordPressToolkit;

add_filter(
    'nyx_wptk_default_behavior',
    static fn () => NyxWordPressToolkit::DEFAULT_BEHAVIOR_DISABLED
);

```

Para habilitar ou desabilitar um componente específico, basta utilizar adicionar um filtro contendo o nome do componente
e de seu sub-componente:

```php

add_filter(
    'nyx_wptk_component_subcomponent_enabled',
    static fn () => false
);

```

Exemplo de como desabilitar o sub-componente `main` do componente `cron`:

```php

add_filter(
    'nyx_wptk_cron_main_enabled',
    static fn () => false
);

```

#### Componentes e Sub-componentes disponíveis

- acf
    - settings
- cache
    - main
- cron
    - main
- dashboard
    - admin
- google-maps
    - main
- helpers
    - main
    - url
    - login
    - content
    - template
    - formatters
    - images
    - google-maps
    - taxonomies
    - videos
    - date-time
    - php8
- login
    - main
- login-required
    - main
- mail
    - main
- rest
    - main
- rewrite
    - main
- security
    - generic
    - head
- server-reports
    - main
- uploads
    - main
- users
    - avatars

### Dashboard

#### Posts em At a Glance

Para apresenar os `post types` de conteúdo, com algumas configurações adicionais, utilize o exemplo abaixo:

```php

add_filter(
    'nyx_wptk_dashboard_post_types',
    static fn () => [
        'post-type' => ['icon' => 'f155', 'male' => true],
        'news'      => ['icon' => 'f155', 'male' => false],
    ]
);

```

**Observação**: os post types padrões são incluídos normalmente. Os ícones podem ser encontrados em
[Developer Resources: Dashicons](https://developer.wordpress.org/resource/dashicons/#upload).

#### Menus de Administração

Por padrão, são desabilitados os seguintes menus de administração:

- menu-posts
- menu-links
- menu-comments

Você pode alterar esse comportamento através do filtro abaixo:

```php

add_filter(
    'nyx_wptk_disabled_admin_menus',
    static fn () => ['menu-links', 'menu-comments']
);

```

No exemplo acima, apenas os menus `menu-links` e `menu-comments` estarão desabilitados.

### Google Maps

Para informar o código (API key) do Google Maps para integrações, utilize o código abaixo:

```php

add_filter(
    'nyx_wptk_google_maps_api_key',
    static fn () => 'API-KEY'
);

```

### Helpers

Por padrão, todas as funções helpers estão disponíveis; porém, você pode desabilitar uma ou mais utilizando o filtro
exemplificado abaixo:

```php

add_filter(
    'nyx_wptk_enabled_functions',
    static function (array $enabledFunctions) {
        return array_diff($enabledFunctions, ['get_as_description']);
    }
);

```

#### Login

Para o funcionamento correto da função `is_login`, é necessário determinar se o `slug` ou arquivo atual deve ser
reconhecido como uma página de autenticação. Os valores reconhecidos por padrão, podem ser encontrados abaixo:

- wp-login.php
- wp-register.php
- administration
- administracao
- administracao-interna

Para adicionar novos, utilize o filtro abaixo:

```php

add_filter(
    'nyx_wptk_valid_login_pages',
    static fn () => ['pagina-de-login', 'login']
);

```

#### Assets

O plugin assume que os caminhos abaixo estarão disponíveis:

- images
- fonts
- scripts
- styles
- svg

Entretanto, o caminho base pode variar; por padrão, o plugin assume que esses caminhos poderão ser encontrados na pasta
do tema, dentro da pasta `/assets`. Isto é, `images` estará disponível em `/assets/images`. Para mudar esse comportamento,
utilize o filtro abaixo:

```php

add_filter(
    'nyx_wptk_assets_relative_path',
    static fn () => '/assets-beta'
);

```

### Login Required

Para habilitar a funcionalidade de **login obrigatório**, utilize o filtro abaixo:

```php

add_filter(
    'nyx_wptk_login_required',
    static fn () => [
        'enabled'          => true,                    // Habilita ou não chamadas REST
        'restEnabled'      => false,                   // Habilita ou não chamadas REST
        'useLoginRedirect' => true,                    // Habilita ou não o redirecionamento automático para o Login
        'htmlFilePath'     => '/path/to/template.html' // Habilita um template HTML para apresentar no bloqueio.
    ]
);

```

### Server Report

Para habilitar a funcionalidade de **server report**, utilize o filtro abaixo:

```php

add_filter(
    'nyx_wptk_server_report',
    static fn () => [
        'enabled' => false,                 // Habilita ou não a funcionalidade
        'token'   => 'token',               // Token de acesso
        'name'    => 'NYX - Server Report', // Nome
        'slug'    => 'nyx-server-report'    // Slug
    ]
);

```
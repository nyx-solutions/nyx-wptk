# NYX WordPress Toolkit

## Changelog

### 1.0.7 / 11/06/2023

#### Changed

- Alterado na função `get_template_url` para usar a função `get_stylesheet_directory_uri` ao invés da função
  `get_template_directory_uri`, de forma a capturar a URL correta em temas filhos.

### 1.0.6 / 01/09/2022

#### Changed

- Adicionado filtro para determinar se o editor (de páginas) deve ser desabilitado. Por padrão, para manter a 
  compatibilidade, o editor é desabilitado.

### 1.0.5 / 18/06/2021

#### Fix

- Correções na implementação dos avatares.

### 1.0.4 / 18/06/2021

#### Fix

- Melhorias gerais no carregamento.
- Correção na ordem de carregamento e de verificação de funções.

### 1.0.3 / 18/06/2021

#### Fix

- Correção de versão.

### 1.0.2 / 18/06/2021

#### Changed

- Logo no Login: adicionado filtro para passar a imagem e o tamanho.
- Avatares: adicionado filtro para passar a imagem padrão.

### 1.0.0 / 09/06/2021

#### Added

- Funcionalidade inicial do plugin

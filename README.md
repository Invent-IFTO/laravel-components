# Laravel Components - Invent IFTO

Este pacote fornece **componentes prontos para Laravel**, desenvolvidos pelo laboratório **Invent IFTO**, com foco em integração ao template [AdminLTE](https://github.com/jeroennoten/Laravel-AdminLTE).

## 📦 Componentes incluídos

- Carregmento de views de forma dinâmcias em um modal (`<x-invent-dynamic-modal />`)
- Outros componentes em desenvolvimento

Todos os componentes seguem a estrutura Blade nativa do Laravel e são facilmente reutilizáveis em qualquer projeto.

---

## 📚 Requisitos

- PHP ^8.1
- Laravel ^10 ou ^12
- [jeroennoten/laravel-adminlte](https://github.com/jeroennoten/Laravel-AdminLTE)

---

## 🚀 Instalação

### ✅ Opção 1: Instalação via GitHub (produção)

No `composer.json` do seu projeto principal, adicione o repositório e o pacote:

```bash
composer config repositories.invent-ifto vcs https://github.com/invent-ifto/laravel-components
```

Depois, instale com:

```bash
composer require invent-ifto/laravel-components
```

### 🔧 Opção 2: Instalação via `path` (desenvolvimento local)

Para editar e testar o pacote no seu projeto localmente:

1. Clone o pacote dentro da pasta `packages/` no seu projeto:

```bash
mkdir -p packages
cd packages
git clone https://github.com/invent-ifto/laravel-components.git
```

2. No `composer.json` do projeto principal, adicione:

```json
"repositories": [
    {
        "type": "path",
        "url": "packages/laravel-components",
        "options": {
            "symlink": true
        }
    }
]
```

3. Reinstale o pacote:

```bash
composer require invent-ifto/laravel-components
```

---

## ⚙️ Registro automático do provider

O service provider `Invent\LaravelComponents\InventProvider` é carregado automaticamente graças à configuração no `composer.json`.

---

## ✅ Como usar

No Blade:

```blade
<x-invent-alert type="success" message="Operação realizada com sucesso!" />
```

---

## 🧪 Testando alterações

Se estiver usando o modo via `path`, qualquer alteração no pacote será refletida instantaneamente.

Para garantir o autoload:

```bash
composer dump-autoload
```

---

## 📄 Licença

MIT - Copyright (c) Invent IFTO

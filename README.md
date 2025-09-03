## 🚀 Instalação e Configuração

### Pré-requisitos

- PHP 8.1 ou superior
- Composer
- SQLite (ou outro banco suportado pelo Laravel)
- Git

### Passo a Passo

#### 1. Clonar o Repositório
```bash
git clone https://github.com/marciomdrs2002/facil-tecnologia-contratos.git
cd facil-tecnlogia-contratos
```

#### 2. Instalar Dependências
```bash
composer install
```

#### 3. Configurar Ambiente
```bash
# Copiar arquivo de configuração
cp .env.example .env

# Gerar chave da aplicação
php artisan key:generate
```

#### 5. Criar Banco e Executar Migrations
```bash
# Criar arquivo do banco SQLite (se usando SQLite)
touch database/database.sqlite

# Executar migrations e seeders
php artisan migrate:fresh --seed
```

#### 6. Verificar Instalação
```bash
# Testar comando de listagem
php artisan contratos:listar
```

## 📊 Comandos Disponíveis

### 1. Listar Contratos
```bash
# Listar no terminal
php artisan contratos:listar
# Irá gerar um arquivo PDF com os dados em: storage/app/
```

### 2. Relatório Agrupado
```bash
# Exibir no terminal
php artisan contratos:agrupado

# Gerar arquivo de texto
php artisan contratos:agrupado --arquivo
# Irá gerar um arquivo TXT com os dados em: storage/app/
```

## 📁 Estrutura de Arquivos Importantes

```
app/
├── Console/Commands/
│   ├── ListarContratos.php      # Comando de listagem e PDF
│   └── RelatorioAgrupado.php    # Comando de relatório agrupado
├── Models/
│   ├── Banco.php               # Model do Banco
│   ├── Convenio.php            # Model do Convênio
│   ├── ConvenioServico.php     # Model do Convênio Serviço
│   └── Contrato.php            # Model do Contrato

database/
├── migrations/
│   └── 2025_09_03_130759_create_tables.php  # Migration das tabelas
└── seeders/
    ├── BancoSeeder.php         # Dados de exemplo dos bancos
    ├── ConvenioSeeder.php      # Dados de exemplo dos convênios
    ├── ConvenioServicoSeeder.php # Dados de exemplo dos serviços
    └── ContratoSeeder.php      # Dados de exemplo dos contratos

resources/views/pdf/
└── contratos.blade.php         # Template para PDF
```

## 🎯 Dados de Exemplo

O sistema vem com dados de demonstração que incluem:

- **5 Bancos brasileiros**: BB, CEF, BNDES, BCB, Bradesco
- **5 Convênios**: Desenvolvimento Urbano, Habitação, Infraestrutura, Tecnologia, Educação
- **10 Serviços**: Consultoria, obras, software, P&D, etc.
- **10 Contratos**: Com valores de R$ 85.000 a R$ 5.000.000

## 📈 Exemplo de Uso

### Executar Relatório Completo
```bash
# 1. Listar contratos e gerar arquivo PDF
php artisan contratos:listar

# 2. Relatório agrupado
php artisan contratos:agrupado

# 2. Relatório agrupado em arquivo TXT
php artisan contratos:agrupado --arquivo
```

### Arquivos Gerados
- **PDFs**: `storage/app/relatorio-contratos-YYYY-MM-DD-HH-mm-ss.pdf`
- **TXT**: `storage/app/relatorio-agrupado-YYYY-MM-DD-HH-mm-ss.txt`

## 🔧 Solução de Problemas

### Erro de Permissão
```bash
chmod -R 775 storage bootstrap/cache
```

### Erro de Banco de Dados
```bash
# Recriar banco e dados
php artisan migrate:fresh --seed
```

### Dependências em Falta
```bash
# Reinstalar dependências
composer install --no-dev --optimize-autoloader
```

## 🆘 Suporte

Para problemas ou dúvidas:

1. Verifique se todos os pré-requisitos estão instalados
2. Execute `composer install` para garantir dependências
3. Execute `php artisan migrate:fresh --seed` para recriar o banco
4. Verifique as permissões das pastas `storage` e `bootstrap/cache`

## 📄 Licença

Este projeto está licenciado sob a [MIT License](https://opensource.org/licenses/MIT).
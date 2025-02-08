# Easy Clinical

O **Easy Clinical** é um sistema desenvolvido para facilitar a gestão de clínicas médicas, oferecendo funcionalidades para o gerenciamento de pacientes, agendamentos, prontuários e outros aspectos administrativos.

## Funcionalidades

- Cadastro e gerenciamento de pacientes
- Agendamento de consultas
- Gestão de prontuários eletrônicos
- Relatórios e dashboards
- Controle de usuários e permissões

## Tecnologias Utilizadas

- **Backend:** PHP (Laravel)
- **Frontend:** Blade
- **Banco de Dados:** Mysql
- **ORM:** Eloquent
- **Gerenciamento de Dependências:** Composer e npm

## Estrutura do Projeto

```
easy-clinical/
├── backend/
│   ├── app/
│   ├── bootstrap/
│   ├── config/
│   ├── database/
│   ├── public/
│   ├── resources/
│   ├── routes/
│   ├── storage/
│   ├── tests/
│   ├── artisan
│   ├── composer.json
│   ├── phpunit.xml
│   └── server.php
├── frontend/
│   ├── src/
│   ├── package.json
│   ├── tsconfig.json
├── .gitignore
├── LICENSE
└── README.md
```

## Pré-requisitos

- **Backend:**
  - PHP 8.x
  - Composer instalado
  - Banco de dados Mysql configurado
- **Frontend:**
  - Node.js instalado (versão recomendada: 16 ou superior)
  - npm instalado

## Como Executar

### Backend

1. Clone o repositório:

   ```bash
   git clone https://github.com/victorfg21/easy-clinical.git
   ```

2. Acesse o diretório do backend:

   ```bash
   cd easy-clinical/backend
   ```

3. Instale as dependências:

   ```bash
   composer install
   ```

4. Configure o arquivo `.env` e gere a chave da aplicação:

   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. Configure a conexão com o Mysql no arquivo `.env`.

6. Execute as migrações do banco de dados:

   ```bash
   php artisan migrate
   ```

7. Inicie o servidor local:

   ```bash
   php artisan serve
   ```

### Frontend

1. Acesse o diretório do frontend:

   ```bash
   cd easy-clinical/frontend
   ```

2. Instale as dependências:

   ```bash
   npm install
   ```

3. Execute o aplicativo:

   ```bash
   npm run dev
   ```

4. Acesse no navegador:

   ```
   http://localhost:8000
   ```

## Testes

### Backend
Para rodar os testes unitários:

```bash
   php artisan test
```

### Frontend
Para rodar os testes unitários:

```bash
   npm run test
```

## Contribuição

Contribuições são bem-vindas! Abra uma issue ou um pull request com suas sugestões.

## Licença

Este projeto está licenciado sob a Licença MIT. Consulte o arquivo [LICENSE](LICENSE) para mais informações.

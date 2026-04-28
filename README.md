# 📸 InstaClone API

Uma API RESTful robusta e escalável desenvolvida em **Laravel 13** e **PHP 8.3+**, projetada para servir como o ecossistema de backend de uma rede social. O projeto foca em alta performance e isolamento total de ambiente via **Docker**.

## 🚀 Tecnologias Utilizadas

* **Linguagem:** PHP 8.3+
* **Framework:** Laravel 13
* **Banco de Dados:** MySQL 8.0
* **Autenticação:** Laravel Sanctum (Bearer Token)
* **Documentação:** L5 Swagger (OpenAPI 3.0)
* **Containerização:** Docker & Docker Compose

## 🏗️ Arquitetura e Padrões

O projeto segue princípios de **Clean Code** e **SOLID**, com as seguintes camadas:
* **Controllers:** Responsáveis apenas por receber a requisição e devolver a resposta.
* **Services:** Camada de lógica de negócio isolada, garantindo que o código seja testável e reutilizável.
* **Models/Eloquent:** Abstração da camada de dados e relacionamentos.
* **Middleware/Sanctum:** Proteção de rotas e persistência de estado via tokens stateless.

## 🛠️ Instruções de Execução (Onboarding)

Para rodar este projeto em uma nova máquina, certifique-se de ter o **Docker** e o **Docker Compose** instalados. Siga os passos abaixo:

### 1. Clonar e Configurar Variáveis
Clone o repositório e crie o arquivo de ambiente:
```bash
git clone https://github.com/seu-usuario/instaclone-api.git
cd instaclone-api
cp .env.example .env
```

> **Nota:** Certifique-se de que a variável `L5_SWAGGER_CONST_HOST=http://localhost:8000/api` esteja presente no seu `.env`.

### 2. Subir o Ambiente Docker

Este comando irá baixar as imagens, instalar as dependências do Composer e configurar os volumes:
```bash
docker compose up -d --build
```

### 3. Preparar a Aplicação

Gere a chave da aplicação e configure as permissões de escrita:
```bash
docker compose exec app php artisan key:generate
docker compose exec app chmod -R 777 storage bootstrap/cache
```

### 4. Banco de Dados e Seeds

Crie as tabelas (incluindo as migrations do Sanctum) e popule o banco com dados de teste:
```bash
docker compose exec app php artisan migrate:fresh --seed
```

### 5. Gerar Documentação Swagger

Para visualizar e testar os endpoints interativamente:
```bash
docker compose exec app php artisan l5-swagger:generate
```

## 📖 Documentação da API

Após seguir os passos acima, a documentação interativa (Swagger UI) estará disponível em:
👉 `http://localhost:8000/api/documentation`

---

*Desenvolvido por Guilherme Bondezan como projeto final do Code Academy (Instituto 3C).*

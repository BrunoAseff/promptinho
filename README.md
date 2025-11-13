# Promptinho

Ferramenta para análise e contagem de tokens em prompts de IA.

## O que faz

Permite analisar como diferentes modelos de linguagem tokenizam texto. Você escreve prompts e vê em tempo real quantos tokens são gerados, além de visualizar cada token individualmente.

Suporta os algoritmos de tokenização do GPT-4o (`o200k_base`) e GPT-3.5-turbo (`cl100k_base`).

## Tecnologias

**Frontend**
- Vue 3 + TypeScript
- Vite

**Backend**
- Laravel 10
- Tiktoken (yethee/tiktoken)

## Como rodar

### Backend

```bash
cd backend
composer install
php artisan serve
```

### Frontend

```bash
cd frontend
pnpm install
pnpm dev
```

Ou roda `pnpm dev:all` no front pra rodar os dois ao mesmo tempo

O backend roda em `http://localhost:8000` e o frontend em `http://localhost:5173`.

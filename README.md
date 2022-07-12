# Teste Laravel + VueJS

Segue meu teste pronto, conforme solicitado na documentação. Confesso que tive uma dificuldade com o Laravel nessa versão 9, mas tentei fazer da melhor forma possível.

Peço também desculpas pela demora, pois tive Covid e fiquei ruim (ainda estou um pouco).

## Instalação

- `git clone` no repositório;
- Executar o `composer install` dentro da pasta do projeto clonado;
- Criar o arquivo `.env` com configurações para conexão com banco de dados;
- Executar migração do banco com o comando `php artisan migrate`;
- Iniciar servidor `php artisan serve`

## API

Na API foram criado os seguintes métodos:

- `GET` - Buscar todos endereços na base local: `/api/cep`;
- `POST` - Adicionar um novo endereço na base local informando o campo CEP: `/api/cep`;
- `PUT` - Editar endereço na base local informando todos os campos: `/api/cep/{cep}`;
- `DELETE` - Excluir endereço na base local: `/api/cep/{cep}`.

E também foi criad o método para buscar um endereço por CEP ou Logradouro. Sendo que:
- Quando o CEP é informado, a API faz uma busca no banco local, se encontrar, deolve ao usuário. Se não encontrar, faz uma busca externa.
- Quando o Logradouro é informado, a API faz uma busca no banco local.
- `POST` - Enviar JSON com campo "cep" ou "logradouro" para: `/api/find/`.

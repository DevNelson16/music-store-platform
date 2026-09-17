# Caso Prático — Base de Dados MySQL: Banda/Artista de Música

**Autor:** Nelson Geovetty Jaime
**Base de dados:** `carrinho_db`

Esta entrega corrige o caso prático do 5º módulo (gestão de eventos e bilhetes),
**integrando as correções diretamente no site completo da banda** já existente —
em vez de entregar apenas ficheiros isolados.

## Estrutura da entrega

```
├── README.md                          este ficheiro
├── Credenciais de Administrador.pdf   credenciais de acesso ao painel admin
├── carrinho_db.sql                    script completo da base de dados
│                                       (site inteiro + tabelas/views do caso prático)
├── diagrama/
│   ├── esquema_base_dados.png         esquema visual (ER) das 4 tabelas do enunciado
│   └── esquema_base_dados.svg         versão vetorial do esquema
├── docs/
│   ├── documentacao.pdf               documentação completa (objetivo, esquema,
│   │                                  tabelas, views, testes, captura de ecrã real)
│   ├── resultado_testes.txt           output real dos testes das views em MySQL
│   └── screenshot_tickets.png         captura de ecrã da app a usar a view event_details
└── site/                              o site completo da banda, com as correções
    ├── db.php                         ligação central (PDO + mysqli) a carrinho_db
    ├── add_event.php / edit_event.php criação/edição de eventos (novos campos)
    ├── tickets.php                    lista eventos usando a view event_details
    ├── comprar_ticket.php             fluxo de compra (transação com sales)
    ├── admin.php                      painel de administração (eventos/bilhetes/vendas)
    └── ... (restantes páginas do site: loja, álbuns, tour, contactos, etc.)
```

## Como testar

1. Importar `carrinho_db.sql` (recomendado: `mysql --default-character-set=utf8mb4 -u root < carrinho_db.sql`,
   para garantir a acentuação correta).
2. Ajustar as credenciais em `site/db.php` se necessário (por defeito: `root` sem password, `127.0.0.1`).
3. Colocar a pasta `site/` num servidor PHP e abrir `tickets.php` no browser — mostra os
   eventos e a disponibilidade de bilhetes em tempo real, a partir da view `event_details`.
4. Testar uma compra em `comprar_ticket.php?event_id=1` (ou outro id) para ver a
   transação completa (cliente, venda, bilhete) a funcionar.
5. Entrar em `login_admin.php` (ver credenciais no PDF) e consultar `admin.php`
   para ver a listagem de eventos, bilhetes e vendas.

## Resumo do que foi corrigido face à entrega anterior

- `carrinho_db.sql` começa com `CREATE DATABASE IF NOT EXISTS carrinho_db; USE carrinho_db;`
  e `SET NAMES utf8mb4` (evita problemas de acentuação ao importar).
- Tabela `events` passou a ter `time` e `capacity`, com os nomes exatos do enunciado
  (`name`, `date`, em vez de `title`, `event_date`).
- Tabela `tickets` passou a ter `price` e `seat_number` (deixou de estar só associado ao evento).
- As 4 views (`event_details`, `customer_sales_summary`, `event_sales_summary`,
  `tickets_status`) foram recriadas com exatamente os campos pedidos no enunciado.
- Foi criado o esquema visual da base de dados (diagrama ER) e o PDF de documentação.
- **As correções foram integradas em todas as páginas do site que usam eventos/bilhetes**
  (`add_event.php`, `edit_event.php`, `tickets.php`, `comprar_ticket.php`, `admin.php`),
  em vez de ficar apenas numa demo isolada — o site continua completo e funcional.
- A view `event_details` passou a ser usada diretamente em `tickets.php`, servindo
  também como demonstração da utilização das views na aplicação.
- Ligação à base de dados centralizada em `site/db.php` (PDO + mysqli), e os 4 ficheiros
  que abriam ligação própria (dois deles à base errada, `banda`) foram corrigidos para
  usar sempre `carrinho_db` através dessa ligação central.
- Todo o fluxo foi testado de ponta a ponta num servidor MySQL + PHP reais (não só
  verificado por leitura de código).

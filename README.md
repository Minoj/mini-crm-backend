# Mini CRM — Backend

Kichik CRM tizimi uchun REST API. Mijozlar (Clients) va bitimlarni (Deals) boshqarish, rolga asoslangan ruxsatlar (har bir menejer faqat o'ziga tegishli mijoz/bitimlarni ko'radi, admin — barchasini).

## Texnologiyalar

- **PHP 8.3**, **Symfony 7.4**
- **API Platform** — REST API resurslari, avtomatik CRUD, OpenAPI hujjatlari
- **PostgreSQL 16**
- **JWT autentifikatsiya** (`lexik/jwt-authentication-bundle`)
- **Docker / Docker Compose** — to'liq konteynerlashtirilgan muhit

## Arxitektura

- DTO + Factory + Manager + Action Controller pattern — biznes logikasini API Platform'ning avtomatik CRUD'idan ajratib, controllerlarni "yupqa" saqlash uchun
- Custom State Provider'lar — foydalanuvchiga tegishli ma'lumotlarni filtrlash (`ClientCollectionProvider`, `DealCollectionProvider`)
- Symfony Security expression'lari (`security: "object.getCreatedBy() == user || is_granted('ROLE_ADMIN')"`) — resurs darajasidagi ruxsatlar

## Ishga tushirish

\`\`\`bash
docker compose up -d --build
docker compose exec php composer install
docker compose exec php php bin/console lexik:jwt:generate-keypair
docker compose exec php php bin/console doctrine:migrations:migrate
\`\`\`

API hujjatlari: `http://localhost:8000/api/docs`

## Loyiha haqida

Bu loyiha Symfony va API Platform'ni chuqurroq o'rganish maqsadida, Claude (Anthropic) yordamida bosqichma-bosqich qurilgan — AI yo'nalish va tushuntirish bergan, kod yozish va debugging mustaqil bajarilgan.

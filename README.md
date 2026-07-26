# Mini CRM — Backend

Kichik CRM tizimi uchun REST API. Mijozlar (Clients) va bitimlarni (Deals) boshqarish, rolga asoslangan ruxsatlar bilan — har bir foydalanuvchi faqat o'ziga tegishli ma'lumotlarni ko'radi, admin esa barchasini boshqara oladi.

## 🔗 Demo

- **Frontend (ishlab turgan ilova):** https://humoyun1.uz
- **API hujjatlari (Swagger UI):** https://mini-crm-backend-218m.onrender.com/api/docs

> ⚠️ **Muhim:** Backend bepul Render rejasida ishlaydi. Agar 15 daqiqa davomida hech kim so'rov yubormasa, server "uxlab qoladi". Shuning uchun **birinchi so'rov (masalan login yoki sahifa ochish) 30-60 soniya sekin javob berishi mumkin** — bu xato emas, server "uyg'onmoqda". Keyingi barcha so'rovlar tez ishlaydi.

## Texnologiyalar

- **PHP 8.3**, **Symfony 7.4**
- **API Platform** — REST API resurslari, avtomatik CRUD, OpenAPI hujjatlari
- **PostgreSQL 16**
- **JWT autentifikatsiya** (`lexik/jwt-authentication-bundle`)
- **Docker / Docker Compose** — to'liq konteynerlashtirilgan muhit (dev va prod uchun alohida konfiguratsiya)
- **Nginx + PHP-FPM** — production muhitida

## Funksionallik

- Ro'yxatdan o'tish / kirish (JWT autentifikatsiya)
- **Mijozlar (Clients)** — CRUD, har bir menejer faqat o'z mijozlarini ko'radi
- **Bitimlar (Deals)** — CRUD, status boshqaruvi (yangi → muzokara → yutilgan/yo'qotilgan)
- **Rolga asoslangan ruxsatlar** — oddiy foydalanuvchi (menejer) faqat o'ziga tegishlisini ko'radi, admin — barchasini
- **Admin Panel** — foydalanuvchilar ro'yxati va rol boshqaruvi (faqat admin uchun)

## Arxitektura

- **DTO + Factory + Manager + Action Controller** pattern — biznes logikasini ApiPlatform'ning avtomatik CRUD'idan ajratib, controllerlarni "yupqa" saqlash uchun
- **Custom State Provider'lar** — foydalanuvchiga tegishli ma'lumotlarni filtrlash (`ClientCollectionProvider`, `DealCollectionProvider`)
- **Symfony Security expression'lari** (`security: "object.getCreatedBy() == user || is_granted('ROLE_ADMIN')"`) — resurs darajasidagi ruxsatlar

## Lokal ishga tushirish

\`\`\`bash
docker compose up -d --build
docker compose exec php composer install
docker compose exec php php bin/console lexik:jwt:generate-keypair
docker compose exec php php bin/console doctrine:migrations:migrate
\`\`\`

API hujjatlari: `http://localhost:8000/api/docs`

## Loyiha haqida

Bu loyiha Symfony va API Platform'ni chuqurroq o'rganish maqsadida, Claude (Anthropic) yordamida bosqichma-bosqich qurilgan — AI arxitektura yo'nalishi va texnik tushuntirish bergan, kod yozish, debugging va production deploy mustaqil bajarilgan.

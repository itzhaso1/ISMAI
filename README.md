# ISMAI Industrial Ecommerce

متجر إلكتروني صناعي احترافي مبني على Laravel وMySQL، مع واجهة عربية RTL وإنجليزية LTR، Dark Mode، Navbar متجاوب، Mega Menu، Live Search، Hero Slider، وقاعدة بيانات قابلة للتوسع للمنتجات والأقسام والطلبات والإعدادات.

## المتطلبات

- PHP 8.2+
- Composer
- Node.js 20+
- MySQL 8+

> ملاحظة: بيئة Cursor الحالية لا تحتوي على PHP/Composer، لذلك تم إنشاء هيكل Laravel يدويًا ولم يتم تشغيل migrations أو الاختبارات داخل هذه البيئة.

## التشغيل المحلي

```bash
cp .env.example .env
composer install
npm install
php artisan key:generate
php artisan migrate --seed
npm run build
php artisan serve
```

## إعداد قاعدة البيانات

في ملف `.env` عدل القيم التالية حسب MySQL لديك:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ismai_store
DB_USERNAME=root
DB_PASSWORD=
```

## ما تم إنجازه

1. إنشاء Laravel Project Structure.
2. إعداد MySQL في `.env.example` و`config/database.php`.
3. إنشاء migrations للجداول المطلوبة: users, categories, products, product_images, brands, sliders, orders, settings, contacts, social_links.
4. إنشاء models والعلاقات الأساسية.
5. إعداد routes للواجهة، المصادقة، البحث، اللغة، ولوحة التحكم.
6. إنشاء Navbar احترافي Sticky/Responsive/Animated.
7. إنشاء Mega Menu للأقسام.
8. إنشاء Hero Slider Full Width مع Auto Slide وCTA.
9. إنشاء Admin Panel منفصل ومحمي بـ Admin role.
10. CRUD كامل للمنتجات، الأقسام، البراندات، السلايدر، المستخدمين، الطلبات، السوشيال، والنصوص الثابتة.
11. Site Settings Manager لإدارة اللوجو، اسم الموقع، أرقام الهاتف، الإيميل، العنوان، الفوتر، والتحكم بأقسام الصفحة الرئيسية.
12. Multiple product images مع upload/delete من لوحة التحكم.
13. Nested dynamic categories داخل Mega Menu.
14. Caching للإعدادات والأقسام وروابط التواصل، مع eager loading وpagination.

## بيانات الدخول التجريبية بعد seed

```text
Email: admin@example.com
Password: password
```

## المسارات الأساسية

- `/` الصفحة الرئيسية
- `/products` المنتجات مع filtering وpagination
- `/products/{slug}` صفحة المنتج
- `/categories/{slug}` صفحة القسم
- `/search/suggestions?q=` البحث المباشر
- `/language/ar` و`/language/en` تبديل اللغة
- `/login`, `/register`, `/forgot-password`
- `/admin` بداية لوحة التحكم

## ملفات Backend الأساسية

- `app/Services/SiteSettingsManager.php`
- `app/Http/Middleware/EnsureAdmin.php`
- `app/Http/Controllers/Admin/*Controller.php`
- `routes/admin.php`
- `resources/views/layouts/admin.blade.php`
- `resources/views/admin/**`

## ملاحظات تشغيل مهمة

- الصور المرفوعة تحفظ على Laravel public disk وتخدم عبر `/storage/{path}` بدون الحاجة لتشغيل `php artisan storage:link` في بيئة التطوير.
- بعد `php artisan migrate --seed` يمكن تسجيل الدخول إلى `/admin` ببيانات الأدمن التجريبية أدناه.

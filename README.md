# نظام نقطة البيع للمطاعم (Restaurant POS System)

نظام كاشير مطعم متكامل مبني باستخدام Laravel و MySQL مع واجهة مستخدم باستخدام Bootstrap و jQuery.

## المميزات

- ✅ إدارة الوجبات (إضافة، تعديل، حذف، تفعيل/تعطيل)
- ✅ إنشاء الطلبات مع حساب تلقائي للضريبة
- ✅ طباعة الفواتير (فاتورة العميل، أوردر الطبخ، فاتورة التوصيل)
- ✅ إدارة البنود غير الخاضعة للضريبة (مثل التأمين)
- ✅ فتح وإغلاق نقطة البيع مع تسجيل الرصيد
- ✅ التقارير اليومية (المبيعات، الطلبات، المبيعات حسب الوجبة)
- ✅ واجهة POS بدون شريط جانبي
- ✅ نظام مصادقة مع أدوار المستخدمين (مدير، كاشير)

## متطلبات التشغيل

- PHP >= 8.2
- MySQL >= 5.7
- Composer
- Node.js و npm

## التثبيت

1. استنساخ المشروع:
```bash
git clone <repository-url>
cd new_pos
```

2. تثبيت التبعيات:
```bash
composer install
npm install
```

3. إعداد ملف البيئة:
```bash
cp .env.example .env
php artisan key:generate
```

4. تحديث إعدادات قاعدة البيانات في ملف `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel_new_pos
DB_USERNAME=root
DB_PASSWORD=
```

5. تشغيل Migrations و Seeders:
```bash
php artisan migrate
php artisan db:seed
```

6. إنشاء رابط التخزين:
```bash
php artisan storage:link
```

7. بناء الأصول:
```bash
npm run build
```

أو للتطوير:
```bash
npm run dev
```

## بيانات الدخول الافتراضية

**مدير:**
- البريد: admin@pos.com
- كلمة المرور: password

**كاشير:**
- البريد: cashier@pos.com
- كلمة المرور: password

## الاستخدام

1. قم بتسجيل الدخول باستخدام بيانات المدير أو الكاشير
2. افتح نقطة البيع من لوحة التحكم
3. اذهب إلى "نقطة البيع" لإنشاء طلب جديد
4. اختر الوجبات وأضفها للطلب
5. يمكنك تحديد البنود غير الخاضعة للضريبة
6. أضف التوصيل إذا لزم الأمر
7. اختر طريقة الدفع وأكمل الطلب
8. يمكنك طباعة الفاتورة وأوردر الطبخ

## البنية

```
app/
├── Http/Controllers/     # Controllers
├── Models/               # Models
└── Services/             # Business Logic Services

database/
├── migrations/           # Database Migrations
└── seeders/              # Database Seeders

resources/
├── views/                # Blade Templates
├── js/                   # JavaScript Files
└── css/                  # CSS Files
```

## الميزات الإضافية

- حساب الضريبة تلقائياً (14% VAT)
- دعم البنود غير الخاضعة للضريبة
- فاتورة منفصلة للتوصيل
- تقارير يومية مفصلة
- واجهة POS محسنة للشاشات اللمسية

## التطوير

لتشغيل المشروع في وضع التطوير:

```bash
php artisan serve
npm run dev
```

ثم افتح المتصفح على: http://localhost:8000

## الرخصة

هذا المشروع مفتوح المصدر ومتاح للاستخدام الحر.

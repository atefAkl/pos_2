---
name: Restaurant POS System
overview: ""
todos: []
---

# خطة تطبيق نظام نقطة بيع المطعم

## نظرة عامة على البنية

التطبيق سيكون نظام نقطة بيع بسيط للمطاعم يتضمن:

- إدارة الوجبات والتصنيفات
- إنشاء الطلبات (تناول في المطعم / خارجي / توصيل)
- معالجة المدفوعات (نقد / بطاقة / محفظة إلكترونية)
- طباعة الأوردرات والفواتير
- تقارير يومية شاملة

## البنية التقنية

### Backend

- **Laravel** - Framework PHP
- **MySQL** - قاعدة البيانات
- **Blade** - محرك القوالب

### Frontend

- **Bootstrap 5** - إطار عمل CSS
- **jQuery** - مكتبة JavaScript
- **Blade Templates** - واجهات المستخدم

## هيكل قاعدة البيانات

### الجداول الأساسية:

1. **users** - المستخدمون (مستخدم واحد بسيط)
2. **categories** - تصنيفات الوجبات (مثل: مقبلات، أطباق رئيسية، مشروبات)
3. **meals** - الوجبات (الاسم، السعر، التصنيف، الصورة)
4. **orders** - الطلبات (رقم الطلب، النوع، الحالة، التاريخ، الإجمالي)
5. **order_items** - عناصر الطلب (الوجبة، الكمية، السعر)
6. **payments** - المدفوعات (الطلب، طريقة الدفع، المبلغ)

## الملفات الرئيسية

### Models

- `app/Models/User.php`
- `app/Models/Category.php`
- `app/Models/Meal.php`
- `app/Models/Order.php`
- `app/Models/OrderItem.php`
- `app/Models/Payment.php`

### Controllers

- `app/Http/Controllers/AuthController.php` - المصادقة
- `app/Http/Controllers/CategoryController.php` - إدارة التصنيفات
- `app/Http/Controllers/MealController.php` - إدارة الوجبات
- `app/Http/Controllers/OrderController.php` - إدارة الطلبات
- `app/Http/Controllers/PaymentController.php` - معالجة المدفوعات
- `app/Http/Controllers/ReportController.php` - التقارير
- `app/Http/Controllers/PrintController.php` - طباعة الفواتير

### Views (Blade)

- `resources/views/layouts/app.blade.php` - القالب الأساسي
- `resources/views/auth/login.blade.php` - صفحة تسجيل الدخول
- `resources/views/dashboard/index.blade.php` - لوحة التحكم الرئيسية
- `resources/views/meals/index.blade.php` - قائمة الوجبات
- `resources/views/orders/create.blade.php` - إنشاء طلب جديد
- `resources/views/orders/show.blade.php` - عرض الطلب
- `resources/views/reports/daily.blade.php
# 🏨 Vistana Hotel Management System

## Leader : Haedara Deeb 
## Deputy Commander : Mohammad Shaheen 
## Develop 1 : Bedoor Ali Deeb 
## Develop 2 : Zaher Sankari 
## Develop 3 : Ali Mohammad Abbas 
## Develop 4 : Mais Ahmad 

### **1. صفحة تسجيل الدخول (Login Page)**
*واجهة تسجيل الدخول الآمنة مع تحقق متعدد الطبقات*
<img width="1893" height="972" alt="Screenshot 2026-01-14 225615" src="https://github.com/user-attachments/assets/2e7fbecf-4651-427a-bd2a-56f1eb194bd2" />

2. لوحة التحكم (Dashboard)
رسوم بيانية وتحليلات مفصلة للإيرادات والإشغال
<img width="1919" height="971" alt="Screenshot 2026-01-14 225744" src="https://github.com/user-attachments/assets/6dbd9e7b-53bc-4d9a-b64c-4ece0b96e561" />

<img width="1901" height="974" alt="Screenshot 2026-01-14 225846" src="https://github.com/user-attachments/assets/f867a559-836d-4f95-a05e-a9900a2aae97" />

3 . Reservations Management

<img width="1898" height="964" alt="Screenshot 2026-01-14 225916" src="https://github.com/user-attachments/assets/930e51ae-9add-4bf7-8cac-2cf541e3aff1" />


📖 وصف المشروع

### **Description**
**Vistana Hotel Management System** is a comprehensive, modern hotel management solution built with Laravel 12. The system provides end-to-end management capabilities for hotel operations including reservations, room management, billing, customer relationships, and staff management. With a sleek, responsive dashboard built using Flowbite and Tailwind CSS, the system offers real-time insights and streamlined operations for hotel administrators.
### **الوصف **
**نظام إدارة الفنادق فيستانا** هو حل شامل وحديث لإدارة الفنادق، تم تطويره باستخدام Laravel 12. يوفر النظام إمكانيات إدارة متكاملة لعمليات الفندق، بما في ذلك الحجوزات، وإدارة الغرف، والفواتير، وعلاقات العملاء، وإدارة الموظفين. بفضل لوحة تحكم أنيقة وسريعة الاستجابة، تم تصميمها باستخدام Flowbite وTailwind CSS، يقدم النظام رؤى فورية وعمليات مبسطة لمديري الفنادق.

**Key Business Values:**
- ✅ **Reduce booking errors** with a centralized reservation system
- ✅ **Real-time revenue tracking** and occupancy rate monitoring
- ✅ **Improve customer satisfaction** with seamless check-in/out processes
- ✅ **Multi-role access control** for different staff levels

**القيم التجارية الرئيسية:**
- ✅ **تقليل أخطاء الحجز** بنظام حجوزات مركزي
- ✅ **تحسين رضا العملاء** بعمليات تسجيل دخول/خروج سلسة
- ✅ **تتبع الإيرادات الفوري** ومراقبة معدل الإشغال
- ✅ **تحكم متعدد الصلاحيات** لمستويات مختلفة من الموظفين

## 🏗️ هيكل قاعدة البيانات (ERD)
<img width="1060" height="790" alt="Screenshot 2026-01-15 005213" src="https://github.com/user-attachments/assets/dd710e8e-8962-4034-8d21-6f726c5a73d5" />

  ### **Main  Tables:**
- **Users**: إدارة المستخدمين 
- **Rooms & Room Types**: إدارة الغرف وأنواعها
- **Reservations**: نظام الحجوزات المتكامل
- **Services**: الخدمات  للفندق
- **Invoices**: نظام الفواتير والدفعات
- **Ratings**: تقييمات العملاء
- **Images** : الصور للغرف وأنواع الغرف و الخدمات
- **notifications** :  الإشعارات

  🔌 واجهة برمجة التطبيقات (API Documentation)

مقدمة عن API
نظام API مصمم باستخدام Laravel Sanctum للمصادقة، يدعم جميع عمليات CRUD الأساسية مع نظام تحكم كامل في الصلاحيات عبر Laravel Spatie. جميع الطلبات تتطلب توثيق باستخدام Bearer Token ما لم يُذكر غير ذلك.

نظام التوثيق (Authentication)
Authorization: Bearer {sanctum_token}
Content-Type: application/json
1. 🔐 وحدات المصادقة (Auth Endpoints)
2. 2. 🏨 أنواع الغرف (RoomType Endpoints)
3. 🛏️ الغرف (Rooms Endpoints)
4. ⭐ التقييمات (Ratings Endpoints)
5. 📅 الحجوزات (Reservation Endpoints)
6. 🛎️ الخدمات (Services Endpoints)
7. 🧾 الفواتير (Invoices Endpoints)

🔗 Postman Collection
The Collections :   ====>>>>>       https://documenter.getpostman.com/view/50368281/2sBXVifovz

✨ المميزات الرئيسية
🎯 لإدارة الفندق
نظام حجوزات متكامل مع تقويم تفاعلي

إدارة متعددة الغرف والأنواع

نظام فواتير آلي 

تقارير وإحصائيات حية

إدارة الخدمات 

👨‍💼 لوحة تحكم إدارية
واجهة حديثة مع Flowbite & Tailwind CSS

إشعارات فورية (Real-time Notifications)


🔐 الأمان والمصادقة
مصادقة كاملة مع Laravel Breeze

API Authentication مع Laravel Sanctum

نظام صلاحيات متعدد المستويات (Laravel Spatie)

CSRF Protection

تسجيل دخول آمن 

📱 للضيوف والعملاء

نظام تقييم 

إشعارات عبر البريد الإلكتروني


🛠️ التقنيات المستخدمة
Backend
Laravel 12 - إطار العمل الرئيسي

Laravel Breeze - نظام المصادقة

Laravel Sanctum - API Authentication

Laravel Spatie - نظام الصلاحيات

Laravel Eloquent - ORM

MySQL 8.0 - قاعدة البيانات

Laravel Notifications - نظام الإشعارات

Laravel Observers - مراقبة التغييرات

Laravel Mail - نظام البريد الإلكتروني




Frontend
Flowbite - مكونات UI متقدمة

Tailwind CSS 3 - إطار العمل CSS

Vite 5 - Build Tool


Alpine.js - للتفاعلية

Chart.js- الرسوم البيانية

⚡ التثبيت السريع
المتطلبات المسبقة
PHP 8.2 أو أعلى

Composer 2.x

Node.js 24.x أو أعلى

MySQL 8.0+


# 1. استنساخ المشروع
git clone https://github.com/haedaraedeeb-stack/Hotel-Management.git
cd Hotel-Management

# 2. تثبيت اعتمادات PHP
composer install

# 3. تثبيت اعتمادات JavaScript
npm install

# 4. نسخ ملف البيئة
cp .env.example .env

# 5. إنشاء مفتاح التطبيق
php artisan key:generate

# 6. تكوين قاعدة البيانات (في ملف .env)
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=hotelmanagement
DB_USERNAME=root
DB_PASSWORD=

# 7. إنشاء جميع جداول التطبيق ووحداته 
php artisan migrate 

# 8. ملء قاعدة البيانات 
php artisan db:seed

# 9. بناء الأصول
npm run build

# 10. تشغيل الخادم
php artisan serve

مطور بـ ❤️ باستخدام Laravel 12, Flowbite, Sanctum, Spatie, Breeze
نظام متكامل لإدارة الفنادق مع لوحة تحكم حديثة وواجهة برمجة تطبيقات قوية

📄 الترخيص
هذا المشروع مرخص تحت MIT License.


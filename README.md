# 🏨 Vistana Hotel Management System

<p align="center">
  <img src="https://raw.githubusercontent.com/tandpfun/skill-icons/main/icons/Laravel-Dark.svg" width="45" alt="Laravel" />
  <img src="https://raw.githubusercontent.com/tandpfun/skill-icons/main/icons/PHP-Dark.svg" width="45" alt="PHP" />
  <img src="https://raw.githubusercontent.com/tandpfun/skill-icons/main/icons/MySQL-Dark.svg" width="45" alt="MySQL" />
  <img src="https://raw.githubusercontent.com/tandpfun/skill-icons/main/icons/TailwindCSS-Dark.svg" width="45" alt="Tailwind" />
  <img src="https://raw.githubusercontent.com/tandpfun/skill-icons/main/icons/Postman.svg" width="45" alt="Postman" />
</p>

<p align="center">
  <b>A High-End, Enterprise-Ready Hotel Management Solution.</b><br>
  <i>نظام إدارة فنادق متكامل يعتمد على معايير البرمجة النظيفة (Clean Code) وهيكلية الخدمات (Service Layer Architecture).</i>
</p>

<div align="center">
  <details>
    <summary><b>🌐 Choose Documentation Language / اختر لغة التوثيق</b></summary>
    <p>
    <a href="#english">English Version</a> • 
    <a href="#arabic">النسخة العربية</a>
    </p>
  </details>
</div>

---

<img width="1918" height="970" alt="image" src="https://github.com/user-attachments/assets/1f780475-ede4-4cf8-9228-0595cc2e70c2" />
<img width="1918" height="967" alt="image" src="https://github.com/user-attachments/assets/500847e3-20bf-4352-91d6-6c3eb35b62cd" />
<img width="1901" height="971" alt="image" src="https://github.com/user-attachments/assets/aa4bdf40-550c-4b49-bd92-155be8b7a838" />
<img width="1901" height="971" alt="image" src="https://github.com/user-attachments/assets/5ce42e7f-ed49-41ba-b5fd-8a0f02c54c2e" />
<img width="1918" height="968" alt="image" src="https://github.com/user-attachments/assets/7dd15b90-a207-4d1e-b7f9-3fd8e5de2aff" />
<img width="1902" height="967" alt="image" src="https://github.com/user-attachments/assets/270fe168-6e08-494c-b4e0-9bcc2a46d022" />
    
<h2 id="english">🚀 English Version</h2>

### 📖 Project Description
**Vistana Hotel Management System** is a comprehensive, modern hotel management solution built with **Laravel 12**. The system provides end-to-end management capabilities for hotel operations including reservations, room management, billing, customer relationships, and staff management. With a sleek dashboard built using **Flowbite** and **Tailwind CSS**, it offers real-time insights and streamlined operations.

### 🏗️ Advanced Architecture (Service Layer)
The system utilizes a sophisticated **Service Layer Pattern** to decouple business logic from controllers, ensuring maximum maintainability and testability.
<img width="1060" height="790" alt="Screenshot 2026-01-15 005213" src="https://github.com/user-attachments/assets/fd65b70e-bc99-4947-9766-bdb8e4df0c9a" />

#### 📁 Key Structure Overview (Sample Files)
<table>
  <tr>
    <td width="50%">
      <b>📂 App/Services (Examples)</b><br>
      • <code>ApiReservationService.php</code>: Handles booking logic.<br>
      • <code>ApiInvoiceService.php</code>: Manages automated billing.<br>
      • <code>RoomService.php</code>: Core room operations.<br>
      • <code>UserService.php</code>: Identity management.
    </td>
    <td width="50%">
      <b>📂 Database/Migrations (Examples)</b><br>
      • <code>create_room_types_table</code>: Dynamic categories.<br>
      • <code>create_reservations_table</code>: Core transaction engine.<br>
      • <code>create_invoices_table</code>: Billing records.<br>
      • <code>create_notifications_table</code>: Real-time alerts.
    </td>
  </tr>
</table>

### 🗄️ Database Structure (Main Tables)
*Below are some of the primary tables used in the system:*
* **Users**: Manages user accounts and roles (Admin, Employee, Client).
* **Rooms & Room Types**: Handles room availability and categorizations.
* **Reservations**: Integrated system for booking management.
* **Invoices**: Automated billing and payment tracking.
* **Ratings**: Customer feedback and service evaluation.

### 🔌 API Documentation (Sample Endpoints)
The system features a robust API built with **Laravel Sanctum**. Below is a map of some core endpoints:

<table>
  <thead>
    <tr style="background-color: #1e293b; color: white;">
      <th>Module</th>
      <th>Method</th>
      <th>Endpoint</th>
      <th>Authentication</th>
    </tr>
  </thead>
  <tbody>
    <tr><td>🔐 <b>Auth</b></td><td><kbd>POST</kbd></td><td><code>/api/auth/login</code></td><td>Public</td></tr>
    <tr><td>🏨 <b>RoomTypes</b></td><td><kbd>GET</kbd></td><td><code>/api/room-types</code></td><td>Bearer Token</td></tr>
    <tr><td>🛏️ <b>Rooms</b></td><td><kbd>POST</kbd></td><td><code>/api/rooms</code></td><td>Bearer Token</td></tr>
    <tr><td>📅 <b>Booking</b></td><td><kbd>POST</kbd></td><td><code>/api/reservations</code></td><td>Bearer Token</td></tr>
    <tr><td>🧾 <b>Invoices</b></td><td><kbd>GET</kbd></td><td><code>/api/invoices</code></td><td>Admin/Staff</td></tr>
  </tbody>
</table>

> 💡 **Full Documentation:** Access our complete Postman collection [here](https://documenter.getpostman.com/view/50368281/2sBXVifovz).

### ⚡ Quick Installation
```bash
# 1. Clone the repository
git clone [https://github.com/haedaraedeeb-stack/Hotel-Management.git](https://github.com/haedaraedeeb-stack/Hotel-Management.git)
cd Hotel-Management
# 2. Install dependencies
composer install 
npm install

# 3. Setup environment & Database
cp .env.example .env 
php artisan key:generate
php artisan migrate --seed

# 4. Build assets & Run
npm run build 
php artisan serve

```


    
<h2 id="arabic">🚀 النسخة العربية</h2>
📖 وصف المشروع
نظام فيستانا لإدارة الفنادق هو حل تقني متكامل وعصري، تم تطويره باستخدام Laravel 12. يوفر النظام إمكانيات إدارة شاملة لعمليات الفنادق تشمل الحجوزات، إدارة الغرف، الفواتير، علاقات العملاء، وإدارة الموظفين. بفضل لوحة تحكم أنيقة مصممة بـ Flowbite و Tailwind CSS، يقدم النظام رؤى فورية وعمليات مبسطة للمديرين.

🏗️ الهيكلية التقنية (Service Layer)
يتميز النظام باستخدام نمط طبقة الخدمات (Service Layer Pattern) لفصل المنطق البرمجي عن المتحكمات (Controllers)، مما يضمن سهولة الصيانة وقابلية الاختبار.

📁 نظرة على هيكلية الملفات (أمثلة)
<table> <tr> <td width="50%"> <b>📂 الخدمات - App/Services (أمثلة)</b>


• <code>ApiReservationService.php</code>: معالجة منطق الحجوزات.


• <code>ApiInvoiceService.php</code>: إدارة الفواتير الآلية.


• <code>RoomService.php</code>: العمليات الأساسية للغرف.


• <code>UserService.php</code>: إدارة الهوية والمستخدمين. </td> <td width="50%"> <b>📂 المهاجرات - Migrations (أمثلة)</b>


• <code>create_room_types_table</code>: تصنيفات الغرف الديناميكية.


• <code>create_reservations_table</code>: المحرك الأساسي للحجوزات.


• <code>create_invoices_table</code>: سجلات الفواتير.


• <code>create_notifications_table</code>: التنبيهات الفورية. </td> </tr> </table>

🗄️ هيكلية قاعدة البيانات (الجداول الرئيسية)
فيما يلي بعض الجداول الأساسية المستخدمة في النظام:

المستخدمين (Users): إدارة حسابات وأدوار المستخدمين (مدير، موظف، عميل).

الغرف وأنواعها (Rooms): معالجة توافر الغرف وتصنيفاتها.

الحجوزات (Reservations): نظام متكامل لإدارة عمليات الحجز.

الفواتير (Invoices): تتبع الفواتير والمدفوعات بشكل آلي.

التقييمات (Ratings): ملاحظات العملاء وتقييم جودة الخدمة.

🔌 توثيق API (أمثلة للروابط)
يحتوي النظام على API قوي يعتمد على Laravel Sanctum. فيما يلي خريطة لبعض الروابط الأساسية:

<table> <thead> <tr style="background-color: #f8f9fa;"> <th align="right">الوحدة</th> <th align="right">الطريقة</th> <th align="right">الرابط (Endpoint)</th> <th align="right">المصادقة</th> </tr> </thead> <tbody> <tr><td>🔐 <b>المصادقة</b></td><td><kbd>POST</kbd></td><td><code>/api/auth/login</code></td><td>عام</td></tr> <tr><td>🏨 <b>أنواع الغرف</b></td><td><kbd>GET</kbd></td><td><code>/api/room-types</code></td><td>Bearer Token</td></tr> <tr><td>🛏️ <b>الغرف</b></td><td><kbd>POST</kbd></td><td><code>/api/rooms</code></td><td>Bearer Token</td></tr> <tr><td>📅 <b>الحجوزات</b></td><td><kbd>POST</kbd></td><td><code>/api/reservations</code></td><td>Bearer Token</td></tr> <tr><td>🧾 <b>الفواتير</b></td><td><kbd>GET</kbd></td><td><code>/api/invoices</code></td><td>المدير/الموظف</td></tr> </tbody> </table>

💡 التوثيق الكامل: يمكنك الوصول إلى كوليكشن بوستمان الكامل من هنا.

⚡ التثبيت والتشغيل السريع

# 1. استنساخ المستودع
git clone [https://github.com/haedaraedeeb-stack/Hotel-Management.git](https://github.com/haedaraedeeb-stack/Hotel-Management.git)

# 2. تثبيت المكتبات البرمجية
composer install && npm install

# 3. إعداد البيئة وقاعدة البيانات
cp .env.example .env && php artisan key:generate
php artisan migrate --seed

# 4. بناء الواجهات وتشغيل الخادم
npm run build && php artisan serve

👥 Team & Acknowledgments / فريق العمل والتقدير
<table width="100%"> <thead> <tr style="background-color: #1a202c; color: white;"> <th align="left">👤 Member / العضو</th> <th align="left">💻 Specialized Role / الدور</th> </tr> </thead> <tbody> <tr><td><b>Haedara Deeb</b></td><td>🚀 Project Lead</td></tr> <tr><td><b>Mohammad Shaheen</b></td><td>🎖️ Deputy Lead</td></tr> <tr><td><b>Bedoor Ali Deeb</b></td><td>💻 Full Stack Developer</td></tr> <tr><td><b>Zaher Sankari</b></td><td>💻 Full Stack Developer</td></tr> <tr><td><b>Ali Mohammad Abbas</b></td><td>⚙️ Backend Specialist</td></tr> <tr><td><b>Mais Ahmad</b></td><td>⚙️ Database Specialist</td></tr> </tbody> </table>

Special Thanks to our Mentors: Mr. Hashim Othman • Mr. Ayham Ibrahim • Ms. Nourhan Almohammed • Ms. Muna Alrays • CEO Alaa Darwish & Focal X Team.
<p align="center"> Licensed under <b>MIT License</b> </p>

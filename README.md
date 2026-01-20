# 🚀 Laravel + Inertia + Vue 3 Project Installation Guide

This project is built with **Laravel**, **Inertia.js**, **Vue 3**, **Jetstream**, **Tailwind CSS**, and supports **multi-tenancy (Stancl Tenancy)**.

---

## 📋 Requirements

Make sure your system has the following installed:

* PHP **^8.1**
* Composer **^2**
* Node.js **^18**
* NPM or Yarn
* PostgreSQL / MySQL
* Git

---

## 📦 Clone the Repository

```bash
git clone https://github.com/your-username/your-project.git
cd your-project
```

---

## ⚙️ Backend Setup (Laravel)

### 1️⃣ Install PHP dependencies

```bash
composer install
```

### 2️⃣ Copy environment file

```bash
cp .env.example .env
```

### 3️⃣ Configure `.env`

Update database and app settings:

```env
APP_NAME="Laravel App"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=course_app_db
DB_USERNAME=postgres
DB_PASSWORD=secret
```

---

### 4️⃣ Generate application key

```bash
php artisan key:generate
```

---

### 5️⃣ Run migrations & seeders

```bash
php artisan migrate --seed
```

> If using **Stancl Tenancy**, also run:

```bash
php artisan tenants:migrate
```

---

## 🎨 Frontend Setup (Vue 3 + Inertia)

### 6️⃣ Install JS dependencies

```bash
npm install
```

### 7️⃣ Build assets

```bash
npm run dev
```

For production:

```bash
npm run build
```

---

## 🔐 Authentication (Jetstream)

This project uses **Laravel Jetstream with Inertia.js**.

* Admin Login: `/admin/login`
* Admin Register: `/admin/register`
* Dashboard: `/dashboard`

---

## 🧭 Useful Artisan Commands

```bash
php artisan route:list
php artisan optimize:clear
php artisan config:clear
php artisan view:clear
```

---

## 🧪 Common Issues

### ❗ Ziggy route not found

Make sure `@routes` exists in your main Blade file:

```blade
@routes
@inertia
```

Clear cache:

```bash
php artisan optimize:clear
npm run build
```

---

### ❗ PostgreSQL collation warning

```sql
ALTER DATABASE your_database_name REFRESH COLLATION VERSION;
```

---

## 📁 Project Structure (Important)

```
resources/
 └─ js/
    ├─ Pages/
    │   ├─ Domain/
    │   │   ├─ Index.vue
    │   │   └─ Create.vue
    ├─ Layouts/
    │   └─ AppLayout.vue
```

---

## ✨ Features

* ✅ Laravel 11
* ✅ Inertia.js + Vue 3
* ✅ Tailwind CSS
* ✅ Jetstream Authentication
* ✅ Domain Management (CRUD)
* ✅ Multi-tenancy ready (Stancl Tenancy)
* ✅ Ziggy route support

---

## 🛠 Future Improvements

* Role & Permission (Spatie)
* Domain → Tenant auto-provision
* Reusable DataTable component
* Toast Notifications
* API integration

---

## 📄 License

This project is open-sourced under the **MIT license**.

---

## 🤝 Contributing

Pull requests are welcome.
For major changes, please open an issue first.

---

Happy coding! 🎉

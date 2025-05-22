

# EWS Risk Register Backend

Backend API untuk aplikasi EWS Risk Register berbasis Laravel, menggunakan JWT Authentication.

## Requirement

- PHP >= 8.4
- Composer
- MySQL / MariaDB
- Laravel 12+
- JWT Auth Package (`tymon/jwt-auth`)
- Laravel configured in `laragon`, `XAMPP`, atau server lokal lainnya

---

## Setup & Menjalankan Proyek

### 1. Clone Repository
```bash
git clone https://github.com/username/ews-risk-register-be.git
cd ews-risk-register-be
````

### 2. Install Dependency

```bash
composer install
```

### 3. Copy dan Atur File Environment

```bash
cp .env.example .env
```

Lalu sesuaikan koneksi database di file `.env`:

```env
DB_DATABASE=ews_risk_db
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Generate App Key & JWT Secret

```bash
php artisan key:generate
php artisan jwt:secret
```

### 5. Jalankan Migrasi & Seeder

```bash
php artisan migrate
php artisan db:seed --class=AdminUserSeeder
```

### 6. Jalankan Server Laravel

```bash
php artisan serve
```

---

##  Endpoint Authentication

### Login

```
POST /api/login
```

**Body (JSON):**

```json
{
  "email": "admin@example.com",
  "password": "password"
}
```

### Mendapatkan Profil User Login

```
GET /api/me
```

**Header:**

```
Authorization: Bearer {token}
```

### Logout

```
POST /api/logout
```

### Refresh Token

```
POST /api/refresh
```

---

##  Manajemen User (Hanya setelah login)

Semua endpoint di bawah ini membutuhkan header token:

```
Authorization: Bearer {token}
```

### List Semua User

```
GET /api/users
```

### Detail User

```
GET /api/users/{id}
```

### Tambah User

```
POST /api/users
```

### Update User

```
PUT /api/users/{id}
```

### Hapus User

```
DELETE /api/users/{id}
```

---

## Testing

Gunakan **Postman** atau aplikasi API client lain untuk menguji endpoint di atas.

---

##  Catatan

* Gunakan guard `api` di middleware Laravel untuk melindungi endpoint.
* Pastikan file `.env` berisi konfigurasi JWT yang benar setelah menjalankan `php artisan jwt:secret`.

---

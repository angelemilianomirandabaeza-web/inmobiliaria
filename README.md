# 🏠 InmoTech - Plataforma Inmobiliaria

Plataforma inmobiliaria completa desarrollada con **Laravel 11** y **MySQL**. Sistema integral con paneles diferenciados para **administradores, agentes y clientes**, búsqueda avanzada con autocompletado, mapas interactivos, subida real de imágenes, dark mode, notificaciones por email y mucho más.

> **Proyecto Segundo Parcial** | Equipo de 5 personas

---

## ✨ Características principales

### Portal público
- 🎨 **Hero espectacular** con gradientes animados, mesh gradient y blobs flotantes
- 🔍 **Búsqueda con autocompletado AJAX** en tiempo real (propiedades, colonias, ciudades)
- 🏘️ Catálogo con filtros avanzados (tipo, operación, precio, habitaciones, baños, ubicación)
- 📍 **Mapa interactivo** con Leaflet en cada propiedad (gratis, sin API key)
- 💰 **Calculadora de hipoteca** integrada
- ⚖️ **Comparador** de hasta 3 propiedades lado a lado
- 📷 Galería de imágenes con carrusel
- ⭐ Propiedades destacadas con badges premium
- 💬 Formulario de contacto que **envía email** al agente

### Panel Cliente
- ❤️ Lista de favoritos con paginación
- 📅 Visitas programadas
- 🔔 Alertas de búsqueda personalizadas
- 📊 Dashboard con estadísticas personales

### Panel Agente
- 🏠 CRUD completo de propiedades
- 📤 **Subida real de imágenes** con drag & drop (hasta 10 imágenes, preview en tiempo real)
- 📈 Dashboard con métricas de ventas
- 📅 Agenda de visitas
- 🎯 Pipeline de ventas
- 💬 Gestión de leads

### Panel Administrador
- ✅ Aprobación/rechazo de propiedades
- 👥 Gestión de usuarios y agentes
- 📊 Dashboard con gráficas (Chart.js)
- 💼 Gestión de planes de publicación

### UX Premium
- 🌙 **Dark mode** con toggle persistente (localStorage)
- ✨ **Animaciones AOS** en scroll
- 🎴 Cards con **tilt 3D** (Vanilla Tilt)
- 🔄 **Carousel de testimonios** (Splide)
- ⌨️ Texto que se escribe solo (Typed.js)
- 🔢 Contadores animados (CountUp.js)
- 🎯 Cursor personalizado en desktop
- 📊 Barra de progreso de scroll
- 🎨 Glassmorphism, gradientes animados, marquees infinitos

---

## 🛠️ Tecnologías

| Stack | Tecnología |
|---|---|
| **Backend** | Laravel 11.x |
| **Lenguaje** | PHP 8.3 |
| **Base de datos** | MySQL 8.1 |
| **Frontend** | Blade + Bootstrap 5.3 |
| **Mapas** | Leaflet + OpenStreetMap (gratis) |
| **Tipografía** | Bricolage Grotesque + Inter (Google Fonts) |
| **Animaciones** | AOS, Vanilla Tilt, Typed.js, CountUp.js |
| **Carouseles** | Splide.js |
| **Iconos** | Font Awesome 6 |
| **Storage** | Laravel Storage (filesystem público) |
| **Mail** | Laravel Mail (driver `log` por defecto) |

---

## 📦 Requisitos

- **PHP 8.2+** (recomendado 8.3)
- **Composer 2.x**
- **MySQL 8+** o **MariaDB 10.6+**
- WAMP / XAMPP / LAMP (recomendado: **WAMP** en Windows)

---

## 🚀 Instalación paso a paso

### 1. Clonar el repositorio

```bash
git clone https://github.com/angelemilianomirandabaeza-web/inmobiliaria.git
cd inmobiliaria
```

### 2. Instalar dependencias de PHP

```bash
composer install
```

> Si tu PHP del PATH es viejo (< 8.2), usa el de WAMP:
> ```powershell
> C:\wamp64\bin\php\php8.3.14\php.exe C:\ProgramData\ComposerSetup\bin\composer.phar install
> ```

### 3. Configurar variables de entorno

```bash
cp .env.example .env
```

Edita `.env` con tus datos:

```env
APP_NAME="InmoTech"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=inmobiliaria
DB_USERNAME=root
DB_PASSWORD=

MAIL_MAILER=log
```

### 4. Generar la clave de la aplicación

```bash
php artisan key:generate
```

### 5. Crear la base de datos

```bash
mysql -u root -e "CREATE DATABASE IF NOT EXISTS inmobiliaria CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
```

O desde phpMyAdmin: crea una BD llamada `inmobiliaria`.

### 6. Migrar y poblar la BD

```bash
php artisan migrate:fresh --seed
```

Esto crea **24+ tablas** y carga datos de prueba.

### 7. Crear el symlink de storage

```bash
php artisan storage:link
```

### 8. Levantar el servidor

```bash
php artisan serve
```

Abre **http://127.0.0.1:8000** en el navegador.

---

## 🔑 Cuentas de prueba

Todas las cuentas usan la contraseña: **`password`**

| Rol | Email |
|---|---|
| 👑 Admin | `admin@inmobiliaria.com` |
| 🏢 Agente | `carlos@inmobiliaria.com` |
| 🏢 Agente | `maria@inmobiliaria.com` |
| 🏢 Agente | `jorge@inmobiliaria.com` |
| 👤 Cliente | `ana@cliente.com` |
| 👤 Cliente | `luis@cliente.com` |
| 👤 Cliente | `patricia@cliente.com` |

---

## 🪟 Manual rápido (Windows con WAMP)

### Iniciar el servidor cada vez

1. Abre **WAMP** y verifica que el icono esté **verde** (Apache + MySQL corriendo)
2. Abre **PowerShell** y ejecuta:

```powershell
cd C:\proyectos\inmobiliaria
C:\wamp64\bin\php\php8.3.14\php.exe artisan serve
```

3. Abre el navegador en **http://127.0.0.1:8000**
4. Para detener el servidor: presiona **Ctrl + C** en PowerShell

### Si la BD está vacía

```powershell
C:\wamp64\bin\php\php8.3.14\php.exe artisan migrate:fresh --seed
```

### Si ves errores de "vendor/autoload.php"

```powershell
C:\wamp64\bin\php\php8.3.14\php.exe C:\ProgramData\ComposerSetup\bin\composer.phar dump-autoload
```

### Si las imágenes subidas no se ven

```powershell
C:\wamp64\bin\php\php8.3.14\php.exe artisan storage:link
```

### Limpiar todas las caches

```powershell
C:\wamp64\bin\php\php8.3.14\php.exe artisan optimize:clear
```

---

## 📂 Estructura del proyecto

```
inmobiliaria/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/        → Panel administrador
│   │   │   ├── Agente/       → Panel agente
│   │   │   ├── Api/          → API autocompletado
│   │   │   ├── Cliente/      → Panel cliente
│   │   │   ├── Public/       → Vistas públicas
│   │   │   └── AuthController.php
│   │   └── Middleware/CheckRole.php
│   ├── Mail/                 → Mailables (notificaciones)
│   └── Models/               → 23 modelos Eloquent
├── database/
│   ├── migrations/           → 13 migraciones (24+ tablas)
│   └── seeders/              → 6 seeders
├── resources/views/
│   ├── layouts/app.blade.php → Layout maestro
│   ├── public/               → Home, búsqueda, ficha, comparador
│   ├── auth/                 → Login, registro
│   ├── admin/                → Dashboard, aprobación
│   ├── agente/               → Dashboard, CRUD propiedades
│   ├── cliente/              → Dashboard, favoritos
│   └── emails/               → Templates HTML de email
└── routes/web.php            → Definición de rutas
```

---

## 👥 División de trabajo (5 personas)

| Persona | Módulo |
|---|---|
| **1** | Auth, middleware, panel admin, aprobaciones, planes |
| **2** | Portal público: home, búsqueda, ficha, comparador |
| **3** | Panel agente: CRUD propiedades, imágenes, amenidades |
| **4** | Visitas, pipeline ventas, leads, contactos, emails |
| **5** | Dashboard admin, gráficas, calculadora, autocompletado, mapas |

---

## 🌟 Funcionalidades destacadas para la presentación

1. **Demo del autocompletado** — escribe "Polanco" o "casa" y muestra los resultados instantáneos
2. **Cambio de tema oscuro/claro** — clic en la luna del navbar
3. **Mapa interactivo** — entra a una propiedad y muestra el marker animado
4. **Calculadora de hipoteca** — calcula la mensualidad de cualquier propiedad
5. **Comparador** — selecciona 3 propiedades y compáralas lado a lado
6. **Subida de imágenes** — drag & drop con preview (login como agente)
7. **Email automático** — al contactar se genera un email HTML profesional (verlo en `storage/logs/laravel.log`)
8. **Galería con carrusel**, **animaciones de scroll**, **3D tilt en cards**

---

## 📝 Licencia

Proyecto académico — Segundo Parcial. Uso educativo.

---

## 👨‍💻 Autor

**Angel Emiliano Miranda Baeza** — [GitHub](https://github.com/angelemilianomirandabaeza-web)

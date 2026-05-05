# 🌊 Hydrothermal Vent Database

![PHP](https://img.shields.io/badge/PHP-7.0%2B-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![HTML5](https://img.shields.io/badge/HTML5-E34F26?style=for-the-badge&logo=html5&logoColor=white)
![CSS3](https://img.shields.io/badge/CSS3-1572B6?style=for-the-badge&logo=css3&logoColor=white)
![JavaScript](https://img.shields.io/badge/JavaScript-ES6-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black)
![Leaflet](https://img.shields.io/badge/Leaflet.js-1.9.4-199900?style=for-the-badge&logo=leaflet&logoColor=white)
![License](https://img.shields.io/badge/License-Academic-blue?style=for-the-badge)
![Status](https://img.shields.io/badge/Status-Complete-brightgreen?style=for-the-badge)

> An interactive web application for exploring hydrothermal vent fields and the unique chemosynthetic fauna that inhabit the deep ocean.

Built for **SET08101 Web Technologies** coursework on a LAMP/WAMP stack.

---

## 📋 Table of Contents

- [Overview](#-overview)
- [Features](#-features)
- [Tech Stack](#-tech-stack)
- [Project Structure](#-project-structure)
- [Database Schema](#-database-schema)
- [Getting Started](#-getting-started)
- [Admin Panel](#-admin-panel)
- [Security](#-security)
- [Screenshots](#-screenshots)
- [Credits](#-credits)

---

## 🔭 Overview

The **Hydrothermal Vent Database** provides a scientifically grounded, searchable resource focused on vent fields from the **Western Pacific region**. Users can browse vent sites, explore associated deep-sea species, and view vent locations on an interactive map — all through a clean, responsive interface.

The application includes a fully protected admin panel for managing vent and fauna records via CRUD operations.

---

## ✨ Features

### Public Interface
| Feature | Description |
|---|---|
| 🔍 Browse & Search | Filter vents by type, depth range, or keyword |
| 📄 Vent Detail Pages | Full metadata per vent: location, type, depth, discovery year |
| 🦀 Fauna Profiles | Species cards with common name, scientific name, image, and description |
| 🗺️ Interactive Map | Leaflet.js map pinpointing each vent's coordinates |
| 🌍 Global Vent Map | Static worldwide hydrothermal vent distribution map |
| 📊 Statistics | Live counts for total vents, vent types, and filtered results |
| 📬 Contact Form | Client- and server-validated form for user submissions |
| 📱 Responsive Design | Mobile-friendly layout with CSS custom properties and Flexbox |

### Admin Panel
| Feature | Description |
|---|---|
| 🔐 Secure Login | Session-based auth with hashed passwords |
| 📋 Manage Dashboard | Full table view of all vents with action controls |
| ➕ Add / ✏️ Edit / 🗑️ Delete Vents | Full CRUD for vent records |
| ➕ Add / ✏️ Edit / 🗑️ Delete Fauna | Full CRUD for species linked to vents |
| 🗑️ Cascade Deletes | Removing a vent automatically removes its associated fauna |

---

## 🛠️ Tech Stack

**Backend**
- **PHP 7.0+** — server-side logic and templating
- **MySQL / MariaDB** — relational database
- **PDO** — database abstraction with prepared statements

**Frontend**
- **HTML5** — semantic markup
- **CSS3** — custom properties, Flexbox, responsive media queries, `clamp()` typography
- **Vanilla JavaScript (ES6)** — filter UI, form validation, map initialisation

**Libraries & Services**
- **[Leaflet.js v1.9.4](https://leafletjs.com/)** — interactive mapping
- **[OpenStreetMap](https://www.openstreetmap.org/)** — map tile provider
- **[Wikimedia Commons](https://commons.wikimedia.org/)** — global vent distribution map image (CC BY-SA)

**Environment**
- **WAMP64 / LAMP** — Apache, MySQL, PHP local development stack

---

## 📁 Project Structure

```
webtech_cw/
│
├── index.php              # Home — vent list with search & filter
├── about.php              # Project info and credits
├── contact.php            # Contact form (client + server validation)
├── login.php              # Admin authentication
├── logout.php             # Session destruction
├── vent.php               # Single vent detail page + Leaflet map
├── vent_map.html          # Static global vent distribution map
│
├── admin/                 # Protected admin pages
│   ├── manage.php         # Main dashboard
│   ├── add_vent.php       # Create vent
│   ├── edit_vent.php      # Update vent
│   ├── delete_vent.php    # Remove vent (cascading)
│   ├── add_fauna.php      # Create fauna for a vent
│   ├── edit_fauna.php     # Update fauna record
│   └── delete_fauna.php   # Remove fauna record
│
├── includes/              # Shared components
│   ├── config.php         # DB credentials, helper functions
│   ├── db.php             # PDO connection factory
│   ├── header.php         # Site navigation and HTML head
│   └── footer.php         # Footer and script includes
│
├── database/
│   └── vent_fauna.sql     # Schema + seed data (6 vents, 23+ fauna)
│
├── css/
│   ├── reset.css          # CSS reset / normalise
│   └── styles.css         # Main stylesheet
│
├── js/
│   └── script.js          # Filter toggle, form validation, map init
│
└── images/
    └── fauna_images/      # Species images organised by vent ID (1–6)
```

---

## 🗄️ Database Schema

The database uses two core tables with a foreign key relationship.

```sql
CREATE TABLE vents (
    id             INT AUTO_INCREMENT PRIMARY KEY,
    name           VARCHAR(100)  NOT NULL,
    location       VARCHAR(200)  NOT NULL,
    type           VARCHAR(50)   NOT NULL,
    depth_metres   INT           NOT NULL,
    discovery_year INT           NOT NULL
);

CREATE TABLE fauna (
    id              INT AUTO_INCREMENT PRIMARY KEY,
    vent_id         INT           NOT NULL,
    name            VARCHAR(100)  NOT NULL,
    scientific_name VARCHAR(150)  NOT NULL,
    description     TEXT,
    image_url       VARCHAR(255),
    FOREIGN KEY (vent_id) REFERENCES vents(id) ON DELETE CASCADE
);
```

### Sample Data
The seed file includes **6 Western Pacific vent fields** and **23+ species records**:

| Vent Field | Type | Depth |
|---|---|---|
| Manus Basin | Black Smoker | ~2,500 m |
| Lau Basin | Black Smoker | ~1,800 m |
| North Fiji Basin | Mixed | ~2,000 m |
| Mariana Back-arc | Diffuse Flow | ~3,600 m |
| Mariana Volcanic Arc | Arc Volcano | ~1,400 m |
| Okinawa Trough | White Smoker | ~1,300 m |

---

## 🚀 Getting Started

### Prerequisites
- **WAMP64**, **XAMPP**, **LAMP**, or any Apache + PHP 7.0+ + MySQL environment
- A web browser

### Installation

1. **Clone or copy** the project into your web server's document root:
   ```
   C:\wamp64\www\webtech_cw\    (WAMP)
   /var/www/html/webtech_cw/    (Linux LAMP)
   ```

2. **Create the database** — open phpMyAdmin or your MySQL client and run:
   ```sql
   CREATE DATABASE vent_fauna CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   USE vent_fauna;
   SOURCE /path/to/database/vent_fauna.sql;
   ```

3. **Configure the connection** — edit `includes/config.php`:
   ```php
   define('DB_HOST', 'localhost');
   define('DB_NAME', 'vent_fauna');
   define('DB_USER', 'your_username');
   define('DB_PASS', 'your_password');
   ```

4. **Create an admin user** — run this in your MySQL client (replace the password):
   ```sql
   INSERT INTO users (username, password)
   VALUES ('admin', '$2y$10$<your_password_hash>');
   ```
   Generate a hash with:
   ```php
   echo password_hash('your_password', PASSWORD_DEFAULT);
   ```

5. **Visit the site** in your browser:
   ```
   http://localhost/webtech_cw/
   ```

---

## 🔐 Admin Panel

Access the admin panel at `http://localhost/webtech_cw/login.php`.

- Log in with your admin credentials
- The **Manage** dashboard lists all vent records
- From each vent you can **View**, **Edit**, or **Delete** it
- Fauna records are managed from within the vent edit page
- Deleting a vent **cascades** and removes all linked fauna automatically

All admin routes are protected — unauthenticated requests are redirected to the login page.

---

## 🔒 Security

| Measure | Implementation |
|---|---|
| **SQL Injection Prevention** | PDO prepared statements throughout; emulated prepares disabled |
| **XSS Prevention** | All output escaped with `htmlspecialchars()` via `e()` helper |
| **Password Hashing** | `password_hash()` / `password_verify()` (bcrypt) |
| **Session Fixation Prevention** | `session_regenerate_id(true)` on login |
| **Session Hijacking Mitigation** | Session destroyed fully on logout |
| **Auth Guards** | Every admin page checks `$_SESSION['user_id']` before rendering |
| **Input Validation** | Server-side validation on all form inputs with generic error messages |

---

## 📸 Screenshots

> Add screenshots of your application here.

| Page | Preview |
|---|---|
| Home / Vent List | *(screenshot)* |
| Vent Detail + Map | *(screenshot)* |
| Admin Dashboard | *(screenshot)* |

---

## 📜 Credits

- **Leaflet.js** — [leafletjs.com](https://leafletjs.com/) — BSD 2-Clause License
- **OpenStreetMap** contributors — [openstreetmap.org](https://www.openstreetmap.org/) — ODbL License
- **Global Vent Map** — Wikimedia Commons — CC BY-SA License
- Scientific species data compiled for academic coursework purposes

---

## 📄 License

This project was created for **SET08101 Web Technologies** academic coursework. It is not licensed for commercial use.

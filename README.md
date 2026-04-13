# Fingerprint Exam Attendance System

## Overview

A biometric exam attendance system that authenticates students via fingerprint scanning at the point of entry for scheduled examinations. Built for university environments, it replaces manual sign-in sheets with hardware-level identity verification, eliminating proxy attendance and reducing administrative overhead. The system bridges a Raspberry Pi–mounted fingerprint sensor with a PHP web platform through a Flask microservice, enabling real-time attendance recording.

---

## Features

- **Biometric Enrollment** – Capture and store student fingerprints directly from the admin dashboard
- **Exam Attendance Verification** – Real-time fingerprint matching with configurable confidence threshold during live exam sessions
- **Role-Based Access Control** – Separate portals for Admins and Lecturers with distinct permissions
- **Student Management** – Full CRUD for students, courses, semesters, and exam schedules
- **Attendance Reports** – Per-exam attendance records with timestamped entries, accessible to lecturers
- **Fingerprint Deletion** – Revoke biometric data from the sensor and system on student offboarding
- **I2C LCD Feedback** – Optional on-device display for real-time scan status (extensible)

---

## Tech Stack

| Category   | Technology                                      |
|------------|-------------------------------------------------|
| IoT / Edge | Python 3, Flask, Adafruit Fingerprint Library   |
| Hardware   | Raspberry Pi, R307/R503 Fingerprint Sensor, I2C LCD |
| Backend    | PHP 8.2, custom MVC structure                   |
| Database   | MariaDB 10.x / MySQL                            |
| Frontend   | PHP-rendered HTML, CSS                          |
| Web Server | Apache (LAMP stack on Raspberry Pi)             |

---

## Architecture

```
┌─────────────────────────────────────────────────────────┐
│                     Raspberry Pi                        │
│                                                         │
│  ┌──────────────┐   Serial/UART   ┌──────────────────┐  │
│  │  Fingerprint │◄───────────────►│  Flask API       │  │
│  │  Sensor      │                 │  (Python)        │  │
│  └──────────────┘                 │  :5000           │  │
│                                   └────────┬─────────┘  │
│                                            │ PyMySQL    │
│  ┌──────────────────────────────┐          │            │
│  │  PHP Web Application         │◄─────────┤            │
│  │  (Apache / LAMP)             │          │            │
│  │  Admin │ Lecturer │ Auth     │    ┌─────▼──────┐    │
│  └──────────────────────────────┘    │  MariaDB   │    │
│                                      └────────────┘    │
└─────────────────────────────────────────────────────────┘
```

The Flask service exposes HTTP endpoints consumed by the PHP layer to trigger hardware operations (enroll, scan, delete). All attendance state is persisted to MariaDB. The PHP application handles session management, user roles, and data presentation.

---

## Setup & Installation

### Prerequisites

- Raspberry Pi (3B+ or later) running Raspberry Pi OS
- Fingerprint sensor connected via `/dev/ttyUSB0`
- LAMP stack installed (`apache2`, `php8.2`, `mariadb-server`)
- Python 3.9+ with `pip`

### 1. Clone the Repository

```bash
git clone https://github.com/yugathes/fingerprint-exam.git
cd fingerprint-exam
```

### 2. Install Python Dependencies

```bash
pip install flask adafruit-circuitpython-fingerprint pymysql pyserial
```

### 3. Configure the Database

```bash
mysql -u root -p < Web/attendance.sql
```

Update the database credentials in `test.py` if needed:

```python
db = pymysql.connect(host='localhost', user='root', password='your_password', db='attendance2')
```

### 4. Deploy the PHP Web App

```bash
sudo cp -r Web/ /var/www/html/Fingerprint
sudo chown -R www-data:www-data /var/www/html/Fingerprint
```

Update `Web/Auth/connection.php` with your database credentials.

### 5. Start the Flask Service

```bash
python test.py
```

The Flask API starts on `http://0.0.0.0:5000`.

### 6. Access the Web Interface

Navigate to `http://<raspberry-pi-ip>/Fingerprint/` in your browser.

Default admin credentials (change immediately):
- **Staff ID:** `Admin`
- **Password:** `123`

---

## API Endpoints

| Method | Endpoint               | Description                                                  |
|--------|------------------------|--------------------------------------------------------------|
| GET    | `/`                    | Health check / index                                         |
| GET    | `/enroll?uid=<id>`     | Capture and store fingerprint for student with given DB ID   |
| GET    | `/attendance?cID=<id>` | Begin continuous fingerprint scan loop for a given exam ID   |
| GET    | `/delete?uid=<id>`     | Remove fingerprint template from sensor and mark unenrolled  |

> All endpoints are intended to be called internally by the PHP layer, not exposed publicly.

---

## Deployment

The system is designed as a **self-hosted edge deployment** on a Raspberry Pi within the institution's local network.

- **Web Server:** Apache serves the PHP application under `/var/www/html/Fingerprint/`
- **Flask Service:** Run as a `systemd` service for process persistence across reboots
- **Database:** MariaDB on the same device; can be migrated to a dedicated DB host for scale
- **Network:** The Pi is accessible over LAN; no external internet exposure required

**Systemd service example (`/etc/systemd/system/flask-fingerprint.service`):**

```ini
[Unit]
Description=Fingerprint Flask Service
After=network.target

[Service]
ExecStart=/usr/bin/python3 /home/pi/fingerprint-exam/test.py
Restart=always
User=pi

[Install]
WantedBy=multi-user.target
```

```bash
sudo systemctl enable flask-fingerprint
sudo systemctl start flask-fingerprint
```

---

## Future Improvements

- **REST API hardening** – Add token-based authentication (JWT) to Flask endpoints
- **HTTPS** – TLS termination via Let's Encrypt or self-signed certificate for LAN deployments
- **Multi-sensor support** – Abstract sensor layer to support multiple simultaneous exam halls
- **Student self-service portal** – Allow students to view their own attendance records
- **Cloud sync** – Push attendance records to a central university system via webhook or API
- **Docker packaging** – Containerise the Flask service for portable deployment and easier updates

---

## Author

**Yugathes**
[github.com/yugathes](https://github.com/yugathes)

# WP Wingman - WordPress Management SaaS

**Your WordPress Wingman - Always at Your Side**

A complete, production-ready WordPress management and monitoring SaaS platform that monitors WordPress sites 24/7, provides automated backups, manages updates, tracks security threats, and offers comprehensive reporting.

![WP Wingman](https://img.shields.io/badge/version-1.0.0-teal)
![License](https://img.shields.io/badge/license-GPL--2.0-orange)
![PHP](https://img.shields.io/badge/PHP-8.3-blue)
![Laravel](https://img.shields.io/badge/Laravel-11-red)
![Vue](https://img.shields.io/badge/Vue-3-green)

## 🚀 Features

### Core Platform Features
- **Site Monitoring**: Real-time uptime monitoring, performance metrics, and health tracking
- **Backup & Recovery**: Automated daily/weekly backups with one-click restoration
- **Security**: Malware detection, vulnerability scanning, SSL monitoring
- **Updates Management**: WordPress core, plugin, and theme updates with compatibility checks
- **Reporting**: Customizable email reports and detailed analytics
- **Client Portal**: Self-service portal for site owners
- **Admin Dashboard**: Complete site management interface

### Technical Features
- JWT + OAuth2 authentication
- Role-based access control (Admin, Client, Support)
- PostgreSQL database with comprehensive migrations
- Redis caching and queue system
- RESTful API architecture
- Docker containerization
- CI/CD with GitHub Actions

## 🏗️ Architecture

```
WP Wingman/
├── backend/              # Laravel 11 REST API
├── admin-dashboard/      # Vue 3 + TypeScript Admin Dashboard
├── client-portal/        # Vue 3 + TypeScript Client Portal
├── wordpress-plugin/     # WordPress monitoring plugin
├── landing-page/         # Marketing website
├── docker-compose.yml    # Docker orchestration
└── docs/                 # Documentation
```

## 🎨 Branding

- **Primary Color**: Teal (#20C997)
- **Secondary Color**: Orange (#FF6B35)
- **Theme**: Light mode, modern, professional SaaS aesthetic
- **Typography**: System fonts for optimal performance

## 🔧 Prerequisites

- Docker & Docker Compose
- Node.js 18+ (for local development)
- PHP 8.3+ (for local development)
- Composer (for local development)

## 📦 Quick Start

### 1. Clone the Repository

```bash
git clone https://github.com/wpclinic/hustlemate.git
cd hustlemate
```

### 2. Configure Environment

```bash
# Copy environment file
cp backend/.env.example backend/.env

# Generate application key
cd backend
php artisan key:generate
```

### 3. Start with Docker Compose

```bash
# Start all services
docker-compose up -d

# Run migrations
docker-compose exec backend php artisan migrate

# Seed database (optional)
docker-compose exec backend php artisan db:seed
```

### 4. Access the Platform

- **Admin Dashboard**: http://localhost:3000
- **Client Portal**: http://localhost:3001
- **Landing Page**: http://localhost:3002
- **API**: http://localhost:8000
- **API Documentation**: http://localhost:8000/api/documentation

## 🗄️ Database Schema

### Core Tables

- `users` - Admin and client users with role-based access
- `clients` - Client organizations
- `subscriptions` - Billing subscriptions (starter, professional, enterprise)
- `sites` - WordPress sites being monitored
- `site_monitors` - Hourly monitoring records
- `backups` - Backup records with versioning
- `security_scans` - Security scan results
- `updates` - Available updates tracking
- `reports` - Generated reports
- `support_tickets` - Client support tickets
- `audit_logs` - System audit logs

## 🔌 WordPress Plugin

The **WP Wingman Client** plugin connects WordPress sites to the platform.

### Installation

1. Download the plugin from `wordpress-plugin/`
2. Upload to WordPress site
3. Activate and configure with API key
4. Enable monitoring and backup features

### Features

- Collects site data (plugins, themes, updates)
- Reports performance metrics
- Sends security information
- Receives remote commands
- Lightweight and fast

## 📱 API Endpoints

```
POST   /api/v1/auth/login
POST   /api/v1/auth/register
POST   /api/v1/auth/logout

GET    /api/v1/clients
POST   /api/v1/clients
GET    /api/v1/clients/{id}
PUT    /api/v1/clients/{id}
DELETE /api/v1/clients/{id}

GET    /api/v1/sites
POST   /api/v1/sites
GET    /api/v1/sites/{id}
PUT    /api/v1/sites/{id}
DELETE /api/v1/sites/{id}

GET    /api/v1/backups
POST   /api/v1/backups
GET    /api/v1/backups/{id}
POST   /api/v1/backups/{id}/restore

GET    /api/v1/security/scans
POST   /api/v1/security/scan/{siteId}

GET    /api/v1/updates
POST   /api/v1/updates/{id}/apply

GET    /api/v1/reports
POST   /api/v1/reports/generate

GET    /api/v1/tickets
POST   /api/v1/tickets
PUT    /api/v1/tickets/{id}

GET    /api/v1/analytics/overview
GET    /api/v1/analytics/performance
```

## 🧪 Testing

```bash
# Backend tests
cd backend
php artisan test

# Admin dashboard tests
cd admin-dashboard
npm run test

# Client portal tests
cd client-portal
npm run test
```

## 🚀 Deployment

### Production Deployment

1. Update environment variables
2. Build frontend applications
3. Deploy with Docker Compose or Kubernetes
4. Configure reverse proxy (Nginx/Caddy)
5. Setup SSL certificates
6. Configure backups and monitoring

### Environment Variables

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourapp.com

DB_CONNECTION=pgsql
DB_HOST=postgres
DB_PORT=5432
DB_DATABASE=wpwingman
DB_USERNAME=wpwingman
DB_PASSWORD=secure_password

REDIS_HOST=redis
REDIS_PORT=6379

MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
```

## 📚 Documentation

- [API Documentation](docs/api.md)
- [Database Schema](docs/database.md)
- [Deployment Guide](docs/deployment.md)
- [Architecture Overview](docs/architecture.md)
- [Contributing Guidelines](docs/contributing.md)

## 🤝 Contributing

We welcome contributions! Please see [CONTRIBUTING.md](docs/contributing.md) for details.

## 📝 License

This project is licensed under the GPL-2.0 License - see the [LICENSE](LICENSE) file for details.

## 🙏 Acknowledgments

- Laravel Framework
- Vue.js
- TailwindCSS
- Chart.js
- PostgreSQL
- Redis

## 📧 Support

For support, email support@wpwingman.com or visit https://wpwingman.com/support

---

**Made with ❤️ by WP Wingman Team**


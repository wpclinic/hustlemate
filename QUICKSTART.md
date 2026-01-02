# Quick Start Guide - WP Wingman

Get WP Wingman running locally in 5 minutes!

## Prerequisites

- Docker Desktop installed and running
- Git installed
- At least 4GB RAM available
- Ports 3000, 3001, 3002, 5432, 6379, 8000 available

## Installation

### 1. Clone the Repository

```bash
git clone https://github.com/wpclinic/hustlemate.git
cd hustlemate
```

### 2. Setup Backend Environment

```bash
cd backend
cp .env.example .env
php artisan key:generate
cd ..
```

The default `.env.example` is already configured for Docker development.

### 3. Start All Services

```bash
docker-compose up -d
```

This will start:
- PostgreSQL database (port 5432)
- Redis cache/queue (port 6379)
- Laravel API backend (port 8000)
- Queue worker
- Admin Dashboard (port 3000)
- Client Portal (port 3001)
- Landing Page (port 3002)

### 4. Initialize Database

Wait about 30 seconds for services to be ready, then:

```bash
# Run migrations
docker-compose exec backend php artisan migrate

# Seed with demo data
docker-compose exec backend php artisan db:seed
```

### 5. Access the Platform

Open your browser and visit:

- **Landing Page**: http://localhost:3002
- **Admin Dashboard**: http://localhost:3000
- **Client Portal**: http://localhost:3001
- **API**: http://localhost:8000

## Demo Accounts

After seeding, you can login with:

### Admin User
- Email: `admin@wpwingman.com`
- Password: `password123`
- Access: Full system access

### Client User
- Email: `client@wpwingman.com`
- Password: `password123`
- Access: Client portal, 3 demo sites

### Support User
- Email: `support@wpwingman.com`
- Password: `password123`
- Access: Support tickets

## API Testing

### Register a New User

```bash
curl -X POST http://localhost:8000/api/v1/auth/register \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Test User",
    "email": "test@example.com",
    "password": "password123",
    "password_confirmation": "password123"
  }'
```

### Login

```bash
curl -X POST http://localhost:8000/api/v1/auth/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "admin@wpwingman.com",
    "password": "password123"
  }'
```

Response will include an authentication token:
```json
{
  "success": true,
  "data": {
    "user": {...},
    "token": "1|aBcDeFg..."
  }
}
```

### Get Sites (Authenticated)

```bash
curl http://localhost:8000/api/v1/sites \
  -H "Authorization: Bearer YOUR_TOKEN_HERE"
```

## Development Workflow

### View Logs

```bash
# All services
docker-compose logs -f

# Specific service
docker-compose logs -f backend
docker-compose logs -f admin-dashboard
docker-compose logs -f queue
```

### Access Database

```bash
# PostgreSQL CLI
docker-compose exec postgres psql -U wpwingman -d wpwingman

# Common queries
SELECT * FROM users;
SELECT * FROM sites;
SELECT * FROM clients;
```

### Run Artisan Commands

```bash
docker-compose exec backend php artisan migrate
docker-compose exec backend php artisan db:seed
docker-compose exec backend php artisan cache:clear
docker-compose exec backend php artisan queue:work
```

### Install New Dependencies

**Backend (PHP)**
```bash
cd backend
composer require package-name
docker-compose restart backend
```

**Frontend (Node)**
```bash
cd admin-dashboard
npm install package-name
docker-compose restart admin-dashboard
```

## WordPress Plugin Installation

The WordPress plugin is located in `wordpress-plugin/` directory.

### Install on Test Site

1. Zip the plugin directory:
   ```bash
   cd wordpress-plugin
   zip -r wp-wingman-client.zip .
   ```

2. Upload to WordPress:
   - Go to WordPress Admin → Plugins → Add New
   - Click "Upload Plugin"
   - Choose `wp-wingman-client.zip`
   - Activate the plugin

3. Configure:
   - Go to WP Wingman menu
   - Enter API Key (get from Admin Dashboard)
   - Enable monitoring and backups
   - Save settings

## Troubleshooting

### Port Already in Use

If you get port conflicts, you can modify `docker-compose.yml` to use different ports:

```yaml
services:
  backend:
    ports:
      - "8001:8000"  # Change 8000 to 8001
```

### Database Connection Failed

Make sure PostgreSQL container is healthy:
```bash
docker-compose ps
docker-compose logs postgres
```

Wait a few more seconds and try again.

### Cannot Access Frontend

Frontend apps may take 30-60 seconds to build on first run:
```bash
docker-compose logs -f admin-dashboard
```

Look for "ready in" message indicating the dev server is running.

### Clear Everything and Start Fresh

```bash
docker-compose down -v
docker-compose up -d
docker-compose exec backend php artisan migrate
docker-compose exec backend php artisan db:seed
```

## Stop Services

```bash
# Stop containers (preserves data)
docker-compose stop

# Stop and remove containers (preserves volumes)
docker-compose down

# Remove everything including data
docker-compose down -v
```

## Next Steps

1. **Explore the API**: Check `docs/api.md` for all available endpoints
2. **Read Architecture**: Understand the system in `docs/architecture.md`
3. **Start Developing**: Check `docs/contributing.md` for guidelines
4. **Deploy to Production**: Follow `docs/deployment.md`

## Resources

- **Documentation**: `/docs` directory
- **API Docs**: http://localhost:8000/api/documentation
- **GitHub**: https://github.com/wpclinic/hustlemate
- **Issues**: https://github.com/wpclinic/hustlemate/issues

## Support

- Email: support@wpwingman.com
- Documentation: https://wpwingman.com/docs
- Community: https://community.wpwingman.com

---

Happy coding! 🚀

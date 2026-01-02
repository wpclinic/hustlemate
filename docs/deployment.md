# Deployment Guide

## Prerequisites

- Docker 20.10+
- Docker Compose 2.0+
- Domain with DNS access
- SSL certificate (or Let's Encrypt)

## Environment Setup

### 1. Clone Repository

```bash
git clone https://github.com/wpclinic/hustlemate.git
cd hustlemate
```

### 2. Configure Environment Variables

#### Backend (.env)

```bash
cd backend
cp .env.example .env
```

Update the following variables:

```env
APP_NAME="WP Wingman"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://api.yourdomain.com

DB_CONNECTION=pgsql
DB_HOST=postgres
DB_PORT=5432
DB_DATABASE=wpwingman
DB_USERNAME=wpwingman
DB_PASSWORD=your_secure_password

REDIS_HOST=redis
REDIS_PORT=6379

MAIL_MAILER=smtp
MAIL_HOST=smtp.yourdomain.com
MAIL_PORT=587
MAIL_USERNAME=your_email@yourdomain.com
MAIL_PASSWORD=your_email_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@yourdomain.com
MAIL_FROM_NAME="${APP_NAME}"

# Generate with: php artisan key:generate
APP_KEY=base64:your_generated_key
```

#### Frontend Environment

Create `.env.production` in both `admin-dashboard` and `client-portal`:

```env
VITE_API_URL=https://api.yourdomain.com/api/v1
```

### 3. Build Docker Images

```bash
# Build all services
docker-compose build

# Or build individually
docker-compose build backend
docker-compose build admin-dashboard
docker-compose build client-portal
```

### 4. Initialize Database

```bash
# Start database service
docker-compose up -d postgres redis

# Wait for database to be ready
sleep 10

# Run migrations
docker-compose run --rm backend php artisan migrate --force

# Seed database (optional)
docker-compose run --rm backend php artisan db:seed --force
```

### 5. Start Services

```bash
# Start all services
docker-compose up -d

# Check service status
docker-compose ps

# View logs
docker-compose logs -f
```

## Production Configuration

### Nginx Reverse Proxy

Create `/etc/nginx/sites-available/wpwingman`:

```nginx
# API Backend
server {
    listen 80;
    server_name api.yourdomain.com;
    
    location / {
        proxy_pass http://localhost:8000;
        proxy_set_header Host $host;
        proxy_set_header X-Real-IP $remote_addr;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
        proxy_set_header X-Forwarded-Proto $scheme;
    }
}

# Admin Dashboard
server {
    listen 80;
    server_name admin.yourdomain.com;
    
    location / {
        proxy_pass http://localhost:3000;
        proxy_set_header Host $host;
        proxy_set_header X-Real-IP $remote_addr;
    }
}

# Client Portal
server {
    listen 80;
    server_name portal.yourdomain.com;
    
    location / {
        proxy_pass http://localhost:3001;
        proxy_set_header Host $host;
        proxy_set_header X-Real-IP $remote_addr;
    }
}

# Landing Page
server {
    listen 80;
    server_name yourdomain.com www.yourdomain.com;
    
    location / {
        proxy_pass http://localhost:3002;
        proxy_set_header Host $host;
        proxy_set_header X-Real-IP $remote_addr;
    }
}
```

Enable the site:

```bash
sudo ln -s /etc/nginx/sites-available/wpwingman /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl reload nginx
```

### SSL with Let's Encrypt

```bash
sudo apt install certbot python3-certbot-nginx

sudo certbot --nginx -d api.yourdomain.com
sudo certbot --nginx -d admin.yourdomain.com
sudo certbot --nginx -d portal.yourdomain.com
sudo certbot --nginx -d yourdomain.com -d www.yourdomain.com
```

## Monitoring & Maintenance

### View Logs

```bash
# All services
docker-compose logs -f

# Specific service
docker-compose logs -f backend
docker-compose logs -f admin-dashboard
```

### Backup Database

```bash
# Create backup
docker-compose exec postgres pg_dump -U wpwingman wpwingman > backup.sql

# Restore backup
docker-compose exec -T postgres psql -U wpwingman wpwingman < backup.sql
```

### Update Application

```bash
# Pull latest changes
git pull origin main

# Rebuild services
docker-compose build

# Restart services
docker-compose up -d

# Run migrations
docker-compose exec backend php artisan migrate --force

# Clear cache
docker-compose exec backend php artisan cache:clear
docker-compose exec backend php artisan config:clear
```

### Queue Worker

The queue worker is automatically started by docker-compose. Monitor it:

```bash
docker-compose logs -f queue
```

### Scheduled Tasks

Add to crontab:

```bash
* * * * * cd /path/to/hustlemate && docker-compose exec -T backend php artisan schedule:run >> /dev/null 2>&1
```

## Scaling

### Horizontal Scaling

For high traffic, scale services:

```bash
# Scale queue workers
docker-compose up -d --scale queue=3

# Scale backend
docker-compose up -d --scale backend=2
```

Use a load balancer (Nginx, HAProxy) to distribute traffic.

### Database Optimization

1. Enable PostgreSQL connection pooling
2. Configure Redis for session and cache
3. Use CDN for static assets
4. Enable query caching

## Security Checklist

- [ ] Change all default passwords
- [ ] Enable firewall (UFW)
- [ ] Disable root SSH login
- [ ] Use SSH keys only
- [ ] Enable fail2ban
- [ ] Regular security updates
- [ ] Backup encryption
- [ ] Rate limiting enabled
- [ ] CORS configured properly
- [ ] Environment files secured

## Troubleshooting

### Container won't start

```bash
docker-compose down
docker-compose up -d
docker-compose logs
```

### Database connection issues

```bash
docker-compose exec postgres psql -U wpwingman -d wpwingman
```

### Permission issues

```bash
docker-compose exec backend chown -R www-data:www-data storage bootstrap/cache
docker-compose exec backend chmod -R 775 storage bootstrap/cache
```

### Clear all caches

```bash
docker-compose exec backend php artisan cache:clear
docker-compose exec backend php artisan config:clear
docker-compose exec backend php artisan route:clear
docker-compose exec backend php artisan view:clear
docker-compose restart redis
```

## Support

For issues and support:
- GitHub Issues: https://github.com/wpclinic/hustlemate/issues
- Email: support@wpwingman.com
- Documentation: https://wpwingman.com/docs

# Architecture Overview

## System Architecture

WP Wingman follows a modern, microservices-inspired architecture with clear separation of concerns.

```
┌─────────────────────────────────────────────────────────────┐
│                        Client Layer                          │
├─────────────────┬─────────────────┬────────────────────────┤
│ Admin Dashboard │  Client Portal  │    Landing Page        │
│   (Vue 3 + TS)  │  (Vue 3 + TS)   │    (Vue 3 + TS)       │
│   Port: 3000    │   Port: 3001    │    Port: 3002         │
└────────┬────────┴────────┬────────┴────────────┬───────────┘
         │                 │                     │
         └─────────────────┼─────────────────────┘
                          │
                          ▼
         ┌────────────────────────────────────┐
         │        API Gateway / Nginx         │
         └────────────────┬───────────────────┘
                          │
                          ▼
         ┌────────────────────────────────────┐
         │      Laravel 11 REST API           │
         │      (PHP 8.3 + Sanctum)          │
         │         Port: 8000                 │
         └────┬────────────┬──────────────────┘
              │            │
      ┌───────┴────┐  ┌────┴────────┐
      │ PostgreSQL │  │   Redis     │
      │  Database  │  │ Cache/Queue │
      └────────────┘  └─────────────┘
                          │
              ┌───────────┴──────────────┐
              │                          │
              ▼                          ▼
    ┌──────────────────┐      ┌──────────────────┐
    │  Queue Workers   │      │  Cron Scheduler  │
    │  (Background)    │      │  (Monitoring)    │
    └──────────────────┘      └──────────────────┘
                          │
                          ▼
              ┌──────────────────────┐
              │  WordPress Plugin    │
              │  (Client Sites)      │
              │  Data Collection     │
              └──────────────────────┘
```

## Technology Stack

### Backend (Laravel 11)
- **Framework**: Laravel 11.x
- **Language**: PHP 8.3
- **Authentication**: Laravel Sanctum (API tokens)
- **Database ORM**: Eloquent
- **Queue System**: Redis-backed queues
- **Cache**: Redis
- **API Style**: RESTful

### Frontend (Vue 3)
- **Framework**: Vue 3.4+ (Composition API)
- **Language**: TypeScript 5.x
- **State Management**: Pinia
- **Routing**: Vue Router 4
- **Styling**: TailwindCSS 3.x
- **Charts**: Chart.js + vue-chartjs
- **HTTP Client**: Axios
- **Build Tool**: Vite

### Database
- **Primary**: PostgreSQL 16
- **Advantages**: 
  - ACID compliance
  - JSON support for flexible data
  - Advanced indexing
  - Better performance for complex queries
  - Excellent concurrency

### Cache & Queue
- **Redis 7**
- **Use Cases**:
  - Session storage
  - Cache layer
  - Queue backend
  - Real-time data

### Infrastructure
- **Containerization**: Docker + Docker Compose
- **Web Server**: Nginx (reverse proxy)
- **CI/CD**: GitHub Actions
- **SSL**: Let's Encrypt

## Data Flow

### 1. User Authentication Flow
```
User → Admin/Client Portal → API (/auth/login)
     ← JWT Token ← API
User → Authenticated Request (with token) → API
     ← Protected Resource ← API
```

### 2. Site Monitoring Flow
```
WordPress Site (Plugin) → Collect Data
                        → Send to API (/api/v1/wp/monitor)
                        → API validates API key
                        → Store in database
                        → Queue background jobs
                        → Update site status
                        → Trigger alerts if needed
```

### 3. Backup Flow
```
Admin → Request Backup → API
                       → Create backup job
                       → Queue worker picks up job
                       → Connect to WordPress site
                       → Create backup
                       → Upload to storage
                       → Update database record
                       → Notify admin
```

### 4. Reporting Flow
```
Scheduler (daily/weekly) → Generate Report Job
                        → Query monitoring data
                        → Aggregate statistics
                        → Generate PDF/HTML
                        → Store report
                        → Email to client
```

## Database Schema

### Core Relationships

```
clients (1) ──┬── (n) users
              ├── (n) sites
              ├── (n) subscriptions
              ├── (n) support_tickets
              └── (n) reports

sites (1) ──┬── (n) site_monitors
            ├── (n) backups
            ├── (n) security_scans
            └── (n) updates

users (1) ── (n) audit_logs
users (n) ── (1) clients
```

### Key Tables

1. **users** - Authentication and authorization
2. **clients** - Client organizations
3. **sites** - WordPress sites being monitored
4. **site_monitors** - Hourly monitoring snapshots
5. **backups** - Backup records and metadata
6. **security_scans** - Security scan results
7. **updates** - Available updates tracking
8. **subscriptions** - Billing and plan management
9. **support_tickets** - Client support system
10. **reports** - Generated reports
11. **audit_logs** - System activity tracking

## Security Architecture

### Authentication & Authorization
- **API Authentication**: Laravel Sanctum tokens
- **Role-Based Access Control** (RBAC):
  - `admin`: Full system access
  - `client`: Client-specific access
  - `support`: Support ticket access
- **Two-Factor Authentication**: Optional 2FA
- **API Key Authentication**: For WordPress plugins

### Data Security
- **Encryption at Rest**: Database encryption
- **Encryption in Transit**: TLS/SSL
- **Password Hashing**: bcrypt
- **API Rate Limiting**: Throttling middleware
- **CORS Protection**: Configured origins
- **XSS Protection**: Input sanitization
- **SQL Injection Protection**: Eloquent ORM
- **CSRF Protection**: Token validation

### Infrastructure Security
- **Firewall**: UFW/iptables
- **SSL Certificates**: Let's Encrypt
- **Container Isolation**: Docker networking
- **Secrets Management**: Environment variables
- **Regular Updates**: Automated security patches

## Scalability

### Horizontal Scaling
- **API Servers**: Multiple Laravel instances behind load balancer
- **Queue Workers**: Scale workers based on queue depth
- **Database**: PostgreSQL replication (read replicas)
- **Cache**: Redis Sentinel or Cluster

### Vertical Scaling
- **CPU**: Multi-core processing for Laravel
- **Memory**: Increase for caching and queue processing
- **Storage**: SSD for database performance

### Performance Optimization
1. **Database Indexing**: All foreign keys and frequent queries
2. **Query Optimization**: Eager loading, select specific columns
3. **Caching Strategy**:
   - Route caching
   - Config caching
   - View caching
   - Query result caching
4. **Asset Optimization**:
   - Minified CSS/JS
   - Image optimization
   - CDN for static assets
5. **Queue Processing**: Background jobs for heavy tasks

## Monitoring & Observability

### Application Monitoring
- **Logging**: Laravel Log (monolog)
- **Error Tracking**: Laravel error handlers
- **Performance**: Query logging, slow query detection
- **Health Checks**: API endpoint health

### Infrastructure Monitoring
- **Container Health**: Docker health checks
- **Database**: PostgreSQL monitoring
- **Redis**: Redis monitoring
- **Disk Space**: Storage alerts
- **Memory/CPU**: Resource monitoring

### Alerting
- **Email Notifications**: Critical errors
- **Webhook Integration**: Slack/Discord
- **SMS Alerts**: For critical issues

## Backup & Recovery

### Database Backups
- **Frequency**: Daily automated backups
- **Retention**: 30 days
- **Location**: Off-site storage
- **Testing**: Monthly restore tests

### Application Backups
- **Code**: Git repository
- **Configuration**: Environment templates
- **Uploads**: S3/Object storage

### Disaster Recovery
- **RTO** (Recovery Time Objective): < 4 hours
- **RPO** (Recovery Point Objective): < 24 hours
- **Procedures**: Documented recovery steps

## Development Workflow

### Git Branching Strategy
```
main (production)
  └── develop (staging)
       ├── feature/feature-name
       ├── bugfix/bug-description
       └── hotfix/critical-fix
```

### CI/CD Pipeline
1. **Code Push** → GitHub
2. **Automated Tests** → GitHub Actions
3. **Build Docker Images** → Container Registry
4. **Deploy to Staging** → Test environment
5. **Manual Approval** → Production gate
6. **Deploy to Production** → Blue-green deployment

### Code Quality
- **Linting**: Laravel Pint (backend), ESLint (frontend)
- **Type Checking**: TypeScript
- **Testing**: PHPUnit, Pest (backend), Vitest (frontend)
- **Code Review**: Required before merge

## Future Enhancements

### Phase 2 Features
- WebSocket support for real-time updates
- Advanced analytics with AI/ML
- Multi-site dashboard views
- API webhooks for integrations
- Mobile applications (iOS/Android)
- White-label options
- Advanced backup scheduling
- Multi-region deployment

### Integrations
- Slack notifications
- Zapier integration
- Stripe payment processing
- AWS S3 for backups
- Cloudflare integration
- GitHub/GitLab CI integration

## Conclusion

This architecture provides:
- ✅ Scalability for growth
- ✅ Security by design
- ✅ High availability
- ✅ Easy maintenance
- ✅ Clear separation of concerns
- ✅ Modern development practices

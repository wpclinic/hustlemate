# API Documentation

## Base URL
```
http://localhost:8000/api/v1
```

## Authentication

All API requests (except registration and login) require authentication via Bearer token.

### Headers
```
Authorization: Bearer {token}
Content-Type: application/json
```

## Endpoints

### Authentication

#### Register
```http
POST /auth/register
```

**Request Body:**
```json
{
  "name": "John Doe",
  "email": "john@example.com",
  "password": "password123",
  "password_confirmation": "password123",
  "role": "client"
}
```

**Response:**
```json
{
  "success": true,
  "message": "User registered successfully",
  "data": {
    "user": {
      "id": 1,
      "name": "John Doe",
      "email": "john@example.com",
      "role": "client"
    },
    "token": "1|aBcDeFgHiJkLmNoPqRsTuVwXyZ"
  }
}
```

#### Login
```http
POST /auth/login
```

**Request Body:**
```json
{
  "email": "john@example.com",
  "password": "password123"
}
```

#### Logout
```http
POST /auth/logout
```

#### Get Current User
```http
GET /auth/me
```

### Clients

#### List Clients
```http
GET /clients
```

#### Create Client
```http
POST /clients
```

**Request Body:**
```json
{
  "name": "John Doe",
  "company": "Acme Corp",
  "email": "john@acme.com",
  "phone": "+1234567890",
  "address": "123 Main St",
  "timezone": "America/New_York"
}
```

#### Get Client
```http
GET /clients/{id}
```

#### Update Client
```http
PUT /clients/{id}
```

#### Delete Client
```http
DELETE /clients/{id}
```

### Sites

#### List Sites
```http
GET /sites
```

**Query Parameters:**
- `client_id` - Filter by client
- `status` - Filter by status (online, offline, warning, critical)
- `monitoring_enabled` - Filter by monitoring status

#### Create Site
```http
POST /sites
```

**Request Body:**
```json
{
  "client_id": 1,
  "name": "My WordPress Site",
  "url": "https://example.com",
  "monitoring_enabled": true,
  "backup_enabled": true,
  "notes": "Production site"
}
```

#### Get Site
```http
GET /sites/{id}
```

#### Update Site
```http
PUT /sites/{id}
```

#### Delete Site
```http
DELETE /sites/{id}
```

#### Check Site Status
```http
POST /sites/{id}/check
```

### Backups

#### List Backups
```http
GET /backups
```

**Query Parameters:**
- `site_id` - Filter by site
- `status` - Filter by status
- `type` - Filter by backup type

#### Create Backup
```http
POST /backups
```

**Request Body:**
```json
{
  "site_id": 1,
  "type": "full"
}
```

#### Get Backup
```http
GET /backups/{id}
```

#### Restore Backup
```http
POST /backups/{id}/restore
```

#### Download Backup
```http
POST /backups/{id}/download
```

### Security

#### List Security Scans
```http
GET /security/scans
```

#### Scan Site
```http
POST /security/scan/{siteId}
```

#### Get Security Scan
```http
GET /security/scans/{id}
```

### Updates

#### List Updates
```http
GET /updates
```

#### Apply Update
```http
POST /updates/{id}/apply
```

#### Schedule Update
```http
POST /updates/{id}/schedule
```

**Request Body:**
```json
{
  "scheduled_at": "2024-01-15 02:00:00"
}
```

### Reports

#### List Reports
```http
GET /reports
```

#### Generate Report
```http
POST /reports/generate
```

**Request Body:**
```json
{
  "client_id": 1,
  "site_id": 1,
  "type": "weekly",
  "period_start": "2024-01-01",
  "period_end": "2024-01-07"
}
```

#### Download Report
```http
GET /reports/{id}/download
```

### Support Tickets

#### List Tickets
```http
GET /tickets
```

#### Create Ticket
```http
POST /tickets
```

**Request Body:**
```json
{
  "client_id": 1,
  "site_id": 1,
  "subject": "Site is down",
  "description": "The site has been offline for 2 hours",
  "priority": "high"
}
```

#### Update Ticket
```http
PUT /tickets/{id}
```

#### Assign Ticket
```http
POST /tickets/{id}/assign
```

#### Resolve Ticket
```http
POST /tickets/{id}/resolve
```

### Analytics

#### Overview Analytics
```http
GET /analytics/overview
```

#### Performance Analytics
```http
GET /analytics/performance
```

#### Security Analytics
```http
GET /analytics/security
```

#### Site Analytics
```http
GET /analytics/sites/{id}
```

### Subscriptions

#### List Subscriptions
```http
GET /subscriptions
```

#### Create Subscription
```http
POST /subscriptions
```

#### Cancel Subscription
```http
POST /subscriptions/{id}/cancel
```

#### Resume Subscription
```http
POST /subscriptions/{id}/resume
```

## WordPress Plugin Endpoints

These endpoints are used by the WordPress plugin to send data.

### Monitor Data
```http
POST /wp/monitor
```

**Headers:**
```
Authorization: Bearer {site_api_key}
```

**Request Body:**
```json
{
  "timestamp": "2024-01-01 12:00:00",
  "site_info": {
    "wp_version": "6.4",
    "php_version": "8.3.0",
    "theme": {...},
    "plugins": [...]
  },
  "performance": {...},
  "status": {...}
}
```

### Daily Report
```http
POST /wp/daily-report
```

## Error Responses

### 401 Unauthorized
```json
{
  "success": false,
  "message": "Unauthenticated"
}
```

### 403 Forbidden
```json
{
  "success": false,
  "message": "This action is unauthorized"
}
```

### 404 Not Found
```json
{
  "success": false,
  "message": "Resource not found"
}
```

### 422 Validation Error
```json
{
  "success": false,
  "message": "Validation error",
  "errors": {
    "email": ["The email field is required."]
  }
}
```

### 500 Server Error
```json
{
  "success": false,
  "message": "Internal server error"
}
```

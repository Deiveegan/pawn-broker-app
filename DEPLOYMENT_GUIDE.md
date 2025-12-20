# DEPLOYMENT GUIDE

## 🚀 Pawn Broker Application - Production Deployment Guide

**Version**: 1.0.0  
**Last Updated**: December 21, 2025  
**Target Environment**: Linux/Ubuntu Server

---

## 📋 Table of Contents

1. [Prerequisites](#prerequisites)
2. [Server Requirements](#server-requirements)
3. [Installation Steps](#installation-steps)
4. [Configuration](#configuration)
5. [Database Setup](#database-setup)
6. [Web Server Configuration](#web-server-configuration)
7. [SSL Certificate](#ssl-certificate)
8. [Performance Optimization](#performance-optimization)
9. [Backup Strategy](#backup-strategy)
10. [Monitoring](#monitoring)
11. [Troubleshooting](#troubleshooting)

---

## Prerequisites

### Required Software

- **PHP**: 8.2 or higher
- **Composer**: Latest version
- **Node.js**: 18.x or higher
- **NPM**: Latest version
- **MySQL**: 8.0 or higher (or MariaDB 10.6+)
- **Web Server**: Nginx (recommended) or Apache
- **Git**: For version control

### Server Access

- SSH access with sudo privileges
- Domain name pointing to server IP
- Minimum 2GB RAM, 20GB disk space

---

## Server Requirements

### PHP Extensions

```bash
sudo apt install -y php8.2-cli php8.2-fpm php8.2-mysql php8.2-xml \
  php8.2-mbstring php8.2-curl php8.2-zip php8.2-gd php8.2-bcmath \
  php8.2-intl php8.2-redis
```

### System Packages

```bash
sudo apt update
sudo apt install -y nginx mysql-server composer nodejs npm git \
  supervisor certbot python3-certbot-nginx
```

---

## Installation Steps

### 1. Clone Repository

```bash
cd /var/www
sudo git clone https://github.com/yourusername/pawn-broker.git
sudo chown -R www-data:www-data pawn-broker
cd pawn-broker
```

### 2. Install Dependencies

```bash
# PHP dependencies
composer install --optimize-autoloader --no-dev

# Node dependencies
npm install
npm run build
```

### 3. Environment Configuration

```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Edit environment variables
nano .env
```

**Required .env Changes**:

```env
APP_NAME="Pawn Broker"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=pawn_broker
DB_USERNAME=pawn_user
DB_PASSWORD=secure_password_here

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@yourdomain.com
MAIL_FROM_NAME="${APP_NAME}"

SESSION_DRIVER=redis
CACHE_DRIVER=redis
QUEUE_CONNECTION=redis

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379
```

### 4. File Permissions

```bash
sudo chown -R www-data:www-data /var/www/pawn-broker
sudo chmod -R 755 /var/www/pawn-broker
sudo chmod -R 775 /var/www/pawn-broker/storage
sudo chmod -R 775 /var/www/pawn-broker/bootstrap/cache
```

---

## Database Setup

### 1. Create Database and User

```bash
sudo mysql -u root -p
```

```sql
CREATE DATABASE pawn_broker CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'pawn_user'@'localhost' IDENTIFIED BY 'secure_password_here';
GRANT ALL PRIVILEGES ON pawn_broker.* TO 'pawn_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

### 2. Run Migrations

```bash
php artisan migrate --force
```

### 3. Seed Initial Data (Optional)

```bash
php artisan db:seed --force
```

### 4. Create Storage Link

```bash
php artisan storage:link
```

---

## Web Server Configuration

### Nginx Configuration

Create file: `/etc/nginx/sites-available/pawn-broker`

```nginx
server {
    listen 80;
    listen [::]:80;
    server_name yourdomain.com www.yourdomain.com;
    root /var/www/pawn-broker/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
        fastcgi_hide_header X-Powered-By;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }

    # Security headers
    add_header X-XSS-Protection "1; mode=block";
    add_header Referrer-Policy "strict-origin-when-cross-origin";
    add_header Permissions-Policy "geolocation=(), microphone=(), camera=()";

    # Gzip compression
    gzip on;
    gzip_vary on;
    gzip_min_length 1024;
    gzip_types text/plain text/css text/xml text/javascript application/x-javascript application/xml+rss application/json;

    # Client body size (for file uploads)
    client_max_body_size 10M;
}
```

### Enable Site

```bash
sudo ln -s /etc/nginx/sites-available/pawn-broker /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl restart nginx
```

### Apache Configuration (Alternative)

Create file: `/etc/apache2/sites-available/pawn-broker.conf`

```apache
<VirtualHost *:80>
    ServerName yourdomain.com
    ServerAlias www.yourdomain.com
    DocumentRoot /var/www/pawn-broker/public

    <Directory /var/www/pawn-broker/public>
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/pawn-broker-error.log
    CustomLog ${APACHE_LOG_DIR}/pawn-broker-access.log combined
</VirtualHost>
```

```bash
sudo a2ensite pawn-broker
sudo a2enmod rewrite
sudo systemctl restart apache2
```

---

## SSL Certificate

### Using Let's Encrypt (Free)

```bash
# For Nginx
sudo certbot --nginx -d yourdomain.com -d www.yourdomain.com

# For Apache
sudo certbot --apache -d yourdomain.com -d www.yourdomain.com
```

### Auto-Renewal

```bash
# Test renewal
sudo certbot renew --dry-run

# Certbot automatically sets up cron job for renewal
```

---

## Performance Optimization

### 1. Cache Configuration

```bash
# Cache routes
php artisan route:cache

# Cache config
php artisan config:cache

# Cache views
php artisan view:cache

# Optimize autoloader
composer dump-autoload --optimize
```

### 2. Queue Worker Setup

Create supervisor config: `/etc/supervisor/conf.d/pawn-broker-worker.conf`

```ini
[program:pawn-broker-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/pawn-broker/artisan queue:work redis --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=www-data
numprocs=2
redirect_stderr=true
stdout_logfile=/var/www/pawn-broker/storage/logs/worker.log
stopwaitsecs=3600
```

```bash
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start pawn-broker-worker:*
```

### 3. Redis Setup

```bash
sudo apt install redis-server
sudo systemctl enable redis-server
sudo systemctl start redis-server
```

### 4. OPcache Configuration

Edit `/etc/php/8.2/fpm/php.ini`:

```ini
opcache.enable=1
opcache.memory_consumption=256
opcache.interned_strings_buffer=16
opcache.max_accelerated_files=10000
opcache.revalidate_freq=60
opcache.fast_shutdown=1
```

```bash
sudo systemctl restart php8.2-fpm
```

---

## Backup Strategy

### 1. Database Backup Script

Create file: `/usr/local/bin/backup-pawn-broker-db.sh`

```bash
#!/bin/bash
BACKUP_DIR="/var/backups/pawn-broker"
DATE=$(date +%Y%m%d_%H%M%S)
DB_NAME="pawn_broker"
DB_USER="pawn_user"
DB_PASS="secure_password_here"

mkdir -p $BACKUP_DIR

# Backup database
mysqldump -u $DB_USER -p$DB_PASS $DB_NAME | gzip > $BACKUP_DIR/db_$DATE.sql.gz

# Backup uploaded files
tar -czf $BACKUP_DIR/storage_$DATE.tar.gz /var/www/pawn-broker/storage/app/public

# Keep only last 30 days of backups
find $BACKUP_DIR -type f -mtime +30 -delete

echo "Backup completed: $DATE"
```

```bash
sudo chmod +x /usr/local/bin/backup-pawn-broker-db.sh
```

### 2. Cron Job for Automated Backups

```bash
sudo crontab -e
```

Add:
```cron
# Daily backup at 2 AM
0 2 * * * /usr/local/bin/backup-pawn-broker-db.sh >> /var/log/pawn-broker-backup.log 2>&1
```

### 3. Off-site Backup (Optional)

```bash
# Install rclone for cloud backup
curl https://rclone.org/install.sh | sudo bash

# Configure rclone (follow prompts)
rclone config

# Add to backup script
rclone sync /var/backups/pawn-broker remote:pawn-broker-backups
```

---

## Monitoring

### 1. Application Logs

```bash
# View Laravel logs
tail -f /var/www/pawn-broker/storage/logs/laravel.log

# View Nginx logs
tail -f /var/log/nginx/access.log
tail -f /var/log/nginx/error.log
```

### 2. Disk Space Monitoring

```bash
# Check disk usage
df -h

# Check storage directory size
du -sh /var/www/pawn-broker/storage
```

### 3. Uptime Monitoring

Consider using:
- **UptimeRobot** (free)
- **Pingdom**
- **StatusCake**

### 4. Error Tracking

Consider integrating:
- **Sentry** (error tracking)
- **Bugsnag**
- **Rollbar**

---

## Security Checklist

- [ ] Change default database credentials
- [ ] Set `APP_DEBUG=false` in production
- [ ] Configure firewall (UFW)
- [ ] Install fail2ban for SSH protection
- [ ] Enable HTTPS with valid SSL certificate
- [ ] Set proper file permissions
- [ ] Disable directory listing
- [ ] Configure CSRF protection
- [ ] Set up regular backups
- [ ] Keep all software updated
- [ ] Use strong passwords
- [ ] Implement rate limiting

### Firewall Configuration

```bash
sudo ufw allow 22/tcp
sudo ufw allow 80/tcp
sudo ufw allow 443/tcp
sudo ufw enable
```

---

## Troubleshooting

### Application Not Loading

```bash
# Check Nginx status
sudo systemctl status nginx

# Check PHP-FPM status
sudo systemctl status php8.2-fpm

# Check Laravel logs
tail -f /var/www/pawn-broker/storage/logs/laravel.log
```

### Database Connection Issues

```bash
# Test database connection
php artisan tinker
>>> DB::connection()->getPdo();
```

### Permission Issues

```bash
sudo chown -R www-data:www-data /var/www/pawn-broker
sudo chmod -R 755 /var/www/pawn-broker
sudo chmod -R 775 /var/www/pawn-broker/storage
sudo chmod -R 775 /var/www/pawn-broker/bootstrap/cache
```

### Cache Issues

```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

### Queue Not Processing

```bash
# Check supervisor status
sudo supervisorctl status

# Restart queue workers
sudo supervisorctl restart pawn-broker-worker:*
```

---

## Maintenance Mode

### Enable Maintenance Mode

```bash
php artisan down --message="Scheduled maintenance" --retry=60
```

### Disable Maintenance Mode

```bash
php artisan up
```

---

## Updates and Upgrades

### Deploying Updates

```bash
cd /var/www/pawn-broker

# Enable maintenance mode
php artisan down

# Pull latest code
git pull origin main

# Install dependencies
composer install --optimize-autoloader --no-dev
npm install && npm run build

# Run migrations
php artisan migrate --force

# Clear and rebuild cache
php artisan cache:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Restart services
sudo systemctl restart php8.2-fpm
sudo supervisorctl restart pawn-broker-worker:*

# Disable maintenance mode
php artisan up
```

---

## Post-Deployment Checklist

- [ ] Application loads successfully
- [ ] SSL certificate is active
- [ ] Database migrations completed
- [ ] File uploads working
- [ ] PDF generation working
- [ ] Email sending configured
- [ ] Queue workers running
- [ ] Backups configured
- [ ] Monitoring set up
- [ ] Logs rotating properly

---

## Support

For deployment issues, check:
1. Laravel logs: `/var/www/pawn-broker/storage/logs/laravel.log`
2. Nginx logs: `/var/log/nginx/error.log`
3. PHP-FPM logs: `/var/log/php8.2-fpm.log`

---

**Deployment Guide Version**: 1.0.0  
**Last Updated**: December 21, 2025  
**Tested On**: Ubuntu 22.04 LTS

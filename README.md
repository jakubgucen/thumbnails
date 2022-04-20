### Installation:
```bash
git clone https://github.com/jakubgucen/thumbnails.git .
composer install
# Create and configure .env.local
# Copy images to public/images
```

### Saving thumbnails on the disk:
```bash
php bin/console app:create-thumbnails disk
# The thumbnails will be saved in the public/thumbnails
```

### Saving thumbnails to the FTP server:
```bash
php bin/console app:create-thumbnails ftp
# The thumbnails will be saved in the ftp server
```

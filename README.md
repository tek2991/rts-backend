## SCP to staging server 
`scp -r ./public/build ubuntu@65.0.138.243:/var/www/rts-backend/public/`

## SCP to live server 
`scp -r ./public/build ubuntu@3.108.151.15:/var/www/rts-backend/public/`

## Upload storage/app/app-release.apk to staging server
`scp ./storage/app/app-release.apk ubuntu@65.0.138.243:/var/www/rts-backend/storage/app/`

## Upload storage/app/app-release.apk to live server
`scp ./storage/app/app-release.apk ubuntu@3.108.151.15:/var/www/rts-backend/storage/app/`

## Edit php.ini
`sudo nano /etc/php/8.1/fpm/conf.d/00-myconf.ini`
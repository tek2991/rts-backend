## SCP to staging server 
`scp -r ./public/build ubuntu@65.0.138.243:/var/www/rts-backend/public/`

## SCP to live server 
`scp -r ./public/build ubuntu@3.108.151.15:/var/www/rts-backend/public/`

## Edit php.ini
`sudo nano /etc/php/8.1/fpm/conf.d/00-myconf.ini`
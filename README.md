rssReader
=========

Basic rss reader

Apache2.4
=============================================================
- create file rssreader.conf at apache conf folder (e.g: /etc/apache2/sites-available )
- put inside
```
    <VirtualHost *:80>
            ServerName rssreader.loc
            ServerAdmin mymail@gmail.com

            DocumentRoot /var/www/rssReader/web
            <Directory /var/www/rssReader/web>
                    Options -Indexes +FollowSymLinks +MultiViews
                    AllowOverride none
                    Order allow,deny
                    Allow from all
                    <IfModule mod_rewrite.c>
                        RewriteEngine On
                        RewriteCond %{REQUEST_FILENAME} !-f
                        RewriteCond %{REQUEST_FILENAME} !-d
                        RewriteRule ^(.*)$ /app.php [QSA,L]
                    </IfModule>
                    DirectoryIndex app.php
            </Directory>

            ErrorLog /var/log/apache2/rss_reader_error.log

            # Possible values include: debug, info, notice, warn, error, crit,
            # alert, emerg.
            LogLevel warn

            CustomLog /var/log/apache2/rss_reader_access.log combined

    </VirtualHost>
```
- enable this conf
- restart apache
- add configuration line to hosts file
    127.0.0.1   rssreader.loc

MySQL
=============================================================
```
create database rssreader;
grant usage on *.* to rssreader@localhost identified by 'rssreader';
grant all privileges on rssreader.* to rssreader@localhost ;
```

Composer
=============================================================
To easy install symfony and all components, use composer: https://getcomposer.org/download/

Parameters
=============================================================
- create file app/config/parameters.yml
- set content:
```
        parameters:

            database_driver: pdo_mysql

            database_host: localhost

            database_port: null

            database_name: rssreader

            database_user: rssreader

            database_password: rssreader

            mailer_transport: smtp

            mailer_host: 127.0.0.1

            mailer_user: null

            mailer_password: null

            locale: en

            secret: 'somesecretkey:)'
```

Tables creation
=============================================================
- in console in root folder of rss reader run next command
```
php app/console doctrine:schema:update --force
```

ExtJS 4.2.1
=============================================================
- download from: http://www.sencha.com/products/extjs/download/
- unpack src/Rss/ReaderBundle/Resources/public/js/ext

=======
Assets
=============================================================
- run in root folder next commands

```
    php app/console assetic:dump
    php app/console assets:install web --symlik
```

Crontab
=============================================================
- add crontab to run next command every 5 minutes
```
*/5 * * * * /usr/bin/php /var/www/rssReader/app/console php app/console rss:feeds:import
```
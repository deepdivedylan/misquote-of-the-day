FROM richarvey/nginx-php-fpm
RUN sed -i "s/try_files.*/try_files \$uri \$uri\/ \/index.html =404;/g" /etc/nginx/sites-available/default.conf
RUN sed -i "s/try_files.*/try_files \$uri \$uri\/ \/index.html =404;/g" /etc/nginx/sites-available/default-ssl.conf
RUN rm /var/www/html/index.php
RUN mkdir /var/www/php
RUN mkdir /var/www/vendor
COPY php /var/www/php
COPY vendor /var/www/vendor
COPY public_html /var/www/html
EXPOSE 80
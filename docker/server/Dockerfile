FROM php:8
WORKDIR /var/www/fl
RUN curl https://raw.githubusercontent.com/composer/getcomposer.org/76a7060ccb93902cd7576b67264ad91c8a2700e2/web/installer  -o /installer.php && \
    php /installer.php --install-dir=/bin --filename=composer
RUN apt update && apt install git unzip -y
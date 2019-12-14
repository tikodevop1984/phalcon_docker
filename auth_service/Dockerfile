FROM php:7.2-apache

# APACHE
RUN a2enmod rewrite
RUN sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf


# NEEDED APPS
RUN apt-get update && \
    apt-get upgrade -y && \
    apt-get install -y git && \
    apt-get install -y sqlite3 && \
    apt-get install -y p7zip && \
    apt-get install -y zip && \
    apt-get install -y unzip


# PHALCON
ENV PHALCON_VERSION=3.4.2
RUN curl -sSL "https://codeload.github.com/phalcon/cphalcon/tar.gz/v${PHALCON_VERSION}" | tar -xz \
    && cd cphalcon-${PHALCON_VERSION}/build \
    && ./install \
    && cp ../tests/_ci/phalcon.ini $(php-config --configure-options | grep -o "with-config-file-scan-dir=\([^ ]*\)" | awk -F'=' '{print $2}') \
    && cd ../../ \
    && rm -r cphalcon-${PHALCON_VERSION}

# COMPOSER
RUN curl -sS https://getcomposer.org/installer | \
    php -- --install-dir=/usr/bin/ --filename=composer

WORKDIR /var/www/html

COPY . ./

# INSTALL COMPOSER PACKAGES AND RUN PHALCON MIGRATIONS ON COMPOSE UP
CMD bash -c "composer install && vendor/phalcon/devtools/phalcon migration run && apachectl -DFOREGROUND"
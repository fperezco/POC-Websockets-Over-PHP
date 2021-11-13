FROM php:7.4-apache

COPY vhost.conf /etc/apache2/sites-available/000-default.conf

RUN a2enmod proxy_fcgi ssl rewrite proxy proxy_balancer proxy_http proxy_ajp

RUN apt-get update && apt-get install -y libpq-dev && docker-php-ext-install pdo pdo_mysql json

RUN apt-get update \
&& apt-get install -y libzip-dev libpq-dev libmcrypt-dev git zlib1g zip unzip libmagickwand-dev libonig-dev --no-install-recommends \
&& docker-php-ext-configure zip \
&& docker-php-ext-install zip pdo pdo_mysql mysqli gd mbstring

RUN pecl install mcrypt && docker-php-ext-enable mcrypt

RUN apt-get install -y sloccount

RUN pecl install imagick \
    && docker-php-ext-enable zip \
    && pecl install xdebug-2.9.7 \
    && docker-php-ext-enable imagick \
    && docker-php-ext-enable xdebug

RUN apt-get update -y && apt-get install -y libwebp-dev libjpeg62-turbo-dev libpng-dev libxpm-dev \
    libfreetype6-dev
RUN apt-get update && \
    apt-get install -y \
        zlib1g-dev

RUN docker-php-ext-install mbstring

RUN apt-get install -y libzip-dev
RUN docker-php-ext-install zip


RUN docker-php-ext-configure gd \
    && docker-php-ext-install gd


RUN sed -ri -e 's!;date.timezone =!date.timezone = "Europe/Madrid"!g' /usr/local/etc/php/php.ini-development
RUN sed -ri -e 's!;date.timezone =!date.timezone = "Europe/Madrid"!g' /usr/local/etc/php/php.ini-production

###required for phantomjs
RUN apt-get -y install libfontconfig libfreetype6 libfreetype6-dev libfontconfig1 libfontconfig1-dev


RUN echo 'max_execution_time = 300' >> /usr/local/etc/php/conf.d/docker-php-maxexectime.ini
RUN echo 'memory_limit = -1' >> /usr/local/etc/php/conf.d/docker-php-memlimit.ini

##############################################################################
# Install support for sendmail. SendMail is used by php native "mail" command
##############################################################################

# Installs sendmail
RUN apt-get update && apt-get -q -y install msmtp mailutils && rm -rf /var/lib/apt/lists/*

#send mail for 7.4
COPY msmtprc /etc/msmtprc
RUN chmod 600 /etc/msmtprc
RUN chown www-data:www-data /etc/msmtprc
ARG SMTP_PASSWORD=not_provided
RUN sed -i "s|nopass|$SMTP_PASSWORD|g" /etc/msmtprc
# Set up php sendmail config
RUN echo "sendmail_path=/usr/bin/msmtp -t" >> /usr/local/etc/php/conf.d/php-sendmail.ini


# set up sendmail config
###RUN echo "hostname=localhost.localdomain" > /etc/ssmtp/ssmtp.conf
###RUN echo "root=testfromdocker@fromdocker.ts" >> /etc/ssmtp/ssmtp.conf
###RUN echo "mailhub=maildev" >> /etc/ssmtp/ssmtp.conf
# The above 'maildev' is the name you used for the link command
# in your docker-compose file or docker link command.
# Docker automatically adds that name in the hosts file
# of the container you're linking MailDev to.
# Set up php sendmail config
###RUN echo "sendmail_path=sendmail -i -t" >> /usr/local/etc/php/conf.d/php-sendmail.ini
# Fully qualified domain name configuration for sendmail on localhost.
# Without this sendmail will not work.
# This must match the value for 'hostname' field that you set in ssmtp.conf.
###RUN echo "localhost localhost.localdomain" >> /etc/hosts

RUN docker-php-ext-install sockets

FROM php:8.1-fpm

# Set working directory
WORKDIR /var/www/

# Arguments defined in docker-compose.yml
ARG user
ARG uid
ARG appname

ENV ENVIRONMENT=development

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libpq-dev supervisor \
    && apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

# Install PHP extensions
RUN docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo pdo_pgsql pgsql

# Create system user to run Composer and Artisan Commands
RUN useradd -G www-data,root,sudo -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    mkdir -p /etc/supervisor/logs/ && \
    chown -R $user:$user /home/$user && \
    chown -R $user:$user /var/www/ && \
    chown -R $user:$user /etc/supervisor/logs/
    

RUN echo '%sudo ALL=(ALL) NOPASSWD:ALL' >> /etc/sudoers

RUN ln -sf /usr/share/zoneinfo/America/Sao_Paulo /etc/localtime

COPY .docker/supervisor/supervisord.conf /etc/supervisor/supervisord.conf

CMD ["/usr/bin/supervisord", "-n", "-c",  "/etc/supervisor/supervisord.conf"]

USER $user

FROM nginx:1.15.2


RUN usermod -u 1000 www-data && \
    groupmod -g 1000 www-data

RUN mkdir -p "/var/www/trade" && mkdir -p "/var/www/gateway" && mkdir -p "/var/www/admin-gateway" && mkdir -p "/var/www/user" && mkdir -p "/var/www/wallet"
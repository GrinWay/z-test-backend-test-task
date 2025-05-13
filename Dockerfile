FROM ubuntu:24.04

RUN apt update
RUN apt install -y software-properties-common ca-certificates lsb-release
RUN apt install -y python3-dev build-essential
RUN apt install -y bash vim supervisor
RUN add-apt-repository ppa:ondrej/php
RUN apt install -y nginx
RUN apt install -y php8.4 php8.4-fpm \
  php8.4-mysql php8.4-mbstring php8.4-xml \
  php8.4-curl php8.4-zip \
  php8.4-gd php8.4-intl

WORKDIR /usr/share/nginx/www/z_app

#COPY . .

EXPOSE 80

ENTRYPOINT ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]

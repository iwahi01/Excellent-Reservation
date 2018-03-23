FROM iwahi01/selenium-httpd
#FROM php:7-apache
COPY . /var/www/html/excellent
#RUN apt-get update && docker-php-ext-install pdo_mysql mysqli mbstring
#RUN apt-get install -y nano locales --no-install-recommends && rm -rf /var/lib/apt/lists/*
#RUN dpkg-reconfigure locales && locale-gen en_US.UTF-8 && /usr/sbin/update-locale LANG=en_US.UTF-8
#RUN locale-gen en_US.UTF-8
#ENV LANG en_US.UTF-8
#ENV LANGUAGE en_US:en
#ENV LC_ALL en_US.UTF-8
RUN echo "AddDefaultCharset UTF-8" > /etc/apache2/conf-enabled/charset.conf
RUN echo "AddDefaultCharset UTF-8" > /etc/apache2/conf-available/charset.conf
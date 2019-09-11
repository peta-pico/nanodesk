FROM php:7.2.1-apache
MAINTAINER Timo Lek
RUN docker-php-ext-install pdo_mysql

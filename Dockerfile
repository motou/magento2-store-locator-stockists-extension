FROM quay.io/continuouspipe/magento2-nginx-php7:stable

RUN apt-get update -qq -y \
 && DEBIAN_FRONTEND=noninteractive apt-get -qq -y --no-install-recommends install \
    bzip2 \
    php-imagick \
 \
 # Clean the image \
 && apt-get auto-remove -qq -y \
 && apt-get clean \
 && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# Add the application
COPY . /app
WORKDIR /app

COPY tools/docker/usr/ /usr/

# Install dependencies
ARG GITHUB_TOKEN=
ARG MAGENTO_USERNAME=
ARG MAGENTO_PASSWORD=
RUN container build
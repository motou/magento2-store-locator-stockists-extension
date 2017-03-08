#!/bin/bash

if [ "$FORCE_DATABASE_DROP" == 'true' ]; then
  echo 'Dropping the Magento DB if exists'
  mysql -h"$DATABASE_HOST" -uroot -p"$DATABASE_ROOT_PASSWORD" -e "DROP DATABASE IF EXISTS $DATABASE_NAME" || exit 1
fi

set +e
mysql -h"$DATABASE_HOST" -u"$DATABASE_USER" -p"$DATABASE_PASSWORD" "$DATABASE_NAME" -e "SHOW TABLES; SELECT FOUND_ROWS() > 0;" | grep -q 1
DATABASE_EXISTS=$?
set -e

if [ "$DATABASE_EXISTS" -ne 0 ]; then
  echo 'Create Magento database'
  echo "CREATE DATABASE IF NOT EXISTS $DATABASE_NAME ; GRANT ALL ON $DATABASE_NAME.* TO $DATABASE_USER@'%' IDENTIFIED BY '$DATABASE_PASSWORD' ; FLUSH PRIVILEGES" |  mysql -uroot -p"$DATABASE_ROOT_PASSWORD" -h"$DATABASE_HOST"

  echo 'Install Magento 2 Database'

  chmod +x bin/magento
  bin/magento setup:install --base-url=http://$PUBLIC_ADDRESS/ \
  --db-host=$DATABASE_HOST \
  --db-name=$DATABASE_NAME \
  --db-user=$DATABASE_USER \
  --db-password=$DATABASE_PASSWORD \
  --admin-firstname=Admin \
  --admin-lastname=Demo \
  --admin-email=admin@admin.com \
  --admin-user=admin \
  --admin-password=admin123 \
  --language=en_GB \
  --currency=GBP \
  --timezone=Europe/London \
  --use-rewrites=1 \
  --session-save=db
fi

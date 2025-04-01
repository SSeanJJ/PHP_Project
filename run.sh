#!/bin/zsh

DB_EXISTS=$(mysql -u root -p'Root' -e "SHOW DATABASES LIKE 'CMSC_4003';" | grep CMSC_4003)

if [ -z "$DB_EXISTS" ]; then
  echo "Database not found. Creating..."
  mysql -u root -p'Root' < sql/createdb.sql
  mysql -u root -p'Root' < sql/schema.sql
  echo "Done."
else
  echo "Database already exists."
fi

mysql -u root -p'Root' < sql/seed.sql

php -S localhost:8000 -t public

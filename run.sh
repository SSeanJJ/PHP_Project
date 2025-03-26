#!/bin/zsh

DB_EXISTS=$(mysql -u root -e "SHOW DATABASES LIKE 'CMS_4003';" | grep CMS_4003)

if [ -z "$DB_EXISTS" ]; then
  echo "Database not found. Creating..."
  mysql -u root < sql/createdb.sql
  mysql -u root < sql/schema.sql
  echo "Done."
else
  echo "Database already exists."
fi

php -S localhost:8000 -t public

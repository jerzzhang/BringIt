#!/bin/bash
UP=$(pgrep mysql | wc -l);
if [ "$UP" -ne 0 ];
then
    filename="/Users/cam/Github/orderMenu/sql_backups/$(date +%Y-%m-%d\ \@\ %H\:%M\:%S).sql"
    /usr/local/mysql-5.6.17-osx10.7-x86/bin/mysqldump ordermenu --user=root --password=ordermenu --port=8889 -h 127.0.0.1 > "$filename"
    git add "$filename"
    git commit -m "Automatic Commit for SQL backup: $filename"
    git push
    echo "Backed up to file: $filename!"
else
    echo "MySQL is not running"
fi
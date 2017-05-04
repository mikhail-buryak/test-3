#!/bin/bash

service supervisor restart &&
supervisorctl reread &&
supervisorctl update &&
supervisorctl start laravel-worker:* &&
/usr/sbin/service php5-fpm start &&
/usr/sbin/service nginx start

server {
        server_name	ekibizz.com	www.ekibizz.com;

        listen  80;

        access_log   /var/log/nginx/ekibizz/live-access.log;
        error_log  /var/log/nginx/ekibizz/live-error.log;

        client_max_body_size 100M;

        location / {
                fastcgi_param REMOTE_ADDR $http_x_real_ip;
                proxy_set_header X-Real-IP  $remote_addr;
                proxy_set_header X-Forwarded-For $remote_addr;
                proxy_set_header Host $host;
                proxy_pass http://127.0.0.1:6969;
        }
}



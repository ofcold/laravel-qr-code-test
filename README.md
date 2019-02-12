<p align="center">
    Ofcold QR Code
</p>


## Introduction
```bash
git clone https://github.com/ofcold/laravel-qr-code-test
```

## Configuration

### Hosts
```bash

echo qr.dev >> /etc/hosts

```

### Nginx
`qr.dev.conf`

```base
server {
    listen  80;
    server_name  qr.dev www.qr.dev;
    charset  utf-8;
    root  /sites/rep/laravel-qr-code-test/public;

    gzip on;
    gzip_static on;
    gzip_http_version 1.0;
    gzip_disable "MSIE [1-6].";
    gzip_vary on;
    gzip_comp_level 9;
    gzip_proxied any;
    gzip_types text/plain text/css application/x-javascript text/xml application/xml application/xml+rss text/javascript application/javascript image/svg+xml;

    fastcgi_intercept_errors off;
    fastcgi_buffers 8 16k;
    fastcgi_buffer_size 32k;
    fastcgi_read_timeout 180;

    # Remove trailing slashes
    rewrite ^/(.*)/$ /$1 permanent;

    access_log  /sites/ofcold/servers/logs/pcf.access.log;
    error_log  /sites/ofcold/servers/logs/pcf.error.log;

    location / {
        try_files $uri $uri/ /index.php?$args;
        index  index.php;
        autoindex   on;
        include  /usr/local/etc/nginx/php-fpm;
    }

    location ~ /\.ht {
        access_log off;
        log_not_found off;
        deny all;
    }

    location ~* \.ico$ {
        expires 1w;
        access_log off;
    }

    location ~* \.(?:jpg|jpeg|gif|png|ico|gz|svg|svgz|ttf|otf|woff|eot|mp4|ogg|ogv|webm)$ {
        try_files $uri $uri/ /index.php?$query_string;

        access_log off;
        log_not_found off;
    }

    location ~* \.(?:css|js)$ {
        try_files $uri $uri/ /index.php?$query_string;
        access_log off;
        log_not_found off;
    }

    client_max_body_size 512M;

    add_header "X-UA-Compatible" "IE=Edge,chrome=1";
}

```

## Example
http://qr.dev/qrcode?content=18898726543&data_type=phone_number&color=0064db&size=200&bg_color=ffffff&format=png&logo=http://toocold.org/favicon.png&module=roundness

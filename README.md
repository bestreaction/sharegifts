    location / {
        try_files $uri $uri/ @rewrites;
    }

    location @rewrites {
            rewrite ^/?([a-zA-Z\-]*)/?([a-zA-Z0-9\-]*)?/?([a-zA-Z0-9\-]*)?/?$ /index.php?controller=$1&action=$2&id=$3 last;
    }

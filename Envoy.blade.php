@servers(['web' => 'root@47.241.67.141'])


@task('deploy')
    if [ ! -d /data/source ]; then
        sudo mkdir -p /data/source
    fi

    if [ -d /data/source/mucts ]; then
        rm -rf /data/source/mucts
    fi

    cd /data/source
    git clone git@github.com:mucts/mucts.git mucts
    cd mucts
    git fetch --all
    git reset --hard origin/master
    sudo ln -nsvf .env.production .env
    composer install
    sudo chown -R www:www storage bootstrap/cache

    if [ ! -d /data/file ]; then
        sudo mkdir -p /data/file/image /data/file/video /data/file/music
        sudo chown -R www:www /data/file
    fi
    if [ ! -d /data/logs/storage ]; then
        sudo mkdir -p /data/logs/storage/logs /data/logs/storage/app/public /data/logs/storage/framework/cache /data/logs/storage/framework/sessions /data/logs/storage/framework/views /data/logs/storage/framework/testing
        sudo ln -s /data/file /data/logs/storage/app/file
        sudo chown -R www:www /data/logs/storage
    fi

    sudo rm -rf storage
    sudo rm -rf /data/www/www.mucts.com
    sudo mv /data/source/mucts /data/www/www.mucts.com
    sudo ln -s /data/logs/storage /data/www/www.mucts.com/storage
    cd /data/www/www.mucts.com
    php artisan route:clear
    php artisan config:clear
    php artisan view:clear
    php artisan migrate --force
    php artisan swoole:http restart &
    echo 'deploy success'
@endtask

@task('nginx')
    if [ ! -d /data/source ]; then
        sudo mkdir -p /data/source
    fi

    if [ -d /data/source/nginx ]; then
        rm -rf /data/source/nginx
    fi

    cd /data/source
    git clone git@github.com:mucts/nginx.git nginx
    cd nginx
    mv -f nginx.conf /data/server/nginx/conf/nginx.conf
    mkdir /data/server/nginx/conf/vhosts/
    mv -f vhosts/* /data/server/nginx/conf/vhosts/
    mkdir /data/cert/
    mv -f cert/* /data/cert/
    rm -rf /data/source/nginx
    cd ~
    service nginx reload
    echo 'nginx success'
@endtask

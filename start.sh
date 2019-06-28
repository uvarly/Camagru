docker run --name camagru_ftp -d -v camagru_img:/home/vsftpd -p 20:20 -p 21:21 -p 47400-47470:47400-47470 -e FTP_USER="root" -e FTP_PASS="root" -e PASV_ADDRESS="192.168.99.100" bogem/ftp
docker run --name camagru_mysql -d -v camagru_db:/var/lib/mysql --restart on-failure:5 -e MYSQL_ROOT_PASSWORD=root -e MYSQL_DATABASE=camagru_db mysql:5 --default-authentication-plugin=mysql_native_password
docker run --name camagru_xdebug -v ~/42/Camagru:/var/www/html -p 8080:80 -d tommylau/xdebug
docker run --name camagru_phpmyadmin -d --link camagru_mysql:db -p 8081:80 phpmyadmin/phpmyadmin
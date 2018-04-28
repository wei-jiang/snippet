Increase file upload size limit in PHP-Nginx
If Nginx aborts your connection when uploading large files, you will see something like below in Nginx’s error logs:

[error] 25556#0: *52 client intended to send too large body:

This means, you need to increase PHP file-upload size limit. Following steps given below will help you troubleshoot this!

Changes in php.ini

To change max file upload size to 100MB

Edit…

vim /etc/php5/fpm/php.ini
Set…

upload_max_filesize = 100M
post_max_size = 100M
Notes:

Technically,  post_max_size should always be larger than upload_max_filesize but for large numbers like 100M you can safely make them equal.
There is another variable max_input_time which can limit upload size but I have never seen it creating any issue. If your application supports uploads of file-size in GBs, you may need to adjust it accordingly. I am using PHP-FPM behind Nginx from very long time and I think in such kind of setup, its Nginx to which a client uploads file and then Nginx copies it to PHP. As Nginx to PHP copying will be local operation max_input_time may never create issue. I also believe Nginx may not copy the file but merely hand-over the location of file or descriptor records to PHP!
You may like to read these posts which explains PHP file upload related config in some details.
Change in Nginx config

Add following line to http{..} block in nginx config:

http {
	#...
        client_max_body_size 100m;
	#...
}
Note: For very large files, you may need to change value of client_body_timeout parameter. Default is 60s.

Reload PHP-FPM & Nginx

service php5-fpm reload
service nginx reload
Changes in WordPress-Multisite

If you are running WordPress Multisite setup, then you may need to make one more change at the WordPress end.

Go to: Network Admin Dashboard >> Settings. Look for Upload Settings

Also change value for Max upload file size



More…

You may need to change PHP max execution time limit also.

More optimization tips for WordPress-Nginx setup
php -i | grep 'php.ini'
or
find / -name php.ini
or
php --ini
or
php -r "phpinfo();" | grep php.ini

#include <iostream>
using namespace std;
int main()
{
	cout<<"Hello world from c++"<<endl;
	return 0;
}
	
swig -c++ -php t.i	
g++ `php-config --includes` -fpic -c t_wrap.cpp t.cpp
g++ -shared example_wrap.o -o t.so
php -m | grep pthreads
http://eddmann.com/posts/compiling-php-5-5-with-zts-and-pthreads-support/
https://github.com/zyzo/meteor-ddp-php
http://ask.xmodulo.com/check-glibc-version-linux.html

openssl pkcs12 -in file.p12 -out file.key.pem -nocerts -nodes
openssl pkcs12 -in file.p12 -out file.crt.pem -clcerts -nokeys
Will create key/cert pair in current directory.

Now, to use it:

curl_setopt($ch, CURLOPT_SSLCERT, 'file.crt.pem');
curl_setopt($ch, CURLOPT_SSLKEY, 'file.key.pem');
curl_setopt($ch, CURLOPT_SSLCERTPASSWD, 'pass');
curl_setopt($ch, CURLOPT_SSLKEYPASSWD, 'pass');
Where pass is the password from .p12 file.
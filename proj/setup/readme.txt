##Stefan Manning dq010612 
Install XAMPP or simliar program
add the folowing to httpd.conf
<Directory />
    Options Indexes FollowSymLinks Includes ExecCGI
    AllowOverride All
    Order deny,allow
    Allow from all
    #AllowOverride none
    #Require all denied
</Directory>

uncomment LoadModule rewrite_module modules/mod_rewrite.so

add the folowing to httpd-vhost.conf
<VirtualHost *:80>
	ServerName api.soa.co.uk
#location of website	
	DocumentRoot "{dir}\api.soa.co.uk"	
#ablity to access all files 	
<Directory {dir}\api.soa.co.uk>
	Options Indexes FollowSymLinks Includes ExecCGI
	Order allow,deny
    Allow from all
	AllowOverride all
</Directory>
	 AccessFileName     .htaccess
</VirtualHost>

<VirtualHost *:80>
	ServerName web.co.uk		
	DocumentRoot "{dir}\proj"	
</VirtualHost>

add the folowing to host file
	127.0.0.1 api.soa.co.uk
	127.0.0.1 web.co.uk

set up a database called test and run structure.sql
then run testdata.sql
navigate to api.soa.co.uk/vendor/bin 
run propel init in the command prompt and follow instructions

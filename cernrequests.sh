#! /bin/bash -x

sudo mysql -u root -p
#code inside mysql
CREATE DATABASE CERNrequests;
USE CERNrequests;

CREATE TABLE nodes(
Name VARCHAR(20) not null,
Number_of_CPU  INT unsigned not null,
Available_CPU INT unsigned not null,
Memory_size FLOAT unsigned not null,
Available_memory FLOAT unsigned not null
);

INSERT INTO nodes VALUES('agate',16,14,118,110);
INSERT INTO nodes VALUES('coral',16,15,58,52);
INSERT INTO nodes VALUES('diamond',24,22,116,106);
INSERT INTO nodes VALUES('jade',32,30,236,220);


CREATE TABLE requests(
ID INT UNSIGNED not null,
allocated_node_name VARCHAR(20) not null,
start_time DATETIME not null,
CPU_required INT unsigned not null,
Memory_required FLOAT not null,
time_required_for_completion INT unsigned not null
);
#exit out of mysql
exit;

sudo su
arr={"loadbalancer" "agate" "coral" "diamond" "jade"}
host=1000;


for((i=0;i<${#arr[@]};i++))
do
	mkdir -p /var/www/${arr[$i]}.com/public_html
    chown -R $USER:$USER /var/www/${arr[$i]}.com/public_html
    chmod -R 755 /var/www/${arr[$i]}.com/public_html
    if [ $i -eq 0 ]
    then
    	    gedit /var/www/loadbalancer.com/public_html/index.html
            #code inside for index.html
            gedit /var/www/loadbalancer.com/public_html/loadbalancer.php
            #code inside for loadbalancer.php
    else
    	    gedit /var/www/${arr[$i]}.com/public_html/index.php
            #code inside for index.php from ${arr[$i]}.php
    fi
    cd /etc/apache2/sites-available
    cp 000-default.conf  ${arr[$i]}.com.conf   #inside /etc/apache2/sites-available

    echo "<VirtualHost *:${host}> 
    ServerAdmin info@${arr[$i]}.com
    ServerName ${arr[$i]}.com
    ServerAlias www.${arr[$i]}.com  #website in internet
    DocumentRoot /var/www/${arr[$i]}.com/public_html
    ErrorLog ${APACHE_LOG_DIR}/error.log
    CustomLog ${APACHE_LOG_DIR}/access.log combined
    </VirtualHost>" >${arr[$i]}.com.conf

    a2ensite ${arr[$i]}.com.conf

    nano /etc/hosts
    #adding ip address and website name
    host=$((host+1))
done

service apache2 restart

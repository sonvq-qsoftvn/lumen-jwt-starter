FROM centos:7

# Install Apache
RUN yum -y update
RUN yum -y install httpd \
    nano \
    vim 

# Install PHP 7
RUN cd ~
RUN curl 'https://setup.ius.io/' -o setup-ius.sh    
RUN bash setup-ius.sh
RUN yum -y install mod_php70u php70u-cli php70u-common php70u-devel php70u-fpm php70u-json php70u-mbstring php70u-mysqlnd php70u-pdo php70u-pear php70u-process php70u-xml

# Install firewall
#RUN yum -y install firewalld

EXPOSE 80 443

# Simple startup script to avoid some issues observed with container restart 
ADD run-httpd.sh /run-httpd.sh
RUN chmod -v +x /run-httpd.sh

CMD ["/run-httpd.sh"]
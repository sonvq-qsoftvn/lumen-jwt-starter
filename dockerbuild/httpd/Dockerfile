# Import base image
FROM centos:7

# Enable systemd for centos 7
MAINTAINER "sonvq" <vuquangson1610@gmail.com>
ENV container docker
RUN (cd /lib/systemd/system/sysinit.target.wants/; for i in *; do [ $i == systemd-tmpfiles-setup.service ] || rm -f $i; done); \
    rm -f /lib/systemd/system/multi-user.target.wants/*;\
    rm -f /etc/systemd/system/*.wants/*;\
    rm -f /lib/systemd/system/local-fs.target.wants/*; \
    rm -f /lib/systemd/system/sockets.target.wants/*udev*; \
    rm -f /lib/systemd/system/sockets.target.wants/*initctl*; \
    rm -f /lib/systemd/system/basic.target.wants/*;\
    rm -f /lib/systemd/system/anaconda.target.wants/*;
VOLUME [ "/sys/fs/cgroup" ]

# Install Apache
RUN yum -y update
RUN yum -y install httpd
RUN yum -y install nano
RUN yum -y install vim


RUN yum clean all
# Enable httpd on reboot
RUN systemctl enable httpd.service

# Install PHP 7
RUN cd ~
RUN curl 'https://setup.ius.io/' -o setup-ius.sh    
RUN bash setup-ius.sh
RUN yum -y install mod_php70u php70u-cli php70u-common php70u-devel php70u-fpm php70u-json php70u-mbstring php70u-mysqlnd php70u-pdo php70u-pear php70u-process php70u-xml

# Install firewall
#RUN yum -y install firewalld

EXPOSE 80 443

# Install Cassandra PHP-driver
RUN yum -y install automake cmake gcc gcc-c++ git libtool openssl-devel wget gmp gmp-devel boost pcre-devel

RUN wget http://downloads.datastax.com/cpp-driver/centos/7/dependencies/libuv/v1.8.0/libuv-1.8.0-1.el7.centos.x86_64.rpm
RUN wget http://downloads.datastax.com/cpp-driver/centos/7/dependencies/libuv/v1.8.0/libuv-debuginfo-1.8.0-1.el7.centos.x86_64.rpm
RUN wget http://downloads.datastax.com/cpp-driver/centos/7/dependencies/libuv/v1.8.0/libuv-devel-1.8.0-1.el7.centos.x86_64.rpm

# Simple startup script to avoid some issues observed with container restart 
ADD run-httpd.sh /run-httpd.sh
RUN chmod -v +x /run-httpd.sh

CMD ["/run-httpd.sh"]
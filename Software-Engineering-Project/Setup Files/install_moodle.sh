#!/bin/bash

# Update System
echo "Updating openSUSE system..."
sudo zypper update -y

# Install Apache
echo "Installing Apache Web Server..."
sudo zypper install -y apache2
sudo systemctl enable apache2
sudo systemctl start apache2

# Firewall for Apache
sudo firewall-cmd --add-service=http --permanent
sudo firewall-cmd --reload

# Install MariaDB
echo "Installing MariaDB..."
sudo zypper install -y mariadb mariadb-tools
sudo systemctl enable mysql
sudo systemctl start mysql

# Secure MariaDB Installation
echo "Securing MariaDB installation..."
sudo mysql_secure_installation

# Install PHP and Extensions
echo "Installing PHP and necessary extensions..."
sudo zypper install -y php81 php81-mysql apache2-mod_php81
sudo zypper install -y php81-gd php81-intl php81-xmlrpc php81-soap php81-xml php81-mbstring php81-json php81-zip
sudo systemctl restart apache2

# Download Moodle
echo "Downloading Moodle..."
cd /srv/www/htdocs
sudo git clone git://git.moodle.org/moodle.git
cd moodle
sudo git branch -a
sudo git branch --track MOODLE_400_STABLE origin/MOODLE_400_STABLE
sudo git checkout MOODLE_400_STABLE

# Create Moodle Data Directory
echo "Creating Moodle data directory..."
sudo mkdir /srv/moodledata
sudo chown -R wwwrun /srv/moodledata
sudo chmod -R 777 /srv/moodledata

# Set Up Database for Moodle
echo "Setting up MariaDB database for Moodle..."
read -p "Enter database name for Moodle: " dbname
read -p "Enter Moodle database username: " dbuser
read -sp "Enter Moodle database password: " dbpass
echo
sudo mysql -u root -p -e "CREATE DATABASE $dbname CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
sudo mysql -u root -p -e "CREATE USER '$dbuser'@'localhost' IDENTIFIED BY '$dbpass';"
sudo mysql -u root -p -e "GRANT ALL PRIVILEGES ON $dbname.* TO '$dbuser'@'localhost';"
sudo mysql -u root -p -e "FLUSH PRIVILEGES;"

# Configure Apache to Serve Moodle
echo "Configuring Apache to serve Moodle..."
sudo tee /etc/apache2/conf.d/moodle.conf > /dev/null <<EOT
DocumentRoot "/srv/www/htdocs/moodle"
<Directory "/srv/www/htdocs/moodle">
    Options Indexes FollowSymLinks
    AllowOverride All
    Require all granted
</Directory>
EOT
sudo systemctl restart apache2

echo "Moodle installation script has completed."
echo "Proceed to your browser to complete the Moodle installation through the web interface."
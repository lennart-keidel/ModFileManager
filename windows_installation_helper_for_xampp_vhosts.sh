path_xampp_root_directory="/c/xampp"
path_start_xampp_executeable="$path_xampp_root_directory/xampp_start.exe"
path_stop_xampp_executeable="$path_xampp_root_directory/xampp_stop.exe"
path_xampp_vhosts_file="$path_xampp_root_directory/apache/conf/extra/httpd-vhosts.conf"
path_windows_hosts_file="/c/Windows/System32/drivers/etc/hosts"
path_app_installation_directory="C:/Program Files/Sims 3 Tools/Mod Dateinamen Manager"

custom_localhost_domain='mod-dateinamenmanager.local'
xampp_vhosts_file_addition='
<VirtualHost '$custom_localhost_domain':80>
    DocumentRoot "'$path_app_installation_directory'"
    ServerName externalapp.local
    <Directory "'$path_app_installation_directory'">
        Require all granted
    </Directory>
</VirtualHost>
'

# error if xampp root directory not existing
if ! [ -f $path_start_xampp_executeable ]; then
  echo -e "FEHLER: XAMPP ist nicht installiert oder konnte nicht gefunden werden."
  echo -e "Fehlender Pfad: $path_xampp_root_directory"
fi

# edit xampp vhosts file
# add custom vhost if not existing already
echo -e "\n\rPasse Xampp-Config an für neuen Host-Ordner"
grep -q "$custom_localhost_domain" "$path_xampp_vhosts_file" ||
  echo "$xampp_vhosts_file_addition" >> "$path_xampp_vhosts_file"
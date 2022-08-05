path_xampp_root_directory="/c/xampp"
path_start_xampp_executeable="$path_xampp_root_directory/xampp_start.exe"
path_stop_xampp_executeable="$path_xampp_root_directory/xampp_stop.exe"
custom_localhost_domain='mod-dateinamenmanager.local'

# error if xampp root directory not existing
if ! [ -f $path_start_xampp_executeable ]; then
  echo -e "FEHLER: XAMPP ist nicht installiert oder konnte nicht gefunden werden."
  echo -e "Fehlender Pfad: $path_xampp_root_directory"
fi

# start xampp
$path_start_xampp_executeable

# open web page with app
start "http://$custom_localhost_domain"
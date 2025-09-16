# variables
custom_localhost_domain='mod-dateinamenmanager.local'

# open web page with app
start "http://$custom_localhost_domain"

# start php internal webserver
php -S $custom_localhost_domain:80

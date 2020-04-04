# Racing-Manager
Source Code of my Formula 1 racing manager game. If you want to get additional information about this game visit my website: https://racing-manager.com. There you can test the game.

## Installation

To run this game you need a webserver. Copy the files to the webroot. Create a new database.

* import sql/racing_manager_leere_datenbank.sql into newly created database
* edit config/config.inc.php and set database connection params (username, password, database name)
* cache and templates_c needs write permission
* content needs recursive write permission
* create a new cronjob that runs cron.php every 30 minutes
* replace lib/replace_me_with_smarty with current version of smarty framework (https://www.smarty.net/download)
* replace lib/replace_me_with_securimage with current version of secureimage (https://www.phpcaptcha.org/download)

## License

The game uses an old version of Metronic theme. I have a license to run this theme. If you also want to run it public, get a licence! (https://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?_ga=2.186343841.962310628.1586001330-470635343.1585382770)

## Optional

The game should run now. To create your own manager profile avatar image, you need to get svg-avatars and copy it into lib folder (https://codecanyon.net/item/svg-avatars-generator-jquery-integrated-script/6498300?_ga=2.114072133.359795139.1585995459-470635343.1585382770)

## Help

This source package was tested on a virtual Debian 10 LAMP server as described here (https://technology-blog.net/lamp-server-mit-debian-10-und-virtual-box-tutorial/). It addionally needs following PHP modules installed:

* php-xml
* php-curl

If something does not work, you can turn on debug mode for PHP, DB and Smarty in bootstrap.php
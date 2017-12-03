This folder contains everything need for rapid Wordpress theme and plugin development.

This theme was built with the amazing open sourced projects: 
[Components Theme by Automattic](https://themeshaper.com/2016/02/09/introducing-components)
[Redux Framework by Redux Framework](https://reduxframework.com/)
[TGM Plugin Activation by TGM] (http://tgmpluginactivation.com/)
[Materialize CSS framework by Materialize](http://materializecss.com/)

## The Theme

This theme contains pretty much everything to get off the ground running. With tons of easy to use customizers and a built in nav menu, the only thing this theme is truly missing is a carousel slider, a minifying and caching plugin, and possibly visual studio code; mega menu may not be a bad choice either.

TGM will ask to install Contact Form 7, MailChimp for WordPress, ACF RGBA Color Picker, Favicon Generator, One Click Demo Import, and the theme's extensions plugin (Redux).

## How To Start
* requires Docker, Docker Compose, and MySQL.

For quick development, run the `./start.sh` script. It will download the latest wordpress version, and create a docker container for Wordpress, Mysql (MariahDB), and PHPMYADMIN.
* it will ask for admin permissions, as it writes to the hosts file.

If you're running on mac or linux, the site will be available at `wordpress.dev`, and phpmyadmin at `wordpress.dev:8181`.

If you're on windows, an IP address will be echoed out at the end, showing the address for the site and phpmyadmin.

To log into PHPMYADMIN, use the username 'root', and the password specified in the docker-compose.yml -- default: "ChangeMeIfYouWant"

## License:
    Everything within this folder (wordpress) is released under GPLv3.
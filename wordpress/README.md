# Wordpress

This folder contains everything need for rapid theme and plugin development.

This theme was built with the amazing open sourced projects: 

[Components Theme by Automattic](https://themeshaper.com/2016/02/09/introducing-components)

[Redux Framework by Redux Framework](https://reduxframework.com/)

[TGM Plugin Activation by TGM](http://tgmpluginactivation.com/)

[Materialize CSS framework by Materialize](http://materializecss.com/)

## The Theme

This theme contains pretty much everything to get off the ground running. With tons of easy to use customizers and a built in mobile nav menu, the only thing this theme is truly missing is a carousel slider, a minifying and caching plugin, and possibly visual studio code; mega menu may not be a bad choice either.

TGM will ask to install Contact Form 7, MailChimp for WordPress, ACF RGBA Color Picker, Favicon Generator, One Click Demo Import, iThemes Security, and the theme's extensions plugin (Redux).

## How To Start
*Requires Docker, Docker Compose, and MySQL.*

For quick development, run the `./start.sh` script. It will download the latest wordpress version, and create a docker container for Wordpress, MySQL (MariahDB), and PHPMYADMIN.
- it will ask for admin permissions, as it writes to the hosts file. This can be disabled by passing in a false parameter - `./start.sh false`

**Mac and Linux:** the site will be available at `wordpress.dev`, and phpmyadmin at `wordpress.dev:8181`. If the false parameter was passed in, read the Windows section below.

**Windows:** an IP address will be echoed out at the end, showing the address for the site and phpmyadmin.

**PHPMYADMIN:** To log into PHPMYADMIN, use the username `root`, and the password specified within the docker-compose.yml -- default: `ChangeMeIfYouWant`

**PROBLEMS CONNECTING TO IP/DOCKER:**
    If problems arise after running `./start.sh`, run the `./stop.sh` and then open the docker client/gui and hit the restart button. Then go to "How To Start Docker.txt" and follow from 1.3 down. (This won't write to the hosts file)

## Creating A New Theme

Run the `./new.sh` script, and an input will appear asking for a new theme name. After that, a description input will appear. This input is not mandatory and can be skipped. The site url, theme url, license, etc. will remain the same, so it's best to change those manually in the theme's style.css, and the theme extensions plugin style.css.

## Changing A Theme Name

Run the `./rename.sh` script, and an input will appear asking for the old theme name, as well as the for the new theme name. The site url, theme url, license, etc. will remain the same, so it's best to change those manually in the theme's style.css, and the theme extensions plugin style.css.


## License:
    Everything within this folder (wordpress) is released under GPLv3. See license for more details.
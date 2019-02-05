# XRF Core, Account, and Administration

XRF, which was backronymed into standing for Xtensible Resource Framework, is a PHP web application framework intended to support a variety of relatively dissimilar websites under a common format. XRF Core contains common files that will be necessary for any XRF-based website, such as the global files, common function files, login and logout pages, as well as the user and admin panels.

## Expected Configuration

The intended design is for the account and admin panels to run on a given subdomain, such as `account.example.com` or `admin.example.com`, and then for websites to exist on other subdomains which are primarily built out of code from modules, which shares the same login session.

Each module may contain code which is intended to be placed on the root of the subdomain of a given XRF site, as well as a module folder which needs to be placed within the `/modules` folder of the XRF Core to add user and admin panels which interact with that module. Each module also includes an SQL script with the database tables needed for the module's code to function.

## System Requirements

* PHP 5.6 or better
* MySQL

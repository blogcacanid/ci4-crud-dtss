# ci4-crud-dtss
CRUD DataTables CodeIgniter 4 - Server Side

> https://cacan.id/crud-datatables-codeigniter-4-server-side

![000](https://user-images.githubusercontent.com/51890752/93695085-245ef080-fb3d-11ea-8ce4-892320cf0414.jpg)

# Cara Penggunaan:

## Clone dari GitHub:
    - Dari Document_Root Web Server Clone menggunakan perintah berikut:
    - git clone https://github.com/blogcacanid/ci4-crud-dtss.git

# Testing
Jalankan CodeIgniter 4 dengan menggunakan perintah berikut:
php spark serve

Kemudian buka browser dan ketikkan URL http://localhost:8080/pegawai

## List Data

![001](https://user-images.githubusercontent.com/51890752/93695088-2fb21c00-fb3d-11ea-81a4-9d209b579a5c.jpg)

## Add Record

![002](https://user-images.githubusercontent.com/51890752/93695092-393b8400-fb3d-11ea-9d0b-fcdf8f51ed66.jpg)

## View Record

![003](https://user-images.githubusercontent.com/51890752/93695102-4193bf00-fb3d-11ea-804a-f590b83f3777.jpg)

## Edit Record

![004](https://user-images.githubusercontent.com/51890752/93695107-4bb5bd80-fb3d-11ea-8315-e939cc86dced.jpg)

## Delete Record

![005](https://user-images.githubusercontent.com/51890752/93695113-540df880-fb3d-11ea-9961-bcd065b267e0.jpg)


# CodeIgniter 4 Framework

## What is CodeIgniter?

CodeIgniter is a PHP full-stack web framework that is light, fast, flexible, and secure. 
More information can be found at the [official site](http://codeigniter.com).

This repository holds the distributable version of the framework,
including the user guide. It has been built from the 
[development repository](https://github.com/codeigniter4/CodeIgniter4).

More information about the plans for version 4 can be found in [the announcement](http://forum.codeigniter.com/thread-62615.html) on the forums.

The user guide corresponding to this version of the framework can be found
[here](https://codeigniter4.github.io/userguide/). 


## Important Change with index.php

`index.php` is no longer in the root of the project! It has been moved inside the *public* folder,
for better security and separation of components.

This means that you should configure your web server to "point" to your project's *public* folder, and
not to the project root. A better practice would be to configure a virtual host to point there. A poor practice would be to point your web server to the project root and expect to enter *public/...*, as the rest of your logic and the
framework are exposed.

**Please** read the user guide for a better explanation of how CI4 works!
The user guide updating and deployment is a bit awkward at the moment, but we are working on it!

## Repository Management

We use Github issues, in our main repository, to track **BUGS** and to track approved **DEVELOPMENT** work packages.
We use our [forum](http://forum.codeigniter.com) to provide SUPPORT and to discuss
FEATURE REQUESTS.

This repository is a "distribution" one, built by our release preparation script. 
Problems with it can be raised on our forum, or as issues in the main repository.

## Contributing

We welcome contributions from the community.

Please read the [*Contributing to CodeIgniter*](https://github.com/codeigniter4/CodeIgniter4/blob/develop/contributing.md) section in the development repository.

## Server Requirements

PHP version 7.2 or higher is required, with the following extensions installed: 

- [intl](http://php.net/manual/en/intl.requirements.php)
- [libcurl](http://php.net/manual/en/curl.requirements.php) if you plan to use the HTTP\CURLRequest library

Additionally, make sure that the following extensions are enabled in your PHP:

- json (enabled by default - don't turn it off)
- [mbstring](http://php.net/manual/en/mbstring.installation.php)
- [mysqlnd](http://php.net/manual/en/mysqlnd.install.php)
- xml (enabled by default - don't turn it off)



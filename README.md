## proxy_mvc

An approximate MVC functioning web page based on the Bootstrap theme. Simple and (mostly) complete codebase for hosting PHP based web applications on AWS or DigitalOcean resources. This is the demo web codebase to accompany the `proxy_src` project.

### Usage

Ubuntu 16.04 LAMP

This code base embodies a PHP first structure, with HTML acting as general template for PHP to insert partial HTML code into templates partitioned by Main (<html>, <head> tags), Body (whats inside <body>), then the Footer and ubiquitious Navbar. Most of the development for sites construced from this code base will be written in PHP with objects generating Bootstrap elements.

Given that a web server such as apache2 has access to /var/www/html/ and down stream, nothing upstream is exposable (in theory). Therefor, if the server diplays and grants access to the directory structure without envoking the PHP engine, not much is exposed. The controller here is index.php, as it handles redirection, authentication and roles as you have defined them. The model is contained in /var/www/src, where layouts allow for HTML abstraction from PHP, and pages contain the web content. Additional model elements can be found in io, which call custom objects for other data structues like SQL or JSON or CSV files.

```
# apache2 source directory
/var/www/html
# where www -> path-to-project
           .
           ├── composer.json
           ├── dat                             (csv data sources)
           ├── html
           │   ├── ajax
           │   ├── content                     (markdown files, ..)
           │   ├── css                         (bootstrap)
           │   ├── fonts
           │   ├── index.php                   Controller => src/Controller.php
           │   ├── js                          (bootstrap)
           │   └── media                       (images, ..)
           ├── ini                             (site config, sql credentials)
           │   ├── config.ini
           ├── log
           └── src
               ├── autoload
               ├── config
               ├── Controller.php
               ├── layouts                     (your site's html layout)
               │   ├── Admin
               │   ├── Default
               │   └── User
               ├── models
               │   ├── graphs
               │   ├── html
               │   ├── sql
               │   └── user
               └── pages                       (your site's pages)
                   ├── Admin
                   ├── Public
                   │   ├── Default.php
                   │   ├── Nav
                   │   │   ├── About.php
                   │   │   ├── Graphs
                   │   │   │   ├── Aggregates
                   │   │   │   │   ├── Bar.php
                   │   │   │   │   ├── Boxplot.php
                   │   │   │   │   └── Pie.php
                   │   │   │   ├── PointsLines
                   │   │   │   │   ├── Area.php
                   │   │   │   │   ├── Bubble.php
                   │   │   │   │   ├── Line.php
                   │   │   │   │   ├── PointLine.php
                   │   │   │   │   └── Scatter.php
                   │   │   │   └── Stats
                   │   │   │       ├── Density.php
                   │   │   │       ├── Histogram.php
                   │   │   │       ├── Regression.php
                   │   │   │       └── Smooth.php
                   │   │   └── Login.php
                   │   └── UserAccept.php
                   └── User
                       └── Nav
                           └── Logout.php

```

API Throttling System
This is a basic API throttling system implemented using PHP. The system throttles requests from a REFERRER when the number of requests exceeds a configurable threshold.

Features
Tracks the number of requests per second from each REFERRER.
Uses a MySQL database to store the request rate limit data.
Configurable request rate threshold.
Returns 429 Too Many Requests error if the request rate exceeds the threshold.

Requirements
PHP 7.0 or higher
MySQL database

Installation
Clone the repository or download the source code as a ZIP file.
Create a MySQL database and import the rate_limit.sql file located in the sql folder.
Update the database configuration in the database.php file located in the lib folder.
Upload the files to your web server.

Usage
To use the API throttling system

Postman
run http://localhost/api_throttling/ with Header Referer => http://localhost/api_throttling/

php
// set the maximum number of requests per second for each referrer
$throttle_limit = 10;

// get the HTTP referer
$referer = $_SERVER['HTTP_REFERER'];

// check the request rate for the referrer
loadThrottleData($throttle_limit);

// serve the requested resource
echo "Hello, World!";

The loadThrottleData() function will check the request rate for the given referrer and throttle requests that exceed the threshold. 
The trackThrottleData() function will track the number of requests per second from each referrer and update the rate limit data in the database.

Configuration
The following configuration options are available in the db.php file:

DB_HOST: The hostname of the MySQL server.
DB_USERNAME: The username to connect to the MySQL server.
DB_PASSWORD: The password to connect to the MySQL server.
DB_DATABASE: The name of the MySQL database.

License
This project is licensed under the MIT License - see the LICENSE file for details.

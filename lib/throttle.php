<?php
require_once('database.php');

class Throttle {

    private $db;
    private $conn;
    private $referer;
    private $time_to_reset = 1; //in seconds

    function __construct() {
        $this->db      = new Database();
        $this->conn    = $this->db->getConnection();
        $this->referer = $_SERVER['HTTP_REFERER'];
    }

    function shouldThrottle($throttle_limit = 5) {

        //check request rate
        $this->loadThrottleData($throttle_limit);

        //track_request data
        $this->trackThrottleData();

    }

    //check request rate
    function loadThrottleData($throttle_limit) {

        // check the rate limit for the referrer
        $result = mysqli_query($this->conn, "SELECT * FROM rate_limit WHERE referrer='$this->referer'");
        if ($result && mysqli_num_rows($result) > 0) {

            $row = mysqli_fetch_assoc($result);
            $count = $row['count'];
            $timestamp = $row['timestamp'];

            // if the timestamp is more than 1 second ago, reset the count and timestamp
            if (time() - $timestamp > $this->time_to_reset) {
                $count = 0;
                $timestamp = time();
            }

            // check if the request rate exceeds the threshold
            if ($count > $throttle_limit) {
                http_response_code(429); // return 429 Too Many Requests error
                echo "Too many requests. Please try again later.";
                exit;
            }
        }

    }

    //track request data
    function trackThrottleData() {

        // get the current timestamp
        $now  = time();
        
        // check if the referrer has been seen before
        $result = mysqli_query($this->conn, "SELECT * FROM rate_limit WHERE referrer = '$this->referer' ");
        if ($result && mysqli_num_rows($result) > 0) {

            $row = mysqli_fetch_assoc($result);
            $count     = $row['count'];
            $timestamp = $row['timestamp'];
    
            // if the timestamp is more than 1 second ago, reset the count and timestamp
            if ($now - $timestamp > $this->time_to_reset) {
                $count = 1;
                $timestamp = $now;
            } else {
                // increment the count
                $count++;
            }
    
            // update the rate limit data in the database
            mysqli_query($this->conn, "UPDATE rate_limit SET count = $count, timestamp=$timestamp WHERE referrer='$this->referer'");
        } else {
            // add a new entry for the referrer
            mysqli_query($this->conn, "INSERT INTO rate_limit (referrer, count, timestamp) VALUES ('$this->referer', 1, $now)");
        }

        $this->db->closeConnection();

    }

}
?>
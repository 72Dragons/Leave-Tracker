<?php
class db2 {
    //Staff DB
    public static $con;
    private static $isCon = false;
    private static $addUserAttempt = 0;


    public static function connect() {
        if (self::$isCon) return;
       self::$con = mysqli_connect('localhost','db_bot','dragon','leave_tracker4_dp');
        if (self::$con->connect_errno) {
            echo "Failed to connect to MySQL: (".self::$con->connect_errno.")".self::$con->connect_error;
        }
        // echo "con";
        mysqli_set_charset(self::$con, "utf8");
        self::$isCon = true;
    }
    public static function disconnect() {
        if (!self::$isCon) return;
        mysqli_close(self::$con);
        self::$isCon = false;
    }



}

db2::connect();

?>

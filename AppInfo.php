<?php

/**
 * This class provides static methods that return pieces of data specific to
 * your app
 */
class AppInfo {

  /*****************************************************************************
   *
   * These functions provide the unique identifiers that your app users.  These
   * have been pre-populated for you, but you may need to change them at some
   * point.  They are currently being stored in 'Environment Variables'.  To
   * learn more about these, visit
   *   'http://php.net/manual/en/function.getenv.php'
   *
   ****************************************************************************/

  /**
   * @return the appID for this app
   */
  public static function appID() {
    return getenv('146244962151403');
  }

  /**
   * @return the appSecret for this app
   */
  public static function appSecret() {
    return getenv('6c47e00af335c0d354210ba6c716401b');
  }
  /**
   * @return the home URL for this site
   */
  public static function getHome () {
    //return ($_SERVER['HTTP_X_FORWARDED_PROTO'] ?: "http") . "://" . $_SERVER['HTTP_HOST'] . "/";
    //return ($_SERVER['HTTP_X_FORWARDED_PROTO']) ?: "http:" . "://" . $_SERVER['HTTP_HOST'] . "/";
    //return "http://".$_SERVER['HTTP_HOST'] . "/";
$protocol = isset($_SERVER['HTTP_X_FORWARDED_PROTO']) ? $_SERVER['HTTP_X_FORWARDED_PROTO'] : "http";
return $protocol . "://" . $_SERVER['HTTP_HOST'] . "/";
  }

}

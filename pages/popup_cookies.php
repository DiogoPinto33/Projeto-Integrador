<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../database/connection.db.php');
  require_once(__DIR__ . '/../database/cookies.class.php');
  require_once(__DIR__ . '/../templates/cookie.tpl.php');



  /********************************************************/
  /*                 DATABASE CONNECTION                  */
  /********************************************************/


  $host = 'localhost';
  $username = 'root';
  $password = 'Pi_1234_';
  $database = 'projeto_integrador';

  $connection = new mysqli($host, $username, $password, $database);



  // Assuming $userId is the current logged in user's id
  // 1 is an example / our user on the database
  $userId = 1;
  

  /********************************************************/
  /*                 COOKIES TO DATABASE                  */
  /********************************************************/



  // Check if the connection was successful
  if ($connection->connect_error) {
    die('Connection failed: ' . $connection->connect_error);
  }



  // Check if the table is empty before resetting
  $checkEmptyTableQuery = "SELECT * FROM Cookie";
  $checkResult = $connection->query($checkEmptyTableQuery);

  if ($checkResult->num_rows === 0) {
      $resetIncrementQuery = "ALTER TABLE Cookie AUTO_INCREMENT = 1";

      if ($connection->query($resetIncrementQuery) === false) {
          echo 'Error resetting auto-increment value: ' . $connection->error;
      }
  }





  foreach ($_COOKIE as $name => $value) {
      // Sanitize the cookie name and value to prevent SQL injection
      $cookieName = $connection->real_escape_string($name);
      $cookieValue = $connection->real_escape_string($value);

      // Check if the cookie already exists
      $existingCookieQuery = "SELECT * FROM Cookie WHERE name_cookie = '$cookieName'";
      $existingCookieResult = $connection->query($existingCookieQuery);

      if ($existingCookieResult->num_rows === 0) {
        $insertCookieQuery = "INSERT INTO Cookie (name_cookie, value_cookie) VALUES ('$cookieName', '$cookieValue')";

        if ($connection->query($insertCookieQuery) === false) {
            echo 'Error inserting cookie: ' . $connection->error;
        }
      }

      // Get the ID of the cookie just inserted or already existed
      $cookieIdQuery = "SELECT id_cookie FROM Cookie WHERE name_cookie = '$cookieName'";
      $cookieIdResult = $connection->query($cookieIdQuery);

      if ($cookieIdResult->num_rows > 0) {
          // Fetch the id of the cookie
          $cookieId = $cookieIdResult->fetch_assoc()['id_cookie'];
          
          // Check if the cookie-user relation already exists
          $existingUserCookieQuery = "SELECT * FROM User_Cookies WHERE id_user = '$userId' AND id_cookie = '$cookieId'";
          $existingUserCookieResult = $connection->query($existingUserCookieQuery);

          if ($existingUserCookieResult->num_rows === 0) {
              $insertUserCookieQuery = "INSERT INTO User_Cookies (id_user, id_cookie) VALUES ('$userId', '$cookieId')";

              if ($connection->query($insertUserCookieQuery) === false) {
                  echo 'Error inserting user-cookie relation: ' . $connection->error;
              }
          }
      }
  }





  /********************************************************/
  /*                         TOOGLES                      */
  /********************************************************/



  // Identify the button pressed
  $button = $_POST['button'] ?? '';
  $action = $_POST['action'] ?? '';

  if ($button === 'aceitarTodos' || $button === 'aceitarTodos_en') {
    $value = 1;

    $sql = "UPDATE User SET 
      allow_preference_cookies_user = $value, 
      allow_analytics_cookies_user = $value, 
      allow_marketing_cookies_user = $value
      WHERE id_user = '$userId'";


    if ($connection->query($sql) === false) {
      echo 'Error updating cookies preferences: ' . $connection->error;
    }


    header('Location: successPage.php');
    exit;



  } elseif ((($button === 'cookieButton' || $button === 'cookieButton_en') && $action === 'necessary') || (($button === 'cookieButton' || $button === 'cookieButton_en') && $action === '')) {
    $value = 0;

    $sql = "UPDATE User SET 
      allow_preference_cookies_user = $value, 
      allow_analytics_cookies_user = $value, 
      allow_marketing_cookies_user = $value
      WHERE id_user = '$userId'";

    if ($connection->query($sql) === false) {
      echo 'Error updating cookies preferences: ' . $connection->error;
    }



    // Create a temporary table with the ids of the cookies we don't want to delete
    $sql_temp = "CREATE TEMPORARY TABLE IF NOT EXISTS temp_table AS (
      SELECT Cookie.id_cookie 
      FROM Cookie
      JOIN User_Cookies ON User_Cookies.id_cookie = Cookie.id_cookie
      WHERE (Cookie.name_cookie LIKE 'session%' OR 
            Cookie.name_cookie LIKE '%session%' OR 
            Cookie.path_cookie IN ('/login', '/dashboard'))
      AND User_Cookies.id_user = '$userId'
    )";

    // Run the query to create the temporary table
    if ($connection->query($sql_temp) === false) {
    echo 'Error creating temporary table: ' . $connection->error;
    }

    // Then, delete the cookies from the Cookie table that are not in the temporary table
    $sql_delete = "DELETE FROM Cookie 
    WHERE id_cookie NOT IN (
      SELECT id_cookie FROM temp_table
    )";

    // Run the query to delete the cookies
    if ($connection->query($sql_delete) === false) {
    echo 'Error deleting cookies: ' . $connection->error;
    }

    // Drop the temporary table
    $sql_drop = "DROP TABLE IF EXISTS temp_table";

    // Run the query to drop the temporary table
    if ($connection->query($sql_drop) === false) {
    echo 'Error dropping temporary table: ' . $connection->error;
    }



    header('Location: successPage.php');
    exit;



  } elseif (($button === 'cookieButton' || $button === 'cookieButton_en') && $action === 'selection') {
    // Only process the checkboxes if neither 'aceitarTodos' nor 'cookieButton' was clicked
    $value_preference = isset($_POST['preference']) && $_POST['preference'] == 'on' ? 1 : 0;
    $value_statistics = isset($_POST['statistics']) && $_POST['statistics'] == 'on' ? 1 : 0;
    $value_marketing = isset($_POST['marketing']) && $_POST['marketing'] == 'on' ? 1 : 0;

    $sql = "UPDATE User SET 
      allow_preference_cookies_user = $value_preference, 
      allow_analytics_cookies_user = $value_statistics, 
      allow_marketing_cookies_user = $value_marketing
      WHERE id_user = '$userId'";

    if ($connection->query($sql) === false) {
      echo 'Error updating cookies preferences: ' . $connection->error;
    }


    //Delete cookies based on unselected checkboxes
    if ($value_preference == 0) {
        $sql_temp = "CREATE TEMPORARY TABLE IF NOT EXISTS temp_table AS (
                        SELECT Cookie.id_cookie 
                        FROM Cookie
                        JOIN User_Cookies ON User_Cookies.id_cookie = Cookie.id_cookie
                        WHERE (Cookie.name_cookie LIKE 'pref_%' OR 
                              Cookie.name_cookie LIKE 'user_%' OR 
                              Cookie.name_cookie LIKE 'settings_%' OR 
                              Cookie.domain_cookie LIKE '%preferences.com' OR 
                              Cookie.domain_cookie LIKE '%settings.com' OR 
                              Cookie.path_cookie LIKE '/preferences%' OR 
                              Cookie.path_cookie LIKE '/settings%')
                        AND User_Cookies.id_user = '$userId'
                    )";

        if ($connection->query($sql_temp) === false) {
            echo 'Error creating temporary table: ' . $connection->error;
        }

        $sql_delete = "DELETE FROM Cookie 
                      WHERE id_cookie IN (
                        SELECT id_cookie FROM temp_table
                      )";

        if ($connection->query($sql_delete) === false) {
            echo 'Error deleting cookies: ' . $connection->error;
        }

        $sql_drop = "DROP TABLE IF EXISTS temp_table";

        if ($connection->query($sql_drop) === false) {
            echo 'Error dropping temporary table: ' . $connection->error;
        }


    }
    if ($value_statistics == 0) {
        $sql_temp = "CREATE TEMPORARY TABLE IF NOT EXISTS temp_table AS (
          SELECT Cookie.id_cookie 
          FROM Cookie
          JOIN User_Cookies ON User_Cookies.id_cookie = Cookie.id_cookie
          WHERE (Cookie.name_cookie LIKE 'ga_%' OR 
                Cookie.name_cookie LIKE 'utm_%' OR 
                Cookie.name_cookie LIKE 'stat_%' OR 
                Cookie.domain_cookie LIKE '%analytics.com' OR 
                Cookie.domain_cookie LIKE '%tracking.com' OR 
                Cookie.path_cookie LIKE '/statistics%' OR 
                Cookie.path_cookie LIKE '/tracking%')
          AND User_Cookies.id_user = '$userId'
        )";

        if ($connection->query($sql_temp) === false) {
        echo 'Error creating temporary table: ' . $connection->error;
        }

        $sql_delete = "DELETE FROM Cookie 
        WHERE id_cookie IN (
          SELECT id_cookie FROM temp_table
        )";

        if ($connection->query($sql_delete) === false) {
        echo 'Error deleting cookies: ' . $connection->error;
        }

        $sql_drop = "DROP TABLE IF EXISTS temp_table";

        if ($connection->query($sql_drop) === false) {
        echo 'Error dropping temporary table: ' . $connection->error;
        }


    }
    if ($value_marketing == 0) {
        $sql_temp = "CREATE TEMPORARY TABLE IF NOT EXISTS temp_table AS (
                        SELECT Cookie.id_cookie 
                        FROM Cookie
                        JOIN User_Cookies ON User_Cookies.id_cookie = Cookie.id_cookie
                        WHERE (Cookie.name_cookie LIKE 'marketing_%' OR 
                              Cookie.name_cookie LIKE 'ad_%' OR 
                              Cookie.name_cookie LIKE 'campaign_%' OR 
                              Cookie.domain_cookie LIKE '%marketing.com' OR 
                              Cookie.domain_cookie LIKE '%advertising.com' OR 
                              Cookie.path_cookie LIKE '/marketing%' OR 
                              Cookie.path_cookie LIKE '/advertising%')
                        AND User_Cookies.id_user = '$userId'
                    )";

        if ($connection->query($sql_temp) === false) {
            echo 'Error creating temporary table: ' . $connection->error;
        }

        $sql_delete = "DELETE FROM Cookie 
                      WHERE id_cookie IN (
                        SELECT id_cookie FROM temp_table
                      )";

        if ($connection->query($sql_delete) === false) {
            echo 'Error deleting cookies: ' . $connection->error;
        }

        $sql_drop = "DROP TABLE IF EXISTS temp_table";

        if ($connection->query($sql_drop) === false) {
            echo 'Error dropping temporary table: ' . $connection->error;
        }

    }



    header('Location: successPage.php');
    exit;



  }



  if (isset($sql) && $connection->query($sql) === false) {
    echo 'Error updating preference: ' . $connection->error;
  }



  // Close the database connection
  $connection->close();





/********************************************************/
/*                         HTML                         */
/********************************************************/



  drawInitPopUp();





?>

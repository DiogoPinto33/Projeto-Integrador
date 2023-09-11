<?php
  declare(strict_types = 1);

  class Cookie {
    public int $id_cookie;
    public ?string $name_cookie;
    public ?string $value_cookie;
    public ?string $domain_cookie;
    public ?string $path_cookie;
    public ?int $expiry_cookie;
    public ?bool $secure_cookie;
    public ?bool $httponly_cookie;
    public ?int $size_cookie;
    public ?string $samesite_cookie;
    public ?string $partitionkey_cookie;
    public ?string $priority_cookie;

    public function __construct(int $id_cookie, ?string $name_cookie, ?string $value_cookie, ?string $domain_cookie, ?string $path_cookie, ?int $expiry_cookie, ?bool $secure_cookie, ?bool $httponly_cookie, ?int $size_cookie, ?string $samesite_cookie, ?string $partitionkey_cookie, ?string $priority_cookie)
    {
      $this->id_cookie = $id_cookie;
      $this->name_cookie = $name_cookie;
      $this->value_cookie = $value_cookie;
      $this->domain_cookie = $domain_cookie;
      $this->path_cookie = $path_cookie;
      $this->expiry_cookie = $expiry_cookie;
      $this->secure_cookie = $secure_cookie;
      $this->httponly_cookie = $httponly_cookie;
      $this->size_cookie = $size_cookie;
      $this->samesite_cookie = $samesite_cookie;
      $this->partitionkey_cookie = $partitionkey_cookie;
      $this->priority_cookie = $priority_cookie;
    }
    



    
    static function getCookies(PDO $db) : array {
      $stmt = $db->prepare('
        SELECT *
        FROM Cookie
      ');
  
      $stmt->execute(array());
  
      $cookies = array();
      while ($cookie = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $cookieObject = new Cookie(
          intval($cookie['id_cookie']),
          $cookie['name_cookie'],
          $cookie['value_cookie'],
          $cookie['domain_cookie'],
          $cookie['path_cookie'],
          intval($cookie['expiry_cookie']),
          boolval($cookie['secure_cookie']),
          boolval($cookie['httponly_cookie']),
          intval($cookie['size_cookie']),
          $cookie['samesite_cookie'],
          $cookie['partitionkey_cookie'],
          $cookie['priority_cookie']
        );
        $cookies[] = $cookieObject;
      }
      return $cookies;
    }














    
    static function getNecessaryCookies(PDO $db, $id_user) : array {
      $stmt = $db->prepare('
          SELECT Cookie.id_cookie, name_cookie, value_cookie, domain_cookie, path_cookie, expiry_cookie, secure_cookie, httponly_cookie, size_cookie, samesite_cookie, partitionkey_cookie, priority_cookie
          FROM Cookie, User_Cookies
          WHERE ((name_cookie LIKE "session%" OR name_cookie LIKE "%session%" OR path_cookie IN ("/login", "/dashboard"))
          AND (User_Cookies.id_user = :id_user AND User_Cookies.id_cookie = Cookie.id_cookie))
      ');
    
      $stmt->execute([':id_user' => $id_user]);
      $necessaryCookies = array();

      while ($cookie = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $cookieObject = new Cookie(
          intval($cookie['id_cookie']),
          $cookie['name_cookie'],
          $cookie['value_cookie'],
          $cookie['domain_cookie'],
          $cookie['path_cookie'],
          intval($cookie['expiry_cookie']),
          boolval($cookie['secure_cookie']),
          boolval($cookie['httponly_cookie']),
          intval($cookie['size_cookie']),
          $cookie['samesite_cookie'],
          $cookie['partitionkey_cookie'],
          $cookie['priority_cookie']
        );
        $necessaryCookies[] = $cookieObject;
      }
      return $necessaryCookies;
    }

    



    static function getPreferenceCookies(PDO $db, $id_user) : array {
      $stmt = $db->prepare('
        SELECT Cookie.id_cookie, name_cookie, value_cookie, domain_cookie, path_cookie, expiry_cookie, secure_cookie, httponly_cookie, size_cookie, samesite_cookie, partitionkey_cookie, priority_cookie
        FROM Cookie, User_Cookies
        WHERE ((name_cookie LIKE "pref_%" OR name_cookie LIKE "user_%" OR name_cookie LIKE "settings_%" OR domain_cookie LIKE "%preferences.com" OR domain_cookie LIKE "%settings.com" OR path_cookie IN ("/preferences%", "/settings%"))
        AND (User_Cookies.id_user = :id_user AND User_Cookies.id_cookie = Cookie.id_cookie))
      ');

      $stmt->execute([':id_user' => $id_user]);
      $preferenceCookies = array();

      while ($cookie = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $cookieObject = new Cookie(
          intval($cookie['id_cookie']),
          $cookie['name_cookie'],
          $cookie['value_cookie'],
          $cookie['domain_cookie'],
          $cookie['path_cookie'],
          intval($cookie['expiry_cookie']),
          boolval($cookie['secure_cookie']),
          boolval($cookie['httponly_cookie']),
          intval($cookie['size_cookie']),
          $cookie['samesite_cookie'],
          $cookie['partitionkey_cookie'],
          $cookie['priority_cookie']
        );
        $preferenceCookies[] = $cookieObject;
      }
      return $preferenceCookies;
    }

    



    static function getAnalyticsCookies(PDO $db, $id_user) : array {
      $stmt = $db->prepare('
        SELECT Cookie.id_cookie, name_cookie, value_cookie, domain_cookie, path_cookie, expiry_cookie, secure_cookie, httponly_cookie, size_cookie, samesite_cookie, partitionkey_cookie, priority_cookie
        FROM Cookie, User_Cookies
        WHERE ((name_cookie LIKE "ga_%" OR name_cookie LIKE "utm_%" OR name_cookie LIKE "stat_%" OR domain_cookie LIKE "%analytics.com" OR domain_cookie LIKE "%tracking.com" OR path_cookie IN ("/statistics%", "/tracking%"))
        AND (User_Cookies.id_user = :id_user AND User_Cookies.id_cookie = Cookie.id_cookie))
      ');

      $stmt->execute([':id_user' => $id_user]);
      $analyticsCookies = array();

      while ($cookie = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $cookieObject = new Cookie(
          intval($cookie['id_cookie']),
          $cookie['name_cookie'],
          $cookie['value_cookie'],
          $cookie['domain_cookie'],
          $cookie['path_cookie'],
          intval($cookie['expiry_cookie']),
          boolval($cookie['secure_cookie']),
          boolval($cookie['httponly_cookie']),
          intval($cookie['size_cookie']),
          $cookie['samesite_cookie'],
          $cookie['partitionkey_cookie'],
          $cookie['priority_cookie']
        );
        $analyticsCookies[] = $cookieObject;
      }
      return $analyticsCookies;
    }





    static function getMarketingCookies(PDO $db, $id_user) : array {
      $stmt = $db->prepare('
        SELECT Cookie.id_cookie, name_cookie, value_cookie, domain_cookie, path_cookie, expiry_cookie, secure_cookie, httponly_cookie, size_cookie, samesite_cookie, partitionkey_cookie, priority_cookie
        FROM Cookie, User_Cookies
        WHERE ((name_cookie LIKE "marketing_%" OR name_cookie LIKE "ad_%" OR name_cookie LIKE "campaign_%" OR domain_cookie LIKE "%marketing.com" OR domain_cookie LIKE "%advertising.com" OR path_cookie IN ("/marketing%", "/advertising%"))
        AND (User_Cookies.id_user = :id_user AND User_Cookies.id_cookie = Cookie.id_cookie))
      ');

      $stmt->execute([':id_user' => $id_user]);
      $marketingCookies = array();

      while ($cookie = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $cookieObject = new Cookie(
          intval($cookie['id_cookie']),
          $cookie['name_cookie'],
          $cookie['value_cookie'],
          $cookie['domain_cookie'],
          $cookie['path_cookie'],
          intval($cookie['expiry_cookie']),
          boolval($cookie['secure_cookie']),
          boolval($cookie['httponly_cookie']),
          intval($cookie['size_cookie']),
          $cookie['samesite_cookie'],
          $cookie['partitionkey_cookie'],
          $cookie['priority_cookie']
        );
        $marketingCookies[] = $cookieObject;
      }
      return $marketingCookies;
    }





    static function getUnclassifiedCookies(PDO $db, $id_user) : array {
      $stmt = $db->prepare('
        SELECT Cookie.id_cookie, name_cookie, value_cookie, domain_cookie, path_cookie, expiry_cookie, secure_cookie, httponly_cookie, size_cookie, samesite_cookie, partitionkey_cookie, priority_cookie
        FROM Cookie
        INNER JOIN User_Cookies ON Cookie.id_cookie = User_Cookies.id_cookie
        WHERE User_Cookies.id_user = :id_user
        AND NOT (name_cookie LIKE "session%" OR name_cookie LIKE "%session%")
        AND NOT (name_cookie LIKE "ga_%" OR name_cookie LIKE "utm_%" OR name_cookie LIKE "stat_%")
        AND NOT (name_cookie LIKE "marketing_%" OR name_cookie LIKE "ad_%" OR name_cookie LIKE "campaign_%")
        AND NOT (name_cookie LIKE "pref_%" OR name_cookie LIKE "user_%" OR name_cookie LIKE "settings_%");
      ');

      $stmt->execute([':id_user' => $id_user]);
      $unclassifiedCookies = array();

      while ($cookie = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $cookieObject = new Cookie(
          intval($cookie['id_cookie']),
          $cookie['name_cookie'],
          $cookie['value_cookie'],
          $cookie['domain_cookie'],
          $cookie['path_cookie'],
          intval($cookie['expiry_cookie']),
          boolval($cookie['secure_cookie']),
          boolval($cookie['httponly_cookie']),
          intval($cookie['size_cookie']),
          $cookie['samesite_cookie'],
          $cookie['partitionkey_cookie'],
          $cookie['priority_cookie']
        );
        $unclassifiedCookies[] = $cookieObject;
      }
      return $unclassifiedCookies;
    }








  }  
?>
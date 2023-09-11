<?php
  declare(strict_types = 1);

  class User {
    public int $id_user;
    public ?int $auth_user;
    public ?int $allow_preference_cookies_user;
    public ?int $allow_marketing_cookies_user;
    public ?int $allow_analytics_cookies_user;
    public ?string $name_user;
    

    public function __construct(int $id_user, int $auth_user, int $allow_preference_cookies_user, int $allow_marketing_cookies_user, int $allow_analytics_cookies_user, string $name_user) 
    {
      $this->id_user = $id_user;
      $this->auth_user = $auth_user;
      $this->allow_preference_cookies_user = $allow_preference_cookies_user;
      $this->allow_marketing_cookies_user = $allow_marketing_cookies_user;
      $this->allow_analytics_cookies_user = $allow_analytics_cookies_user;
      $this->name_user = $name_user;
    }


    function saveName($db) {
      $stmt = $db->prepare('
        UPDATE User SET name_user = ?
        WHERE id_user = ?
      ');

      $stmt->execute(array($this->name_user, $this->id_user));
    }

    function saveAuth($db) {
      $stmt = $db->prepare('
        UPDATE User SET auth_user = ?
        WHERE id_user = ?
      ');

      $stmt->execute(array(intval($this->auth_user, $this->id_user)));
    }

    function saveAllowPreferenceCookies($db) {
      $stmt = $db->prepare('
        UPDATE User SET allow_preference_cookies_user = ?
        WHERE id_user = ?
      ');

      $stmt->execute(array(intval($this->allow_preference_cookies_user, $this->id_user)));
    }

    function saveAllowMarketingCookies($db) {
      $stmt = $db->prepare('
        UPDATE User SET allow_marketing_cookies_user = ?
        WHERE id_user = ?
      ');

      $stmt->execute(array(intval($this->allow_marketing_cookies_user, $this->id_user)));
    }

    function saveAllowAnalyticsCookies($db) {
      $stmt = $db->prepare('
        UPDATE User SET allow_analytics_cookies_user = ?
        WHERE id_user = ?
      ');

      $stmt->execute(array(intval($this->allow_analytics_cookies_user, $this->id_user)));
    }
  
  }  
?>
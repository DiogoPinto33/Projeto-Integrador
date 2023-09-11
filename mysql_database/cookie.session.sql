-- DATABASE: cookie


-- @block
DROP TABLE IF EXISTS Cookie;


-- @block
CREATE TABLE Cookie (
  id_cookie INTEGER PRIMARY KEY AUTO_INCREMENT,
  name_cookie TEXT NOT NULL,
  value_cookie TEXT NOT NULL,
  domain_cookie TEXT,
  path_cookie TEXT,
  expiry_cookie INTEGER,
  secure_cookie BOOLEAN,
  httponly_cookie BOOLEAN,
  size_cookie INTEGER,
  samesite_cookie TEXT,
  partitionkey_cookie TEXT,
  priority_cookie TEXT
);


-- @block
SELECT * FROM Cookie;


-- @block
DELETE FROM Cookie;










-- DATABASE: User


-- @block
DROP TABLE IF EXISTS User;



-- @block
CREATE TABLE User(
  id_user INTEGER PRIMARY KEY NOT NULL,
  name_user TEXT,
  auth_user BOOLEAN,
  allow_preference_cookies_user BOOLEAN,
  allow_analytics_cookies_user BOOLEAN,
  allow_marketing_cookies_user BOOLEAN
);


-- @block
SELECT * FROM User;


-- @block
INSERT INTO User (id_user, name_user, auth_user, allow_preference_cookies_user, allow_analytics_cookies_user, allow_marketing_cookies_user)
VALUES ('1', 'name_1', '1', '0', '0', '0');


-- @block
DELETE FROM User;










-- DATABASE: User_Cookies


-- @block
DROP TABLE IF EXISTS User_Cookies;


-- @block
CREATE TABLE User_Cookies (
    id_user INT NOT NULL,
    id_cookie INT NOT NULL,
    PRIMARY KEY (id_user, id_cookie),
    FOREIGN KEY (id_user) REFERENCES User(id_user),
    FOREIGN KEY (id_cookie) REFERENCES Cookie(id_cookie) ON DELETE CASCADE
);


-- @block
SELECT * FROM User_Cookies;


-- @block
DELETE FROM User_Cookies;

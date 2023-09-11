<?php 
  declare(strict_types = 1); 
  include_once __DIR__ . '/../database/connection.db.php';
  include_once __DIR__ . '/../database/cookies.class.php';
?>

<?php function drawInitPopUp() { ?>
  <!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cookie Consent</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script defer src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
  <script defer src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <script src="https://kit.fontawesome.com/229d2ad1bd.js" crossorigin="anonymous"></script>  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link rel="stylesheet" href="cookies.css">
  <script defer src="cookies.js"></script>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Roboto&display=swap');
  </style>
</head>


<body>
    <div class="pop_up" id="pop_up">
    
      <form id="cookieForm" method="post" action="popup_cookies.php">

        <h1 id="title" class="display-4" lang="pt">Este website usa Cookies</h1>
        <h1 id="title" class="display-4" lang="en">This Website uses Cookies</h1>

        <div class="description" lang="pt">
          Utilizamos Cookies para melhorar a sua experiência no website. 
          Ao continuar a navegar, concorda com a utilização de Cookies de acordo com a nossa Política de Cookies. 
          Os cookies são pequenos arquivos de texto armazenados no dispositivo que nos permitem coletar informações 
          importantes para o funcionamento adequado do site, personalizar conteúdos e anúncios, 
          fornecer recursos de mídia social e analisar o tráfego do site.
        </div>
        <div class="description" lang="en">
          We use cookies to enhance your experience on the website. 
          By continuing to browse, you agree to the use of cookies in accordance with our Cookie Policy. 
          Cookies are small text files stored on your device that allow us to collect important information 
          for the proper functioning of the site, personalize content and ads, 
          provide social media features, and analyze website traffic.
        </div>

        <div class="buttons">
          <button type="submit" id="cookieButton" class="btn btn-outline-secondary" lang="pt" name="button" value="cookieButton">Só Cookies necessários</button>
          <button type="submit" id="cookieButton_en" class="btn btn-outline-secondary" lang="en" name="button" value="cookieButton_en">Only Necessary Cookies</button>
          
          <button type="submit" id="aceitarTodos" class="btn btn-dark" lang="pt" name="button" value="aceitarTodos">Aceitar todos</button>
          <button type="submit" id="aceitarTodos_en" class="btn btn-dark" lang="en" name="button" value="aceitarTodos_en">Allow All</button>

          <input type="hidden" id="action" name="action" value="">

        </div>

        <div class="details" onclick="openCookies()" lang="pt">Mostrar detalhes</div>
        <div class="details" onclick="openCookies()" lang="en">Show Details</div>


        <div id="preferences">
          <div class="toggles">

            <!--   NECESSARY   -->

            <div class="form-check form-switch">
              <div class="toggles-visible">
                <input class="form-check-input custom-switch-green" type="checkbox" role="switch" id="flexSwitchCheckCheckedDisabled" checked disabled>
                <label class="form-check-label" for="flexSwitchCheckCheckedDisabled" lang="pt">Necessários</label>
                <label class="form-check-label" for="flexSwitchCheckCheckedDisabled" lang="en">Necessary</label>
                <div onclick="openCookiesDetails1()" lang="pt">Detalhes</div>
                <div onclick="openCookiesDetails1()" lang="en">Details</div>
              </div>
              <div id="toggles-dropdown1">
                <span lang="pt">
                  Os cookies Necessários ajudam a tornar um site utilizável, permitindo funções básicas 
                  como navegação de páginas e acesso a áreas seguras do site. 
                  O site não pode funcionar corretamente sem esses cookies.
                </span>
                <span lang="en">
                  Necessary cookies help make a website usable by enabling basic 
                  functions like page navigation and access to secure areas of the website. 
                  The website cannot function properly without these cookies.
                </span>

                <?php
                  $db = getDatabaseConnection();
                  $userId = 1;
                  $cookies = Cookie::getNecessaryCookies($db, $userId);
                  foreach ($cookies as $cookie) {
                ?>
                
                <div>
                  <div class="toggle-header">
                    <div> <?php echo $cookie->name_cookie; ?> </div>
                    <i class="fa-solid fa-angle-down"></i>
                  </div>

                  
                  <div> <?php echo $cookie->value_cookie; ?> </div>
                  
                  <div class="cookie-info">
                    <hr>
                    <div class="exp-type">
                      <div lang="pt">Expira: <?php echo $cookie->expiry_cookie; ?> </div>
                      <div lang="en">Expiry: <?php echo $cookie->expiry_cookie; ?> </div>
                      <div lang="pt">Tipo: <?php echo $cookie->httponly_cookie; ?> </div>
                      <div lang="en">Type: <?php echo $cookie->httponly_cookie; ?> </div>
                    </div>
                  </div>
                </div>

                <?php
                  }
                ?>

              </div>

            </div>

            <!--   PREFERENCES   -->

            <div class="form-check form-switch">
              <div class="toggles-visible">
                <input class="form-check-input custom-switch-green" type="checkbox" role="switch" id="toggle1" name="preference">
                <label class="form-check-label" for="flexSwitchCheckDefault" lang="pt">Preferências</label>
                <label class="form-check-label" for="flexSwitchCheckDefault" lang="en">Preferences</label>
                <div onclick="openCookiesDetails2()" lang="pt">Detalhes</div>
                <div onclick="openCookiesDetails2()" lang="en">Details</div>

              </div>
              <div id="toggles-dropdown2">
                <span lang="pt">
                  Os cookies de Preferências permitem que um website se lembre de informações que alteram 
                  a forma ele se comporta ou é exibido, como seu idioma preferido ou 
                  a região em que você se encontra.
                </span>
                <span lang="en">
                  Preference cookies enable a website to remember information that changes 
                  the way it behaves or looks, like your preferred language or 
                  the region that you are in.
                </span>

                <?php
                  $db = getDatabaseConnection();
                  $userId = 1;
                  $cookies = Cookie::getPreferenceCookies($db, $userId);
                  foreach ($cookies as $cookie) {
                ?>

                <div>
                  <div class="toggle-header">
                    <div> <?php echo $cookie->name_cookie; ?> </div>
                    <i class="fa-solid fa-angle-down"></i>
                  </div>
                  
                  <div> <?php echo $cookie->value_cookie; ?> </div>
                  
                  <div class="cookie-info">
                    <hr>
                    <div class="exp-type">
                      <div lang="pt">Expira: <?php echo $cookie->expiry_cookie; ?> </div>
                      <div lang="en">Expiry: <?php echo $cookie->expiry_cookie; ?> </div>
                      <div lang="pt">Tipo: <?php echo $cookie->httponly_cookie; ?> </div>
                      <div lang="en">Type: <?php echo $cookie->httponly_cookie; ?> </div>
                    </div>
                  </div>
                </div>
                
                <?php
                  }
                ?>

              </div>
            </div>

            <!--   STATISTICS   -->

            <div class="form-check form-switch">
              <div class="toggles-visible">
                <input class="form-check-input custom-switch-green" type="checkbox" role="switch" id="toggle2" name="statistics">
                <label class="form-check-label" for="flexSwitchCheckDefault" lang="pt">Estatísticas</label>
                <label class="form-check-label" for="flexSwitchCheckDefault" lang="en">Statistics</label>
                <div onclick="openCookiesDetails3()" lang="pt">Detalhes</div>
                <div onclick="openCookiesDetails3()" lang="en">Details</div>
              </div>
              <div id="toggles-dropdown3">
                <span lang="pt">
                  Os cookies de Estatísticas ajudam os proprietários do websites 
                  a compreender como os visitantes interagem com ele, 
                  recolhendo e reportando informações de forma anónima.
                </span>
                <span lang="en">
                  Statistic cookies help the website owners to understand how visitors interact 
                  with it by collecting and reporting information anonymously.
                </span>

                <?php
                  $db = getDatabaseConnection();
                  $userId = 1;
                  $cookies = Cookie::getAnalyticsCookies($db, $userId);
                  foreach ($cookies as $cookie) {
                ?>

                <div>
                  <div class="toggle-header">
                    <div> <?php echo $cookie->name_cookie; ?> </div>
                    <i class="fa-solid fa-angle-down"></i>
                  </div>
                  
                  <div> <?php echo $cookie->value_cookie; ?> </div>
                  
                  <div class="cookie-info">
                    <hr>
                    <div class="exp-type">
                      <div lang="pt">Expira: <?php echo $cookie->expiry_cookie; ?> </div>
                      <div lang="en">Expiry: <?php echo $cookie->expiry_cookie; ?> </div>
                      <div lang="pt">Tipo: <?php echo $cookie->httponly_cookie; ?> </div>
                      <div lang="en">Type: <?php echo $cookie->httponly_cookie; ?> </div>
                    </div>
                  </div>
                </div>

                <?php
                  }
                ?>


              </div>
            </div>
           
            <!--   MARKETING   -->

            <div class="form-check form-switch">
              <div class="toggles-visible">
                <input class="form-check-input custom-switch-green" type="checkbox" role="switch" id="toggle3" name="marketing">
                <label class="form-check-label" for="flexSwitchCheckDefault">Marketing</label>
                <div onclick="openCookiesDetails4()" lang="pt">Detalhes</div>
                <div onclick="openCookiesDetails4()" lang="en">Details</div>
              </div>
              <div id="toggles-dropdown4">
                <span lang="pt">
                  Os cookies de Marketing são utilizados para rastrear visitantes em diferentes websites. 
                  A intenção é exibir anúncios relevantes e atrativos para o usuário individual, 
                  tornando-os mais valiosos para os editores e publicitários.
                </span>
                <span lang="en">
                  Marketing cookies are used to track visitors across websites. 
                  The intention is to display ads that are relevant and engaging for the 
                  individual user and thereby more valuable for publishers and third party advertisers.
                </span>

                <?php
                  $db = getDatabaseConnection();
                  $userId = 1;
                  $cookies = Cookie::getMarketingCookies($db, $userId);
                  foreach ($cookies as $cookie) {
                ?>

                <div>
                  <div class="toggle-header">
                    <div> <?php echo $cookie->name_cookie; ?> </div>
                    <i class="fa-solid fa-angle-down"></i>
                  </div>
                  
                  <div> <?php echo $cookie->value_cookie; ?> </div>
                  
                  <div class="cookie-info">
                    <hr>
                    <div class="exp-type">
                      <div lang="pt">Expira: <?php echo $cookie->expiry_cookie; ?> </div>
                      <div lang="en">Expiry: <?php echo $cookie->expiry_cookie; ?> </div>
                      <div lang="pt">Tipo: <?php echo $cookie->httponly_cookie; ?> </div>
                      <div lang="en">Type: <?php echo $cookie->httponly_cookie; ?> </div>
                    </div>
                  </div>
                </div>

                <?php
                  }
                ?>

              </div>
            </div>

            <!--   UNCLASSIFIED   -->
            
            <div class="form-check form-switch">
              <div class="toggles-visible">
                <label style="padding-left: 25px;" class="form-check-label" for="flexSwitchCheckDefault" lang="pt">Indefinido</label>
                <label style="padding-left: 25px;" class="form-check-label" for="flexSwitchCheckDefault" lang="en">Unclassified</label>
                <div onclick="openCookiesDetails5()" lang="pt">Detalhes</div>
                <div onclick="openCookiesDetails5()" lang="en">Details</div>
              </div>
              <div id="toggles-dropdown5">
                <span lang="pt">
                  Os cookies Indefinidos são cookies que estão em processo de classificação, 
                  juntamente com os fornecedores de cookies individuais.
                </span>
                <span lang="en">
                  Unclassified cookies are cookies that we are in the process of classifying, 
                  together with the providers of individual cookies.
                </span>
                
                <?php
                  $db = getDatabaseConnection();
                  $userId = 1;
                  $cookies = Cookie::getUnclassifiedCookies($db, $userId);
                  foreach ($cookies as $cookie) {
                ?>

                <div>
                  <div class="toggle-header">
                    <div> <?php echo $cookie->name_cookie; ?> </div>
                    <i class="fa-solid fa-angle-down"></i>
                  </div>
                  
                  <div> <?php echo $cookie->value_cookie; ?> </div>
                  
                  <div class="cookie-info">
                    <hr>
                    <div class="exp-type">
                      <div lang="pt">Expira: <?php echo $cookie->expiry_cookie; ?> </div>
                      <div lang="en">Expiry: <?php echo $cookie->expiry_cookie; ?> </div>
                      <div lang="pt">Tipo: <?php echo $cookie->httponly_cookie; ?> </div>
                      <div lang="en">Type: <?php echo $cookie->httponly_cookie; ?> </div>
                    </div>
                  </div>
                </div>

                <?php
                  }
                ?>

              </div>
            </div>
          </div>
          
          <div class="policy" lang="pt">Pode ler mais sobre o nosso uso de cookies na <b>Política de Cookies</b></div>
          <div class="policy" lang="en">You may read more about our use of cookies in the <b>Cookie Policy</b></div>

        
        </div>
      </form>
    </div>
  
  

</body>
</html>



<?php } ?>
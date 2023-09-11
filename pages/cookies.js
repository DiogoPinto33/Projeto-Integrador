
/********************************************************/
/*                         POP UP                       */
/********************************************************/



function openpop_up(pop_up) {
  if (pop_up == null) return
  pop_up.classList.add('active')
}

function closepop_up(pop_up) {
  if (pop_up == null) return
  pop_up.classList.remove('active')
}


window.onload = function() {
  const pop_up = document.querySelector('#pop_up');
  openpop_up(pop_up);

  // Uncheck toggles on page load
  document.getElementById('toggle1').checked = false;
  document.getElementById('toggle2').checked = false;
  document.getElementById('toggle3').checked = false;
}





/********************************************************/
/*                        DROPDOWNS                     */
/********************************************************/



function openCookies() {
  if (document.getElementById("preferences").style.display == "block") {
    document.getElementById("preferences").style.display = "none";
  } else {
    document.getElementById("preferences").style.display = "block";
  }
}

function openCookiesDetails1() {
  if (document.getElementById("toggles-dropdown1").style.display == "block") {
    document.getElementById("toggles-dropdown1").style.display = "none";
  } else {
    document.getElementById("toggles-dropdown1").style.display = "block";
  }
}

function openCookiesDetails2() {
  if (document.getElementById("toggles-dropdown2").style.display == "block") {
    document.getElementById("toggles-dropdown2").style.display = "none";
  } else {
    document.getElementById("toggles-dropdown2").style.display = "block";
  }
}

function openCookiesDetails3() {
  if (document.getElementById("toggles-dropdown3").style.display == "block") {
    document.getElementById("toggles-dropdown3").style.display = "none";
  } else {
    document.getElementById("toggles-dropdown3").style.display = "block";
  }
}

function openCookiesDetails4() {
  if (document.getElementById("toggles-dropdown4").style.display == "block") {
    document.getElementById("toggles-dropdown4").style.display = "none";
  } else {
    document.getElementById("toggles-dropdown4").style.display = "block";
  }
}

function openCookiesDetails5() {
  if (document.getElementById("toggles-dropdown5").style.display == "block") {
    document.getElementById("toggles-dropdown5").style.display = "none";
  } else {
    document.getElementById("toggles-dropdown5").style.display = "block";
  }
}


window.addEventListener('DOMContentLoaded', (event) => {
  document.querySelectorAll('.toggle-header').forEach((header) => {
      header.addEventListener('click', function() {
          this.classList.toggle('open');
          this.nextElementSibling.nextElementSibling.classList.toggle('show');
      });
  });
});





/********************************************************/
/*                       TOGGLES                        */
/********************************************************/



// Get references to the necessary elements
const toggle1 = document.getElementById('toggle1');
const toggle2 = document.getElementById('toggle2');
const toggle3 = document.getElementById('toggle3');

// Function to handle changes in the toggles
function handleToggleChange() {
  let lang = navigator.language.slice(0, 2);
  const actionInput = document.getElementById('action');

  if (lang == "en") {
    cookieButton = document.getElementById('cookieButton_en');
  } else {
    cookieButton = document.getElementById('cookieButton');
  }

  // Check if any of the toggles are checked
  if (toggle1.checked || toggle2.checked || toggle3.checked) {
    // Update the button text and color
    if (lang == "pt") {
      cookieButton.textContent = 'Permitir Seleção';
    } else {
      cookieButton.textContent = 'Allow Selection';
    }
    cookieButton.classList.add('btn-outline-success');
    actionInput.value = 'selection';

  } else {
    if (lang == "pt") {
      cookieButton.textContent = 'Só Cookies Necessários';
    } else {
      cookieButton.textContent = 'Only Necessary Cookies';
    }
    cookieButton.classList.remove('btn-outline-success');
    actionInput.value = 'necessary';
  }
}

// Add event listeners to the toggles
toggle1.addEventListener('change', handleToggleChange);
toggle2.addEventListener('change', handleToggleChange);
toggle3.addEventListener('change', handleToggleChange);



document.addEventListener("DOMContentLoaded", function() {
  var toggleHeaders = document.querySelectorAll(".toggle-header");

  toggleHeaders.forEach(function(toggleHeader) {
    toggleHeader.addEventListener("click", function() {
      var targetId = toggleHeader.getAttribute("data-target");

      toggleHeader.classList.toggle("open");
    });
  });
});





/********************************************************/
/*                     SWITCH LANGUAGE                  */
/********************************************************/



let lang = navigator.language.slice(0, 2);

if (lang == "pt") {
  $('[lang="en"]').hide();
  $('[lang="pt"]').hide();
  $('[lang="pt"]').toggle();
}
else {
  $('[lang="en"]').hide();
  $('[lang="pt"]').hide();
  $('[lang="en"]').toggle();
}





/********************************************************/
/*                         COOKIES                      */
/********************************************************/



function setCookie(name, value, domain, path, expiration, size, httpOnly, secure, sameSite, partitionKey, priority) {
  var cookieString = encodeURIComponent(name) + '=' + encodeURIComponent(value);

  if (domain) {
    cookieString += '; domain=' + domain;
  }

  if (path) {
    cookieString += '; path=' + path;
  }

  if (expiration) {
    var expirationDate = new Date();
    expirationDate.setTime(expirationDate.getTime() + expiration * 24 * 60 * 60 * 1000);
    cookieString += '; expires=' + expirationDate.toUTCString();
  }

  if (size) {
    cookieString += '; size=' + size;
  }
  
  if (httpOnly) {
    cookieString += '; httpOnly';
  }

  if (secure) {
    cookieString += '; secure';
  }

  if (sameSite) {
    cookieString += '; sameSite=' + sameSite;
  }

  if (partitionKey) {
    cookieString += '; partitionKey=' + partitionKey;
  }

  if (priority) {
    cookieString += '; priority=' + priority;
  }

  document.cookie = cookieString;
}


// Set a cookie with all available options
setCookie('exampleCookie1', 'fictionalValue2', 'localhost', 'path=/', 'Thu, 30 Dec 2023 23:59:59 UTC');
setCookie('session', 'user_gonzallito');
setCookie('teste', 'user_teste');
setCookie('user_balazeiro', 'value_teste');
setCookie('stat_cookie', 'valor');
setCookie('ad_cookie', 'value_cookie');

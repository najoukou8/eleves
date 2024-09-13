<?php


?>
<style>
.modal-container {
  margin: 0 auto;
  padding-top: 60px;
  position: relative;
  width: 160px;
}

.modal-container button {
  display: block;
  margin: 0 auto;
  color: #fff;
  width: 160px;
  height: 50px;
  line-height: 50px;
  background: #446CB3;
  font-size: 22px;
  border: 0;
  border-radius: 3px;
  box-shadow: 0 5px 5px -5px #333;
  transition: background 0.3s ease-in;
}
.modal-container .modal-backdrop {
  height: 0;
  width: 0;
  opacity: 0;
  overflow: hidden;
  transition: opacity 0.2s ease-in;
}
.modal-container #modal-toggle {
  position: absolute;
  left: 0;
  top: 0;
  height: 100%;
  width: 100%;
  margin: 0;
  opacity: 0;
  cursor: pointer;
}

.modal-container #modal-toggle:hover ~ button { background: #1E824C; }
.modal-container #modal-toggle:checked {
  width: 100vw;
  height: 100vh;
  position: fixed;
  left: 0;
  top: 0;
  z-index: 9;
  opacity: 0;
}
.modal-container #modal-toggle:checked ~ .modal-backdrop {
  background-color: rgba(0, 0, 0, 0.6);
  width: 100vw;
  height: 100vh;
  position: fixed;
  left: 0;
  top: 0;
  z-index: 9;
  pointer-events: none;
  opacity: 1;
}
.modal-container #modal-toggle:checked ~ .modal-backdrop .modal-content {
  background-color: #fff;
  max-width: 496px;
  width: 100%;
  height: 255px;
  padding: 10px 30px;
  position: absolute;
  left: calc(50% - 200px);
  top: 12%;
  border-radius: 4px;
  z-index: 999;
  pointer-events: auto;
  cursor: auto;
  box-shadow: 0 3px 7px rgba(0, 0, 0, 0.6);
}
@media (max-width: 400px) {
.modal-container #modal-toggle:checked ~ .modal-backdrop .modal-content { left: 0; }
}
.modal-container #modal-toggle:checked ~ .modal-backdrop .modal-content .modal-close {
  color: #666;
  position: absolute;
  right: 2px;
  top: 0;
  padding-top: 7px;
  background: #fff;
  font-size: 16px;
  width: 25px;
  height: 28px;
  font-weight: bold;
  text-align: center;
  cursor: pointer;
}
.modal-container #modal-toggle:checked ~ .modal-backdrop .modal-content .modal-close.button {
  top: initial;
  bottom: 20px;
  right: 20px;
  background: #4CAF50;
  color: #fff;
  width: 50px;
  border-radius: 2px;
  font-size: 14px;
  font-weight: normal;
}
.modal-container #modal-toggle:checked ~ .modal-backdrop .modal-content .modal-close.button:hover {
  color: #fff;
  background: #1E824C;
}
.modal-container #modal-toggle:checked ~ .modal-backdrop .modal-content .modal-close:hover { color: #333; }

*{
font-family : helvetica ; 
}

</style>



<script
			  src="https://code.jquery.com/jquery-1.12.4.min.js"
			  integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ="
			  crossorigin="anonymous"></script>
			  
			     <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>




$(document).ready(function () {
    $("#delCookie").click(function(){
        del_cookie("cookie");   
    });
	
	var messageDispatcher = "<p style='color:orange'>Pour renforcer la sécurité de nos applications, l'option de la double authentification 2FA est appliquée, pour la désactiver il suffit de cliquer sur la case à cocher 'OTP' , elle sera renouveler de nouveau tout les 15 jours. <br> Merci de votre compréhension</p>" ; 
    
    console.log(document.cookie);
    var visit = getCookie("cookie");
    if (visit == null) {

           Swal.fire({
                    icon: "info",
                    title: "SERVICE GI-DEV<hr>" ,
                    html: messageDispatcher,
                    footer: '<a href="#">MESSAGE AUTOMATIQUE</a>'
                });
				
        var expire = new Date();
        expire = new Date(expire.getTime() + 360000000 );
		console.log("expiration"+expire) ; 
        document.cookie = "cookie=here; expires=" + expire;
    }
});

function del_cookie(name)
{
    document.cookie = name + '=; expires=Thu, 01 Jan 1970 00:00:01 GMT;';
}

function getCookie(c_name) {
    var c_value = document.cookie;
    var c_start = c_value.indexOf(" " + c_name + "=");
    if (c_start == -1) {
        c_start = c_value.indexOf(c_name + "=");
    }
    if (c_start == -1) {
        c_value = null;
    } else {
        c_start = c_value.indexOf("=", c_start) + 1;
        var c_end = c_value.indexOf(";", c_start);
        if (c_end == -1) {
            c_end = c_value.length;
        }
        c_value = unescape(c_value.substring(c_start, c_end));
    }
    return c_value;
}
</script>

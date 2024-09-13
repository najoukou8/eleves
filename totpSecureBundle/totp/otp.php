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
  max-width: 500px;
  width: 100%;
  height: 250px;
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

<button id="delCookie">DELETE COOKIE</button>

<div class="modal-container">
  <input id="modal-toggle" type="checkbox">
  <div class="modal-backdrop">
    <div class="modal-content">
      <label class="modal-close" for="modal-toggle">X</label>
      <h1 style='text-align:center ; color:red ; font-style:italic ;'>&#9888;  Informations de sécurité  </h1>
      
      <p style='font-style:italic'>Pour renfonrcer la sécurité de nos applications web
	   un nouveau système d'Authentification ( T-OTP ) va s'ajouter bientot au système classique CAS.<br>Pour anticiper cette solution merci de lire cette 
	    <a href='https://gricad-gitlab.univ-grenoble-alpes.fr/foukan/t-otp/-/wikis/TOTP-Pour-GI-2023'>documention</a> ;  temps de lecture ~ 1 mn 
	   </p>
      <label class="modal-close button" for="modal-toggle">Fermer</label>
    </div>
  </div>
</div>

<script
			  src="https://code.jquery.com/jquery-2.2.4.min.js"
			  integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="
			  crossorigin="anonymous"></script>
<script>

$(document).ready(function () {
    $("#delCookie").click(function(){
        del_cookie("cookie");   
    });
    
    console.log(document.cookie);
    var visit = getCookie("cookie");
    if (visit == null) {
	    $('#modal-toggle').click() ; 
        var expire = new Date();
        expire = new Date(expire.getTime() + 7776000000);
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
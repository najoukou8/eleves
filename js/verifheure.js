  // Original JavaScript code by Chirp Internet: www.chirp.com.au
  // Please acknowledge use of this code by including this header.

  function checkTime(field)
  {
    var errorMsg = "";

    // regular expression to match required time format
    re = /^(\d{1,2}):(\d{2})(:00)?([ap]m)?$/;

    if(field.value != '') {
      if(regs = field.value.match(re)) {
        if(regs[4]) {
          // 12-hour time format with am/pm
          if(regs[1] < 1 || regs[1] > 12) {
            errorMsg = "Valeur invalide pour les heures: " + regs[1];
          }
        } else {
          // 24-hour time format
          if(regs[1] > 23) {
            errorMsg = "Valeur invalide pour les heures: " + regs[1];
          }
        }
        if(!errorMsg && regs[2] > 59) {
          errorMsg = "Valeur invalide pour les minutes: " + regs[2];
        }
      } else {
        errorMsg = "Format heure invalide: " + field.value;
      }
    }

    if(errorMsg != "") {
      alert(errorMsg);
	  field.value='';
      field.focus();
      return false;
    }

    return true;
  }
$(function() {
  function validateRegistration()
  {
	if(!$("#usernameR").val()||!$("#passwordR").val()||!$("#emailR").val()){
		alert("Παρακαλώ, συμπληρώστε όλα τα στοιχεία εγγραφής");
		return false;
	}
  }
function validateLogin()
  {
	if(!$("#usernameL").val()||!$("#passwordL").val()){
		alert("Παρακαλώ, συμπληρώστε όλα τα στοιχεία σύνδεσης");
		return false;
	}
  }

function validateSearch()
  {
	if(!$("#searchi").val()){
		alert("Παρακαλώ, συμπληρώστε το πεδίο αναζήτησης");
		return false;
	}
  }

function validateSearchΤ()
  {
	if(!$("#txt1").val()){
		alert("Παρακαλώ, συμπληρώστε το πεδίο αναζήτησης");
		return false;
	}
  }

function validateUpload()
  {
	if(!$("#file2").val()||!$("#title2").val()||!$("#description").val()||!$("#position").val()){
		alert("Παρακαλώ, συμπληρώστε τα πεδία: αρχείο, τίτλος, περιγραφή, θέση");
		return false;
	}
  }



  $("#registerB").click(validateRegistration);

  $("#loginB").click(validateLogin);

  $("#searchB").click(validateSearch);

  $("#searchBT").click(validateSearchΤ);

  $("#uploadB").click(validateUpload);

});

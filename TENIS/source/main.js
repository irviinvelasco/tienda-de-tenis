function validateEmail(){
                
	// Get our input reference.
	var emailField = document.getElementById('user-email');
	var emailField = document.getElementById('user-email1');
	
	// Define our regular expression.
	var validEmail =  /^\w+([.-_+]?\w+)*@\w+([.-]?\w+)*(\.\w{2,10})+$/;

	// Using test we can check if the text match the pattern
	if( validEmail.test(emailField.value) ){
		alert('Email is valid, continue with form submission');
		return true;
	}else{
		alert('Email is invalid, skip form submission');
		return false;
	}
} 
function entrar(){
document.getElementById('c0').style.display = 'none';    
document.getElementById('c1').style.display = 'block';
}

function ocultar(){
document.getElementById('c2').style.display = 'block';
document.getElementById('c1').style.display = 'none';
}
function inicio(){
document.getElementById('c0').style.display = 'block';
document.getElementById('c1').style.display = 'none';    
document.getElementById('c2').style.display = 'none';
document.getElementById('c3').style.display = 'none';
document.getElementById('c4').style.display = 'none';    
    
}
function nosotros(){
document.getElementById('c0').style.display = 'none';
document.getElementById('c1').style.display = 'none';    
document.getElementById('c2').style.display = 'none';
document.getElementById('c3').style.display = 'block';
document.getElementById('c4').style.display = 'none';    
}
function contacto(){
document.getElementById('c0').style.display = 'none';
document.getElementById('c1').style.display = 'none';    
document.getElementById('c2').style.display = 'none';
document.getElementById('c3').style.display = 'none';
document.getElementById('c4').style.display = 'block';        
}

function validarPassword() {
  var password = document.getElementById("password").value;
  var regexMayuscula = /[A-Z]/;
  var regexMinuscula = /[a-z]/;
  var regexNumero = /[0-9]/;
  var regexCaracterEspecial = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/;

  if (password.length < 8) {
    document.getElementById("password-error").innerHTML = "La contraseña debe tener al menos 8 caracteres.";
  } else if (!regexMayuscula.test(password)) {
    document.getElementById("password-error").innerHTML = "La contraseña debe tener al menos una letra mayúscula.";
  } else if (!regexMinuscula.test(password)) {
    document.getElementById("password-error").innerHTML = "La contraseña debe tener al menos una letra minúscula.";
  } else if (!regexNumero.test(password)) {
    document.getElementById("password-error").innerHTML = "La contraseña debe tener al menos un número.";
  } else if (!regexCaracterEspecial.test(password)) {
    document.getElementById("password-error").innerHTML = "La contraseña debe tener al menos un carácter especial.";
  } else {
    document.getElementById("password-error").innerHTML = "";
  }
}

function validarFecha() {
  var fechaNacimiento = new Date(document.getElementById("fecha_nacimiento").value);
  var hoy = new Date();
  var edadMinima = new Date(hoy.getFullYear() - 18, hoy.getMonth(), hoy.getDate());

  if (fechaNacimiento > edadMinima) {
    document.getElementById("fecha_nacimiento").setCustomValidity("Debes tener al menos 18 años para registrarte.");
  } else {
    document.getElementById("fecha_nacimiento").setCustomValidity("");
  }
}

document.getElementById("fecha_nacimiento").addEventListener("input", validarFecha);


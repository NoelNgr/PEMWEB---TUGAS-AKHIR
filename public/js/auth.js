// auth.js
function togglePassword(fieldId) {
  const field = document.getElementById(fieldId);
  const toggle = field.nextElementSibling;

  if (field.type === "password") {
    field.type = "text";
    if (toggle) toggle.textContent = "Sembunyikan"; 
  } else {
    field.type = "password";
    if (toggle) toggle.textContent = "Tampilkan";
  }
}
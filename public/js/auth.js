const form = document.getElementById("registerForm");
const whatsapp = document.getElementById("whatsapp");
const waError = document.getElementById("wa-error");

const password = document.getElementById("registerPassword");
const pwError = document.getElementById("pw-error");

const fullname = document.getElementById("fullname");
const nameError = document.getElementById("name-error");

const MIN_DIGIT = 10;
const MAX_DIGIT = 15;
const MIN_PASSWORD = 8;

// Batasi input agar hanya angka dan max digit
whatsapp.addEventListener("input", function () {
    let value = whatsapp.value.replace(/[^0-9]/g, "");
    whatsapp.value = value.slice(0, MAX_DIGIT);
});

form.addEventListener("submit", function (e) {

    let valid = true;

    // Validasi Nama Lengkap
    const namePattern = /^[A-Za-z\s\-]+$/;

    if (!namePattern.test(fullname.value.trim())) {
        nameError.style.display = "block";
        valid = false;
    } else {
        nameError.style.display = "none";
    }


    // Validasi WhatsApp
    if (whatsapp.value.trim().length < MIN_DIGIT) {
        waError.style.display = "block";
        valid = false;
    } else {
        waError.style.display = "none";
    }

    // Validasi Password
    if (password.value.trim().length < MIN_PASSWORD) {
        pwError.style.display = "block";
        valid = false;
    } else {
        pwError.style.display = "none";
    }

    // Kalau salah satu tidak valid → cegah submit
    if (!valid) {
        e.preventDefault();
    }
});

// Toggle password
function togglePassword(fieldId) {
  const field = document.getElementById(fieldId);
  const toggle = field.nextElementSibling;

  if (field.type === "password") {
    field.type = "text";
    toggle.textContent = "Sembunyikan";
  } else {
    field.type = "password";
    toggle.textContent = "Tampilkan";
  }
}

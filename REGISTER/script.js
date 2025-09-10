function togglePassword(inputId) {
  const input = document.getElementById(inputId);
  if (input.type === "password") {
    input.type = "text";
  } else {
    input.type = "password";
  }
}

document.addEventListener("DOMContentLoaded", function () {
  const forms = document.querySelectorAll("form");

  forms.forEach((form) => {
    form.addEventListener("submit", function (e) {
      e.preventDefault();

      const inputs = form.querySelectorAll("input[required]");
      let valid = true;

      inputs.forEach((input) => {
        if (!input.value.trim()) {
          alert(`${input.placeholder} wajib diisi!`);
          valid = false;
        }
      });

      const checkbox = form.querySelector("input[type='checkbox']");
      if (checkbox && !checkbox.checked) {
        alert("Anda harus menyetujui Terms of Service!");
        valid = false;
      }

      if (valid) {
        alert("Form berhasil dikirim 🚀");
        form.reset();
      }
    });
  });
});

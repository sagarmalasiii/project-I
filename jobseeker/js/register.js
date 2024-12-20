// Bootstrap validation script
document.addEventListener("DOMContentLoaded", function () {
  const form = document.getElementById("registrationForm");

  form.addEventListener("submit", function (event) {
    // Custom validation for password match
    const password = document.getElementById("password");
    const confirmPassword = document.getElementById("confirmPassword");
    const checkbox = document.getElementById("myCheckbox");

    if (password.value !== confirmPassword.value) {
      confirmPassword.setCustomValidity("Passwords do not match");
      confirmPassword.reportValidity();
    } else {
      confirmPassword.setCustomValidity("");
    }
    if (!checkbox.checked) {
      alert("Checkbox is selected!");
    }

    form.classList.add("was-validated");
  });
});

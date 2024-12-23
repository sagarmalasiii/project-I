function validateField(field, regex, errorMsg) {
  const errorElement = document.getElementById(`${field.id}_error`);
  if (!regex.test(field.value)) {
    errorElement.textContent = errorMsg;
    return false;
  } else {
    errorElement.textContent = "";
    return true;
  }
}

function validateForm() {
  const companyName = document.getElementById("company_name");
  const email = document.getElementById("email");
  const username = document.getElementById("username");
  const password = document.getElementById("password");
  const confirmPassword = document.getElementById("confirm_password");

  const isCompanyNameValid = validateField(
    companyName,
    /\S+/,
    "Company Name is required."
  );
  const isEmailValid = validateField(
    email,
    /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
    "Please enter a valid email address."
  );
  const isUsernameValid = validateField(
    username,
    /\S+/,
    "Username is required."
  );
  const isPasswordValid = validateField(
    password,
    /.{6,}/,
    "Password must be at least 6 characters long."
  );
  const isConfirmPasswordValid = validateField(
    confirmPassword,
    new RegExp(`^${password.value}$`),
    "Passwords do not match."
  );

  return (
    isCompanyNameValid &&
    isEmailValid &&
    isUsernameValid &&
    isPasswordValid &&
    isConfirmPasswordValid
  );
}

function addRealTimeValidation() {
  document.getElementById("full_name").addEventListener("input", (e) => {
    validateField(e.target, /\S+/, "Full Name is required.");
  });
  document.getElementById("email").addEventListener("input", (e) => {
    validateField(
      e.target,
      /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
      "Please enter a valid email address."
    );
  });
  document.getElementById("username").addEventListener("input", (e) => {
    validateField(e.target, /\S+/, "Username is required.");
  });
  document.getElementById("password").addEventListener("input", (e) => {
    validateField(
      e.target,
      /.{6,}/,
      "Password must be at least 6 characters long."
    );
  });
  document.getElementById("confirm_password").addEventListener("input", (e) => {
    const password = document.getElementById("password");
    validateField(
      e.target,
      new RegExp(`^${password.value}$`),
      "Passwords do not match."
    );
  });
}

window.onload = addRealTimeValidation;

const loginForm = document.querySelector("#login-form");
const loginContainer = document.querySelector("#login-container");
const registerForm = document.querySelector("#register-form");
const registerContainer = document.querySelector("#register-container");

function OpenloginModal() {
  if (loginForm.classList.contains("active-modal")) {
    return;
  }
  loginForm.classList.add("active-modal");
}

function CloseloginModal() {
  if (!loginForm.classList.contains("active-modal")) {
    return;
  }
  loginContainer.classList.add("animate-out");
  setTimeout(() => {
    loginForm.classList.remove("active-modal");
    loginContainer.classList.remove("animate-out");
  }, 500);
}

function OpenregisterModal() {
  CloseloginModal();
  setTimeout(() => {
    registerForm.classList.add("active-modal");
  }, 500);
}

function CloseregisterModal() {
  if (!registerForm.classList.contains("active-modal")) {
    return;
  }
  registerContainer.classList.add("animate-out");
  setTimeout(() => {
    registerForm.classList.remove("active-modal");
    registerContainer.classList.remove("animate-out");
  }, 500);
}
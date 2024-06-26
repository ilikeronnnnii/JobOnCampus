const container = document.getElementById("container");
const registerBtn = document.getElementById("register");
const loginBtn = document.getElementById("login");

registerBtn.addEventListener("click", () => {
  container.classList.add("active");
});

loginBtn.addEventListener("click", () => {
  container.classList.remove("active");
});

const emailError = document.getElementById('emailError').textContent;
const passwordError = document.getElementById('passwordError').textContent;

if (emailError) {
    document.getElementById('email').classList.add('error');
}

if (passwordError) {
    document.getElementById('password').classList.add('error');
}
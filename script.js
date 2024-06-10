const container = document.getElementById("container");
const registerBtn = document.getElementById("register");
const loginBtn = document.getElementById("login");

registerBtn.addEventListener("click", () => {
  container.classList.add("active");
});

loginBtn.addEventListener("click", () => {
  container.classList.remove("active");
});

document.addEventListener("DOMContentLoaded", function () {
  document
    .getElementById("signInButton")
    .addEventListener("click", function (event) {
      event.preventDefault(); // Prevent the form from submitting
      window.location.href = "careers.html"; // Redirect to the new HTML page
    });
});

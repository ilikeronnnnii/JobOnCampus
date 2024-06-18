document.addEventListener("DOMContentLoaded", function () {
  const container = document.getElementById("container");
  const registerBtn = document.getElementById("register");
  const loginBtn = document.getElementById("login");

  registerBtn.addEventListener("click", () => {
    container.classList.add("active");
  });

  loginBtn.addEventListener("click", () => {
    container.classList.remove("active");
  });

  // Cookie handling logic
  const cookies = document.cookie.split(";");
  let status = null;
  cookies.forEach((cookie) => {
    const [name, value] = cookie.trim().split("=");
    if (name === "status") {
      status = value;
    }
  });
  if (status === "error") {
    alert("An error occurred during registration. Please try again.");
  } else if (status === "success") {
    alert("Registration successful!");
  }
  // Clear the status cookie after displaying the message
  document.cookie = "status=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
});

var modal = document.getElementById("jobModal");
var span = document.getElementsByClassName("close")[0];

var jobs = document.querySelectorAll(".job");
jobs.forEach(function (job) {
  job.addEventListener("click", function () {
    console.log("button clicked");
    var companyName = job.querySelector(".company-title").textContent;
    document.getElementById("companyName").textContent = companyName;
    // Populate job positions dynamically if needed
    modal.style.display = "block";
  });
});

span.onclick = function () {
  modal.style.display = "none";
};

window.onclick = function (event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
};

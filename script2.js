document.addEventListener("DOMContentLoaded", function () {
  console.log("Document is ready");

  // Example of changing sidebar color dynamically
  const sidebar = document.querySelector(".sidebar");
  sidebar.style.backgroundColor = "#e0e0e0"; // Change to desired color
});

/*+*/

document.addEventListener("DOMContentLoaded", function () {
  const eventCards = document.querySelectorAll(".event-card");
  const popup = document.getElementById("popup");

  eventCards.forEach(function (card) {
    card.addEventListener("click", function () {
      // tukar display of popup
      popup.style.display = popup.style.display === "block" ? "none" : "block";
    });
  });

  // Close popup bila "Done"
  const doneButton = document.querySelector(".done");
  doneButton.addEventListener("click", function () {
    popup.style.display = "none";
  });
});

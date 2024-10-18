document.addEventListener("DOMContentLoaded", function () {

  // FAQ Accordions
  const accordions = document.querySelectorAll(".accordion");
  accordions.forEach((accordion) => {
    const question = accordion.querySelector(".question");
    const arrow = accordion.querySelector(".arrow");
    const answer = accordion.querySelector(".answer");

    question.addEventListener("click", () => {
      const isActive = accordion.classList.contains("active");

      accordions.forEach((acc) => {
        acc.classList.remove("active");
        acc.querySelector(".arrow").classList.remove("active");
        acc.querySelector(".answer").style.maxHeight = null;
      });

      if (!isActive) {
        accordion.classList.add("active");
        arrow.classList.add("active");
        answer.style.maxHeight = answer.scrollHeight + "px";
      } else {
        accordion.classList.remove("active");
        arrow.classList.remove("active");
        answer.style.maxHeight = null;
      }
    });
  });

  // Clock
  function updateClock() {
    const clockElements = document.querySelectorAll(".clock");
    const now = new Date();
    const hours = now.getHours().toString().padStart(2, "0");
    const minutes = now.getMinutes().toString().padStart(2, "0");
    const seconds = now.getSeconds().toString().padStart(2, "0");

    clockElements.forEach((clockElement) => {
      clockElement.textContent = `${hours}:${minutes}:${seconds}`;
    });
  }

  setInterval(updateClock, 1000); // Update the clock every second
  updateClock(); // Initial call to display the clock immediately


  // Attach click event listener to each product card
  var productCards = document.querySelectorAll(".card");
  productCards.forEach(function (card) {
    card.addEventListener("click", function () {
      var productInfo = this.querySelector(".sci").innerHTML;
      var imageUrl = this.querySelector(".imgBx img").src;
    });
  });

  // Combo box state
  var states = [
    "Johor", "Kedah", "Kelantan", "Melaka", "Negeri Sembilan", "Pahang",
    "Perak", "Perlis", "Penang", "Sabah", "Sarawak", "Selangor", "Terengganu",
    "Wilayah Persekutuan Kuala Lumpur", "Wilayah Persekutuan Labuan",
    "Wilayah Persekutuan Putrajaya"
  ];

  var stateInput = document.getElementById("stateInput");
  if (stateInput) {
    var datalist = document.createElement("datalist");
    datalist.id = "states";

    states.forEach(function (state) {
      var option = document.createElement("option");
      option.value = state;
      datalist.appendChild(option);
    });

    stateInput.setAttribute("list", "states");
    stateInput.parentNode.appendChild(datalist);

    // Initialize Select2 on the state input field
    $("#stateInput").select2({
      placeholder: "Select a state",
      width: "100%",
      theme: "bootstrap4",
      dropdownAutoWidth: true,
      data: states.map(function (state) {
        return { id: state, text: state };
      }),
      matcher: function (params, data) {
        // If there are no search terms, return all options
        if ($.trim(params.term) === "") {
          return data;
        }

        // Check if the option starts with the search term
        if (data.text.toUpperCase().indexOf(params.term.toUpperCase()) === 0) {
          return data;
        }

        // If the option does not match, do not include it
        return null;
      },
    });
  }
});

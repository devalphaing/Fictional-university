document.addEventListener("DOMContentLoaded", function () {
  let isOverlayOpen = false;
  let isSpinnerRunning = false;
  let inputValue = "";

  // Get all elements with the class .js-search-trigger
  var searchTriggers = document.querySelectorAll(".js-search-trigger");

  //reference to input search box
  const inputRef = document.querySelector(".search-term");

  //result div
  const resultsDiv = document.querySelector("#search-overlay__results");

  // Get the search overlay element
  var searchOverlay = document.querySelector(".search-overlay");

  // Get the close button element within the search overlay
  var closeOverlay = document.querySelector(".search-overlay__close");

  // Add event listener to each search trigger element
  searchTriggers.forEach(function (searchTrigger) {
    searchTrigger.addEventListener("click", function () {
      // Toggle the search-overlay__active class
      searchOverlay.classList.add("search-overlay--active");
      document.body.classList.add("body-no-scroll");
      isOverlayOpen = true;
    });
  });

  // Add event listener to the close button within the search overlay
  closeOverlay.addEventListener("click", function () {
    // Remove the search-overlay--active class to close the overlay
    searchOverlay.classList.remove("search-overlay--active");
    document.body.classList.remove("body-no-scroll");
    isOverlayOpen = false;
  });

  document.addEventListener("keydown", function (event) {
    if (event.keyCode === 83 && !isOverlayOpen && !isInputFocused()) {
      searchOverlay.classList.add("search-overlay--active");
      document.body.classList.add("body-no-scroll");
      isOverlayOpen = true;
    }
    // Check if the Esc key is pressed
    if (event.keyCode === 27 && isOverlayOpen) {
      searchOverlay.classList.remove("search-overlay--active");
      document.body.classList.remove("body-no-scroll");
      isOverlayOpen = false;
    }
  });

  let timeTyper;

  inputRef.addEventListener("input", (event) => {
    clearTimeout(timeTyper);

    if (event.target.value === "") {
      isSpinnerRunning = false;
      inputValue = event.target.value;
      resultsDiv.innerHTML = "";
    } else {
      inputValue = event.target.value;
      if (!isSpinnerRunning) {
        resultsDiv.innerHTML = '<div class="spinner-loader"></div>';
        isSpinnerRunning = true;
      }
      timeTyper = setTimeout(() => {
        resultsDiv.innerHTML = "<div>Results will come here...</div>";
        isSpinnerRunning = false;
      }, 2000);
    }
  });

  //check input box is focused
  function isInputFocused() {
    return (
      document.activeElement.tagName === "INPUT" ||
      document.activeElement.tagName === "TEXTAREA"
    );
  }
});

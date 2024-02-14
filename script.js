document.addEventListener("DOMContentLoaded", function () {

  document.body.insertAdjacentHTML('beforeend', `
    <div class="search-overlay">
    <div class="search-overlay__top">
      <div class="container">
        <i class="fa fa-search search-overlay__icon" aria-hidden="true"></i>
        <input type="text" class="search-term" placeholder="What are you looking for?" id="search-item">
        <i class="fa fa-window-close search-overlay__close" aria-hidden="true"></i>
      </div>
    </div>
  
    <div class="container">
      <div id="search-overlay__results"></div>
    </div>
  </div>
`)

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
      setTimeout(() => {
        inputRef.focus();
      }, 301)
    });
  });

  // Add event listener to the close button within the search overlay
  closeOverlay.addEventListener("click", function () {
    // Remove the search-overlay--active class to close the overlay
    searchOverlay.classList.remove("search-overlay--active");
    document.body.classList.remove("body-no-scroll");
    inputRef.value = '';
    isOverlayOpen = false;
  });

  document.addEventListener("keydown", function (event) {
    if (event.keyCode === 83 && !isOverlayOpen && !isInputFocused()) {
      searchOverlay.classList.add("search-overlay--active");
      document.body.classList.add("body-no-scroll");
      setTimeout(() => {
        inputRef.focus();
      }, 301)
      isOverlayOpen = true;
    }
    // Check if the Esc key is pressed
    if (event.keyCode === 27 && isOverlayOpen) {
      searchOverlay.classList.remove("search-overlay--active");
      document.body.classList.remove("body-no-scroll");
      inputRef.value = '';
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
      timeTyper = setTimeout(async () => {
        try {

          //delete below code later on
          const promises = [
            axios.get(`${universityData.root_url}/wp-json/wp/v2/posts?search=${inputValue}`),
            axios.get(`${universityData.root_url}/wp-json/wp/v2/pages?search=${inputValue}`)
          ];
      
          // Execute all promises concurrently
          const [resDataPosts, resDataPages] = await Promise.all(promises);

          const resData = resDataPosts.data.concat(resDataPages.data);
          console.log(resData, ' data ----');

          let html = `
            <h2 class="search-overlay__section-title">Search Results:</h2>
          `;

          html += resData.length ? `<ul class="link-list min-list">` : '<p>No Information Found!</p>';

          resData.forEach((data) => {
            html += `
              <li>
                <a href="${data?.link}">
                  ${data?.title?.rendered}
                </a>
                ${data?.type === 'post' ? 'by ' + data?.authorName : ''}
              </li>
            `;
          });
          html += resData.length ? `</ul>`: '';
          resultsDiv.innerHTML = html;
        } catch (err) {
          console.error(err);
          resultsDiv.innerHTML = '<h2 class="search-overlay__section-title">Error</h2>';
        }
        isSpinnerRunning = false;
      }, 750);
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

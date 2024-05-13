/**
 * script used to make the search button functional in the navbar
 * the user enters a cnp and is redirected to the search result with said inmate (if it exists in our db)
 */
const searchInput = document.getElementById('searchInput');
console.log(searchInput);
searchInput.addEventListener('keydown', (event) => {
    if (event.key === 'Enter') {
      const searchTerm = searchInput.value;
      const url = "searchpage/getInfo?prisoner-cnp=" + searchTerm;
      window.location.href = url;
    }
});
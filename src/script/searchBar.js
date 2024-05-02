const searchInput = document.getElementById('searchInput');
console.log(searchInput);
searchInput.addEventListener('keydown', (event) => {
    if (event.key === 'Enter') {
      const searchTerm = searchInput.value;
      console.log(searchTerm);
    }
});
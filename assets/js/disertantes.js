const searchbox = document.getElementById('query-disertante');

searchbox.addEventListener('input', event => {
  let searchQuery = event.target.value;

  queryDisertante(searchQuery);
});

function queryDisertante(searchQuery) {
  const disertantes = document.querySelectorAll('.disertante');
  const searchQueryLower = searchQuery.toLowerCase();

  disertantes.forEach(element => {
    element.classList.remove('d-block');
    element.classList.add('d-none');

    let toSearch = element.textContent.toLowerCase();

    if (toSearch.includes(searchQueryLower)) {
      element.classList.add('d-block');
      element.classList.remove('d-none');
    }
  })
}
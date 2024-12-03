const searchbox = document.getElementById('query-disertante');

searchbox.addEventListener('input', event => {
  let searchQuery = event.target.value;

  queryDisertante(searchQuery);
});

function queryDisertante(searchQuery) {
  const disertantes = document.querySelectorAll('.disertante');

  disertantes.forEach(element => {
    element.classList.remove('d-block');
    element.classList.add('d-none');

    if (element.textContent.includes(searchQuery)) {
      element.classList.add('d-block');
      element.classList.remove('d-none');
    }
  })
}
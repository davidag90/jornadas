const selCat = document.getElementById('cat_inscripcion');

selCat.addEventListener('change', createOrderURL);

function createOrderURL(event) {
    let variationID = event.target.value;
    let orderURL = CHECKOUT_URL + variationID;
    
    const btnPreOrder = document.getElementById('btn_pre_order');    
     
    btnPreOrder.setAttribute('href', orderURL);
    
    if (variationID != '') {
        btnPreOrder.classList.remove('disabled');
    } else {
        btnPreOrder.classList.add('disabled');
    }
}

const tableArancelesWrapper = document.getElementById('aranceles-table');
const tableAranceles = document.querySelector('#aranceles-table > table');

tableArancelesWrapper.setAttribute('class', 'w-100');
tableAranceles.classList.remove('has-fixed-layout');
tableAranceles.classList.add('table');
tableAranceles.classList.add('table-light');

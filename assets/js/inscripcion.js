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

const styleTables = () => {
    const tableArancelesWrapper = document.querySelector('.aranceles-table');
    const tableAranceles = document.querySelector('.aranceles-table > table');
    const tableArancelesHeads = document.querySelector('.aranceles-table > table > thead');
    
    tableArancelesWrapper.setAttribute('class', 'w-100');
    tableAranceles.classList.remove('has-fixed-layout');
    tableAranceles.classList.add('table', 'table-light', 'table-striped');
    tableArancelesHeads.classList.add('table-dark');
};

document.addEventListener('DOMContentLoaded', styleTables);
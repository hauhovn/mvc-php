const ingSection = document.getElementById('ingredient-section');
const addBtn = ingSection.querySelector('#add');
const editBtn = ingSection.querySelector('#edit');
const deleteBtn = ingSection.querySelector('#delete');
const table = ingSection.querySelector('#ing-table');
const rows = ingSection.querySelectorAll('.ing-tr');
const numOfRowsInfo = ingSection.querySelector('#num-of-row-selected');
const numOfRowAddInput = ingSection.querySelector('#num-of-row-input');
const addRowTable = ingSection.querySelector('#add-ing-table');

var rowsSelected = [];

addBtn.onclick = (e) => {
    renderAddNewTable(numOfRowAddInput.value);
};

editBtn.onclick = (e) => {
    console.table(rowsSelected);
};

deleteBtn.onclick = (e) => {
    console.log('deleteBtn clicked');
    console.log(typeof (rows));
    console.log(rows.length);
};

// listen rows clicked
rows.forEach((row) => {
    row.onclick = () => {
        if (row.classList.contains('active')) {
            row.classList.remove('active');
            rowsSelected.splice(rowsSelected.indexOf(row.id), 1);
        } else {
            row.classList.add('active');
            rowsSelected.push(row.id);
        }
        numOfRowsInfo.textContent = rowsSelected.length;
    }
})

// định dạng các số với dấu phân cách hàng ngàn
function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}
document.addEventListener('DOMContentLoaded', (event) => {
    const numberElements = document.querySelectorAll('.td-price, .td-total_price');
    numberElements.forEach(element =>
        element.textContent = numberWithCommas(element.textContent));
})

function renderAddNewTable(rows = 1, cols = ['name', 'inventory', 'price', 'unit', 'toal_price']) {
    // Kiem tra co ton tai hay tbody khong
    const tbody = addRowTable.querySelector('tbody')
        ? addRowTable.querySelector('tbody')
        : document.createElement('tbody');
    do {
        const tr = document.createElement('tr');
        cols.forEach(col => {
            const td = document.createElement('td');
            td.classList.add(`td-${col}`);
            const input = document.createElement('input');
            input.classList.add(`td-inp-${col}`);
            // Them input -> td
            td.appendChild(input);
            // Them td -> tr
            tr.appendChild(td);
        })
        tbody.appendChild(tr);
        rows--;
    } while (rows > 0)
    if (addRowTable) {
        addRowTable.appendChild(tbody);
    } else {
        console.error('Element with ID "add-ing-table" not found.');
    }
}
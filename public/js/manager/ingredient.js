const ingSection = document.getElementById('ingredient-section');
const addBtn = ingSection.querySelector('#add');
const editBtn = ingSection.querySelector('#edit');
const deleteBtn = ingSection.querySelector('#delete');
const confirmBtn = ingSection.querySelector('#confirm');
const table = ingSection.querySelector('#ing-table');
const ingRows = ingSection.querySelectorAll('.ing-tr');
const numOfRowsInfo = ingSection.querySelector('#num-of-row-selected');
const numOfRowAddInput = ingSection.querySelector('#num-of-row-input');
const addRowTable = ingSection.querySelector('#add-ing-table');

var rowsSelected = [];
var isEdit = false;
const VIEW_TABLE_FORM = {
    id: {
        value: 'id',
        display: 'ID',
        tagName: 'span',
        className: 'td-view-id',
    },
    name: {
        value: 'name',
        display: 'Name',
        tagName: 'span',
        className: 'td-view-name',
    },
    inventory: {
        value: 'inventory',
        display: 'Inventory',
        tagName: 'span',
        className: 'td-view-inventory',
    },
    price: {
        value: 'price',
        display: 'Price',
        tagName: 'span',
        className: 'td-view-price',
    },
    unit: {
        value: 'unit',
        display: 'Unit',
        tagName: 'span',
        className: 'td-view-unit',
    },
    total: {
        value: 'total',
        display: 'Total',
        tagName: 'span',
        className: 'td-view-total',
    },

}

// DOMContentLoaded
const myApp = () => {
    getIngListData().then(data => {
        renderIngTable(data);
        caculatorSumColumns();
        formatNumberRow();
    });
}
myApp();
// Lắng nghe tương tác các nút chức năng
addBtn.onclick = (e) => {
    renderAddNewTable(numOfRowAddInput.value);
    !addRowTable.classList.contains('active') && addRowTable.classList.add('active');
};

editBtn.onclick = (e) => {
    isEdit = !isEdit;
    removeAddIngTalbe();
    // console.table(rowsSelected);
    // rowsSelected.forEach(r=>{
    //     console.log(getDataRowById(r));
    // })
    console.log(rowsSelected);
    renderAddNewTable(undefined, ['id', 'name', 'inventory', 'price', 'unit'], rowsSelected);
    !addRowTable.classList.contains('active') && addRowTable.classList.add('active');
};

deleteBtn.onclick = (e) => {

    console.log(readAddTable());;
};

confirmBtn.onclick = async (e) => {
    if (isEdit) {
        console.log(readAddTable());
        isEdit = !isEdit;
    } else {
        const newRows = readAddTable();
        if (newRows.length <= 0 || !checkRequiredFields()) { return; }
        newRows.forEach(row => {
            let insertRow = insertIngredient(row);
            if (!insertRow) {
                console.error('Error:', insertRow);
                alert('Lỗi: ', insertRow)
            }
        })
        alert(`Đã thêm thành công ${newRows.length} nguyên liệu mới`);
        myApp();
    }
};

// Call api
async function insertIngredient(row) {
    await fetch('/api/ingredient', {
        method: 'post',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(row)
    }).catch(err => { return err });
}
async function getIngListData() {
    const response = await fetch("/api/ingredient");
    const ingredients = await response.json();
    return ingredients;
}


// FUNCTIONs
function hightlightRowSelected(row) {
    row.onclick = () => {
        if (row.classList.contains('active')) {
            row.classList.remove('active');
            rowsSelected.splice(rowsSelected.indexOf(row.id), 1);
        } else {
            row.classList.add('active');
            rowsSelected.push(getDataRowById(row));
        }
        numOfRowsInfo.textContent = rowsSelected.length;
    }
}
// định dạng các số với dấu phân cách hàng ngàn
function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

function loadIngredientTable() {
    getIngListData().then(data => renderIngTable(data));
}
// Render talbe
function renderIngTable(rows = [], cols = ['id', 'name', 'inventory', 'price', 'unit', 'total_price']) {
    // RENDER BODY
    const tbody = table.querySelector('tbody');
    tbody.innerHTML = '';
    rows.forEach((row) => {
        const tr = document.createElement('tr');
        tr.classList.add('ing-tr');
        tr.id = `tr-${row.id}`;
        cols.forEach(col => {
            const td = document.createElement('td');
            td.classList.add(col);
            td.textContent = row[col];
            tr.appendChild(td);
        });
        tr.addEventListener('click', hightlightRowSelected(tr));
        tbody.append(tr);
    });
    table.appendChild(tbody);
}

// Add row
function renderAddNewTable(_rows = 1, cols = ['name', 'inventory', 'price', 'unit'], data = []) {
    // CAPTION
    const caption = addRowTable.getElementsByTagName('caption')[0];
    caption.textContent = isEdit ? 'Edit below content' : 'Add ingredients table info';

    //RENDER HEAD
    const thead = addRowTable.querySelector('thead');
    thead.innerHTML = '';
    const tr = document.createElement('tr');
    cols.forEach(col => {
        const td = document.createElement('td');
        td.textContent = col;
        td.classList.add(`table-head`);
        // td.classList.add(col);
        tr.appendChild(td);
    });
    thead.appendChild(tr);
    addRowTable.appendChild(thead);


    //RENDER BODY
    const tbody = addRowTable.querySelector('tbody');
    // Set rows
    const rows = data.length > 0 ? data.length : _rows;
    for (let i = 0; i < rows; i++) {
        const tr = document.createElement('tr');
        if (data[i]?.id) { tr.id = `tr-edit-${data[i]?.id}` };
        cols.forEach(col => {
            const td = document.createElement('td');
            td.classList.add(col);
            const input = document.createElement('input');
            input.classList.add(`td-inp-${col}`);
            input.setAttribute('required', true);
            input.setAttribute("editable", false);
            //
            input.value = data.length > 0 ? data[i][col] : '';
            // Them input -> td
            td.appendChild(input);
            // Them td -> tr
            tr.appendChild(td);
        })
        tbody.appendChild(tr);
    }
    addRowTable.appendChild(tbody);


    // v1
    // const tbody = addRowTable.querySelector('tbody');
    // do {
    //     const tr = document.createElement('tr');
    //     cols.forEach(col => {
    //         const td = document.createElement('td');
    //         td.classList.add(col);
    //         const input = document.createElement('input');
    //         input.classList.add(`td-inp-${col}`);
    //         input.setAttribute('required', true);
    //         // Them input -> td
    //         td.appendChild(input);
    //         // Them td -> tr
    //         tr.appendChild(td);
    //     })
    //     tbody.appendChild(tr);
    //     rows--;
    // } while (rows > 0)
    // addRowTable.appendChild(tbody);
}
function formatNumberRow() {
    const numberElements = table.querySelectorAll('.inventory, .price, .total_price');
    numberElements.forEach(element =>
        element.textContent = numberWithCommas(element.textContent));
}
function caculatorSumColumns() {
    const invenCol = table.querySelector('#sum-inventory');
    const priceCol = table.querySelector('#sum-price');
    const totalCol = table.querySelector('#sum-total');

    const invRows = table.querySelectorAll('.inventory');
    const priRows = table.querySelectorAll('.price');
    const totRows = table.querySelectorAll('.total_price');
    let invVal = 0;
    let priVal = 0;
    let totVal = 0;
    invRows.forEach(inv => invVal += parseFloat(inv.textContent));
    priRows.forEach(inv => priVal += parseFloat(inv.textContent));
    totRows.forEach(inv => totVal += parseFloat(inv.textContent));

    invenCol.textContent = numberWithCommas(invVal);
    priceCol.textContent = numberWithCommas(priVal);
    totalCol.textContent = numberWithCommas(totVal);

}

function readAddTable(_table = 0) {
    // Tim ra so dong
    const rowsData = [];
    const body = addRowTable.getElementsByTagName('tbody')[0];
    if (!body) { return rowsData; }
    const rows = body.getElementsByTagName('tr');
    Array.from(rows).forEach(row => {
        let rowData = {};
        const cols = row.getElementsByTagName('td');
        Array.from(cols).forEach(((col) => {
            rowData[col.className] = col.getElementsByTagName('input')[0].value;
        }))
        // Thêm rowData vào rowsData
        rowsData.push(rowData);
    });
    return rowsData;
}
function checkRequiredFields() {
    const body = addRowTable.getElementsByTagName('tbody')[0];
    const rows = body.getElementsByTagName('tr');
    let allFieldsFilled = true;

    Array.from(rows).forEach(row => {
        const cols = row.getElementsByTagName('td');
        Array.from(cols).forEach(col => {
            const input = col.querySelector('input'); // Sử dụng querySelector để chọn phần tử input đầu tiên
            if (input && input.hasAttribute('required') && !input.value.trim()) {
                allFieldsFilled = false; // Sửa tên biến từ allInputsValid thành allFieldsFilled
                // Nếu input không hợp lệ, thêm class 'invalid' để áp dụng CSS
                input.classList.add('invalid');
            } else {
                // Nếu input hợp lệ, xóa class 'invalid'
                input.classList.remove('invalid');
            }
        });
    });

    return allFieldsFilled;

}
function removeAddIngTalbe() {
    const body = addRowTable.getElementsByTagName('tbody')[0];
    addRowTable.classList.remove('active');
    body.innerHTML = '';
}

function getDataRowById(row) {
    let result = {};
    Array.from(row.children)
        .forEach(chil => result[chil?.className] = chil?.textContent)
    return result;
}
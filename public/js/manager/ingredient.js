const ingSection = document.getElementById('ingredient-section');
const addBtn = ingSection.querySelector('#add');
const editBtn = ingSection.querySelector('#edit');
const deleteBtn = ingSection.querySelector('#delete');
const confirmBtn = ingSection.querySelector('#confirm');
const table = ingSection.querySelector('#ing-table');
const rows = ingSection.querySelectorAll('.ing-tr');
const numOfRowsInfo = ingSection.querySelector('#num-of-row-selected');
const numOfRowAddInput = ingSection.querySelector('#num-of-row-input');
const addRowTable = ingSection.querySelector('#add-ing-table');

var rowsSelected = [];

addBtn.onclick = (e) => {
    renderAddNewTable(numOfRowAddInput.value);
    if (rowsSelected.length > 0) {
        !addRowTable.classList.contains('active') && addRowTable.classList.add('active');
    } addRowTable.classList.add('active')
};

editBtn.onclick = (e) => {
};

deleteBtn.onclick = (e) => {

    console.log(readAddTable());;
};

confirmBtn.onclick = async (e) => {
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
    removeAddIngTalbe();
    //Force a hard reload to clear the cache if supported by the browser
    window.location.reload(true);
};

async function insertIngredient(row) {
    await fetch('/api/ingredient', {
        method: 'post',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(row)
    }).catch(err => { return err });
}

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
    caculatorSumColumns();
    const numberElements = document.querySelectorAll('.price, .total_price');
    numberElements.forEach(element =>
        element.textContent = numberWithCommas(element.textContent));
})

function renderAddNewTable(rows = 1, cols = ['name', 'inventory', 'price', 'unit']) {
    // Kiem tra co ton tai hay tbody khong
    const tbody = addRowTable.querySelector('tbody')
        ? addRowTable.querySelector('tbody')
        : document.createElement('tbody');
    do {
        const tr = document.createElement('tr');
        cols.forEach(col => {
            const td = document.createElement('td');
            td.classList.add(col);
            const input = document.createElement('input');
            input.classList.add(`td-inp-${col}`);
            input.setAttribute('required', true);
            // Them input -> td
            td.appendChild(input);
            // Them td -> tr
            tr.appendChild(td);
        })
        tbody.appendChild(tr);
        rows--;
    } while (rows > 0)
    addRowTable.appendChild(tbody);
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
    body.remove();
}
// Truy xuất dữ liệu JSON từ phần tử ẩn trong DOM
var tableDataText = document.getElementById('table-data').textContent;
var tableConfigText = document.getElementById('table-config').textContent;
var tableData, tableConfig;

try {
    tableData = JSON.parse(tableDataText).data;
    tableConfig = JSON.parse(tableConfigText);
} catch (e) {
    console.error('Error parsing JSON data:', e);
    tableData = [];
    tableConfig = { columns: [] };
}
console.log(`table: `,tableData);
// Kiểm tra nếu tableData là một mảng và có ít nhất một phần tử
if (Array.isArray(tableData) && tableData.length > 0) {
    // Tạo bảng và thêm tiêu đề
    var table = document.getElementById(tableConfig.table_name);
    var thead = document.createElement('thead');
    var headerRow = document.createElement('tr');

    tableConfig.columns.forEach(function(column) {
        var th = document.createElement('th');
        th.textContent = column.display;
        headerRow.appendChild(th);
    });
    thead.appendChild(headerRow);
    table.appendChild(thead);

    // Thêm phần thân của bảng (có thể làm tương tự với dữ liệu thực)
    var tbody = document.createElement('tbody');
    // Thêm dòng nhập liệu
    // bấm nút -> tạo dòng 
    // bấm nút -> thêm dữ liệu

    tableData.forEach(function(row) {
        // create a data row
        var dataRow = document.createElement('tr');
        dataRow.id=row[tableConfig.columns[0].id];
        tableConfig.columns.forEach(function(column){
            // create a data item
            var td = document.createElement('td');
            // set value to item
            td.textContent = row[column.id];
            // add item to row
            dataRow.appendChild(td);
        })
        // add row to table body
        tbody.appendChild(dataRow);
    });
    table.appendChild(tbody);

  } else {
    console.error('Invalid JSON data or no data available.');
}

const addInputRow = () => {
    let tr = document.createElement('tr');
    tr.classList.add('new-row')
    tableConfig.columns.forEach((item)=>{
        let td = document.createElement('td');
        let input = document.createElement('input');
        input.placeholder=item.display;
        td.appendChild(input);
        tr.appendChild(td);
    });
    // Lấy hàng đầu tiên trong phần tbody
    let firstRow = tbody.firstChild;
    // Chèn dòng mới vào trước hàng đầu tiên
    tbody.insertBefore(tr, firstRow);
}
document.getElementById(tableConfig.add_input_row_btn_id).onclick = addInputRow;

// Hàm xử lý sự kiện paste
function handlePaste(event) {
    // Ngăn chặn hành động mặc định của sự kiện paste
    event.preventDefault();

    // Lấy dữ liệu dán từ clipboard
    var clipboardData = event.clipboardData || window.clipboardData;
    var pastedData = clipboardData.getData('text');
    console.log(pastedData);

    // Tách dữ liệu thành các dòng
    var rows = pastedData.split('\n');

    // Thêm dữ liệu vào các ô input trong hàng trống
    var newRow = table.insertRow(0);
     // Chú ý: Sử dụng insertRow(0) để thêm vào đầu tiên
    rows.forEach(function(rowData) {
        var cells = rowData.split('\t'); // Giả sử dữ liệu được ngăn cách bằng tab trong Excel
        cells.forEach(function(cellData) {
            var cell = newRow.insertCell();
            cell.textContent = cellData;
        });
    });
}

// Gắn sự kiện paste vào bảng
table.addEventListener('paste', handlePaste);

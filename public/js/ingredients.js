const table = document.getElementById('ingredient-table');
const rows = table.querySelectorAll('tr');

rows.forEach((row, index) => {
    if (index === 0) return; // Bỏ qua hàng tiêu đề
    row.addEventListener('click', function(e) {
       alert(row.id);
    });
});

const ingSection = document.getElementById('ingredient-section');
const addBtn = ingSection.querySelector('#add');
const editBtn = ingSection.querySelector('#edit');
const deleteBtn = ingSection.querySelector('#delete');
const table = ingSection.querySelector('#ing-table');
const rows = ingSection.querySelectorAll('.ing-tr');
const numOfRowsInfo = ingSection.querySelector('#num-of-row-selected');
const numOfRowAddInput = ingSection.querySelector('#num-of-row-input');

var rowsSelected = [];

addBtn.onclick = (e)=>{
    console.log(`add ${numOfRowAddInput.value} rows`);
};

editBtn.onclick = (e)=>{
    console.table(rowsSelected);
};

deleteBtn.onclick = (e)=>{
    console.log('deleteBtn clicked');
    console.log(typeof(rows));
    console.log(rows.length);
};

// listen rows clicked
rows.forEach((row)=>{
    row.onclick = () => {
        if(row.classList.contains('active')){
            row.classList.remove('active');
            rowsSelected.splice(rowsSelected.indexOf(row.id),1);
        }else{
            row.classList.add('active');
            rowsSelected.push(row.id);
        }
        numOfRowsInfo.textContent = rowsSelected.length;
    }
})
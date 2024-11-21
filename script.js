const hiddenButtons = document.querySelectorAll('.hidden_cell');

hiddenButtons.forEach(btn => 
    btn.addEventListener('click', () => hiddenCell(btn.id))
);

function addProductQuantity(productId) {
    updateProductQuantity(productId, 1);
}

function removeProductQuantity(productId) {
    updateProductQuantity(productId, -1);
}

function updateProductQuantity(productId, change) {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "script.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    
    var params = "action=update_quantity&productId=" + productId + "&change=" + change;
    
    xhr.onload = function() {
        if (xhr.status === 200) {
            var response = JSON.parse(xhr.responseText);
            if (response.success) {
                document.getElementById('quantity_' + productId).textContent = parseInt(document.getElementById('quantity_' + productId).textContent) + change;
            }
        } else {
            console.error('Ошибка: ' + xhr.status);
        }
    };
    
    xhr.send(params);
}

function hiddenCell(id) {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "script.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    
    var params = "action=hide&id=" + id;
    
    xhr.onload = function() {
        if (xhr.status === 200) {
            if (JSON.parse(xhr.responseText).success) {
                document.getElementById(id).closest('tr').style.display = 'none';
            }
        } else {
            console.error('Ошибка: ' + xhr.status);
        }
    };
    
    xhr.send(params);
}

// 1. Создаем кнопку
const button = document.createElement("button");
button.textContent = "Add Item";
document.body.appendChild(button); // добавляем кнопку на страницу

// 2. Создаем список <ul>
const list = document.createElement("ul");
document.body.appendChild(list); // добавляем список на страницу

// 3. Когда нажимаем на кнопку — добавляем новый пункт
button.addEventListener("click", function() {
  // создаем новый элемент списка
  const item = document.createElement("li");
  item.textContent = "New Item";
  
  // реакция на клик — подсветка
  item.addEventListener("click", function() {
    item.style.backgroundColor = "yellow";
  });

  // реакция на двойной клик — удаление
  item.addEventListener("dblclick", function() {
    list.removeChild(item);
  });

  // добавляем элемент в список
  list.appendChild(item);
});
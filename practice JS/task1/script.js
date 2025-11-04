// 1. Создаем элемент <div>
const square = document.createElement("div");

// 2. Настраиваем стиль квадрата
square.style.width = "100px";
square.style.height = "100px";
square.style.backgroundColor = "white";
square.style.border = "2px solid black";

// 3. Добавляем квадрат на страницу
document.body.appendChild(square);

// 4. Добавляем реакцию на наведение мыши
square.addEventListener("mouseover", function() {
  square.style.borderColor = "red";
});

// 5. Добавляем реакцию, когда мышка уходит
square.addEventListener("mouseout", function() {
  square.style.borderColor = "black";
});
// Получаем элементы со страницы
const textArea = document.getElementById("textInput");
const biggerBtn = document.getElementById("biggerBtn");
const snoopBtn = document.getElementById("snoopBtn");
const blingCheck = document.getElementById("blingCheck");
const marvelBtn = document.getElementById("marvelBtn");
const pigBtn = document.getElementById("pigBtn");

// Exercise 2: Bigger Pimpin’ (простая версия)
biggerBtn.addEventListener("click", function () {
  const currentSize = parseInt(window.getComputedStyle(textArea).fontSize);
  textArea.style.fontSize = currentSize + 2 + "px";
});

// Exercise 3 + 5.1: Bling 
blingCheck.addEventListener("change", function () {
  if (blingCheck.checked) {
    textArea.classList.add("bling");

    // ✅ Твоя картинка на весь экран
    document.body.style.backgroundImage = "url('marvel1.jpeg')";
    document.body.style.backgroundSize = "cover";
    document.body.style.backgroundRepeat = "no-repeat";
    document.body.style.backgroundPosition = "center";
    document.body.style.backgroundAttachment = "fixed";
    document.body.style.height = "100vh";

    // Добавляем затемнение
    document.body.classList.add("bling-bg");
  } else {
    textArea.classList.remove("bling");
    document.body.style.backgroundImage = "none";
    document.body.style.backgroundColor = "#f5f5f5";
    document.body.classList.remove("bling-bg");
  }
});

// Exercise 4: Snoopify
snoopBtn.addEventListener("click", function () {
  let text = textArea.value;

  // 1. Всё в верхний регистр
  text = text.toUpperCase();

  // 2. Добавляем ! в конец
  if (!text.endsWith("!")) {
    text += "!";
  }

  // 3. Добавляем -IZZLE к последнему слову в каждом предложении
  let sentences = text.split(".");
  for (let i = 0; i < sentences.length; i++) {
    let words = sentences[i].trim().split(" ");
    if (words.length > 0 && words[0] !== "") {
      let lastIndex = words.length - 1;
      words[lastIndex] = words[lastIndex] + "-IZZLE";
    }
    sentences[i] = words.join(" ");
  }

  textArea.value = sentences.join(". ");
});

// Exercise 5.3: Marvel Mode
marvelBtn.addEventListener("click", function () {
  let text = textArea.value;
  let words = text.split(" ");
  for (let i = 0; i < words.length; i++) {
    if (words[i].length >= 5) {
      words[i] = "Marvel";
    }
  }
  textArea.value = words.join(" ");
});


// Exercise 5.4: Pig Latin (Igpay Atinlay)
pigBtn.addEventListener("click", function () {
  const vowels = ["a", "e", "i", "o", "u"];
  let words = textArea.value.split(" ");

  for (let i = 0; i < words.length; i++) {
    let w = words[i];
    if (w.length > 0) {
      let first = w[0].toLowerCase();
      if (vowels.includes(first)) {
        words[i] = w + "ay";
      } else {
        words[i] = w.slice(1) + w[0] + "ay";
      }
    }
  }

  textArea.value = words.join(" ");
});
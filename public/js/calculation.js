// Reading and validating data
function readDate(inputDate) {
    let dateStr = inputDate.value;
    if (dateStr === null || dateStr === ""){
        throw new Error("Пожалуйста введите дату");
    }
    if (dateStr.length < 9){
        throw new Error("Неправельный формат даты");
    }
    let dateArray = [0,0,0];
    for (let i = 0; i < 4; i++){
        dateArray[2] *= 10;
        let n = parseInt(dateStr[i], 10);
        if (isNaN(n)){
            throw new Error("Неправельный формат даты");
        }
        dateArray[2] += n;
    }
    for (let i = 5; i < 7; i++){
        dateArray[1] *= 10;
        let n = parseInt(dateStr[i], 10);
        if (isNaN(n)){
            throw new Error("Неправельный формат даты");
        }
        dateArray[1] += n;
    }
    for (let i = 8; i < 10; i++){
        dateArray[0] *= 10;
        let n = parseInt(dateStr[i], 10);
        if (isNaN(n)){
            throw new Error("Неправельный формат даты");
        }
        dateArray[0] += n;
    }
    if (dateArray[0] > 31 || dateArray[0] < 1){
        throw new Error("Пожалуйста введите день от 1 до 31");
    }
    if (dateArray[1] > 12 || dateArray[1] < 1){
        throw new Error("Пожалуйста введите месяц от 1 до 12");
    }
    if (dateArray[2] >= 2100 || dateArray[2] < 1900){
        throw new Error("Пожалуйста введите год между 1900 и 2100");
    }
    return dateArray;
}

// Logic
function calculate() {
    let inputDate = document.querySelector("#inputDate");
    let date;
    let msgPar = document.querySelector("#errorMsg");
    msgPar.textContent = "";
    try {
        date = readDate(inputDate);
    } catch (e) {
        msgPar.textContent = e.message;
        return;
    }

    let digits = calculateDigits(date);

    setTable(digits);
    setDescription(digits);
}

function inputEnter(e) {
    if (e.code === "Enter"){
        calculate();
        //document.querySelector("#inputDate").blur();
    }
}

function splitNumber(number) {
    let digits = [0,0,0,0,0,0,0,0,0];
    let digit;
    while (number !== 0) {
        digit = number % 10;
        if (digit !== 0){
            digits[digit - 1]++;
        }
        number = Math.floor(number / 10);
    }
    return digits;
}

function collapseDigits(digits) {
    let number = 0;
    for (let i = 0; i  < 9; i++){
        number += digits[i] * (i + 1);
    }
    return number;
}

function calculateDigits(date) {
    let digitsDay = splitNumber(date[0]);
    let digitsMonth = splitNumber(date[1]);
    let digitsYear = splitNumber(date[2]);


    let digits = [0,0,0,0,0,0,0,0,0,0];
    for (let i = 0; i < 9; i++){
        digits[i] += digitsDay[i];
        digits[i] += digitsMonth[i];
        digits[i] += digitsYear[i];
    }

    let topRowNumber1 = collapseDigits(digits);
    let topRowDigits1 = splitNumber(topRowNumber1);
    let topRowNumber2 = collapseDigits(topRowDigits1);
    let topRowDigits2 = splitNumber(topRowNumber2);

    // Setting end digits as digits[9]
    if (topRowNumber2 < 10){
        digits[9] = topRowNumber2;
    } else {
        digits[9] = collapseDigits(topRowDigits2);
    }

    let coeficent = 0;
    if (date[2] < 2000){
        coeficent = -2;
    } else {
        coeficent = 19;
    }
    let coeficentDigits = splitNumber(Math.abs(coeficent));

    let botRowNumber1 = topRowNumber1 + coeficent;
    let botRowDigits1 = splitNumber(botRowNumber1);
    let botRowNumber2 = collapseDigits(botRowDigits1);
    let botRowDigits2 = splitNumber(botRowNumber2);

    for (let i = 0; i < 9; i++){
        digits[i] += topRowDigits1[i];
        digits[i] += topRowDigits2[i];
        digits[i] += coeficentDigits[i];
        digits[i] += botRowDigits1[i];
        digits[i] += botRowDigits2[i];
    }

    return digits;
}

// Output
function setTable(digits) {
    let cell;
    for (let i = 0; i < 9; i++){
        cell = document.querySelector("#cCell" + (i + 1)).querySelector(".cCellText");
        if (digits[i] !== 0){
            let cellString = "";
            for (let j = 0; j < digits[i]; j++){
                cellString += (i + 1);
            }
            cell.textContent = cellString;
        } else {
            cell.textContent = "-";
        }
    }
}

function setDescription(digits){
    let descriptionBlock = document.querySelector("#calculationDescription");
    while (descriptionBlock.firstChild){
        descriptionBlock.removeChild(descriptionBlock.firstChild);
    }

    let endDigitPar = document.createElement("p");
    endDigitPar.textContent = "Конечная цифра: " + digits[9];
    descriptionBlock.appendChild(endDigitPar);

    let psychotypePar = document.createElement("p");
    if (digits[0] > digits[1]){
        psychotypePar.textContent = "Психотип 1";
    } else if (digits[1] > digits[0]){
        psychotypePar.textContent = "Психотип 2";
    } else {
        psychotypePar.textContent = "Психотип 3";
    }
    descriptionBlock.appendChild(psychotypePar);

    let blocksDiv = document.createElement("div");

    let mainBlock = 0;
    if ((digits[0] / 2) >= digits[1]){
        mainBlock = 1;
        let mainBlockPar = document.createElement("p");
        mainBlockPar.textContent = "1 Блок";
        blocksDiv.appendChild(mainBlockPar);
    } else if ((digits[1] / 2) >= digits[0]){
        mainBlock = 2;
        let mainBlockPar = document.createElement("p");
        mainBlockPar.textContent = "2 Блок";
        blocksDiv.appendChild(mainBlockPar);
    } else if (digits[0] === digits[1]){
        let mainBlockPar = document.createElement("p");
        mainBlockPar.textContent = "Блок противоречия";
        blocksDiv.appendChild(mainBlockPar);
    }

    if (mainBlock !== 0){
        if (digits[2] === 0){
            let blockPar = document.createElement("p");
            blockPar.textContent = "3 Блок";
            blocksDiv.appendChild(blockPar);
        }
        if (digits[3] >= 3){
            let blockPar = document.createElement("p");
            blockPar.textContent = "4 Блок";
            blocksDiv.appendChild(blockPar);
        }
        if (digits[4] >= 3){
            let blockPar = document.createElement("p");
            blockPar.textContent = "5 Блок";
            blocksDiv.appendChild(blockPar);
        }
        if (digits[5] >= 3){
            let blockPar = document.createElement("p");
            blockPar.textContent = "6 Блок";
            blocksDiv.appendChild(blockPar);
        }
    }
    if (blocksDiv.firstChild){
        descriptionBlock.appendChild(blocksDiv);
    }

    let evenDigitsPar = document.createElement("p");
    evenDigitsPar.textContent = "Мужских цифр: " + (digits[1] + digits[3] + digits[5] + digits[7]);
    descriptionBlock.appendChild(evenDigitsPar);

    let oddDigitsPar = document.createElement("p");
    oddDigitsPar.textContent = "Женских цифр: " + (digits[0] + digits[2] + digits[4] + digits[6] + digits[8]);
    descriptionBlock.appendChild(oddDigitsPar);

    if (digits[0] > 1 && digits[3] > 0 && digits[4] > 0 && digits[6] > 0){
        let altruismPar = document.createElement("p");
        altruismPar.textContent = "Альтруизм";
        descriptionBlock.appendChild(altruismPar);
    }
    if (digits[2] > 0 && digits[4] > 0 && digits[5] > 0 && digits[8] > 1){
        let egoismPar = document.createElement("p");
        egoismPar.textContent = "Эгоизм";
        descriptionBlock.appendChild(egoismPar);
    }
}

// Callback linking
window.addEventListener('load', function () {
    let buttonCalculate = document.querySelector("#buttonCalculate");
    buttonCalculate.addEventListener('click', function (event) {
        calculate();
    });

    let inputDate = document.querySelector("#inputDate");
    inputDate.onkeydown = inputEnter;
});




// When the page is loaded, check for local storage
//.getItem() returns the value
// if this key doesn't exist, .getItem() return false
let storedName = localStorage.getItem("name");
let storedBgColor = localStorage.getItem("bgcolor");

if(storedName) {
    // Grab the values stored in web storage and change the name
    document.querySelector("#name-display").innerHTML = storedName;
}

if(storedBgColor) {
    // Grab the values stored in web storage and change the bg color
    document.querySelector("body").style.backgroundColor = storedBgColor;
}



document.querySelector("#form").onsubmit = function(event) {
    event.preventDefault();

    let nameInput = document.querySelector("#name").value;
    let bgColorInput = document.querySelector("#bgcolor").value;

    // Save this info to the local storage
    // .setItem() saves key/value pairs into the web storage
    // 1st arg: the name of the key - you can name this whatever you want
    // 2nd rg: the value 
    localStorage.setItem("name", nameInput);
    localStorage.setItem("bgcolor", bgColorInput);

    // Change the name using user input
    document.querySelector("#name-display").innerHTML = nameInput;
    // Change the background color to user input
    document.querySelector("body").style.backgroundColor = bgColorInput;
}


// Storing arrays
let fruitArray = [];

// Check if fruits already exist in storage
let fruitsInStorage = localStorage.getItem("fruits");
if(fruitsInStorage) {
    // We stored fruits as a string, so we will get it back as a string
    console.log(fruitsInStorage);

    // Convert the string into JS array
    let fruits = JSON.parse(fruitsInStorage);
    console.log(fruits);

    // Fill up the fruitArray with these previously saved fruits
    fruitArray = fruits;
}

document.querySelector("#fruit-form").onsubmit = function(event) {
    event.preventDefault();

    // Get the user input
    let fruitInput = document.querySelector("#fruit").value.trim();

    fruitArray.push(fruitInput);
    console.log(fruitArray);

    // local storage does not allow us to save arrays. So we will convert this array into a JSON string and save the JSON string into local storage!

    // conversion
    // .stringify() converts JS arrays/objects into JSON string
    // .parse() converts JSON strings into JS arrays/objects
    let fruitString = JSON.stringify(fruitArray);
    console.log(fruitString);

    // Save this string into local storage!!
    localStorage.setItem("fruits", fruitString);

    

    // Clear the fruit display 
    document.querySelector("#fruitsDisplay").innerHTML = "";

    // Display the fruits
    for(let i = 0; i < fruitArray.length; i++) {
        document.querySelector("#fruitsDisplay").innerHTML += fruitArray[i] + ", ";
    }
    
}
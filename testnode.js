//this is for hiding phone number sa using node.js
const phoneNumber = "555-123-4567";
const hiddenNumber = phoneNumber.replace(/\d/g, "*");
console.log(hiddenNumber); // Output: "***-***-****"
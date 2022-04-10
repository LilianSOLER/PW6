// Write a function that takes an object (a) and a string (b) as argument
// Return true if a has a property with key b
// Return false otherwise
function propertyExistsInObject(a, b) {
	return b in a;
}

// Write a function that takes a string as argument
// Extract the last 3 characters from the string
// Return the result
function lastNChar(str, n) {
	return str.slice(n);
}

// Write a function that takes a value as argument
// Return the type of the value
function typeOf(a) {
	return typeof a;
}

// Write a function that takes an array (a) as argument
// Return the number of elements in a
function numberOfElement(a) {
	return a.length;
}

// Write a function that takes a string (a) as argument
// Extract the first half a
// Return the result
function firstHalf(a) {
	return a.substring(0, a.length / 2);
}

// Write a function that a string (a) as argument
// Create an object that has a property with key 'key' and a value of a
// Return the object
function objectWithKeyProprety(a) {
	return { key: a };
}

// Write a function that takes an object with two properties as argument
// It should return the value of the property with key country
function accessObjectPropreties(obj) {
	return obj.country;
}

// Write a function that takes an array (a) as argument
// Extract the first 3 elements of a
// Return the resulting array
function getFirstNChars(a, n) {
	return a.slice(0, n);
}

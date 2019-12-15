var radio = document.querySelector(".radio");
var radios = document.querySelector("#radios");
var entry1 = document.querySelector("#entry1");
var entry2 = document.querySelector("#entry2");
var faculties = document.getElementById("faculty");
var add_button_f = document.querySelector("#add_button_f");
var remove_button_f = document.querySelector('#remove_button_f');

if(entry2) {
	entry2.style.display = "none";
}

if(radios) {
	radios.addEventListener("click", function(){
		if(radio.checked == true) {
			entry1.style.display = "block";
			entry2.style.display = "none";
		}
		else {
			entry1.style.display = "none";
			entry2.style.display = "block";
		}
	});
}

var no = 0;

var ids = ["faculty", "role"];
var placeholders = ["Faculty Email", "Role"];
var faculties = document.querySelector("#faculty");

var add = function() {
	console.log("hello");
	var entry = document.createElement("input");
	entry.type = "text";
	entry.name = ids[0] + no;
	entry.placeholder = placeholders[0];
	entry.id = ids[0] + no;
	faculties.appendChild(entry);

	var ent = document.createElement("input");
	ent.type = "text";
	ent.name = ids[1] + no;
	ent.placeholder = "Role";
	ent.id = ids[1] + no;
	faculties.appendChild(ent);

	no = no + 1;
};

var remove = function(){
	if(no > 0) {
		no = no - 1;
		var entry = "#" + ids[0] + no;
		faculties.removeChild(document.querySelector(entry));
		entry = "#" + ids[1] + no;
		faculties.removeChild(document.querySelector(entry));
	}
};

add_button_f.addEventListener("click", function(){
	add();
});

remove_button_f.addEventListener("click", function(){
	remove();
});


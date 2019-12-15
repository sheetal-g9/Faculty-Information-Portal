var research_fields = document.querySelector("#research_fields");
var add_button_r = document.querySelector("#add_button_r");
var remove_button_r = document.querySelector('#remove_button_r');

var faculties = document.querySelector("#faculties");
var add_button_f = document.querySelector("#add_button_f");
var remove_button_f = document.querySelector('#remove_button_f');


var faculties1 = document.querySelector("#faculties1");
var add_button_f1 = document.querySelector("#add_button_f1");
var remove_button_f1 = document.querySelector('#remove_button_f1');
var no = [0, 0];

var ids = ["research_field", "faculty", "role"];
var placeholders = ["Research Field", "Faculty ID"];
var containers = [document.querySelector("#research_field"), document.querySelector("#faculty")];

var add = function(i, j = 0) {
	console.log("hello");
	var entry = document.createElement("input");
	entry.type = "text";
	entry.name = ids[i] + no[i];
	entry.placeholder = placeholders[i];
	entry.id = ids[i] + no[i];
	containers[i].appendChild(entry);

	if(j) {
		var ent = document.createElement("input");
		ent.type = "text";
		ent.name = ids[j] + no[i];
		ent.placeholder = "Role";
		ent.id = ids[j] + no[i];
		containers[i].appendChild(ent);
	}
	no[i] = no[i] + 1;
};

var remove = function(i, j = 0){
	if(no[i] > 0) {
		no[i] = no[i] - 1;
		var entry = "#" + ids[i] + no[i];
		containers[i].removeChild(document.querySelector(entry));
		if(j) {
			entry = "#" + ids[j] + no[i];
			containers[i].removeChild(document.querySelector(entry));
		}
	}
};

add_button_r.addEventListener("click", function(){
	add(0);
});

remove_button_r.addEventListener("click", function(){
	remove(0);
});

add_button_f.addEventListener("click", function(){
	add(1);
});

remove_button_f.addEventListener("click", function(){
	remove(1);
});



add_button_f1.addEventListener("click", function(){
	add(1, 2);
});

remove_button_f1.addEventListener("click", function(){
	remove(1, 2);
});


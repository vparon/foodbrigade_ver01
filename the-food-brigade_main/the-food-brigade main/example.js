import { htmlGet, htmlPost } from "./src/utils/utils.js";

htmlGet("./src/service/CreateWebuser.php?webuser_username=adras&webuser_password=alma").then((v) => {
	document.write(v + "<br/>") 
	htmlGet("./src/service/GetAllWebuser.php").then((v) => {
		document.write(v + "<br/>");
	});
});

class MyTestClass {
	
	constructor() { 
		this.i = 42;
	}
	
}

let obj = new MyTestClass();
console.log(obj.i);
function showhide(name) {
   var elem = document.getElementById(name);
       if (elem.style.display === 'block') {
               elem.style.display ='none';
       } else {
               elem.style.display = 'block';
       }
}

function hide() {
	var elem = document.getElementsByClassName("hidden");
	for (i=0; i<elem.length; i++){
		elem[i].style.display='none';
	}
}

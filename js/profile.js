let subMenu = document.getElementById("subMenu");
	
	function toggleMenu()
	{
		subMenu.classList.toggle("open-menu");
	}
	
	
	/*window.onclick = function(even) {
		
		if (!even.target.matches('.user-pic')) {
		var drop = document.getElementsByClassName("sub-menu-wrap");
		var a;
    for (a = 0; a < drop.length; a++) {
      var openD = drop[a];
      if (openD.classList.contains('open-menu')) {
		  openD.classList.remove('open-menu');
	  }
	}
		}
	}*/
	window.onclick = function(event) {
  if (!event.target.matches('.user-pic')) {
    var dropdowns = document.getElementsByClassName("sub-menu-wrap");
    var i;
    for (i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      if (openDropdown.classList.contains('open-menu')) {
        openDropdown.classList.remove('open-menu');
      }
    }
  }
}
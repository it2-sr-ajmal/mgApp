<?php
class MenuHelper{
	
	function getFrontendMenuTree(){
		return '<ul role="menubar" class="nav navbar-nav mainNav ">
			<li class="  active-main-menu">
				<a class="scroll" href="http://demopgs.com/mbz/gamma/" data-href="#home">Home</a>
			</li> 
			<li aria-level="0" data-lang="en" class="   " data-level="0" data-id="14"> 
				<a data-href="#about" aria-title="Main Navigation About" data-slug="#" href="http://demopgs.com/mbz/gamma/en/about" class="scroll">About</a> 
			</li> 
			<li aria-level="0" data-lang="en" class="   1 dropdown smallMenu has-submenu " data-level="0" data-id="1">
				<span class="arrow-submenu"></span> 
				<a data-href="#what-to-expect" aria-title="Main Navigation What To Expect" data-slug="#" href="http://demopgs.com/mbz/gamma/en/what-to-expect" class="  dropdown-toggle disabled " data-toggle="dropdown">What To Expect</a>
					<ul role="menu" class=" dropdown-menu dp-normal "> 
						<li aria-level="1" data-lang="en" class="   " data-level="1" data-id="15"> 
							<a data-href="#agenda" aria-title="Main Navigation Agenda" data-slug="agenda" href="http://demopgs.com/mbz/gamma/en/agenda" class=" ">Agenda</a> 
						</li> 
						<li aria-level="1" data-lang="en" class="   " data-level="1" data-id="3"> 
							<a data-href="#speakers" aria-title="Main Navigation Speakers" data-slug="#" href="http://demopgs.com/mbz/gamma/en/speakers" class="scroll  ">Speakers</a>
						</li>
					</ul> 
			</li> 
			<li aria-level="0" data-lang="en" class="   " data-level="0" data-id="12"> 
				<a data-href="#2017-at-a-glance" aria-title="Main Navigation 2017 At A Glance" data-slug="2017-at-a-glance" href="http://demopgs.com/mbz/gamma/en/2017-at-a-glance" class=" ">2017 At A Glance</a> 
			</li>                                    
			<li class="langSwitch mobileOnly">
				<a class=" " href="http://demopgs.com/mbz/gamma/language/ar/?redirect_url=http://demopgs.com/mbz/gamma">
				AR
			</a>
		
			</li> 
			
		</ul>';
	}
}

function getFrontendMenu($lang='en'){
	$helper = new MenuHelper($lang);
	return $helper->getFrontendMenuTree();
}
@include('modal.attendance_time')
<header id="topnav">
	<nav class="navbar-custom">
		<div class="container-fluid">
			<ul class="list-unstyled topbar-right-menu float-right mb-0 front_nav">
				<li><a id="attendance_time" class="nav-link" data-toggle="modal" data-target="#attendance_time" data-animation="blur" data-overlayspeed="100" data-overlaycolor="#36404a">Time In / Time Out</a></li>
				<li><a href="/f_clients" class="nav-link">Clients</a></li>
				<li><a href="/f_gift-certificate" class="nav-link">Gift Certificates</a></li>
				<li><a href="/f_petty-expenses" class="nav-link">Petty Expenses</a></li>
				<li><a href="#" class="nav-link" id="payroll_prompt">Payroll</a></li>
			</ul>
			<ul class="list-inline menu-left mb-0">
	        <li class="float-left">
	            <a href="/" class="logo">
	                <span class="logo-lg">
	                    <!-- {{ HTML::image('img/body-and-sole-logo.jpg', 'Body and Sole', array('height' => '50')) }} -->
	                </span>
	                <span class="logo-sm">
	                    BS
	                </span>
	            </a>
	        </li>
			</ul>
		</div>
	</nav>
</header>
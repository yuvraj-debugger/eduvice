<!-- Sidebar -->
<ul
	class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion"
	id="accordionSidebar">

	<!-- Sidebar - Brand -->
	<a
		class="sidebar-brand d-flex align-items-center justify-content-center"
		href="">
		<img src="{{asset ('images/logoWhite.svg')}}" />
		<!-- <div class="sidebar-brand-icon rotate-n-15">
			<i class="fas fa-laugh-wink"></i>
		</div>
		<div class="sidebar-brand-text mx-3">
			{{ __('Dashboard') }}
		</div> -->
	</a>

	<!-- Divider -->
	<hr class="sidebar-divider my-0">


	<!-- Heading -->

	<!-- Nav Item - Pages Collapse Menu -->
		<li class="nav-item"><a class="nav-link"
		href="{{route('admin.user')}}"> <i
			class="fa fa-user"></i> <span>Users</span></a></li>

	<!-- Nav Item - Pages Collapse Menu -->
	
	<li class="nav-item"><a class="nav-link"
		href="{{route('admin.areaofinterest.index')}}"> <i
			class="fas fa-fw fa-chart-area"></i> <span>Area Of Interest</span></a></li>
	
	<!-- Nav Item - Pages Collapse Menu -->
	<li class="nav-item"><a class="nav-link"
		href="{{route('admin.globalcourses.index')}}"> <i
			class="fas fa-book-reader"></i> <span>Global Courses</span></a></li>
	<!-- Nav Item - Pages Collapse Menu -->
	<li class="nav-item"><a class="nav-link"
		href="{{route('admin.university.index')}}"> <i
			class="fa fa-university"></i> <span>Universities</span></a></li>
			<li class="nav-item"><a class="nav-link"
		href="{{route('admin.manage.index')}}"> <i
			class="fa fa-graduation-cap"></i> <span>Manage Courses</span></a></li>
			<li class="nav-item"><a class="nav-link"
		href="{{route('admin.document.index')}}"> <i
			class="fa fa-file"></i> <span>Applications</span></a></li>
<!-- 	<li class="nav-item"><a class="nav-link collapsed" -->
<!-- 		href="{{route('admin.user')}}" data-toggle="collapse" -->
<!-- 		data-target="#collapseBlog" aria-expanded="true" -->
<!-- 		aria-controls="collapseBlog"> <i class="fas fa-fw fa-cog"></i> <span>Blog</span> -->
<!-- 	</a> -->
<!-- 		<div id="collapseBlog" class="collapse" aria-labelledby="headingTwo" -->
<!-- 			data-parent="#accordionSidebar"> -->
<!-- 			<div class="bg-white py-2 collapse-inner rounded"> -->
<!-- 				<h6 class="collapse-header">Blog</h6> -->
<!-- 				<a class="collapse-item" href="{{route('blog.posts')}}">Posts</a> <a -->
<!-- 					class="collapse-item" href="{{route('blog.tags')}}">Tags</a> <a -->
<!-- 					class="collapse-item" href="{{route('blog.category')}}">Category</a> -->
<!-- 			</div> -->
<!-- 		</div></li> -->



	<!-- Divider -->
<!-- 	<hr class="sidebar-divider"> -->

	<!-- Heading -->
<!-- 	<div class="sidebar-heading">Addons</div> -->

	<!-- Nav Item - Pages Collapse Menu -->
<!-- 	<li class="nav-item"><a class="nav-link collapsed" href="#" -->
<!-- 		data-toggle="collapse" data-target="#collapsePages" -->
<!-- 		aria-expanded="true" aria-controls="collapsePages"> <i -->
<!-- 			class="fas fa-fw fa-folder"></i> <span>Pages</span> -->
<!-- 	</a> -->
<!-- 		<div id="collapsePages" class="collapse" -->
<!-- 			aria-labelledby="headingPages" data-parent="#accordionSidebar"> -->
<!-- 			<div class="bg-white py-2 collapse-inner rounded"> -->

<!-- 				<h6 class="collapse-header">Other Pages:</h6> -->
<!-- 				<a class="collapse-item" href="{{route('dashboard.404')}}">404 Page</a> -->
<!-- 			</div> -->
<!-- 		</div></li> -->

	<!-- Nav Item - Charts -->
<!-- 	<li class="nav-item"><a class="nav-link" -->
<!-- 		href="{{route('dashboard.chart')}}"> <i -->
<!-- 			class="fas fa-fw fa-chart-area"></i> <span>Charts</span></a></li> -->



</ul>
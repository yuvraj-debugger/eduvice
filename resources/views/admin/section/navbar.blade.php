

<!-- Topbar -->
<nav
	class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

	<!-- Sidebar Toggle (Topbar) -->
	<button id="sidebarToggleTop"
		class="btn btn-link d-md-none rounded-circle mr-3">
		<i class="fa fa-bars"></i>
	</button>



	<!-- Topbar Navbar -->
	<ul class="navbar-nav ml-auto">

	

			
			@if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
		<li class="nav-item dropdown no-arrow mx-1"><a
			class="nav-link dropdown-toggle" href="#" id="messagesDropdown"
			role="button" data-toggle="dropdown" aria-haspopup="true"
			aria-expanded="false"> {{ Auth::user()->currentTeam->name }} <i
				class="fa fa-caret-down" aria-hidden="true"></i>
		</a> <!-- Dropdown - Messages -->
			<div
				class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
				aria-labelledby="messagesDropdown">
				<h6 class="dropdown-header">{{ __('Manage Team') }}</h6>
				<a class="dropdown-item d-flex align-items-center"
					href="{{ route('teams.show', Auth::user()->currentTeam->id) }}">
					<div class="font-weight-bold">{{ __('Team Settings') }}</div>
				</a> @can('create', Laravel\Jetstream\Jetstream::newTeamModel()) <a
					class="dropdown-item d-flex align-items-center"
					href="{{ route('teams.create') }}">
					<div class="font-weight-bold">{{ __('Create New Team') }}</div>
				</a> @endcan
				<div class="dropdown-divider"></div>
			</div></li> @endif

		<div class="topbar-divider d-none d-sm-block"></div>

		<!-- Nav Item - User Information -->
		<li class="nav-item dropdown no-arrow"><a
			class="nav-link dropdown-toggle" href="#" id="userDropdown"
			role="button" data-toggle="dropdown" aria-haspopup="true"
			aria-expanded="false"> <span
				class="mr-2 d-none d-lg-inline text-gray-600 small">{{
					Auth::user()->name }}</span> <img
				class="img-profile rounded-circle"
				src="{{ Auth::user()->profile_photo_url }}"
				alt="{{ Auth::user()->name }}">
		</a> <!-- Dropdown - User Information -->
			<div
				class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
				aria-labelledby="userDropdown">
				<a href="javascript:void(0);" class="dropdown-item"><span>{{
						__('Manage Account') }}</span></a> <a class="dropdown-item"
					href="{{ route('profile.show') }}"> <i
					class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i> {{
					__('Profile') }}
				<div class="dropdown-divider"></div>
				<form method="POST" action="{{ route('logout') }}" x-data>
					@csrf <a class="dropdown-item" href="{{ route('logout') }}"
						@click.prevent="$root.submit();" data-toggle="modal"
						data-target="#logoutModal"> <i
						class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i> {{
						__('Log Out') }}
					</a>
				</form>
			</div></li>

	</ul>

</nav>
<div class="box">
    <div class="box-body box-profile">
	    <img class="profile-user-img img-responsive img-circle" src="{{ backpack_avatar_url(backpack_auth()->user()) }}">
	    <h3 class="profile-username text-center">{{ backpack_auth()->user()->name }}</h3>
	</div>

	<hr class="m-t-0 m-b-0">

	<ul class="nav nav-pills nav-stacked">

	  <li role="presentation"
		@if (Request::route()->getName() == 'backpack.account.info')
	  	class="active"
	  	@endif
	  	><a href="{{ route('backpack.account.info') }}"><!--{{ trans('backpack::base.update_account_info') }}-->Mettre à jour les informations</a></li>

	  <li role="presentation"
		@if (Request::route()->getName() == 'backpack.account.password')
	  	class="active"
	  	@endif
	  	><a href="{{ route('backpack.account.password') }}">Changer le mot de passe<!--{{ trans('backpack::base.change_password') }}--></a></li>

	</ul>
</div>

<!-- This file is used to store sidebar items, starting with Backpack\Base 0.9.0 -->
<!--<li><a href="{{ backpack_url('dashboard') }}"><i class="fa fa-dashboard"></i> <span>{{ trans('backpack::base.dashboard') }}</span></a></li>-->
@if (backpack_auth()->check())
<li><a href="/admin/dashboard"><i class="fa fa-dashboard"></i> <span>Tableau de board</span></a></li>
<li><a href="{{ backpack_url('elfinder') }}"><i class="fa fa-files-o"></i> <span>Gestionnaire de fichiers</span></a></li>
<!--<li><a href="{{ backpack_url('elfinder') }}"><i class="fa fa-files-o"></i> <span>{{ trans('backpack::crud.file_manager') }}</span></a></li>-->
<!--<li><a href="{{ backpack_url('page') }}"><i class="fa fa-files-o"></i> <span>Pages</span></a></li>-->
<li><a href="{{ backpack_url('news') }}"><i class="fa fa-files-o"></i> <span>Nouveautés</span></a></li>
<!--<li><a href="{{ backpack_url('beneficiaire') }}"><i class="fa fa-user"></i> <span>Bénéficiaires</span></a>-->
<!--<li><a href="#"><i class="fa fa-user"></i><span>Bénéficiaires</span></a>-->

<li class="treeview">
  
	<a href="{{ backpack_url('beneficiaire') }}"><i class="fa fa-user"></i> <span>Bénéficiaires</span> <i class="fa fa-angle-left pull-right"></i></a>
  <ul class="treeview-menu">
	<li>
      <a href="{{ backpack_url('beneficiaire')}}"><i class="fa fa-user"></i><span>Tous les bénéficiaires</span></a>
    </li>
    <li>
      <a href="{{ backpack_url('beneficiairehandicaps')}}"><i class="fa fa-user"></i><span>Bénéficiaires Handicapés</span></a>
    </li>
    <li>
      <a href="{{ backpack_url('beneficiairenonparraine') }}"><i class="fa fa-user"></i><span>Bénéficiaires non parrainés</span></a>
    </li>
	 <li>
      <a href="{{ backpack_url('beneficiaireparraine') }}"><i class="fa fa-user"></i><span>Bénéficiaires parrainés</span></a>
    </li>

<!--	<li>

      <a href="{{ backpack_url('nouveautesValides') }}"><i class="fa fa-user"></i><span>Nouveautés validées</span></a>

</li>
    
	 <li>
      <a href="{{ backpack_url('nouveautesencours') }}"><i class="fa fa-user"></i><span>Nouveautés à valider</span></a>
    </li>
-->






  </ul>
</li>


<li class="treeview">
        <a href="{{ backpack_url('beneficiaire') }}"><i class="fa fa-user"></i> <span>Contrôle d'associations</span> <i class="fa fa-angle-left pull-right"></i></a>
<ul class="treeview-menu">
 <li>

      <a href="{{ backpack_url('nouveautesValides') }}"><i class="fa fa-user"></i><span>Nouveautés (validées)</span></a>

</li>

         <li>
      <a href="{{ backpack_url('nouveautesencours') }}"><i class="fa fa-user"></i><span>Nouveautés (en attente)</span></a>
    </li>
<li>
      <a href="{{ backpack_url('beneficiairesencours') }}"><i class="fa fa-user"></i><span>Ajout/Modif. bénéfi.(en attente)</span></a>
    </li>

<li>
      <a href="{{ backpack_url('beneficiairesvalides') }}"><i class="fa fa-user"></i><span>Ajout/Modif. bénéfi. (validée)</span></a>
    </li>







</ul>



</li>


<li class="treeview">

        <a href="{{ backpack_url('beneficiaire') }}"><i class="fa fa-user"></i> <span>Prise en charge</span> <i class="fa fa-angle-left pull-right"></i></a>
  <ul class="treeview-menu">
         <li>
      <a href="{{ backpack_url('prise_en_charge') }}"><i class="fa fa-user"></i><span>Prise en charge complète</span></a>
    </li>
        <li><a href="{{ backpack_url('prise_en_charge_partage') }}"><i class="fa fa-user"></i> <span>Prise en charge partagée</span></a></li>
  </ul>
</li>



<li class="treeview">

        <a href="#"><i class="fa fa-user"></i> <span>Projets</span> <i class="fa fa-angle-left pull-right"></i></a>
  <ul class="treeview-menu">
        <li>
      <a href="{{ backpack_url('project')}}"><i class="fa fa-user"></i><span>Tous les projets</span></a>
    </li>
    <li>
      <a href="{{ backpack_url('projectInProgress')}}"><i class="fa fa-user"></i><span>Projets en phase de collection</span></a>
    </li>
    <li>
      <a href="{{ backpack_url('projectCollected') }}"><i class="fa fa-user"></i><span>Projets en phase de réalisation</span></a>
    </li>
         <li>
      <a href="{{ backpack_url('projectClosed') }}"><i class="fa fa-user"></i><span>Projets fermés</span></a>
    </li>
	<li>
      <a href="{{ backpack_url('donation') }}"><i class="fa fa-money"></i><span>Donations pour les projets</span></a>
    </li>

  </ul>
</li>
<!--</li>-->
<!--
<li><a href="{{ backpack_url('prise_en_charge') }}"><i class="fa fa-user"></i> <span>Prise en charge</span></a></li>-->
<!--<li><a href="{{ backpack_url('donation') }}"><i class="fa fa-user"></i> <span>Donations</span></a></li>-->
<!--<li><a href="{{ backpack_url('project') }}"><i class="fa fa-user"></i> <span>Projets</span></a></li>-->
<li><a href="{{ backpack_url('association') }}"><i class="fa fa-user"></i> <span>Associations</span></a></li>

<li><a href="{{ backpack_url('paiement') }}"><i class="fa fa-money"></i> <span>Paiements</span></a></li>
<li><a href="{{ backpack_url('notification') }}"><i class="fa fa-cloud"></i> <span>Notifications</span></a></li>

<li class="treeview">

        <a href="#"><i class="fa fa-user"></i> <span>Utilisateurs</span> <i class="fa fa-angle-left pull-right"></i></a>
  <ul class="treeview-menu">
        <li>
      <a href="{{ backpack_url('utilisateur') }}"><i class="fa fa-user"></i><span>Tous les utilisateurs</span></a>
    </li>
    <li>
      <a href="{{ backpack_url('parrains') }}"><i class="fa fa-user"></i><span>Parrains</span></a>
    </li>

  </ul>
</li>

<li class="treeview">

        <a href="#"><i class="fa fa-user"></i> <span>Activités</span> <i class="fa fa-angle-left pull-right"></i></a>
  <ul class="treeview-menu">
        <li>
      <a href="{{ backpack_url('activities') }}"><i class="fa fa-user"></i><span>Toutes les activités</span></a>
    </li>
    <li>
      <a href="{{ backpack_url('benevoles') }}"><i class="fa fa-user"></i><span>Bénévoles</span></a>
    </li>
	<li>
      <a href="{{ backpack_url('benevoles2') }}"><i class="fa fa-user"></i><span>Bénévoles non inscrits</span></a>
    </li>
	

  </ul>
</li>
    @endif
<!--<li><a href="/admin/utilisateur"><i class="fa fa-cloud"></i> <span>Utilisateurs</span></a></li>
<li><a href="/admin/parrains"><i class="fa fa-cloud"></i> <span>Parrains</span></a></li>
<li><a href="/admin/activities"><i class="fa fa-cloud"></i> <span>Activités</span></a></li>
<li><a href="/admin/benevoles"><i class="fa fa-cloud"></i> <span>Bénévoles</span></a></li>-->

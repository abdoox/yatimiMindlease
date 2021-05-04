<!-- This file is used to store sidebar items, starting with Backpack\Base 0.9.0 -->
<!--<li><a href="{{ backpack_url('dashboard') }}"><i class="fa fa-dashboard"></i> <span>{{ trans('backpack::base.dashboard') }}</span></a></li>-->

    @if (auth('associations')->check())

      <li class="treeview">

        <a href="#"><i class="fa fa-user"></i> <span>Bénéficiaires</span> <i class="fa fa-angle-left pull-right"></i></a>
  <ul class="treeview-menu">
        <li>
      <a href="/beneficiairesAssoc"><i class="fa fa-user"></i><span>Tous les bénéficiaires</span></a>
    </li>
    <li>
      <a href="/beneficiairesAssocHandicape"><i class="fa fa-user"></i><span>Bénéficiaires Handicapés</span></a>
    </li>
    <li>
      <a href="/beneficiairesAssocNonParraine"><i class="fa fa-user"></i><span>Bénéficiaires non parrainés</span></a>
    </li>
         <li>
      <a href="/beneficiairesAssocParraine"><i class="fa fa-user"></i><span>Bénéficiaires parrainés</span></a>
    </li>

  </ul>
</li>
<li class="treeview">

        <a href="#"><i class="fa fa-user"></i> <span>Prise en charge</span> <i class="fa fa-angle-left pull-right"></i></a>
  <ul class="treeview-menu">
         <li>
      <a href="/priseEnChargeAssoc"><i class="fa fa-user"></i><span>Prise en charge en cours</span></a>
    </li>
        <li><a href="/priseEnChargeAssocTermine"><i class="fa fa-user"></i> <span>Prise en charge annulée</span></a></li>
  </ul>
</li>
    



@endif
<!--<li><a href="/admin/utilisateur"><i class="fa fa-cloud"></i> <span>Utilisateurs</span></a></li>
<li><a href="/admin/parrains"><i class="fa fa-cloud"></i> <span>Parrains</span></a></li>
<li><a href="/admin/activities"><i class="fa fa-cloud"></i> <span>Activités</span></a></li>
<li><a href="/admin/benevoles"><i class="fa fa-cloud"></i> <span>Bénévoles</span></a></li>-->

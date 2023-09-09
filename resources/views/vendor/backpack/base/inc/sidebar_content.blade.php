{{-- This file is used to store sidebar items, inside the Backpack admin panel --}}
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>

<li class="nav-item"><a class="nav-link" href="{{ backpack_url('electeur') }}"><i class="nav-icon la la-question"></i> Electeurs</a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('formule') }}"><i class="nav-icon la la-question"></i> Formules</a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('parrainage') }}"><i class="nav-icon la la-question"></i> Parrainages</a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('parti') }}"><i class="nav-icon la la-question"></i> Partis</a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('user') }}"><i class="nav-icon la la-question"></i> Users</a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('params') }}"><i class="nav-icon la la-question"></i> Params</a></li>
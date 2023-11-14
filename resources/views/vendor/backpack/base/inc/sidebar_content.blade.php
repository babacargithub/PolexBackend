{{-- This file is used to store sidebar items, inside the Backpack admin panel --}}
@if(backpack_user()->hasRole('polex_admin'))
    <li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i
                class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>

    <li class="nav-item"><a class="nav-link" href="{{ backpack_url('formule') }}"><i
                class="nav-icon la la-shopping-cart"></i> Formules</a></li>
    <li class="nav-item"><a class="nav-link" href="{{ backpack_url('parti') }}"><i class="nav-icon la la-home"></i>
            Partis</a></li>
    <li class="nav-item"><a class="nav-link" href="{{ backpack_url('params') }}"><i class="nav-icon la la-user-cog"></i>
            Params</a></li>
    <li class="nav-item nav-dropdown">
        <a class="nav-link nav-dropdown-toggle" href="#">
            <i class="nav-icon la la-users"></i> Authentication</a>
        <ul class="nav-dropdown-items">
            <li class="nav-item"><a class="nav-link" href="{{ backpack_url('user') }}"><i
                        class="nav-icon la la-user"></i> Utilisateurs</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ backpack_url('role') }}"><i
                        class="nav-icon la la-id-badge"></i> <span>Roles</span></a></li>
            <li class="nav-item"><a class="nav-link" href="{{ backpack_url('permission') }}"><i
                        class="nav-icon la la-key"></i> <span>Permissions</span></a></li>
        </ul>
    </li>

@endif


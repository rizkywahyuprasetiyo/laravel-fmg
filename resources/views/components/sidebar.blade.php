<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="#">Laravel FMG</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">FMG</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li class="{{ request()->is('/*') ? 'active' : '' }}"><a class="nav-link" href="blank.html"><i class="far fa-hdd"></i> <span>Drive Saya</span></a></li>
        </ul>
    </aside>
</div>
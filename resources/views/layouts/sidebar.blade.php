<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="/" class="brand-link">
        <span class="brand-image elevation-3 bg-cyan p-2">TS</span>
        <span class="brand-text font-weight-light font-weight-bold">
            TicketSystems
        </span>
    </a>

    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('assets/img/avatar.png') }}" class="img-circle elevation-2" alt="Avatar">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ auth()->user()->name }}</a>
            </div>
        </div>

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link" title="Dashboard">
                        <i class="nav-icon fas fa-home"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('ticket.create') }}" class="nav-link" title="Create New Ticket">
                        <i class="nav-icon fas fa-ticket-alt"></i>
                        <p>
                            Create New Ticket
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('ticket.list') }}" class="nav-link" title="Ticket List">
                        <i class="nav-icon fas fa-list-alt"></i>
                        <p>
                            Tickets
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>

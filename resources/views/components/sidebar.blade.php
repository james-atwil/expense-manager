<?php
use App\Models\User;
use Illuminate\Support\Facades\Route;

/** @var User $user */
$user = auth()->user();
$current = Route::currentRouteName();
?>

<div id="sidebar" v-cloak class="offcanvas offcanvas-start sidebar sidebar-dark bg-primary text-white">
    <div class="sidebar-content h-100 d-flex flex-column flex-shrink-0">
        <div class="profile p-4 text-center">
            <img src="{{ url('images/logo.svg') }}" class="mb-3 p-3 bg-white" alt="Logo" height="96">
            <h4 class="mb-0"><?php echo $user->name_display; ?></h4>
            <p class="mb-0"><?php echo $user->role->name; ?></p>
        </div>
        <scroll-area class="nav-wrapper flex-fill" :options="{ scrollbars: { autoHide: 'leave'} }">
            <nav-area id="navigation">
                <nav-item href="/">Dashboard</nav-item>
                <nav-section name="Expenses Management">
                    @role(['admin'])
                    <nav-item href="{{ route('expenses.categories.index') }}" {{ is_current_route('expenses.categories.index') }}>Categories</nav-item>
                    @endrole
                    <nav-item href="{{ route('expenses.expenses.index') }}" {{ is_current_route('expenses.expenses.index') }}>Expenses</nav-item>
                </nav-section>
                @role(['admin'])
                <nav-section name="Users Management">
                    <nav-item href="{{ route('users.users.index') }}" {{ is_current_route('users.users.index') }}>Users</nav-item>
                    <nav-item href="{{ route('users.roles.index') }}" {{ is_current_route('users.roles.index') }}>Roles</nav-item>
                </nav-section>
                @endrole
            </nav-area>
            <hr>
            <nav-area id="navigation">
                <nav-item href="/profile">Profile</nav-item>
                <nav-item href="/logout">Logout</nav-item>
            </nav-area>
        </scroll-area>
    </div>
</div>

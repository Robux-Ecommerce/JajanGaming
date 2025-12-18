@extends('layouts.app')

@section('content-with-sidebar')
<div style="display: flex; min-height: calc(100vh - 80px);">
    <!-- Page Sidebar -->
    <x-page-sidebar :sidebarTitle="$sidebarTitle ?? 'Menu'" />
    
    <!-- Main Content -->
    <div style="flex: 1; overflow-y: auto;">
        @yield('page-content')
    </div>
</div>

<style>
@media (max-width: 768px) {
    [data-page-container] {
        display: flex;
    }
    
    [data-page-container] .page-sidebar {
        position: fixed;
        left: 0;
        top: 80px;
        z-index: 998;
    }
}
</style>
@endsection

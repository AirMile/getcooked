{{-- Role-based Navigation --}}
@auth
    <x-nav.navigation :isAdmin="Gate::allows('access-admin-features')" />
@endauth

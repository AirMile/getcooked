<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h1 class="font-primary text-3xl font-semibold text-gray-700 mb-8 px-4 sm:px-0">
                {{ __('Profile') }}
            </h1>

            <div class="space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow-md rounded-lg border border-gray-200">
                    <div class="max-w-xl">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                <div class="p-4 sm:p-8 bg-white shadow-md rounded-lg border border-gray-200">
                    <div class="max-w-xl">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>

                <div class="p-4 sm:p-8 bg-white shadow-md rounded-lg border border-gray-200">
                    <div class="max-w-xl">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

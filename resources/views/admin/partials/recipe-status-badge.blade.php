<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
    {{ $status === 'approved' ? 'bg-green-100 text-green-800' : '' }}
    {{ $status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
    {{ $status === 'rejected' ? 'bg-red-100 text-red-800' : '' }}
    {{ $status === 'private' ? 'bg-gray-100 text-gray-800' : '' }}">
    {{ ucfirst($status) }}
</span>

<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest focus:outline-none transition ease-in-out duration-150', 'style' => 'background-color: #A67C52; color: white;']) }}
    onmouseover="this.style.backgroundColor='#8B6644'"
    onmouseout="this.style.backgroundColor='#A67C52'"
    onmousedown="this.style.backgroundColor='#75563A'"
    onmouseup="this.style.backgroundColor='#8B6644'">
    {{ $slot }}
</button>

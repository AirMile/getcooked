@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-gray-300 bg-white text-gray-700 rounded-md shadow-sm focus:ring-0 focus:outline-none', 'style' => 'border-color: #D4CEC5; background-color: #FFFFFF; color: #3E3830; border-radius: 8px; border-width: 1px;']) }}
    onfocus="this.style.borderColor='#A67C52';"
    onblur="this.style.borderColor='#D4CEC5';">

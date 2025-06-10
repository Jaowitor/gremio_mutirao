<div class="custom-input-wrapper">
    @if($leftIcon)
        <span class="input-icon left">
            <i class="{{ $leftIcon }}"></i>
        </span>
    @endif

    <input 
        type="{{ $type ?? 'text' }}" 
        name="{{ $name }}" 
        id="{{ $name }}"
        value="{{ $value ?? '' }}" 
        placeholder="{{ $placeholder ?? '' }}" 
        class="custom-input {{ $leftIcon ? 'has-left-icon' : '' }} {{ $rightIcon ? 'has-right-icon' : '' }}"
    >


    @if($rightIcon)
        <span class="input-icon right">
            <i class="{{ $rightIcon }}"></i>
        </span>
    @endif
</div>

@if (isset($custom_class) && isset($custom_image_error) && isset($custom_image))
    <div class="{{ $custom_class }} hidden_image_container" style="background-color: #ddd !important;">
        <img class="hidden_image" style="display: none;"
             error-src="{{ asset($custom_image_error) }}"
             src="{{ !empty($custom_image) && $custom_image != '' ? asset($custom_image) : '' }}">
    </div>
@endif
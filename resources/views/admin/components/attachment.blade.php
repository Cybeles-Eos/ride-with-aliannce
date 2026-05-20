<div class="row">
  <div class="col-md-8 col-md-offset-2">
    @php 
      $uniqueKey = uniqid(); // temporary unique string for duplicate alias
      $inputId   = 'input_' . $field . '_' . $uniqueKey;
      $imgId     = 'preview_' . $field . '_' . $uniqueKey;
      $fileInputName = !empty($async) && $async ? '' : $field;  // Empty for async uploads
      $hiddenInputName = $field;  // Always use the dynamic field name
      $media     = isset($value) && !empty($value) ? $value->url : '';
      $media_ext = pathinfo($media, PATHINFO_EXTENSION);
      $is_video  = in_array(strtolower($media_ext), ['mp4', 'webm', 'ogg']);
    @endphp

    {{-- File Input --}}
    <div class="form-group{{ $errors->has($field) ? ' has-error' : '' }}">
      <label class="col-md-2 control-label" for="file">{{ $label }}</label>
      <div class="col-md-10">
        <div class="input-group">
          <label class="input-group-btn">
            <span class="btn btn-primary">
              Choose File 
              <input type="file" id="{{ $inputId }}" class="{{ !empty($async) && $async ? 'async' : '' }}" 
                    name="{{ $fileInputName }}" accept="image/*,video/*" style="display: none;">
              <input type="hidden" class="fld" data-name="{{ $field }}" 
                    name="{{ $hiddenInputName }}" value="{{ isset($value) && !empty($value) ? $value->id : 0 }}">
            </span>
          </label>
          <input type="text" class="form-control" readonly value="{{ $media ? basename($media) : '' }}">
        </div>
        @if($errors->has($field)) 
          <span class="help-block animation-slideDown">{{ $errors->first($field) }}</span> 
        @endif
      </div>
    </div>

    {{-- Preview Section --}}
    <div class="form-group">
      <div class="col-md-10 col-md-offset-2">
        <a href="{{ $media != '' ? asset($media) : '' }}" 
           class="zoom img-thumbnail" style="cursor: default !important;" data-toggle="lightbox-image">

          {{-- Image Preview --}}
          <img id="{{ $imgId }}" 
               src="{{ !$is_video && $media != '' ? asset($media) : '' }}" 
               alt="{{ !$is_video && $media != '' ? basename($media) : '' }}" 
               class="img-responsive center-block media-preview-img"
               style="max-width: 100px; {{ !$is_video && $media != '' ? '' : 'display: none;' }}">

          {{-- Video Preview --}}
          <video controls class="img-responsive center-block media-preview-video" 
                 style="max-width: 150px; {{ $is_video && $media != '' ? '' : 'display: none;' }}">
            <source src="{{ $is_video ? asset($media) : '' }}" type="video/{{ $media_ext }}">
            Your browser does not support the video tag.
          </video>
        </a>

        <br>
        {{-- Remove Button --}}
        <a href="javascript:void(0)" class="btn btn-xs btn-danger remove-image-btn" 
           style="display: {{ $media != '' ? '' : 'none' }};">
          <i class="fa fa-trash"></i> Remove 
        </a>
        <input type="hidden" name="remove_{{ $field }}" class="remove-image" value="0">
      </div>
    </div>
  </div>
</div>

{{-- Script For Image/Video Preview --}}
<script>
  document.addEventListener("DOMContentLoaded", function() {
    const inputs = document.querySelectorAll("input[type='file']");
    inputs.forEach(input => {
      input.addEventListener("change", function() {
        const id = this.id.replace('input_', '');
        const previewImg = document.getElementById('preview_' + id);
        const anchor = previewImg.closest('a.zoom');
        const videoEl = anchor.querySelector("video");
        const videoSource = videoEl.querySelector("source");
        const fileNameInput = this.closest('.input-group').querySelector("input.form-control");
        const removeBtn = anchor.parentElement.querySelector(".remove-image-btn");
        const removeInput = anchor.parentElement.querySelector("input.remove-image");
        const file = this.files[0];

        if (file) {
          fileNameInput.value = file.name;
          const ext = file.name.split('.').pop().toLowerCase();
          const isVideo = ['mp4', 'webm', 'ogg'].includes(ext);
          const reader = new FileReader();

          reader.onload = function(e) {
            if (isVideo) {
              previewImg.style.display = "none";
              previewImg.src = "";
              videoEl.style.display = "block";
              videoSource.src = e.target.result;
              videoEl.load();
              anchor.href = e.target.result;
            } else {
              previewImg.style.display = "block";
              previewImg.src = e.target.result;
              videoEl.style.display = "none";
              videoSource.src = "";
              videoEl.load();
              anchor.href = e.target.result;
            }
          };
          reader.readAsDataURL(file);

          removeBtn.style.display = "inline-block";
          removeInput.value = "0";
        }
      });
    });

    // Remove Button Handler
    document.querySelectorAll(".remove-image-btn").forEach(btn => {
      btn.addEventListener("click", function() {
        const formGroup = this.closest(".form-group");
        const anchor = formGroup.querySelector("a.zoom");
        const previewImg = anchor.querySelector(".media-preview-img");
        const videoEl = anchor.querySelector(".media-preview-video");
        const videoSource = videoEl.querySelector("source");
        const inputFile = formGroup.parentElement.querySelector("input[type='file']");
        const fileNameInput = formGroup.parentElement.querySelector(".input-group input.form-control");
        const removeInput = formGroup.querySelector("input.remove-image");

        // Reset previews
        previewImg.src = "";
        previewImg.style.display = "none";
        videoSource.src = "";
        videoEl.load();
        videoEl.style.display = "none";
        anchor.href = "";

        // Reset inputs
        inputFile.value = "";
        fileNameInput.value = "";

        // Hide remove button + mark for removal
        this.style.display = "none";
        removeInput.value = "1";
      });
    });
  });
</script>

@props([
    'model',
    'id' => null,
    'placeholder' => 'Comienza a escribir...'
])

@php
    $id = $id ?? 'tinymce_' . md5($model);
@endphp

<div wire:ignore class="tinymce-wrapper modern-canva-editor mb-3" 
     x-data="{
         value: @entangle($model),
         instance: null,
         init() {
             tinymce.init({
                 selector: '#{{ $id }}',
                 height: 350,
                 menubar: false,
                 statusbar: true,
                 elementpath: false,
                 branding: false,
                 plugins: 'advlist autolink lists link image charmap preview anchor searchreplace visualblocks code fullscreen insertdatetime media table wordcount',
                 toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline forecolor | alignleft aligncenter alignright alignjustify | bullist numlist | link image media | code fullscreen',
                 skin: 'oxide',
                 content_css: 'default',
                 content_style: `
                     @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@300;400;500;600;700;800&display=swap');
                     body { 
                         font-family: 'Inter', sans-serif; 
                         font-size: 15px; 
                         color: #334155; 
                         line-height: 1.6;
                         padding: 20px;
                         background-color: #ffffff;
                     }
                     h1, h2, h3, h4, h5, h6 { 
                         font-family: 'Outfit', sans-serif; 
                         color: #0f172a; 
                         font-weight: 700;
                     }
                     ul, ol {
                         padding-left: 20px;
                     }
                 `,
                 placeholder: '{{ $placeholder }}',
                 setup: (editor) => {
                     this.instance = editor;
                     editor.on('init', () => {
                         editor.setContent(this.value || '');
                     });
                     editor.on('change keyup undo redo', () => {
                         this.value = editor.getContent();
                     });
                 }
             });

             $watch('value', (newValue) => {
                 if (this.instance && newValue !== this.instance.getContent()) {
                     this.instance.setContent(newValue || '');
                 }
             });
         },
         destroy() {
             if (this.instance) {
                 tinymce.remove(this.instance);
             }
         }
     }" 
     x-init="init()" 
     x-on:destroy="destroy()">
    <textarea id="{{ $id }}"></textarea>
</div>

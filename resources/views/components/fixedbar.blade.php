@php
    $images = File::files(public_path('images/fixedbar_icons'));
@endphp

@foreach ($images as $img)
    <img src="{{ asset('images/fixedbar_icons/' . $img->getFilename()) }}" alt="{{ $img->getFilename() }}">
@endforeach

@props(['src' => ''])
<script {{ $attributes->merge(['src' => asset($src)]) }} ></script>

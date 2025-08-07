@props(['title', 'count', 'bg' => 'bg-white', 'text' => 'text-gray-800'])

<div class="{{ $bg }} p-6 rounded-lg shadow text-center">
  <p class="text-sm font-medium {{ $text }}">{{ $title }}</p>
  <p class="text-2xl font-bold {{ $text }}">{{ $count }}</p>
</div>

@props([
    'title' => null, 
    'subtitle' => null,
    'posts' => [
        'C8XqXqXqXqX',
        'C8YqYqYqYqY', 
        'C8ZqZqZqZqZ'
    ]
])

<div class="bg-gray-50 py-16">
    <div class="container mx-auto px-4">
        <!-- Section Header -->
        <div class="text-center space-y-4 mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-black">
                📱 {{ $title ?? __('words.instagram.title') }}
            </h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                {{ $subtitle ?? __('words.instagram.subtitle') }}
            </p>
        </div>

        <!-- Instagram Embeds Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 max-w-6xl mx-auto">
            @foreach($posts as $index => $postId)
            <div class="bg-white rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 ease-in-out transform hover:-translate-y-1 overflow-hidden">
                <div class="p-4">
                    <div class="flex items-center space-x-3 rtl:space-x-reverse mb-3">
                        <div class="w-8 h-8 bg-gradient-to-br from-purple-400 to-pink-400 rounded-full flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                            </svg>
                        </div>
                        <div>
                            <div class="font-semibold text-sm text-gray-900">hadaf_saudi</div>
                            <div class="text-xs text-gray-500">Saudi Arabia</div>
                        </div>
                    </div>
                    
                    <!-- Instagram Embed -->
                    <div class="mb-3">
                        <iframe src="https://www.instagram.com/p/{{ $postId }}/embed" 
                                width="100%" 
                                height="320" 
                                frameborder="0" 
                                scrolling="no" 
                                allowtransparency="true"
                                class="rounded-lg">
                        </iframe>
                    </div>
                    
                    <div class="flex items-center space-x-4 rtl:space-x-reverse text-sm text-gray-600">
                        <span class="flex items-center space-x-1 rtl:space-x-reverse">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                            </svg>
                            <span>{{ $index === 0 ? '1.2k' : ($index === 1 ? '856' : '2.1k') }}</span>
                        </span>
                        <span class="flex items-center space-x-1 rtl:space-x-reverse">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                            </svg>
                            <span>{{ $index === 0 ? '89' : ($index === 1 ? '67' : '156') }}</span>
                        </span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Follow Button -->
        <div class="text-center mt-8">
            <a href="https://www.instagram.com/hadaf_saudi/" 
               target="_blank" 
               rel="noopener noreferrer"
               class="inline-flex items-center space-x-2 rtl:space-x-reverse bg-gradient-to-r from-purple-500 to-pink-500 text-white px-8 py-3 rounded-full font-semibold hover:from-purple-600 hover:to-pink-600 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                </svg>
                <span>{{ __('words.instagram.follow_button') }}</span>
            </a>
        </div>
    </div>
</div>

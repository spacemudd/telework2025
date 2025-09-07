<div x-data="{
    slides: [
        {
            title: `{{ __('words.promo_rise_title') }}`,
            description: `{{ __('words.promo_rise_desc') }}`,
            buttonText: `{{ __('words.promo_rise_action') }}`,
            buttonLink: '#',
        },
        {
            title: `{{ __('words.promo_ai_title') }}`,
            description: `{{ __('words.promo_ai_desc') }}`,
            buttonText: `{{ __('words.promo_ai_action') }}`,
            buttonLink: '#',
        }
    ],
    activeSlide: 1,
    autoplayTimeout: null,
    startAutoplay() {
        this.autoplayTimeout = setTimeout(() => {
            this.activeSlide = this.activeSlide % this.slides.length + 1;
        }, 8000);
    },
    stopAutoplay() {
        clearTimeout(this.autoplayTimeout);
    },
    init() {
        this.$watch('activeSlide', () => {
            this.stopAutoplay();
            this.startAutoplay();
        });
        this.startAutoplay();
    }
}" x-init="init()" @mouseenter="stopAutoplay()" @mouseleave="startAutoplay()" class="relative rounded-2xl overflow-hidden shadow-lg mb-8 text-white" style="background-color: #012d48;">
    <div class="p-8 flex items-center min-h-[200px]">
        <div class="w-full relative text-start">
            <template x-for="(slide, index) in slides" :key="index">
                <div x-show="activeSlide === index + 1" 
                     x-transition:enter="transition ease-out duration-700"
                     x-transition:enter-start="opacity-0 transform -translate-y-4"
                     x-transition:enter-end="opacity-100 transform translate-y-0"
                     x-transition:leave="transition ease-in duration-500 absolute inset-x-0"
                     x-transition:leave-start="opacity-100 transform translate-y-0"
                     x-transition:leave-end="opacity-0 transform translate-y-4"
                     class="space-y-4">
                    <h2 class="text-3xl font-bold" x-text="slide.title"></h2>
                    <p class="text-lg text-white/80 max-w-2xl" x-text="slide.description"></p>
                    <button onclick="openPromoModal(event)" class="inline-block bg-white font-semibold px-6 py-2 rounded-lg hover:bg-gray-200 transition-colors duration-300" style="color: #012d48;" x-text="slide.buttonText"></button>
                </div>
            </template>
        </div>
    </div>
    
    <!-- Pagination -->
    <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex items-center space-x-2 rtl:space-x-reverse">
        <template x-for="(slide, index) in slides" :key="index">
            <button @click="activeSlide = index + 1" class="w-8 h-1 rounded-full" :class="{'bg-white': activeSlide === index + 1, 'bg-white/50': activeSlide !== index + 1}"></button>
        </template>
    </div>
</div>

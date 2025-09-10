<!-- Promo Modal -->
<div id="promoModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg max-w-md w-full p-6 text-center">
            <div class="flex justify-between items-center mb-4">
                <h3 id="promoModalTitle" class="text-lg font-semibold">التقديم الذكي بالذكاء الاصطناعي</h3>
                <button onclick="closePromoModal()" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div id="promoModalBody">
                <ul class="space-y-2 text-start text-gray-600 mb-6">
                    <li class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                        <span>التقديم التلقائي للوظائف المنشورة حديثاً.</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                        <span>كتابة ملخص سيرتك الذاتية تلقائياً لخطاب التقديم.</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                        <span>قبول الدعوات.</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                        <span>إرسال ملخص أسبوعي للوظائف التي تم التقديم عليها.</span>
                    </li>
                </ul>
                <div class="my-6">
                    <p class="text-4xl font-bold text-gray-800"><span class="line-through">103.5 ر.س</span> <span class="text-lg font-normal text-gray-500 line-through">/ 1 شهر</span></p>
                    <p class="text-lg font-semibold text-green-600 mt-2">لمدة محدودة فقط - الاشتراك مجاناً</p>
                </div>
                <button id="subscribeBtn" class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-full shadow-sm text-white transition-transform hover:scale-105 mb-4" style="background-color: #012d48;" onmouseover="this.style.backgroundColor='#001a2e';" onmouseout="this.style.backgroundColor='#012d48';" onfocus="this.style.outline='2px solid #012d48'; this.style.outlineOffset='2px';" onblur="this.style.outline='none';" onclick="initiateSubscription('3_months')">
                    <span id="subscribeBtnText">اشترك الآن</span>
                    <div id="subscribeBtnLoader" class="hidden ml-2">
                        <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </div>
                </button>
                <div class="mt-4">
                    <img src="{{ asset('logos/cards.png') }}" alt="طرق الدفع" class="h-8 mx-auto">
                </div>
            </div>
            <div class="flex justify-end gap-2 mt-6">
                <button type="button" onclick="closePromoModal()"
                        class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-full text-sm">
                    {{ __('words.close') }}
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function openPromoModal(event) {
    event.preventDefault();
    document.getElementById('promoModal').classList.remove('hidden');
}

function closePromoModal() {
    document.getElementById('promoModal').classList.add('hidden');
}

// Close modal when clicking outside
document.getElementById('promoModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closePromoModal();
    }
});

// Subscription success function
function initiateSubscription(planType) {
    // Set enrollment cookie (expires in 1 year)
    const expirationDate = new Date();
    expirationDate.setFullYear(expirationDate.getFullYear() + 1);
    document.cookie = `ai_subscription_enrolled=true; expires=${expirationDate.toUTCString()}; path=/; SameSite=Lax`;
    
    // Show success message by updating modal content
    const promoModalTitle = document.getElementById('promoModalTitle');
    const promoModalBody = document.getElementById('promoModalBody');
    
    // Update modal title
    promoModalTitle.textContent = 'تم الاشتراك بنجاح!';
    
    // Update modal body with success message
    promoModalBody.innerHTML = `
        <div class="text-center py-8">
            <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-green-100 mb-4">
                <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">تم الاشتراك بنجاح!</h3>
            <p class="text-sm text-gray-600">يمكنك الآن الاستفادة من جميع ميزات التقديم الذكي بالذكاء الاصطناعي</p>
        </div>
    `;
}
</script>
@endpush

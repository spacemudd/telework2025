<div class="p-5">
    <div class="flex items-center space-x-2">
        <input
            id="global-search"
            type="text"
            placeholder="{{ __('words.search_placeholder') }}"
            class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
        >
    </div>

    <div id="search-results" class="mt-4 bg-white shadow rounded p-4 hidden">
        <ul id="results-list" class="space-y-2"></ul>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const input = document.getElementById('global-search');
        const resultsBox = document.getElementById('search-results');
        const resultsList = document.getElementById('results-list');
        let timeout = null;

        input.addEventListener('input', function () {
            clearTimeout(timeout);

            timeout = setTimeout(() => {
                const query = input.value.trim();
                if (query.length < 2) {
                    resultsBox.classList.add('hidden');
                    return;
                }

                fetch(`/admin/search?query=${encodeURIComponent(query)}`)
                    .then(response => response.json())
                    .then(data => {
                        resultsList.innerHTML = '';
                        if (data.length > 0) {
                            resultsBox.classList.remove('hidden');
                            data.forEach(item => {
                                const li = document.createElement('li');
                                li.innerHTML = `<a href="${item.link}" class="text-blue-600 hover:underline"><strong>${item.type}</strong>: ${item.name} (${item.extra})</a>`;
                                resultsList.appendChild(li);
                            });
                        } else {
                            resultsBox.classList.remove('hidden');
                            resultsList.innerHTML = '<li class="text-gray-500">لا توجد نتائج</li>';
                        }
                    });
            }, 300);
        });
    });
</script>

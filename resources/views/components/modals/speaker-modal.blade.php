{{-- Adam Ahmed -> Edited the Speaker Modal  --}}
@if (Auth::user() && Auth::user()->role == 'speaker')
    <div id="speakerModal"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/80
        {{ session('errors') && str_starts_with(array_keys(session('errors')->getBags())[0] ?? '', 'speaker') ? '' : 'hidden' }}">
        <div class="bg-white dark:bg-dark-bg w-full max-w-xl rounded-2xl p-8 shadow-2xl relative mx-4">
            <!-- Close Button -->
            <button onclick="closeSpeakerModal()"
                class="cursor-pointer absolute top-4 right-4 text-white bg-gray-600 dark:bg-gray-500 hover:bg-gray-700 dark:hover:bg-gray-400 transition-colors rounded-full w-10 h-10 flex items-center justify-center focus:outline-none">
                <i class="fas fa-times text-lg"></i>
            </button>

            <!-- Title -->
            <h2 class="text-2xl font-semibold font-heading mb-6 text-primary dark:text-dark-primary">Request to be a
                Speaker</h2>

            <!-- Form -->
            <form action="{{ route('speaker.createproposal', ['id' => $event->id]) }}" method="POST"
                enctype="multipart/form-data" class="space-y-4">
                @csrf

                <!-- Talk Title -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Talk Title</label>
                    <input type="text" name="title" value="{{ old('title') }}"
                        class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-dark-bg text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-accent focus:outline-none">
                    @error('title', 'speaker')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Description</label>
                    <textarea name="description" rows="4" style="color:red !important;"
                        class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-dark-bg text-primary dark:text-dark-primary focus:ring-2 focus:ring-accent focus:outline-none">
                        {{ old('description') }}
                    </textarea>
                    @error('description', 'speaker')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <!-- Upload CV -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Upload CV (PDF or
                        DOCX)</label>
                    <input type="file" name="cv"
                        accept="application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document"
                        class="block w-full text-sm text-gray-900 dark:text-gray-100 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-accent file:text-white hover:file:bg-accent-hover transition-all cursor-pointer">
                    @error('cv', 'speaker')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div>
                    <button type="submit"
                        class="cursor-pointer w-full py-3 rounded-lg bg-accent hover:bg-accent-hover text-white text-sm font-semibold transition-colors">
                        Submit Proposal
                    </button>
                </div>
            </form>
        </div>
    </div>

    @section('scripts')
        <script>
            function openSpeakerModal() {
                document.getElementById('speakerModal').classList.remove('hidden');
                @if (session('errors'))
                    window.history.replaceState({}, document.title, window.location.pathname);
                @endif
            }

            function closeSpeakerModal() {
                document.getElementById('speakerModal').classList.add('hidden');
                @if (session('errors'))
                    window.history.replaceState({}, document.title, window.location.pathname);
                @endif
            }

            document.addEventListener('DOMContentLoaded', function() {
                @if ($errors->getBag('speaker')->any())
                    openSpeakerModal();
                @endif
            });
        </script>
    @endsection
@endif

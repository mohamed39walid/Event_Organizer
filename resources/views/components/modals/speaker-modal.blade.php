<div id="speakerModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/80 hidden shadow-2xl">
    <div class="bg-bg dark:bg-dark-bg w-full max-w-xl rounded-xl p-10 relative">
        <button onclick="closeSpeakerModal()"
            class="absolute top-4 right-4 text-gray-200 rounded-full cursor-pointer hover:text-gray-100 bg-gray-400 dark:bg-gray-600 w-10 h-10 flex justify-center items-center">
            <i class="fas fa-times"></i>
        </button>
        <h2 class="text-xl font-bold font-heading mb-4 text-primary dark:text-dark-primary">Request to be a Speaker</h2>

        <form action="{{ route('speaker.createproposal', ['id' => $event->id]) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium font-inter text-secondary dark:text-dark-secondary mb-1">
                    Talk Title
                </label>
                <input type="text" name="title" 
                    class="w-full px-4 py-2 border border-border dark:border-dark-border rounded-lg bg-white dark:bg-dark-bg text-primary dark:text-dark-primary focus:outline-none focus:ring-2 focus:ring-accent">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium font-inter text-secondary dark:text-dark-secondary mb-1">
                    Description
                </label>
                <textarea name="description"  rows="4"
                    class="w-full px-4 py-2 border border-border dark:border-dark-border rounded-lg bg-white dark:bg-dark-bg text-primary dark:text-dark-primary focus:outline-none focus:ring-2 focus:ring-accent"></textarea>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium font-inter text-secondary dark:text-dark-secondary mb-1">
                    Upload CV (PDF or DOCX)
                </label>
                <input type="file" name="cv" accept="application/pdf" 
                    class="w-full file:px-4 file:py-1 cursor-pointer file:border-none file:rounded-lg file:bg-accent file:text-white text-primary dark:text-dark-primary bg-white dark:bg-dark-bg">
            </div>

            <button type="submit"
                class="w-full px-4 cursor-pointer py-2.5 bg-accent hover:bg-accent-hover text-white text-sm font-medium font-poppins rounded-lg transition-colors duration-200">
                Submit Proposal
            </button>
        </form>
    </div>
</div>

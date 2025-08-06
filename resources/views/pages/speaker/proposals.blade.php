@extends('layouts.app')

@php
    use Carbon\Carbon;

    $search = request('search');
    $filteredProposals = $proposals
        ->when($search, function ($collection) use ($search) {
            $searchTerm = strtolower($search);
            return $collection->filter(function ($proposal) use ($searchTerm) {
                return str_contains(strtolower($proposal->title), $searchTerm) ||
                    str_contains(strtolower($proposal->description), $searchTerm) ||
                    str_contains(strtolower($proposal->event->event_name), $searchTerm) ||
                    str_contains(strtolower($proposal->event->location), $searchTerm) ||
                    str_contains(strtolower(optional($proposal->speaker)->fullname ?? ''), $searchTerm) ||
                    str_contains(strtolower($proposal->status), $searchTerm);
            });
        })
        ->sortByDesc('created_at');

    $statusConfig = [
        'pending' => [
            'classes' =>
                'bg-yellow-100 text-yellow-800 border-yellow-200 dark:bg-yellow-900/20 dark:text-yellow-300 dark:border-yellow-800',
            'icon' => 'fas fa-clock',
            'label' => 'Under Review',
        ],
        'approved' => [
            'classes' =>
                'bg-green-100 text-green-800 border-green-200 dark:bg-green-900/20 dark:text-green-300 dark:border-green-800',
            'icon' => 'fas fa-check-circle',
            'label' => 'Approved',
        ],
        'rejected' => [
            'classes' =>
                'bg-red-100 text-red-800 border-red-200 dark:bg-red-900/20 dark:text-red-300 dark:border-red-800',
            'icon' => 'fas fa-times-circle',
            'label' => 'Rejected',
        ],
    ];

    $statusIcons = [
        'all' => 'fas fa-list',
        'pending' => 'fas fa-clock',
        'approved' => 'fas fa-check-circle',
        'rejected' => 'fas fa-times-circle',
    ];
@endphp

@section('main')
    <div class="max-w-7xl mx-auto space-y-8 min-h-screen mt-10 px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <header class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6">
            <div>
                <h1 class="text-3xl font-bold text-primary dark:text-dark-primary">My Proposals</h1>
                <p class="mt-2 text-muted dark:text-dark-muted">Track your speaking proposals and their status</p>
            </div>
            <!-- Search -->
            <form method="GET" class="w-full sm:w-auto">
                <div class="relative">
                    <input type="search" name="search" value="{{ request('search') }}"
                        placeholder="Search proposals, events, or speakers..."
                        class="w-full md:w-80 px-5 py-3 pl-12 rounded-lg border border-border dark:border-dark-border bg-surface dark:bg-dark-surface text-primary dark:text-dark-primary placeholder-muted dark:placeholder-dark-muted focus:ring-2 focus:ring-accent"
                        autocomplete="off">
                    <div
                        class="absolute left-4 top-1/2 transform -translate-y-1/2 text-muted dark:text-dark-muted pointer-events-none">
                        <i class="fas fa-search"></i>
                    </div>
                </div>
            </form>
        </header>

        <!-- Filter Pills -->
        <div class="flex flex-wrap gap-2">
            @foreach (['all', 'pending', 'approved', 'rejected'] as $status)
                @php
                    $isActive = request('search') === $status || ($status === 'all' && !request('search'));
                    $count = $status === 'all' ? $proposals->count() : $proposals->where('status', $status)->count();
                @endphp
                <a href="{{ request()->fullUrlWithQuery(['search' => $status === 'all' ? null : $status]) }}"
                    class="inline-flex items-center px-3 py-2 rounded-lg text-sm font-medium transition-all duration-200 {{ $isActive ? 'bg-accent text-white shadow-sm' : 'bg-surface hover:bg-accent/5 dark:bg-dark-surface dark:hover:bg-accent/5 text-muted hover:text-accent border border-border dark:border-dark-border' }}">
                    <i class="{{ $statusIcons[$status] ?? 'fas fa-question-circle' }} text-xs mr-1.5"></i>
                    {{ ucfirst($status) }}
                    <span
                        class="ml-1.5 {{ $isActive ? 'text-white/80' : 'text-muted dark:text-dark-muted' }}">({{ $count }})</span>
                </a>
            @endforeach
        </div>

        <!-- Proposals Grid -->
        <main>
            @if ($filteredProposals->isNotEmpty())
                <div class="grid gap-6 sm:gap-8">
                    @foreach ($filteredProposals as $proposal)
                        @php
                            $config = $statusConfig[$proposal->status] ?? [
                                'classes' =>
                                    'bg-muted/10 text-muted border-muted/20 dark:bg-dark-muted/10 dark:text-dark-muted dark:border-dark-muted/20',
                                'icon' => 'fas fa-question-circle',
                                'label' => ucfirst($proposal->status),
                            ];
                        @endphp

                        <article
                            class="group bg-surface dark:bg-dark-surface rounded-xl border border-border dark:border-dark-border transition-all duration-300 hover:shadow-lg transform overflow-hidden">
                            <div class="p-6 sm:p-8 relative">
                                <!-- Status Badge -->
                                <div class="absolute top-6 right-6 z-10">
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium border {{ $config['classes'] }}">
                                        <i class="{{ $config['icon'] }} mr-1.5 text-sm"></i>
                                        {{ $config['label'] }}
                                    </span>
                                </div>

                                <!-- Header -->
                                <header class="mb-6 pr-24">
                                    <h2 class="text-xl sm:text-2xl font-bold text-secondary dark:text-dark-secondary mb-3">
                                        {{ $proposal->title }}
                                    </h2>
                                    <div class="flex items-center gap-2 text-sm text-muted dark:text-dark-muted">
                                        <i class="fas fa-calendar-alt"></i>
                                        <span>Submitted {{ $proposal->created_at->diffForHumans() }}</span>
                                    </div>
                                </header>

                                <!-- Description -->
                                <div class="space-y-6">
                                    <div>
                                        <h3 class="text-sm font-medium text-muted dark:text-dark-muted uppercase mb-2">
                                            Description</h3>
                                        <p class="text-primary dark:text-dark-primary">
                                            {{ Str::limit($proposal->description, 200) }}
                                        </p>
                                    </div>

                                    <!-- Event Details -->
                                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                        <div class="space-y-4">
                                            <h3 class="text-sm font-medium text-muted dark:text-dark-muted uppercase">Event
                                                Details</h3>
                                            <div class="space-y-3">
                                                <div class="flex items-start gap-3">
                                                    <i class="fas fa-map-marker-alt text-accent mt-1 w-5"></i>
                                                    <div>
                                                        <p class="font-medium text-primary dark:text-dark-primary">
                                                            {{ $proposal->event->event_name }}
                                                        </p>
                                                        <p class="text-sm text-muted dark:text-dark-muted">
                                                            {{ $proposal->event->location }}
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="flex items-start gap-3">
                                                    <i class="fas fa-calendar-week text-accent mt-1 w-5"></i>
                                                    <div class="text-sm">
                                                        <p class="text-primary dark:text-dark-primary">
                                                            {{ Carbon::parse($proposal->event->start_date)->format('M j, Y') }}
                                                            -
                                                            {{ Carbon::parse($proposal->event->end_date)->format('M j, Y') }}
                                                        </p>
                                                        <p class="text-muted dark:text-dark-muted">
                                                            {{ Carbon::parse($proposal->event->start_date)->diffInDays(Carbon::parse($proposal->event->end_date)) + 1 }}
                                                            days
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Footer / Action -->
                                <footer class="pt-6 border-t border-border dark:border-dark-border mt-8">
                                    @if ($proposal->cv)
                                        <a href="{{ asset('storage/' . $proposal->cv) }}" target="_blank"
                                            class="inline-flex items-center gap-2 px-5 py-3 bg-accent hover:bg-accent-hover text-white rounded-lg font-medium transition-all duration-200 hover:shadow-lg transform ">
                                            <i class="fas fa-file-alt"></i>
                                            View CV
                                            <i class="fas fa-arrow-right"></i>
                                        </a>
                                    @endif
                                </footer>
                            </div>
                        </article>
                    @endforeach
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-16">
                    <div class="mx-auto max-w-md">
                        <i class="fas fa-folder-open text-5xl text-muted dark:text-dark-muted mb-6"></i>
                        <h3 class="text-xl font-bold text-secondary dark:text-dark-secondary mb-2">No proposals found</h3>
                        <p class="text-muted dark:text-dark-muted mb-6">
                            {{ $search ? 'No proposals match your search criteria.' : "You haven't submitted any proposals yet." }}
                        </p>
                        <a href="{{ $search ? route('speaker.my-proposals') : route('speaker.createproposal') }}"
                            class="inline-flex items-center px-4 py-2 bg-accent hover:bg-accent-hover text-white rounded-lg font-medium transition-colors focus:ring-2 focus:ring-accent/50">
                            {{ $search ? 'View all proposals' : 'Submit New Proposal' }}
                        </a>
                    </div>
                </div>
            @endif
        </main>
    </div>
@endsection


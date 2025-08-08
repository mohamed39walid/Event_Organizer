@extends('layouts.app')

@section('main')
    {{-- Hero Section --}}
    <section class="relative overflow-hidden bg-dark-bg dark:bg-dark-bg text-white">
        <img src="{{ asset('images/hero-talks.webp') }}" alt="Event Hub Background"
            class="absolute inset-0 w-full h-full object-cover opacity-20">

        <div class="relative z-10 container mx-auto px-4 py-20 lg:py-32 text-center">
            <h1 class="text-4xl md:text-6xl lg:text-7xl font-bold mb-6 font-heading">
                Welcome to <span class="text-accent">Event Hub</span>
            </h1>
            <p class="text-xl md:text-2xl mb-8 max-w-3xl mx-auto leading-relaxed text-muted font-manrope">
                Connect with inspiring speakers, discover meaningful conversations, and create unforgettable events that
                matter.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="#events"
                    class="border hover:border-2 bg-accent hover:bg-accent-hover text-white font-semibold px-8 py-3 rounded-full transition-all duration-300 backdrop-blur-sm font-poppins">
                    Explore Events
                </a>
                <a href="#about"
                    class="border-2 border-dark-border hover:border-accent text-white font-semibold px-8 py-3 rounded-full transition-all duration-300 backdrop-blur-sm font-poppins">
                    Show Event
                </a>
            </div>
        </div>
    </section>

    {{-- Upcoming Events --}}
    <section id="events" class="py-24 bg-bg dark:bg-dark-bg">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-secondary dark:text-dark-primary mb-4 font-heading">
                    Upcoming Events
                </h2>
                <p class="text-lg text-muted dark:text-muted max-w-2xl mx-auto font-manrope">
                    Join our community of curious minds and passionate speakers.
                </p>
            </div>

            <div class="grid grid-cols-3 gap-10 max-w-6xl mx-auto">
                @foreach ($events as $event)
                    <x-card :eventid="$event->id" :eventName="$event->event_name" :date="$event->start_date" :endDate="$event->end_date" :location="$event->location"
                        :image="$event->image ? $event->image : asset('images/Concert.jpg')" :tickets="$event->available_tickets" :status="$event->status" :organizer="$event->organizer->username" />
                @endforeach
            </div>

            <div class="text-center mt-12">
                <a href="{{ route('events') }}"
                    class="bg-accent hover:bg-accent-hover text-white font-semibold px-8 py-3 rounded-full shadow-lg transition-all duration-300 transform hover:scale-105 font-poppins">
                    View All Events
                </a>
            </div>
        </div>
    </section>



    {{-- About Section --}}
    <section id="about" class="py-24 bg-surface dark:bg-dark-surface">
        <div class="container mx-auto px-4 text-center">
            <div class="max-w-4xl mx-auto">
                <h2 class="text-3xl md:text-4xl font-bold text-secondary dark:text-dark-primary mb-6 font-heading">
                    About Event Hub
                </h2>
                <p class="text-lg md:text-xl text-primary dark:text-dark-secondary leading-relaxed mb-8 font-manrope">
                    We believe that great conversations change the world. Event Hub connects passionate speakers with
                    engaged audiences, creating spaces where ideas flourish and communities grow. Whether you're organizing
                    an intimate workshop or a large-scale conference, we provide the tools to make it extraordinary.
                </p>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-8 mt-12">
                    <div class="text-center">
                        <div class="text-3xl font-bold text-accent font-urbanist">500+</div>
                        <div class="text-muted dark:text-muted font-manrope">Events Hosted</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-accent font-urbanist">10K+</div>
                        <div class="text-muted dark:text-muted font-manrope">Community Members</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-accent font-urbanist">200+</div>
                        <div class="text-muted dark:text-muted font-manrope">Featured Speakers</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-accent font-urbanist">50+</div>
                        <div class="text-muted dark:text-muted font-manrope">Cities Worldwide</div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

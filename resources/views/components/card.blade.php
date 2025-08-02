<?php use Carbon\Carbon;
?>
<div class="w-[350px] h-[400px] bg-surface dark:bg-dark-surface rounded-4xl shadow-lg">
    <div class="relative">
        <div class="absolute h-full w-full bg-black/20 dark:bg-black/50 rounded-4xl"></div>
        <img src="{{ asset($image) }}" alt="" class="rounded-4xl shadow-md w-full h-[250px] object-cover">
    </div>

    <div class="flex justify-between items-center h-[150px] py-10">
        <div class="border-r w-1/4 h-full flex flex-col justify-center items-center text-2xl">
            <h1>{{ Carbon::parse($date)->format('M') }}</h1>
            <h1 class="font-bold">{{ Carbon::parse($date)->format('d') }}</h1>
        </div>
        <div class="w-3/4 pl-6">
            <p class="font-manrope text-muted dark:text-dark-muted leading-5 tracking-wide">
                <i class="fa-solid fa-location-dot"></i> {{ $location }}
            </p>
            <h1 class="font-heading text-secondary dark:text-dark-secondary text-xl">
                {{ $eventName }}
            </h1>
        </div>
    </div>
</div>

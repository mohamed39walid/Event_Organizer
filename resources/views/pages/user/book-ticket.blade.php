@extends('layouts.app')

@php
    $event = [
        'id' => 1,
        'eventName' => 'Live Talk Night',
        'location' => 'Alexandria',
        'start-date' => '2025-08-20',
        'end-date' => '2025-08-24',
        'available_tickets' => 'Available',
        'status' => 'Active',
        'organizer_name' => 'Ahmed Khaled',
    ];
@endphp
@section('main')
    <x-card :eventid="$event['id']" :eventName="$event['eventName']" :date="$event['start-date']" :endDate="$event['end-date']" :location="$event['location']" :image="$event['image'] ?? ''"
        :tickets="$event['available_tickets']" :status="$event['status']" :organizer="$event['organizer_name']" />
@endsection

@extends('layouts.app')

@section('main')
    {{-- IMPORTANT - READ --}}
    {{-- Uncomment when the FrontEnd part Ends  --}}
    {{--
1- Should require all the proposlas
2- on each card on the proposals, there must be an Accept or Decline Proposal for the speaker who requested
Example Should be :

Accepted Proposal
<form action="{{ route('proposal.approve', $proposal->id) }}" method="POST">
    @csrf
    <button type="submit">Accept Proposal</button>
</form>


Rejected Proposal
<form action="{{ route('proposal.reject', $proposal->id) }}" method="POST">
    @csrf
    <button type="submit">Reject Proposal</button>
</form>

--}}
    <div
        class="min-h-[calc(100vh-140px)] flex flex-col justify-center items-center px-4 bg-bg text-foreground dark:bg-dark-bg dark:text-dark-foreground">
        <div class="space-y-6">
            <h1
                class="text-8xl text-center font-instrument sm:text-9xl font-extrabold text-error dark:text-dark-error tracking-tight drop-shadow-lg">
                Review Proposals Page
            </h1>
        </div>
    </div>
@endsection

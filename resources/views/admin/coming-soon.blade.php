@extends('admin.includes.layout')

@section('title', $title ?? 'Coming Soon')

@section('content')
<div class="container-fluid mt-4">
    <div class="card shadow-sm border-0 w-100" style="border-radius: 12px; position: relative; overflow: hidden; min-height: 70vh;">
        <!-- Optional faint background patterns could go here -->
        <div class="card-body text-center d-flex flex-column justify-content-center align-items-center" style="padding: 80px 40px;">
            
            <div class="mb-4 text-secondary">
                <i class="fas fa-tools" style="font-size: 60px; color: #6c757d;"></i>
            </div>
            
            <h3 class="mb-4 fw-bold text-dark">{{ $title ?? 'This' }} Feature: Coming Soon</h3>
            
            <p class="text-muted mb-5" style="font-size: 16px; line-height: 1.6; max-width: 600px; margin: 0 auto;">
                @if(isset($title) && $title == 'Forms')
                    We are building an intuitive drag-and-drop form builder integrated with your workflow, designed to streamline repetitive reservation, recipient, and solution data into your future.
                @elseif(isset($title) && $title == 'Imports')
                    We are building an intuitive import tool integrated with your workflow, designed to seamlessly transfer your existing data into our system.
                @else
                    We are working hard to bring this feature to you. Stay tuned!
                @endif
            </p>
            
            <a href="{{ route('admin.dashboard') }}" class="btn mt-2 px-4 py-2" style="background-color: #554e5e; color: white; border-radius: 8px; font-weight: 500;">
                <i class="fas fa-arrow-left me-2"></i> Return to Dashboard
            </a>
            
        </div>
    </div>
</div>
@endsection

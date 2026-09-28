@extends('layouts.app')

@section('title', 'Size Chart - ThreadLine')

@section('content')
<div class="page-header">
    <h1>Size Chart</h1>
    <p>Find your perfect fit</p>
</div>

<section class="section">
    <div class="container" style="max-width: 700px;">
        <h2 style="font-family: var(--font-heading); font-size: 20px; margin-bottom: 8px;">Clothing Size Guide</h2>
        <p style="color: var(--secondary); margin-bottom: 24px; font-size: 13px;">All measurements are in inches. For the best fit, measure a similar garment that fits you well.</p>

        <table class="size-chart-table">
            <thead>
                <tr>
                    <th>Size</th>
                    <th>Width</th>
                    <th>Length</th>
                </tr>
            </thead>
            <tbody>
                @forelse($sizes as $size)
                    <tr>
                        <td><strong>{{ $size->name }}</strong></td>
                        <td>{{ $size->width ?? '-' }}</td>
                        <td>{{ $size->length ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center">No sizes available.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4" style="background: var(--light); padding: 24px; border-radius: var(--radius);">
            <h3 style="font-size: 14px; font-weight: 600; margin-bottom: 12px;">How to Measure</h3>
            <ul style="list-style: none; font-size: 13px; color: var(--secondary); line-height: 2;">
                <li><strong>Width:</strong> Measure across the chest, 1 inch below the armhole.</li>
                <li><strong>Length:</strong> Measure from the highest point of the shoulder to the bottom hem.</li>
            </ul>
        </div>
    </div>
</section>
@endsection

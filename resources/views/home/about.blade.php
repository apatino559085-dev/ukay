@extends('layouts.app')

@section('title', 'About Us - THRIFT FINDS Online Ukay Store')

@section('content')
<div class="page-header">
    <h1>About THRIFT FINDS</h1>
    <p>Your destination for curated, sustainable pre-loved fashion</p>
</div>

<section class="section">
    <div class="container" style="max-width: 800px;">
        <div style="line-height: 1.8; color: #333333; font-size: 15px;">
            <h2 style="font-family: var(--font-heading); font-size: 24px; margin-bottom: 16px;">Our Story & Ukay Concept</h2>
            <p style="margin-bottom: 20px;">
                <strong>THRIFT FINDS</strong> was established with a clear goal: to make sustainable, high-quality pre-loved clothing accessible online. We believe that every vintage garment carries a story, character, and timeless appeal that modern fast-fashion simply cannot replicate.
            </p>

            <h3 style="font-size: 18px; font-weight: 600; margin-top: 30px; margin-bottom: 12px;">The 1-of-1 Unique Item Promise</h3>
            <p style="margin-bottom: 20px;">
                Unlike standard retail stores with mass-produced inventory, almost all items in our catalog are <strong>unique 1-of-1 pieces</strong> (Stock: 1). Once a customer purchases a vintage jacket or rare graphic tee, it is marked as <strong>SOLD OUT</strong> and cannot be restocked. If you find a piece you love, snag it before someone else does!
            </p>

            <h3 style="font-size: 18px; font-weight: 600; margin-top: 30px; margin-bottom: 12px;">Condition & Transparency</h3>
            <p style="margin-bottom: 20px;">
                We thoroughly inspect, clean, and grade every thrift item into four clear condition ratings:
            </p>
            <ul style="padding-left: 20px; margin-bottom: 20px; line-height: 2;">
                <li><strong>New / Like New:</strong> Unworn or pristine condition with no visible wear.</li>
                <li><strong>Excellent:</strong> Gently worn with minimal signs of prior use.</li>
                <li><strong>Good:</strong> Pre-loved item with minor authentic wear, fully functional and wearable.</li>
                <li><strong>Fair:</strong> Visible signs of age or minor distressing that add vintage charm.</li>
            </ul>

            <div style="text-align: center; margin-top: 40px;">
                <a href="{{ route('shop') }}" class="btn btn-primary">Start Shopping Ukay Finds →</a>
            </div>
        </div>
    </div>
</section>
@endsection

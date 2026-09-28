@extends('layouts.app')

@section('title', 'About Us - ThreadLine')

@section('content')
<div class="page-header">
    <h1>About Us</h1>
    <p>Our story, our mission</p>
</div>

<section class="section">
    <div class="container">
        <div class="about-grid">
            <div class="about-image">
                <i class="fas fa-scissors"></i>
            </div>
            <div class="about-text">
                <h2>The ThreadLine Story</h2>
                <p>ThreadLine started as a small idea between friends who shared a love for well-made clothing. We believed that streetwear could be both affordable and premium — without cutting corners on quality.</p>
                <p>Every piece in our collection is carefully designed and crafted using high-quality fabrics. From our signature graphic tees to our heavyweight hoodies, we focus on creating versatile essentials that last.</p>
                <p>Based in the Philippines, we're proud to offer contemporary streetwear that celebrates individuality and self-expression. Our designs are minimal, our quality is maximal.</p>
            </div>
        </div>

        <div class="mt-4" style="text-align: center; max-width: 600px; margin: 60px auto 0;">
            <h2 style="font-family: var(--font-heading); font-size: 24px; margin-bottom: 16px;">Our Values</h2>
            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 30px; margin-top: 30px;">
                <div>
                    <div style="font-size: 28px; margin-bottom: 12px;"><i class="fas fa-leaf"></i></div>
                    <h3 style="font-size: 14px; font-weight: 600; margin-bottom: 8px;">Quality First</h3>
                    <p style="font-size: 13px; color: var(--secondary);">Premium fabrics and construction in every piece.</p>
                </div>
                <div>
                    <div style="font-size: 28px; margin-bottom: 12px;"><i class="fas fa-heart"></i></div>
                    <h3 style="font-size: 14px; font-weight: 600; margin-bottom: 8px;">Made With Care</h3>
                    <p style="font-size: 13px; color: var(--secondary);">Every detail is intentional and thoughtful.</p>
                </div>
                <div>
                    <div style="font-size: 28px; margin-bottom: 12px;"><i class="fas fa-recycle"></i></div>
                    <h3 style="font-size: 14px; font-weight: 600; margin-bottom: 8px;">Sustainable</h3>
                    <p style="font-size: 13px; color: var(--secondary);">Conscious choices for a better future.</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

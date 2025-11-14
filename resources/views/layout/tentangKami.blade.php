<style>
    .mission-section {
        padding: 5rem 2rem;
        background-color: #fff;
        position: relative;
    }

    .mission-container {
        max-width: 1200px;
        margin: 0 auto;
        display: flex;
        align-items: center;
        gap: 4rem;
        flex-wrap: wrap;
    }

    .mission-text {
        flex: 1;
        min-width: 300px;
    }

    .mission-text h2 {
        font-size: 2.5rem;
        font-weight: 700;
        color: #2d3748;
        margin-bottom: 1.5rem;
        line-height: 1.2;
    }

    .mission-text p {
        font-size: 1.125rem;
        line-height: 1.7;
        color: #4a5568;
        margin-bottom: 1.5rem;
    }

    .mission-image-wrapper {
        flex: 1;
        min-width: 300px;
        position: relative;
        overflow: hidden;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
    }

    .mission-image {
        width: 100%;
        height: auto;
        object-fit: cover;
        border-radius: 20px;
    }

    /* Custom shape overlay (like HubSpot) */
    .shape-overlay {
        position: absolute;
        bottom: -20px;
        right: -20px;
        width: 300px;
        height: 300px;
        background: #f7fafc;
        border-radius: 50%;
        z-index: 1;
        opacity: 0.7;
    }

    .story-section {
        padding: 5rem 2rem;
        background-color: #f7fafc;
    }

    .story-container {
        max-width: 1200px;
        margin: 0 auto;
        display: flex;
        align-items: center;
        gap: 4rem;
        flex-wrap: wrap;
        flex-direction: row-reverse; /* Image on left, text on right */
    }

    .story-text {
        flex: 1;
        min-width: 300px;
    }

    .story-text h2 {
        font-size: 2.5rem;
        font-weight: 700;
        color: #2d3748;
        margin-bottom: 1.5rem;
        line-height: 1.2;
    }

    .story-text p {
        font-size: 1.125rem;
        line-height: 1.7;
        color: #4a5568;
        margin-bottom: 1.5rem;
    }

    .story-image-wrapper {
        flex: 1;
        min-width: 300px;
        position: relative;
        overflow: hidden;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
    }

    .story-image {
        width: 100%;
        height: auto;
        object-fit: cover;
        border-radius: 20px;
    }

    @media (max-width: 992px) {
        .mission-container,
        .story-container {
            flex-direction: column;
            gap: 2rem;
        }

        .mission-text,
        .story-text {
            order: 2;
        }

        .mission-image-wrapper,
        .story-image-wrapper {
            order: 1;
        }

        .mission-text h2,
        .story-text h2 {
            font-size: 2rem;
        }
    }

    @media (max-width: 768px) {
        .mission-section,
        .story-section {
            padding: 3rem 1rem;
        }

        .mission-text h2,
        .story-text h2 {
            font-size: 1.75rem;
        }

        .mission-text p,
        .story-text p {
            font-size: 1rem;
        }
    }
</style>

@extends('layout.master')

@section('content')
<div class="mission-section">
    <div class="mission-container">
        <div class="mission-text">
            <h2>Misi Kami</h2>
            <p>
                <strong>Pawslife</strong> adalah platform yang peduli terhadap kesejahteraan kucing dan anjing yang membutuhkan rumah penuh kasih. Misi kami sederhana namun bermakna, yaitu 
                <strong>menghubungkan hewan terlantar dengan orang-orang baik yang siap mengadopsi dan merawat mereka.</strong>
            </p>
            <p>
                Setiap kucing dan anjing yang kami bantu berasal dari latar belakang berbeda — ada yang diselamatkan dari jalanan atau ditinggalkan pemiliknya. Kami percaya bahwa setiap hewan berhak mendapat kesempatan kedua untuk hidup lebih baik.
            </p>
        </div>
        <div class="mission-image-wrapper">
            <img src="/image/tentangKami/TentangKami1.jpg" alt="Pawslife Mission" class="mission-image">
        </div>
    </div>
</div>

<div class="story-section">
    <div class="story-container">
        <div class="story-text">
            <h2>Cerita Kami</h2>
            <p>
                Bergabunglah dengan kami dalam menciptakan dunia yang lebih ramah bagi hewan. Adopsi bukan sekadar menyelamatkan satu nyawa — ini adalah awal dari kisah cinta tanpa syarat.
            </p>
            <p>
                Kami memulai perjalanan ini dari kepedulian sederhana: melihat banyak kucing dan anjing yang terlantar, dan ingin memberi mereka rumah yang hangat. Dari ide kecil itu, Pawslife lahir — sebuah platform yang tidak hanya mencocokkan hewan dengan pemilik, tapi juga membangun komunitas yang saling peduli.
            </p>
        </div>
        <div class="story-image-wrapper">
            <img src="/image/tentangKami/TentangKami2.jpg" alt="Pawslife Story" class="story-image">
        </div>
    </div>
</div>
@endsection
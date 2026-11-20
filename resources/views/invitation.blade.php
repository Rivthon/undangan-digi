<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Undangan pernikahan {{ $invitation['bride']['short_name'] }} dan {{ $invitation['groom']['short_name'] }}">
    <title>{{ $invitation['bride']['short_name'] }} & {{ $invitation['groom']['short_name'] }} — Wedding Invitation</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;1,500&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/invitation.css') }}">
</head>
<body class="locked">
    <div class="opening" id="opening">
        <div class="opening__veil"></div>
        <div class="opening__content">
            <span class="eyebrow">The Wedding of</span>
            <h1>{{ $invitation['bride']['short_name'] }} <i>&</i> {{ $invitation['groom']['short_name'] }}</h1>
            <div class="ornament">✦</div>
            <p>Kepada Yth.<br><strong>{{ $guestName ?: 'Tamu Undangan' }}</strong></p>
            <small>Mohon maaf apabila ada kesalahan penulisan nama atau gelar</small>
            <button class="button button--light" id="openInvitation" type="button">Buka Undangan</button>
        </div>
    </div>

    <main id="mainContent">
        <section class="hero section-dark">
            <div class="hero__image"></div>
            <div class="hero__overlay"></div>
            <div class="hero__content reveal">
                <span class="eyebrow">We are getting married</span>
                <h2>{{ $invitation['bride']['short_name'] }} <i>&</i> {{ $invitation['groom']['short_name'] }}</h2>
                <p>{{ $invitation['display_date'] }}</p>
                <a href="#couple" class="scroll-hint" aria-label="Lihat undangan">⌄</a>
            </div>
        </section>

        <section class="intro paper-section" id="couple">
            <div class="container narrow reveal">
                <span class="eyebrow sage">Assalamu’alaikum Warahmatullahi Wabarakatuh</span>
                <p>Dengan memohon rahmat dan ridho Allah SWT, kami bermaksud mengundang Bapak/Ibu/Saudara/i untuk hadir dan memberikan doa restu pada pernikahan kami.</p>
                <div class="botanical">❦</div>
            </div>
            <div class="couple container">
                <article class="person reveal">
                    <div class="person__photo person__photo--bride"><span>A</span></div>
                    <h3>{{ $invitation['bride']['name'] }}</h3>
                    <p>{{ $invitation['bride']['parents'] }}</p>
                    <a href="https://instagram.com/{{ $invitation['bride']['instagram'] }}" target="_blank" rel="noopener">@ {{ $invitation['bride']['instagram'] }}</a>
                </article>
                <div class="ampersand reveal">&</div>
                <article class="person reveal">
                    <div class="person__photo person__photo--groom"><span>R</span></div>
                    <h3>{{ $invitation['groom']['name'] }}</h3>
                    <p>{{ $invitation['groom']['parents'] }}</p>
                    <a href="https://instagram.com/{{ $invitation['groom']['instagram'] }}" target="_blank" rel="noopener">@ {{ $invitation['groom']['instagram'] }}</a>
                </article>
            </div>
        </section>

        <section class="quote section-dark">
            <div class="container narrow reveal">
                <span class="quote__mark">“</span>
                <blockquote>{{ $invitation['quote'] }}</blockquote>
                <p>— QS. Ar-Rum: 21 —</p>
            </div>
        </section>

        <section class="events paper-section" id="events">
            <div class="container reveal">
                <span class="eyebrow sage">Save the date</span>
                <h2 class="section-title">Hari Bahagia Kami</h2>
                <p class="event-date">{{ $invitation['display_date'] }}</p>
                <div class="countdown" data-date="{{ $invitation['date'] }}">
                    <div><strong id="days">00</strong><span>Hari</span></div>
                    <div><strong id="hours">00</strong><span>Jam</span></div>
                    <div><strong id="minutes">00</strong><span>Menit</span></div>
                    <div><strong id="seconds">00</strong><span>Detik</span></div>
                </div>
            </div>
            <div class="event-grid container">
                <article class="event-card reveal">
                    <span class="event-card__icon">◇</span>
                    <h3>Akad Nikah</h3>
                    <p class="time">{{ $invitation['akad'] }}</p>
                    <hr>
                    <strong>{{ $invitation['venue'] }}</strong>
                    <p>{{ $invitation['address'] }}</p>
                </article>
                <article class="event-card event-card--green reveal">
                    <span class="event-card__icon">♧</span>
                    <h3>Resepsi</h3>
                    <p class="time">{{ $invitation['reception'] }}</p>
                    <hr>
                    <strong>{{ $invitation['venue'] }}</strong>
                    <p>{{ $invitation['address'] }}</p>
                </article>
            </div>
            <a class="button" href="{{ $invitation['maps_url'] }}" target="_blank" rel="noopener">Buka Google Maps</a>
        </section>

        <section class="gallery section-dark">
            <div class="container reveal">
                <span class="eyebrow">Our moments</span>
                <h2 class="section-title">A Glimpse of Us</h2>
                <div class="gallery-grid">
                    <div class="gallery-photo photo-1"><span>Two souls,<br>one journey</span></div>
                    <div class="gallery-photo photo-2"></div>
                    <div class="gallery-photo photo-3"></div>
                    <div class="gallery-photo photo-4"><span>Forever<br>starts here</span></div>
                </div>
            </div>
        </section>

        <section class="rsvp paper-section" id="rsvp">
            <div class="container narrow reveal">
                <span class="eyebrow sage">Will you join us?</span>
                <h2 class="section-title">Konfirmasi Kehadiran</h2>
                <p>Kehadiran dan doa restu Anda adalah hadiah terindah bagi kami.</p>

                @if (session('success'))
                    <div class="alert">{{ session('success') }}</div>
                @endif

                @if ($invitationModel)
                <form action="{{ route('invitation.rsvp', $invitationModel) }}" method="POST" class="rsvp-form">
                    @csrf
                    <label>Nama lengkap<input type="text" name="name" value="{{ old('name', $guestName !== 'Tamu Undangan' ? $guestName : '') }}" required maxlength="80" placeholder="Masukkan nama Anda"></label>
                    <label>Konfirmasi kehadiran
                        <select name="attendance" required>
                            <option value="">Pilih jawaban</option>
                            <option value="hadir" @selected(old('attendance') === 'hadir')>InsyaAllah hadir</option>
                            <option value="tidak_hadir" @selected(old('attendance') === 'tidak_hadir')>Maaf, belum bisa hadir</option>
                            <option value="masih_ragu" @selected(old('attendance') === 'masih_ragu')>Masih belum pasti</option>
                        </select>
                    </label>
                    <label>Jumlah tamu<select name="guest_count" required>@for ($i = 1; $i <= 5; $i++)<option value="{{ $i }}" @selected(old('guest_count', 1) == $i)>{{ $i }} orang</option>@endfor</select></label>
                    <label>Ucapan & doa<textarea name="message" required maxlength="500" rows="4" placeholder="Tuliskan doa terbaik Anda">{{ old('message') }}</textarea></label>
                    @if ($errors->any())<div class="error">{{ $errors->first() }}</div>@endif
                    <button class="button" type="submit">Kirim Konfirmasi</button>
                </form>
                @else
                    <div class="alert">Ini adalah halaman demo. RSVP tersedia pada tautan undangan pelanggan.</div>
                @endif
            </div>

            @if ($messages->isNotEmpty())
                <div class="wishes container reveal">
                    <h3>Ucapan Terbaru</h3>
                    <div class="wishes__list">
                        @foreach ($messages as $wish)
                            <article><div class="avatar">{{ mb_strtoupper(mb_substr($wish->name, 0, 1)) }}</div><div><strong>{{ $wish->name }}</strong><small>{{ $wish->created_at->diffForHumans() }}</small><p>{{ $wish->message }}</p></div></article>
                        @endforeach
                    </div>
                </div>
            @endif
        </section>

        <footer>
            <span class="eyebrow">With love</span>
            <h2>{{ $invitation['bride']['short_name'] }} <i>&</i> {{ $invitation['groom']['short_name'] }}</h2>
            <p>Terima kasih atas doa dan restu Anda.</p>
        </footer>
    </main>
    <button class="music-button" id="musicButton" type="button" aria-label="Putar musik">♫</button>
    <script src="{{ asset('js/invitation.js') }}"></script>
</body>
</html>

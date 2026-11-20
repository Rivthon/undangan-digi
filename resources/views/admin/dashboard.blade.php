@extends('admin.layouts.app')
@section('title', 'Dashboard')
@section('heading', 'Dashboard')
@section('subheading', 'Ringkasan RSVP dan aktivitas undangan Anda.')
@section('content')
    <section class="share-card">
        <div><small>TAUTAN UNDANGAN ANDA</small><strong>{{ route('invitation.show', $invitation) }}</strong></div>
        <a href="{{ route('invitation.show', $invitation) }}" target="_blank" class="primary-button">Buka Undangan ↗</a>
    </section>
    <section class="stats-grid">
        <article><span>↙</span><div><small>Total Respons</small><strong>{{ $statistics['responses'] }}</strong></div></article>
        <article><span>✓</span><div><small>Tamu Hadir</small><strong>{{ $statistics['attending'] }}</strong></div></article>
        <article><span>×</span><div><small>Tidak Hadir</small><strong>{{ $statistics['notAttending'] }}</strong></div></article>
    </section>
    <section class="panel">
        <div class="panel-title"><div><h2>RSVP & Ucapan Terbaru</h2><p>Konfirmasi yang dikirim melalui halaman undangan.</p></div></div>
        <div class="table-wrap"><table><thead><tr><th>Nama</th><th>Kehadiran</th><th>Jumlah</th><th>Ucapan</th><th>Tanggal</th><th></th></tr></thead><tbody>
        @forelse ($messages as $message)
            <tr><td><strong>{{ $message->name }}</strong></td><td><span class="badge {{ $message->attendance }}">{{ str_replace('_', ' ', $message->attendance) }}</span></td><td>{{ $message->guest_count }} orang</td><td class="message-cell">{{ $message->message }}</td><td>{{ $message->created_at->format('d M Y, H:i') }}</td><td><form method="POST" action="{{ route('admin.rsvp.destroy', $message) }}" onsubmit="return confirm('Hapus data RSVP ini?')">@csrf @method('DELETE')<button class="danger-link">Hapus</button></form></td></tr>
        @empty<tr><td colspan="6" class="empty">Belum ada RSVP yang masuk.</td></tr>@endforelse
        </tbody></table></div>
        {{ $messages->links() }}
    </section>
@endsection

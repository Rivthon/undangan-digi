@if ($errors->any())<div class="alert error">{{ $errors->first() }}</div>@endif
<div class="form-grid">
    <label>Nama pelanggan<input type="text" name="name" value="{{ old('name', $adminUser?->name) }}" required maxlength="255" placeholder="Nama lengkap"></label>
    <label>Email<input type="email" name="email" value="{{ old('email', $adminUser?->email) }}" required maxlength="255" placeholder="pelanggan@email.com"></label>
    <label>Kata sandi {{ $adminUser ? '(kosongkan jika tidak diganti)' : '' }}<input type="password" name="password" {{ $adminUser ? '' : 'required' }} minlength="8" autocomplete="new-password" placeholder="Minimal 8 karakter"></label>
    <label>Konfirmasi kata sandi<input type="password" name="password_confirmation" {{ $adminUser ? '' : 'required' }} minlength="8" autocomplete="new-password" placeholder="Ulangi kata sandi"></label>
</div>
<label class="checkbox"><input type="hidden" name="is_active" value="0"><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $adminUser?->is_active ?? true))> Akun aktif dan dapat login</label>

<x-admin-layout>
    <x-slot name="pageTitle">Manajemen User</x-slot>
    <x-slot name="pageBreadcrumb">Admin Panel / Data User</x-slot>

    <div class="card">
        <div class="card-header">
            <div>
                <div class="card-title">Daftar User</div>
                <div class="card-subtitle">Kelola hak akses dan informasi pengguna sistem</div>
            </div>
            <a href="{{ route('admin.users.create') }}" class="card-action">+ Tambah User</a>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div style="background: #dcfce7; color: #15803d; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-size: 0.85rem; font-weight: 500;">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div style="background: #fee2e2; color: #b91c1c; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-size: 0.85rem; font-weight: 500;">
                    {{ session('error') }}
                </div>
            @endif

            <table class="data-table">
                <thead>
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th>Status</th>
                        <th>Nama & Email</th>
                        <th>WhatsApp/Telepon</th>
                        <th>Peran</th>
                        <th style="text-align: right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td style="color: #94a3b8; font-weight: 500;">{{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}</td>
                        <td>
                            <div style="width: 32px; height: 32px; border-radius: 50%; background: linear-gradient(135deg, #3b82f6, #1d4ed8); display: flex; align-items: center; justify-content: center; font-size: 0.75rem; font-weight: 700; color: #fff;">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                        </td>
                        <td>
                            <div style="font-weight: 600; color: #0f172a;">{{ $user->name }}</div>
                            <div style="font-size: 0.75rem; color: #94a3b8;">{{ $user->email }}</div>
                        </td>
                        <td>
                            @if($user->phone)
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $user->phone) }}" target="_blank" style="color: #16a34a; text-decoration: none; display: flex; align-items: center; gap: 4px;">
                                    <svg style="width:14px;height:14px;" fill="currentColor" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.038 3.284l-.542 2.317 2.138-.542c.866.471 1.765.883 2.974.884 3.181 0 5.767-2.586 5.768-5.766 0-3.182-2.585-5.771-5.769-5.772zm3.174 7.749c-.147.405-.852.742-1.224.782-.338.038-.724.084-1.231-.083-.341-.112-1.396-.543-2.385-1.423-.815-.724-1.332-1.472-1.531-1.812-.199-.34-.022-.524.148-.694.154-.153.342-.405.512-.607.17-.203.226-.339.34-.565.114-.226.056-.424-.028-.593-.084-.17-.749-1.808-.946-2.284-.191-.462-.403-.399-.586-.409-.176-.009-.38-.011-.584-.011-.204 0-.537.077-.817.382-.28.305-1.074 1.051-1.074 2.561s1.099 2.966 1.252 3.17c.152.204 2.163 3.303 5.239 4.629.732.316 1.303.504 1.747.645.735.233 1.403.2 1.932.121.589-.088 1.807-.738 2.063-1.452.256-.714.256-1.325.18-1.452-.076-.127-.282-.203-.586-.31z"/></svg>
                                    {{ $user->phone }}
                                </a>
                            @else
                                <span style="color: #cbd5e1;">-</span>
                            @endif
                        </td>
                        <td>
                            @php
                                $roleClass = match($user->role) {
                                    'admin'   => 'badge-danger',
                                    'petugas' => 'badge-info',
                                    default   => 'badge-success',
                                };
                            @endphp
                            <span class="badge {{ $roleClass }}">{{ ucfirst($user->role) }}</span>
                        </td>
                        <td style="text-align: right;">
                            <div style="display: flex; justify-content: flex-end; gap: 8px;">
                                <a href="{{ route('admin.users.edit', $user) }}" class="topbar-icon-btn" style="width: 32px; height: 32px; background: #eff6ff; color: #2563eb;" title="Edit">
                                    <svg style="width:14px;height:14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </a>
                                @if($user->id !== auth()->id())
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="topbar-icon-btn" style="width: 32px; height: 32px; background: #fff1f2; color: #be123c;" title="Hapus">
                                        <svg style="width:14px;height:14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 40px; color: #94a3b8;">Belum ada data user.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <div style="margin-top: 24px;">
                {{ $users->links() }}
            </div>
        </div>
    </div>
</x-admin-layout>

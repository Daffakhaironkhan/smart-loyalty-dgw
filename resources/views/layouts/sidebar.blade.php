<aside class="fixed inset-y-0 left-0 z-40 hidden w-64 flex-col border-r border-slate-200 bg-white shadow-sm md:flex">
    <div class="border-b border-slate-200 px-5 py-5">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-white p-2 shadow-sm ring-1 ring-slate-200">
                <img src="{{ asset('images/dgw-logo.png') }}"
                     alt="Logo DGW"
                     class="h-full w-full object-contain">
            </div>

            <div class="min-w-0">
                <p class="truncate text-lg font-bold leading-tight text-slate-900">
                    DGW Loyalty
                </p>
                <p class="truncate text-xs text-slate-500">
                    Smart Loyalty System
                </p>
            </div>
        </a>
    </div>

    <nav class="flex-1 overflow-y-auto px-4 py-5">
        @php
            $navBase = 'flex items-center rounded-xl px-4 py-2.5 text-sm font-medium transition';
            $navActive = 'bg-blue-50 text-blue-700 font-semibold';
            $navInactive = 'text-slate-700 hover:bg-slate-50 hover:text-blue-700';

            $navWithBadgeBase = 'flex items-center justify-between rounded-xl px-4 py-2.5 text-sm font-medium transition';
            $sectionTitle = 'px-4 text-xs font-bold uppercase tracking-wider text-slate-400';
            $badgeClass = 'rounded-full bg-red-600 px-2 py-0.5 text-xs font-semibold text-white';
        @endphp

        <div class="space-y-1">
            <a href="{{ route('dashboard') }}"
               class="{{ $navBase }} {{ request()->routeIs('dashboard') || request()->routeIs('admin.dashboard') || request()->routeIs('toko.dashboard') || request()->routeIs('konsumen.dashboard') ? $navActive : $navInactive }}">
                Dashboard
            </a>

            <a href="{{ route('notifications.index') }}"
               class="{{ $navWithBadgeBase }} {{ request()->routeIs('notifications.*') ? $navActive : $navInactive }}">
                <span>Notifikasi</span>

                @php
                    $unreadNotificationCount = auth()->user()->unreadNotifications()->count();
                @endphp

                @if ($unreadNotificationCount > 0)
                    <span class="{{ $badgeClass }}">
                        {{ $unreadNotificationCount }}
                    </span>
                @endif
            </a>
        </div>

        @if (auth()->user()->hasRole('admin'))
            <div class="mt-6">
                <p class="{{ $sectionTitle }}">
                    Master Data
                </p>

                <div class="mt-3 space-y-1">
                    <a href="{{ route('admin.users.index') }}"
                       class="{{ $navBase }} {{ request()->routeIs('admin.users.*') ? $navActive : $navInactive }}">
                        User
                    </a>

                    <a href="{{ route('admin.stores.index') }}"
                       class="{{ $navBase }} {{ request()->routeIs('admin.stores.*') ? $navActive : $navInactive }}">
                        Toko/Kios
                    </a>

                    <a href="{{ route('admin.customers.index') }}"
                       class="{{ $navBase }} {{ request()->routeIs('admin.customers.*') ? $navActive : $navInactive }}">
                        Konsumen
                    </a>

                    <a href="{{ route('admin.product-categories.index') }}"
                       class="{{ $navBase }} {{ request()->routeIs('admin.product-categories.*') ? $navActive : $navInactive }}">
                        Kategori Produk
                    </a>

                    <a href="{{ route('admin.products.index') }}"
                       class="{{ $navBase }} {{ request()->routeIs('admin.products.*') ? $navActive : $navInactive }}">
                        Produk
                    </a>
                </div>
            </div>

            <div class="mt-6">
                <p class="{{ $sectionTitle }}">
                    Poin & Reward
                </p>

                <div class="mt-3 space-y-1">
                    <a href="{{ route('admin.point-programs.index') }}"
                       class="{{ $navBase }} {{ request()->routeIs('admin.point-programs.*') ? $navActive : $navInactive }}">
                        Program Poin
                    </a>

                    <a href="{{ route('admin.point-rules.index') }}"
                       class="{{ $navBase }} {{ request()->routeIs('admin.point-rules.*') ? $navActive : $navInactive }}">
                        Aturan Poin
                    </a>

                    <a href="{{ route('admin.point-histories.index') }}"
                       class="{{ $navBase }} {{ request()->routeIs('admin.point-histories.*') ? $navActive : $navInactive }}">
                        Riwayat Poin
                    </a>

                    <a href="{{ route('admin.rewards.index') }}"
                       class="{{ $navBase }} {{ request()->routeIs('admin.rewards.*') ? $navActive : $navInactive }}">
                        Reward
                    </a>

                    <a href="{{ route('admin.reports.index') }}"
                       class="{{ $navBase }} {{ request()->routeIs('admin.reports.*') ? $navActive : $navInactive }}">
                        Laporan
                    </a>

                    <a href="{{ route('admin.activity-logs.index') }}"
                       class="{{ $navBase }} {{ request()->routeIs('admin.activity-logs.*') ? $navActive : $navInactive }}">
                        Activity Log
                    </a>
                </div>
            </div>

            @php
                $pendingCustomerTransactionCount = \App\Models\CustomerTransaction::where('status', 'pending')->count();
                $pendingStorePurchaseCount = \App\Models\StorePurchaseTransaction::where('status', 'pending')->count();
                $pendingRewardRedemptionCount = \App\Models\RewardRedemption::where('status', 'requested')->count();

                $totalPendingValidation = $pendingCustomerTransactionCount
                    + $pendingStorePurchaseCount
                    + $pendingRewardRedemptionCount;
            @endphp

            <div class="mt-6">
                <div class="flex items-center justify-between px-4">
                    <p class="{{ $sectionTitle }} px-0">
                        Validasi
                    </p>

                    @if ($totalPendingValidation > 0)
                        <span class="{{ $badgeClass }}">
                            {{ $totalPendingValidation }}
                        </span>
                    @endif
                </div>

                <div class="mt-3 space-y-1">
                    <a href="{{ route('admin.customer-transactions.index') }}"
                       class="{{ $navWithBadgeBase }} {{ request()->routeIs('admin.customer-transactions.*') ? $navActive : $navInactive }}">
                        <span>Validasi Transaksi</span>

                        @if ($pendingCustomerTransactionCount > 0)
                            <span class="{{ $badgeClass }}">
                                {{ $pendingCustomerTransactionCount }}
                            </span>
                        @endif
                    </a>

                    <a href="{{ route('admin.store-purchases.index') }}"
                       class="{{ $navWithBadgeBase }} {{ request()->routeIs('admin.store-purchases.*') ? $navActive : $navInactive }}">
                        <span>Validasi Pembelian</span>

                        @if ($pendingStorePurchaseCount > 0)
                            <span class="{{ $badgeClass }}">
                                {{ $pendingStorePurchaseCount }}
                            </span>
                        @endif
                    </a>

                    <a href="{{ route('admin.reward-redemptions.index') }}"
                       class="{{ $navWithBadgeBase }} {{ request()->routeIs('admin.reward-redemptions.*') ? $navActive : $navInactive }}">
                        <span>Validasi Reward</span>

                        @if ($pendingRewardRedemptionCount > 0)
                            <span class="{{ $badgeClass }}">
                                {{ $pendingRewardRedemptionCount }}
                            </span>
                        @endif
                    </a>
                </div>
            </div>
        @endif

        @if (auth()->user()->hasRole('toko_kios'))
            <div class="mt-6">
                <p class="{{ $sectionTitle }}">
                    Transaksi
                </p>

                <div class="mt-3 space-y-1">
                    <a href="{{ route('toko.customer-transactions.index') }}"
                       class="{{ $navBase }} {{ request()->routeIs('toko.customer-transactions.*') ? $navActive : $navInactive }}">
                        Transaksi Konsumen
                    </a>

                    <a href="{{ route('toko.store-purchases.index') }}"
                       class="{{ $navBase }} {{ request()->routeIs('toko.store-purchases.*') ? $navActive : $navInactive }}">
                        Pembelian ke DGW
                    </a>
                </div>
            </div>

            <div class="mt-6">
                <p class="{{ $sectionTitle }}">
                    Poin & Reward
                </p>

                <div class="mt-3 space-y-1">
                    <a href="{{ route('toko.point-histories.index') }}"
                       class="{{ $navBase }} {{ request()->routeIs('toko.point-histories.*') ? $navActive : $navInactive }}">
                        Riwayat Poin
                    </a>

                    <a href="{{ route('toko.rewards.index') }}"
                       class="{{ $navBase }} {{ request()->routeIs('toko.rewards.*') ? $navActive : $navInactive }}">
                        Katalog Reward
                    </a>

                    <a href="{{ route('toko.reward-redemptions.index') }}"
                       class="{{ $navBase }} {{ request()->routeIs('toko.reward-redemptions.*') ? $navActive : $navInactive }}">
                        Penukaran Reward
                    </a>
                </div>
            </div>
        @endif

        @if (auth()->user()->hasRole('konsumen'))
            <div class="mt-6">
                <p class="{{ $sectionTitle }}">
                    Konsumen
                </p>

                <div class="mt-3 space-y-1">
                    <a href="{{ route('konsumen.point-histories.index') }}"
                       class="{{ $navBase }} {{ request()->routeIs('konsumen.point-histories.*') ? $navActive : $navInactive }}">
                        Riwayat Poin
                    </a>

                    <a href="{{ route('konsumen.rewards.index') }}"
                       class="{{ $navBase }} {{ request()->routeIs('konsumen.rewards.*') ? $navActive : $navInactive }}">
                        Katalog Reward
                    </a>

                    <a href="{{ route('konsumen.reward-redemptions.index') }}"
                       class="{{ $navBase }} {{ request()->routeIs('konsumen.reward-redemptions.*') ? $navActive : $navInactive }}">
                        Penukaran Reward
                    </a>
                </div>
            </div>
        @endif
    </nav>

    <div class="border-t border-slate-200 bg-white px-4 py-4">
        <div class="rounded-2xl bg-slate-50 p-4">
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-2xl bg-blue-100 text-sm font-bold text-blue-700">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>

                <div class="min-w-0">
                    <p class="truncate text-sm font-semibold text-slate-900">
                        {{ auth()->user()->name }}
                    </p>
                    <p class="truncate text-xs text-slate-500">
                        {{ auth()->user()->email }}
                    </p>
                </div>
            </div>

            <a href="{{ route('profile.edit') }}"
               class="mt-3 inline-flex text-xs font-semibold text-blue-600 hover:text-blue-700">
                Edit Profile
            </a>
        </div>

        <form method="POST" action="{{ route('logout') }}" class="mt-3">
            @csrf

            <button type="submit"
                    class="w-full rounded-xl px-4 py-2.5 text-left text-sm font-semibold text-red-600 transition hover:bg-red-50">
                Logout
            </button>
        </form>
    </div>
</aside>

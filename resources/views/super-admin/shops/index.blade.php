<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <span class="material-icons text-blue-600 text-3xl">store</span>
                <h2 class="font-black text-2xl text-gray-800 tracking-tighter uppercase">
                    {{ __('Partner Shops') }}
                </h2>
            </div>
            <a href="{{ route('super-admin.shops.create') }}" class="md-button px-6 py-2.5 bg-blue-600 text-white rounded-xl elevation-2 hover:elevation-3 flex items-center space-x-2 text-xs">
                <span class="material-icons text-sm">add_business</span>
                <span>Onboard New shop</span>
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-[2rem] border border-gray-100 italic">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 border-b border-gray-100">
                        <tr>
                            <th class="px-8 py-5 text-[10px] font-black uppercase text-gray-400 tracking-widest">Shop Identity</th>
                            <th class="px-8 py-5 text-[10px] font-black uppercase text-gray-400 tracking-widest text-center">Stats</th>
                            <th class="px-8 py-5 text-[10px] font-black uppercase text-gray-400 tracking-widest">Status</th>
                            <th class="px-8 py-5 text-[10px] font-black uppercase text-gray-400 tracking-widest text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($shops as $shop)
                            <tr class="hover:bg-blue-50/30 transition-colors">
                                <td class="px-8 py-6">
                                    <div class="flex items-center space-x-4">
                                        <div class="w-14 h-14 rounded-2xl bg-white border border-gray-100 p-1 shadow-sm overflow-hidden flex items-center justify-center">
                                            @if($shop->logo)
                                                <img src="{{ Storage::url($shop->logo) }}" class="w-full h-full object-contain">
                                            @else
                                                <span class="material-icons text-gray-200 text-3xl">image</span>
                                            @endif
                                        </div>
                                        <div>
                                            <p class="text-lg font-black text-gray-900 tracking-tighter uppercase leading-none">{{ $shop->name }}</p>
                                            <p class="text-[10px] font-bold text-gray-400 mt-2 uppercase italic leading-tight max-w-xs">{{ $shop->address }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="flex items-center justify-center space-x-8">
                                        <div class="text-center">
                                            <p class="text-sm font-black text-gray-900 leading-none">{{ $shop->customers_count }}</p>
                                            <p class="text-[8px] font-black text-gray-400 uppercase tracking-widest mt-1">Clients</p>
                                        </div>
                                        <div class="text-center">
                                            <p class="text-sm font-black text-gray-900 leading-none">{{ $shop->loans_count }}</p>
                                            <p class="text-[8px] font-black text-gray-400 uppercase tracking-widest mt-1">Loans</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    <span class="inline-flex px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-widest {{ $shop->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                        {{ $shop->is_active ? 'Authorized' : 'Disabled' }}
                                    </span>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="flex items-center justify-end space-x-2">
                                        <form action="{{ route('super-admin.shops.toggle-status', $shop) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="p-2 transition-colors rounded-xl {{ $shop->is_active ? 'text-orange-600 hover:bg-orange-50' : 'text-green-600 hover:bg-green-50' }}" title="{{ $shop->is_active ? 'Disable' : 'Enable' }}">
                                                <span class="material-icons">{{ $shop->is_active ? 'block' : 'check_circle' }}</span>
                                            </button>
                                        </form>
                                        <a href="{{ route('super-admin.shops.edit', $shop) }}" class="p-2 text-blue-600 hover:bg-blue-50 transition-colors rounded-xl">
                                            <span class="material-icons">edit</span>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="px-8 py-6 bg-gray-50 border-t border-gray-100">
                    {{ $shops->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

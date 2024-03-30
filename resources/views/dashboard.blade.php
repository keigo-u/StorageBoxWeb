<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="mx-10 my-12 flex">
        <div class="md:m-3 p-5 w-1/3 bg-white overflow-hidden shadow-sm md:rounded-lg">
            <div class="mt-2 mb-4 text-xl font-bold">DMスクレイパー</div>
            <div class="flex justify-between my-2">
                <label for="page" class="text-sm">開始ページ：</label>
                <input type="number" id="page"class="w-1/2" min="1" value="1">
            </div>
            <div class="flex justify-between my-2">
                <label for="length" class="text-sm">取得ページ数：</label>
                <input type="number" id="length" class="w-1/2" min="1" value="1">
            </div>
            <div class="flex justify-between text-slate-400 text-xs my-2">
                <div>
                    <div class="flex">
                        <div>現在の総ページ数：</div>
                        <div class="text-slate-500">{{ $latest_page->count }}</div>
                    </div>
                    <div>取得日時：{{ $latest_page->created_at }}</div>
                </div>
                <button class="hover:text-slate-500" onclick="getLatestPageCount">再取得</button>
            </div>
            <div class="flex justify-end my-2">
                <button class="px-3 py-2 bg-slate-200 hover:bg-slate-300 shadow-md rounded-md">実行</button>
            </div>
        </div>
        <div class="md:m-3 p-5 w-full bg-white overflow-hidden shadow-sm md:rounded-lg">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-900 uppercase dark:text-gray-400">
                    <th scope="col" class="px-6 py-3">カード名</th>
                    <th scope="col" class="px-6 py-3">パック名</th>
                    <th scope="col" class="px-6 py-3">画像URL</th>
                    <th scope="col" class="px-6 py-3">種類</th>
                    <th scope="col" class="px-6 py-3">レアリティ</th>
                    <th scope="col" class="px-6 py-3">種族</th>
                    <th scope="col" class="px-6 py-3">文明</th>
                    <th scope="col" class="px-6 py-3">パワー</th>
                    <th scope="col" class="px-6 py-3">コスト</th>
                    <th scope="col" class="px-6 py-3">マナ</th>
                    <th scope="col" class="px-6 py-3">イラストレーター</th>
                    <th scope="col" class="px-6 py-3">特殊能力</th>
                    <th scope="col" class="px-6 py-3">フレーバーテキスト</th>
                </thead>
                <tbody>
                    @foreach ($cards as $cards)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <td class="px-6 py-4">{{ $card->card_name }}</td>
                            <td class="px-6 py-4">{{ $card->pack_name }}</td>
                            <td class="px-6 py-4"><a href="{{ $card->base_image_url }}">確認する</a></td>
                            <td class="px-6 py-4">{{ $card->type->name }}</td>
                            <td class="px-6 py-4">{{ $card->rarity->name }}</td>
                            <td class="px-6 py-4">
                                @foreach ($card->races as $race)
                                    {{ $race->name }}
                                    @if (!$loop->last)
                                        /
                                    @endif
                                @endforeach
                            </td>
                            <td class="px-6 py-4">
                                @foreach ($card->civils as $civil)
                                    {{ $civil->name }}
                                    @if (!$loop->last)
                                        /
                                    @endif
                                @endforeach
                            </td>
                            <td class="px-6 py-4">{{ $card->power }}</td>
                            <td class="px-6 py-4">{{ $card->cost }}</td>
                            <td class="px-6 py-4">{{ $card->mana }}</td>
                            <td class="px-6 py-4">{{ $card->illust }}</td>
                            <td class="px-6 py-4">{{ $card->ability }}</td>
                            <td class="px-6 py-4">{{ $card->flavor }}</td>
                        </tr>
                    @endforeach
                    {{-- <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        @for ($i = 0; $i < 13; $i++)
                            <td>テスト</td>
                        @endfor
                    </tr> --}}
                </tbody>
            </table>
        </div>
    </div>
    <script>
        const getLatestPageCount() => {
            axios.post('/page_count')
                .then((res) => {
                    console.log(res);
                })
                .catch((error) => {
                    console.log(error);
                })
        }
    </script>
</x-app-layout>

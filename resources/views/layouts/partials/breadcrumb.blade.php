@if (!request()->is('/'))
    <div class="bg-white shadow-lg">
        <div class="container">
            <nav class="flex px-5 py-3 text-gray-700" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1">
                    <li class="inline-flex items-center">
                        <a href="/"
                            class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-gray-900">
                            {{-- <svg class="mr-2 h-4 w-4" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z">
                                </path>
                            </svg> --}}
                            @if (request()->is('umum*') ||
                                request()->is('member*') ||
                                request()->is('grosir*') ||
                                request()->is('member-grosir*'))
                                <i class="fa fa-rupiah-sign mr-2 h-4 w-4"></i>
                            @else
                                <i class="fa fa-home"></i>
                            @endif
                            @if (request()->is('umum*') ||
                                request()->is('member*') ||
                                request()->is('grosir*') ||
                                request()->is('member-grosir*'))
                                Harga
                            @endif
                        </a>
                    </li>
                    @php
                        $link = '';
                    @endphp
                    @for ($i = 1; $i <= count(Request::segments()); $i++)
                        @if (($i < count(Request::segments())) & ($i > 0))
                            @php
                                $link .= '/' . Request::segment($i);
                            @endphp
                            <li>
                                <div class="flex items-center">
                                    <svg class="h-6 w-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    <a href="<?= $link ?>"
                                        class="ml-1 text-sm font-medium text-gray-700 hover:text-gray-900">
                                        @if (!request()->is('cart*') || !request()->is('stock*'))
                                            {{ ucwords(str_replace('-', ' ', Request::segment($i))) }}
                                        @endif
                                    </a>
                                </div>
                            </li>
                        @else
                            <li>
                                <div class="flex items-center">
                                    <svg class="h-6 w-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="ml-1 text-sm font-medium text-gray-500">
                                        @if (!request()->is('cart*') || !request()->is('stock*'))
                                            {{ request()->is('products/*') ? $title : ucwords(str_replace('-', ' ', Request::segment($i))) }}
                                        @endif
                                    </span>
                                </div>
                            </li>
                        @endif
                    @endfor
                </ol>
            </nav>
        </div>
    </div>
@endif

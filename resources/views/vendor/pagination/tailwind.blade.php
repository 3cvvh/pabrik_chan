@if ($paginator->hasPages())
    <div class="flex flex-col items-center gap-4 mt-12">
        
        {{-- Badge Counter --}}
        <div class="px-4 py-1.5 rounded-full bg-blue-50 text-blue-700 font-medium text-sm 
                    border border-blue-200 shadow-sm dark:bg-gray-800 dark:text-blue-300 dark:border-gray-700">
            Page <span class="font-bold">{{ $paginator->currentPage() }}</span> of <span class="font-bold">{{ $paginator->lastPage() }}</span>
        </div>

        {{-- Pagination Navigation --}}
        <nav role="navigation" aria-label="Pagination">
            <ul class="flex items-center gap-2 text-sm font-medium">
                
                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                    <li>
                        <span class="flex items-center justify-center w-10 h-10 rounded-full 
                                     bg-gray-200 text-gray-400 cursor-not-allowed 
                                     dark:bg-gray-700 dark:text-gray-500">
                            <svg xmlns="http://www.w3.org/2000/svg" 
                                 class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                            </svg>
                        </span>
                    </li>
                @else
                    <li>
                        <a href="{{ $paginator->previousPageUrl() }}" rel="prev"
                           class="flex items-center justify-center w-10 h-10 rounded-full 
                                  bg-white border border-gray-300 text-gray-600 
                                  hover:bg-blue-600 hover:text-white hover:border-blue-600 
                                  focus:outline-none focus:ring-2 focus:ring-blue-400 
                                  transition ease-out duration-200 dark:bg-gray-800 dark:text-gray-200 dark:border-gray-600">
                            <svg xmlns="http://www.w3.org/2000/svg" 
                                 class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                            </svg>
                        </a>
                    </li>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($elements as $element)
                    {{-- Dots --}}
                    @if (is_string($element))
                        <li>
                            <span class="px-3 py-2 text-gray-400">…</span>
                        </li>
                    @endif

                    {{-- Links --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <li>
                                    <span aria-current="page"
                                          class="flex items-center justify-center w-10 h-10 rounded-full 
                                                 bg-blue-600 text-white font-semibold shadow-md">
                                        {{ $page }}
                                    </span>
                                </li>
                            @else
                                <li>
                                    <a href="{{ $url }}" 
                                       class="flex items-center justify-center w-10 h-10 rounded-full 
                                              bg-white border border-gray-300 text-gray-600
                                              hover:bg-blue-600 hover:text-white hover:border-blue-600
                                              focus:outline-none focus:ring-2 focus:ring-blue-400
                                              transition ease-out duration-200 dark:bg-gray-800 dark:text-gray-200 dark:border-gray-600">
                                        {{ $page }}
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <li>
                        <a href="{{ $paginator->nextPageUrl() }}" rel="next"
                           class="flex items-center justify-center w-10 h-10 rounded-full 
                                  bg-white border border-gray-300 text-gray-600 
                                  hover:bg-blue-600 hover:text-white hover:border-blue-600
                                  focus:outline-none focus:ring-2 focus:ring-blue-400
                                  transition ease-out duration-200 dark:bg-gray-800 dark:text-gray-200 dark:border-gray-600">
                            <svg xmlns="http://www.w3.org/2000/svg" 
                                 class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </li>
                @else
                    <li>
                        <span class="flex items-center justify-center w-10 h-10 rounded-full 
                                     bg-gray-200 text-gray-400 cursor-not-allowed 
                                     dark:bg-gray-700 dark:text-gray-500">
                            <svg xmlns="http://www.w3.org/2000/svg" 
                                 class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </span>
                    </li>
                @endif
            </ul>
        </nav>
    </div>
@endif

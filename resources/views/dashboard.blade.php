<x-app-layout>
	<x-slot name="header">
		<h2 class="font-semibold text-xl text-gray-800 leading-tight">
			{{ __('Infoboard') }}
		</h2>
	</x-slot>

	<div class="py-12">
		<div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
			<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
				<div class="p-6 bg-white border-b border-gray-200">
					<!-- You're logged in! -->

					<h2 class="text-lg font-medium text-gray-900">
						Ваші права доступу:
					</h2>


					<div class="mt-3">
					@if ($so_id === 0)
					<b><p><span>Структурна одиниця: </span><br/>
						<span class="text-green-700 ml-2">Всі</span></p></b>
					@elseif ($so_id === -1)
					<b><p><span>Структурна одиниця: </span><br/>
						<span class="text-red-700 ml-2">Права відсутні</span></p></b>
					@elseif ($so_id > 0)
					<b><p><span>Структурна одиниця: </span><br/>
						<span class="text-green-700 ml-2">{{ $so_code }} {{ $so_name }}</span></p></b>
					@endif

					@if ($so_id > 0 && $rem_id > 0) 
					<p>
						<span class="text-green-700 ml-4">{{ $rem_code }} {{ $rem_name }}</span></p>
					@endif
					</div>

					<div class="mt-3">
					@if ($bo_id === 0)
					<b><p><span>Балансова одиниця: </span><br/>
						<span class="text-green-700 ml-2">Всі</span></p></b>
					@elseif ($bo_id === -1)
					<b><p><span>Балансова одиниця: </span><br/>
						<span class="text-red-700 ml-2">Права відсутні</span></p></b>
					@elseif ($bo_id > 0)
					<b><p><span>Балансова одиниця: </span><br/>
						<span class="text-green-700 ml-2">{{ $bo_code }} {{ $bo_name }}</span></p></b>
					@endif
					</div>
				</div>
			</div>
			<div class="ml-4 text-lg leading-7 font-semibold text-gray-900 dark:text-white">
				<p class="mt-2">
					<a href="/" class="underline text-gray-900 dark:text-white">
						На головну
					</a>
				</p>
				@if (auth()->user()->name === 'Admin')
				<p class="mt-2">
					<a href="{{ route('delete_report') }}" class="underline text-gray-900 dark:text-white">
						Чистити тимчасову папку
					</a>
				</p>
				@endif
			</div>
		</div>
	</div>
</x-app-layout>

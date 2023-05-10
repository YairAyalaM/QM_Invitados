<div>
	<!-- <div class="flex items-center md:justify-center min-h-screen bg-white overflow-x-auto relative shadow-md sm:rounded-lg"> -->
	<div class="md:m-4">
		<div class="col-span-12">
			<div class="overflow-auto lg:overflow-visible ">
				<div class="flex justify-between items-center pb-4 bg-white dark:bg-white">
					@livewire('create-user')
					<label for="table-search" class="sr-only">Search</label>
					<div class="relative">
						<div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
							<svg class="w-5 h-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
								<path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
							</svg>
						</div>
						<input type="text" wire:model="term" class="block w-full py-2 pl-10 pr-3 text-sm placeholder-gray-500 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="Buscar">
					</div>
				</div>

				{{ csrf_field()}}
				<!-- <input type="submit" value="Eliminar comidas"> -->
				<!-- <div>
						<button type="submit" value="Eliminar comidas" class="inline-flex items-center text-gray-500 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-3 py-1.5 dark:bg-gray-200 dark:text-gray-400 dark:border-gray-100 dark:hover:bg-gray-100 dark:hover:border-gray-100 dark:focus:ring-white">Eliminar multiple</button>
					</div> -->
				<table class="table text-gray-400 border-separate space-y-6 text-sm">
					<thead class="bg-gray-200 text-gray-500">
						<tr>
							<th class="p-3"></th>
							<th class="p-3">Usuario</th>
							<th class="p-3 text-left">Categoria</th>
							<th class="p-3 text-left">check-In</th>
							<th class="p-3 text-left">Action</th>
						</tr>
					</thead>
					<tbody id="table">
						@foreach($users as $user)
						@if($user->id !== Auth::user()->id)
						<tr class="bg-gray-200" data-id="{{$user->id}}">
							<td class="p-3">
								<!-- <div class="flex align-items-center">
										<div class="ml-3">
											<input value="{{$user->id}}" id="{{$user->id}}" type="checkbox" name="borrarRegistros[]" class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-400 dark:border-gray-300">
											<label for="checkbox-all-search" class="sr-only">checkbox</label>
										</div>
									</div> -->
							</td>
							<td class="p-3">
								<div class="flex align-items-center">
									<img class="handle cursor-grab rounded-full h-12 w-12  object-cover" src="{{$user->profile_photo_path}}" alt="unsplash image">
									<div class="ml-3">
										<div class="">{{$user->name}}</div>
										<div class="text-gray-500">{{$user->email}}</div>
									</div>
								</div>
							</td>
							<td class="p-3">
								{{$user->name}}
							</td>
							<td class="p-3 font-bold">
								<div class="relative inline-block w-10 mr-2 align-middle select-none transition duration-200 ease-in focus-within:shadow-outline">
									<input wire:click="toggleStatus({{ $user->id }})" type="checkbox" name="toggle" id="toggle" class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer {{ $user->status ? 'border-blue-500 bg-blue-500' : 'border-red-500 bg-red-500' }}" />
									<label for="toggle" class="toggle-label block overflow-hidden h-6 rounded-full bg-gray-300 cursor-pointer"></label>
								</div>
								<span class="text-sm">{{ $user->status ? 'Asistio' : 'Ausente' }}</span>
							</td>

							<!-- <td class="p-3">
								<span class="bg-green-400 text-gray-50 rounded-md px-2">available</span>
							</td> -->
							<td class="p-3 ">
								<!-- <a href="javascript:void(0)" wire:click.prevent='editar({{$user->id}})' class="text-gray-400 hover:text-gray-100 mr-2">
										<i class="material-icons-outlined text-base">visibility</i>
									</a> -->
								<a href="javascript:void(0)" wire:click.prevent='editar({{$user->id}})' class="text-gray-400 hover:text-gray-100  mx-2">
									<i class="material-icons-outlined text-base">edit</i>
								</a>
								<a href="javascript:void(0)" wire:click.prevent='deleteConfirmation({{ $user->id }})' class="text-gray-400 hover:text-gray-100  mx-2">
									<i class="material-icons-outlined text-base">delete_outline</i>
								</a>
							</td>
						</tr>
						@endif
						@endforeach
					</tbody>
				</table>


				<!-- @if($users->hasPages())
				<div class="px-6 py-3">
					{{$users->links()}}
				</div>
				@endif -->
			</div>
		</div>
	</div>
	<style>
		.table {
			border-spacing: 0 15px;
		}

		/* i {
			font-size: 1rem !important;
		} */

		.table tr {
			border-radius: 20px;
		}

		tr td:nth-child(n+5),
		tr th:nth-child(n+5) {
			border-radius: 0 .625rem .625rem 0;
		}

		tr td:nth-child(1),
		tr th:nth-child(1) {
			border-radius: .625rem 0 0 .625rem;
		}
	</style>

	<script>
		$(function() {
			Livewire.on('userUpdated', function(userId, status) {
				var button = $('button[data-user-id="' + userId + '"]');
				var buttonText = status ? 'Active' : 'Inactive';
				button.text(buttonText);
			});
		});
	</script>

	<!-- script sortable -->
	<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
	<!-- no olvidar el data-id="" para que funcione -->
	<script>
		new Sortable(table, {
			handle: '.handle', //handle permite mover solo elementos que tengan la clase handle
			animation: 150,
			ghostClass: 'bg-blue-100',
			store: {
				set: function(sortable) {
					const sorts = sortable.toArray();
					axios.post("{{route('api.sort.posts')}}", {
						sorts: sorts
					}).catch(function(error) {
						console.log(error);
					});
				}
			}
		});
	</script>
	<!-- scripts de se a eliminado correctamente -->
	<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<x-livewire-alert::scripts />

	<!-- script de boton de confirmacion -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

	<script>
		window.addEventListener('show-delete-confirmation', event => {
			Swal.fire({
				title: 'Are you sure?',
				text: "You won't be able to revert this!",
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Yes, Delete'
			}).then((result) => {
				if (result.isConfirmed) {
					livewire.emit('deleteConfirmed')
				}
			})
		})


		//confirmacion
		window.addEventListener('FileDeleted', event => {
			Swal.fire(
				'Deleted!',
				'Your file has been deleted.',
				'success'
			)
		});
	</script>
	<!-- modal -->
	<x-dialog-modal wire:model="open_edit">
		<x-slot name="title">
			<div class="text-center">
				Editar Invitado
			</div>
		</x-slot>

		<x-slot name="content">
			<!-- form starts -->
			
				@if($profile_photo_path)
				@if($profile_photo_path == $profile_photo_path_old)
				<div class="mb-8 flex justify-center">
					<img class="object-center object-cover rounded-full h-36 w-36 mx-auto" src="{{$profile_photo_path}}" alt="photo">
				</div>
				@else
				<div class="mb-8 flex justify-center">
					<img class="object-center object-cover rounded-full h-36 w-36 mx-auto" src="{{$profile_photo_path->temporaryUrl()}}" alt="photo">
				</div>
				@endif
				@endif

				@csrf
				<div class="form-group">

					<input type="hidden" class="userid" name="userid" id="userid" value="">

					<label for="name">Name</label>
					<input type="text" name="name" id="name" placeholder="Enter your name" class="form-control" required autocomplete="off" wire:model="name">
				</div>
				<div class="form-group">
					<label for="email">Email</label>
					<input type="email" name="email" id="email" placeholder="Enter your email" class="form-control" required autocomplete="off" wire:model="email">
				</div>

				<!-- <div class="form-group">
					<label for="password">Password</label>
					<input type="password" name="password" id="password" placeholder="********" class="form-control" required autocomplete="off" wire:model="password">
				</div> -->

				<div style="display: none" wire:loading wire:target="profile_photo_path" class="flex bg-green-100 rounded-lg p-4 mb-4 text-sm text-green-700" role="alert">
					<svg class="w-5 h-5 inline mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
						<path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
					</svg>
					<div>
						<span class="font-medium">Cargando imagen!</span> Espere un momento.
					</div>
				</div>
				<!-- dropzone -->

				<!-- component -->
				<div class="bg-white p7 rounded w-full mx-auto">
					<div x-data="dataFileDnD()" class="relative flex flex-col text-gray-400 border border-gray-200 rounded">
						<div x-ref="dnd" class="relative flex flex-col text-gray-400 border border-gray-200 border-dashed rounded cursor-pointer">
							<input id="profile_photo_path" wire:model="profile_photo_path" type="file" class="absolute inset-0 z-50 w-full h-full p-0 m-0 outline-none opacity-0 cursor-pointer" @change="addFiles($event)" @dragover="$refs.dnd.classList.add('border-blue-400'); $refs.dnd.classList.add('ring-4'); $refs.dnd.classList.add('ring-inset');" @dragleave="$refs.dnd.classList.remove('border-blue-400'); $refs.dnd.classList.remove('ring-4'); $refs.dnd.classList.remove('ring-inset');" @drop="$refs.dnd.classList.remove('border-blue-400'); $refs.dnd.classList.remove('ring-4'); $refs.dnd.classList.remove('ring-inset');" title="" />

							<div class="flex flex-col items-center justify-center py-10 text-center">
								<svg class="w-6 h-6 mr-1 text-current-50" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
								</svg>
								<p class="m-0">Drag your files here or click in this area.</p>
							</div>
						</div>

						<template x-if="files.length > 0">
							<div class="grid grid-cols-2 gap-4 mt-4 md:grid-cols-6" @drop.prevent="drop($event)" @dragover.prevent="$event.dataTransfer.dropEffect = 'move'">
								<template x-for="(_, index) in Array.from({ length: files.length })">
									<div class="relative flex flex-col items-center overflow-hidden text-center bg-gray-100 border rounded cursor-move select-none" style="padding-top: 100%;" @dragstart="dragstart($event)" @dragend="fileDragging = null" :class="{'border-blue-600': fileDragging == index}" draggable="true" :data-index="index">
										<button class="absolute top-0 right-0 z-50 p-1 bg-white rounded-bl focus:outline-none" type="button" @click="remove(index)">
											<svg class="w-4 h-4 text-gray-700" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
												<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
											</svg>
										</button>
										<template x-if="files[index].type.includes('audio/')">
											<svg class="absolute w-12 h-12 text-gray-400 transform top-1/2 -translate-y-2/3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
												<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
											</svg>
										</template>
										<template x-if="files[index].type.includes('application/') || files[index].type === ''">
											<svg class="absolute w-12 h-12 text-gray-400 transform top-1/2 -translate-y-2/3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
												<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
											</svg>
										</template>
										<template x-if="files[index].type.includes('image/')">
											<img class="absolute inset-0 z-0 object-cover w-full h-full border-4 border-white preview" x-bind:src="loadFile(files[index])" />
										</template>
										<template x-if="files[index].type.includes('video/')">
											<video class="absolute inset-0 object-cover w-full h-full border-4 border-white pointer-events-none preview">
												<fileDragging x-bind:src="loadFile(files[index])" type="video/mp4">
											</video>
										</template>

										<div class="absolute bottom-0 left-0 right-0 flex flex-col p-2 text-xs bg-white bg-opacity-50">
											<span class="w-full font-bold text-gray-900 truncate" x-text="files[index].name">Loading</span>
											<span class="text-xs text-gray-900" x-text="humanFileSize(files[index].size)">...</span>
										</div>

										<div class="absolute inset-0 z-40 transition-colors duration-300" @dragenter="dragenter($event)" @dragleave="fileDropping = null" :class="{'bg-blue-200 bg-opacity-80': fileDropping == index && fileDragging != index}">
										</div>
									</div>
								</template>
							</div>
						</template>
					</div>
				</div>
				<!-- <div class="form-group">
					<button class="btn btn-md btn-primary">create</button>
				</div> -->

				<!-- end dropzone -->

				<!-- form end -->
		</x-slot>

		<x-slot name="footer">
			<x-secondary-button class="form-group" wire:click="cerrarModal()">
				Cancelar
			</x-secondary-button>
			<x-danger-button wire:click="guardar()" type="submit" class="form-group">
				Guardar
			</x-danger-button>
		</x-slot>
		
	</x-dialog-modal>
	<!-- end modal -->
</div>
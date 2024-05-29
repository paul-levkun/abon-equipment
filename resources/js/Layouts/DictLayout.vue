<template>
  <div>
		<div class="min-h-screen bg-blue-50">
			<!-- Nav -->

			<!-- Page Heading -->
			<header class="bg-white shadow">
				<div class="max-w-6xl mx-auto py-2 px-4 sm:px-6 lg:px-8">
					<slot name="header"></slot>
				</div>
			</header>

			<!-- Page Content -->
			<!-- <div class="bg-white bg-gray-200">
				<div class="shadow"> -->
					<slot name="table"></slot>
				<!-- </div>
			</div> -->
		</div>
  </div>
</template>


<template>
  <div>
		<div class="min-h-screen bg-gray-100">
			<!-- Nav -->

			<!-- Page Heading -->
			<header class="bg-white shadow">
				<div class="max-w-6xl mx-auto py-2 px-4 sm:px-6 lg:px-8">
					<slot name="header"></slot>
				</div>
			</header>

			<!-- Page Content -->
			<main>
				<slot></slot>
			</main>
		</div>
  </div>
</template>

<script>
export default {
	mounted() {
	},
}
</script>
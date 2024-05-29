<template>
<div class="flex flex-col h-[calc(100vh-41px)] max-w-7xl mx-auto">
  <div class="flex-grow overflow-auto">
    <table class="relative w-full border">
      <thead>
        <tr>
          <th class="sticky top-0 px-6 py-3 text-red-900 bg-red-300">Header</th>
          <th class="sticky top-0 px-6 py-3 text-red-900 bg-red-300">Header</th>
          <th class="sticky top-0 px-6 py-3 text-red-900 bg-red-300">Header</th>
        </tr>
      </thead>
      <tbody class="divide-y bg-red-100">
        <tr>
          <td class="px-6 py-4 text-center">Column</td>
          <td class="px-6 py-4 text-center">Column</td>
          <td class="px-6 py-4 text-center">Column</td>
        </tr>
        <tr>
          <td class="px-6 py-4 text-center">Column</td>
          <td class="px-6 py-4 text-center">Column</td>
          <td class="px-6 py-4 text-center">Column</td>
        </tr>
        <tr>
          <td class="px-6 py-4 text-center">Column</td>
          <td class="px-6 py-4 text-center">Column</td>
          <td class="px-6 py-4 text-center">Column</td>
        </tr>
        <tr>
          <td class="px-6 py-4 text-center">Column</td>
          <td class="px-6 py-4 text-center">Column</td>
          <td class="px-6 py-4 text-center">Column</td>
        </tr>
        <tr>
          <td class="px-6 py-4 text-center">Column</td>
          <td class="px-6 py-4 text-center">Column</td>
          <td class="px-6 py-4 text-center">Column</td>
        </tr>
        <tr>
          <td class="px-6 py-4 text-center">Column</td>
          <td class="px-6 py-4 text-center">Column</td>
          <td class="px-6 py-4 text-center">Column</td>
        </tr>
      </tbody>
      <!-- <thead>
        <tr>
          <th class="sticky top-0 px-6 py-3 text-green-900 bg-green-300">Header</th>
          <th class="sticky top-0 px-6 py-3 text-green-900 bg-green-300">Header</th>
          <th class="sticky top-0 px-6 py-3 text-green-900 bg-green-300">Header</th>
        </tr>
      </thead>
      <tbody class="divide-y bg-green-100">
        <tr>
          <td class="px-6 py-4 text-center">Column</td>
          <td class="px-6 py-4 text-center">Column</td>
          <td class="px-6 py-4 text-center">Column</td>
        </tr>
        <tr>
          <td class="px-6 py-4 text-center">Column</td>
          <td class="px-6 py-4 text-center">Column</td>
          <td class="px-6 py-4 text-center">Column</td>
        </tr>
        <tr>
          <td class="px-6 py-4 text-center">Column</td>
          <td class="px-6 py-4 text-center">Column</td>
          <td class="px-6 py-4 text-center">Column</td>
        </tr>
        <tr>
          <td class="px-6 py-4 text-center">Column</td>
          <td class="px-6 py-4 text-center">Column</td>
          <td class="px-6 py-4 text-center">Column</td>
        </tr>
        <tr>
          <td class="px-6 py-4 text-center">Column</td>
          <td class="px-6 py-4 text-center">Column</td>
          <td class="px-6 py-4 text-center">Column</td>
        </tr>
        <tr>
          <td class="px-6 py-4 text-center">Column</td>
          <td class="px-6 py-4 text-center">Column</td>
          <td class="px-6 py-4 text-center">Column</td>
        </tr>
      </tbody>
      <thead>
        <tr>
          <th class="sticky top-0 px-6 py-3 text-blue-900 bg-blue-300">Header</th>
          <th class="sticky top-0 px-6 py-3 text-blue-900 bg-blue-300">Header</th>
          <th class="sticky top-0 px-6 py-3 text-blue-900 bg-blue-300">Header</th>
        </tr>
      </thead>
      <tbody class="divide-y bg-blue-100">
        <tr>
          <td class="px-6 py-4 text-center">Column</td>
          <td class="px-6 py-4 text-center">Column</td>
          <td class="px-6 py-4 text-center">Column</td>
        </tr>
        <tr>
          <td class="px-6 py-4 text-center">Column</td>
          <td class="px-6 py-4 text-center">Column</td>
          <td class="px-6 py-4 text-center">Column</td>
        </tr>
        <tr>
          <td class="px-6 py-4 text-center">Column</td>
          <td class="px-6 py-4 text-center">Column</td>
          <td class="px-6 py-4 text-center">Column</td>
        </tr>
        <tr>
          <td class="px-6 py-4 text-center">Column</td>
          <td class="px-6 py-4 text-center">Column</td>
          <td class="px-6 py-4 text-center">Column</td>
        </tr>
        <tr>
          <td class="px-6 py-4 text-center">Column</td>
          <td class="px-6 py-4 text-center">Column</td>
          <td class="px-6 py-4 text-center">Column</td>
        </tr>
        <tr>
          <td class="px-6 py-4 text-center">Column</td>
          <td class="px-6 py-4 text-center">Column</td>
          <td class="px-6 py-4 text-center">Column</td>
        </tr>
      </tbody>
      <thead>
        <tr>
          <th class="sticky top-0 px-6 py-3 text-yellow-900 bg-yellow-300">Header</th>
          <th class="sticky top-0 px-6 py-3 text-yellow-900 bg-yellow-300">Header</th>
          <th class="sticky top-0 px-6 py-3 text-yellow-900 bg-yellow-300">Header</th>
        </tr>
      </thead>
      <tbody class="divide-y bg-yellow-100">
        <tr>
          <td class="px-6 py-4 text-center">Column</td>
          <td class="px-6 py-4 text-center">Column</td>
          <td class="px-6 py-4 text-center">Column</td>
        </tr>
        <tr>
          <td class="px-6 py-4 text-center">Column</td>
          <td class="px-6 py-4 text-center">Column</td>
          <td class="px-6 py-4 text-center">Column</td>
        </tr>
        <tr>
          <td class="px-6 py-4 text-center">Column</td>
          <td class="px-6 py-4 text-center">Column</td>
          <td class="px-6 py-4 text-center">Column</td>
        </tr>
        <tr>
          <td class="px-6 py-4 text-center">Column</td>
          <td class="px-6 py-4 text-center">Column</td>
          <td class="px-6 py-4 text-center">Column</td>
        </tr>
        <tr>
          <td class="px-6 py-4 text-center">Column</td>
          <td class="px-6 py-4 text-center">Column</td>
          <td class="px-6 py-4 text-center">Column</td>
        </tr>
        <tr>
          <td class="px-6 py-4 text-center">Column</td>
          <td class="px-6 py-4 text-center">Column</td>
          <td class="px-6 py-4 text-center">Column</td>
        </tr>
      </tbody>
      <thead>
        <tr>
          <th class="sticky top-0 px-6 py-3 text-purple-900 bg-purple-300">Header</th>
          <th class="sticky top-0 px-6 py-3 text-purple-900 bg-purple-300">Header</th>
          <th class="sticky top-0 px-6 py-3 text-purple-900 bg-purple-300">Header</th>
        </tr>
      </thead>
      <tbody class="divide-y bg-purple-100">
        <tr>
          <td class="px-6 py-4 text-center">Column</td>
          <td class="px-6 py-4 text-center">Column</td>
          <td class="px-6 py-4 text-center">Column</td>
        </tr>
        <tr>
          <td class="px-6 py-4 text-center">Column</td>
          <td class="px-6 py-4 text-center">Column</td>
          <td class="px-6 py-4 text-center">Column</td>
        </tr>
        <tr>
          <td class="px-6 py-4 text-center">Column</td>
          <td class="px-6 py-4 text-center">Column</td>
          <td class="px-6 py-4 text-center">Column</td>
        </tr>
        <tr>
          <td class="px-6 py-4 text-center">Column</td>
          <td class="px-6 py-4 text-center">Column</td>
          <td class="px-6 py-4 text-center">Column</td>
        </tr>
        <tr>
          <td class="px-6 py-4 text-center">Column</td>
          <td class="px-6 py-4 text-center">Column</td>
          <td class="px-6 py-4 text-center">Column</td>
        </tr>
        <tr>
          <td class="px-6 py-4 text-center">Column</td>
          <td class="px-6 py-4 text-center">Column</td>
          <td class="px-6 py-4 text-center">Column</td>
        </tr>
      </tbody> -->
    </table>
  </div>
</div>
</template>

<script>
export default {
  data() {
    return {
      dict: [],
      // npp: 0
    }
  },
  computed: {
    // getNpp() {
    //   this.npp = this.npp + 1
    //   console.log(this.npp)
    //   return this.npp
    // }
  },
  mounted() {
    this.dict = this.$store.getters['dictModule/currentDict']
    // console.log("dict", this.dict)
  },
}
</script>

  
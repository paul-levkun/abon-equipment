<template>
  <div v-if="canShowDict" class="px-6 py-3 border-t border-gray-500 dark:border-gray-700" :class="style_border">
    <div class="flex items-center">
      <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" class="w-8 h-8 text-gray-500"><path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
      <div class="ml-4 text-lg leading-7 font-semibold">
        <button type="button" @click="showDict" class="underline text-gray-900 dark:text-white">{{ title }}</button>
      </div>
    </div>

    <div class="ml-12">
      <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm">
        {{ description }}
      </div>
    </div>
  </div>
</template>
<script>
  export default {
		name: "DictItem",
    props: ['id', 'title', 'description',],
    data() {
      return {
        dict: []
      }
    },
    methods: {
      showDict() {
        const arr = ["ao_detail1", "ao_detail2"]
        if (arr.indexOf(this.id) === -1) {
          this.$store.commit('dictModule/setForcedDownload', false)
          this.$store.dispatch('dictModule/showDict', { id: this.id, title: this.title, pageId: 1, })
        }
        else {
          this.$store.dispatch('dictModule/makeReport', { id: this.id/*, title: this.title, pageId: 1,*/ })
        }
      },
    },
    computed: {
      style_border() {
        const arr = ["registers", "sap_sos", "ao_detail1"]
        return arr.indexOf(this.id) === -1 ? "md:border-t-1" : "md:border-t-0"
      },
      canShowDict() {
        const arr = [ "users", ]
        // return arr.indexOf(this.id) === -1 ? true : +this.$store.getters['dictModule/userId'] === 4 ?? false
        return arr.indexOf(this.id) === -1 ? true : this.$store.getters['dictModule/userName'] === "Admin" ?? false
      },
    },

  }
</script>
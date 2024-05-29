<!-- npm install vuejs-paginate-next --save -->
<template>
  <paginate class="pagination"
    :page-count="pageCount"
    :page-range="3"
    :margin-pages="2"
    :click-handler="clickCallback"
    :prev-text="'Попер'"
    :next-text="'Наст'"
    :container-class="'pagination'"
    :page-class="'page-item'"
    v-model="page"
  >
  </paginate>
</template>

<script>
  import Paginate from 'vuejs-paginate-next';
  export default {
    emits: ['dictGridChanged', 'pageRelo'],
    data() {
      return {
        page: 1,
        // pageCount: 0,
      }
    },
    components: {
      paginate: Paginate,
    },
    methods: {
      clickCallback(pageNum) { // clickCallback: (pageNum) => { стрілкова функція не годиться зза this...
        this.$emit('dictGridChanged', pageNum)
      }
    },
    computed: {
      pageCount() {
        this.page = Number(this.$store.getters['dictModule/currentDictPageId'])
        const dictRCount = this.$store.getters['dictModule/currentDictRCount']
        const dictRPage = this.$store.getters['dictModule/currentDictPageSize']
        return Math.ceil(dictRCount / dictRPage)
      }
    },
    mounted() {
    }
  };
</script>

<style lang="css">
  /* Adopt bootstrap pagination stylesheet. */
  @import "https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css";

  /* Write your own CSS for pagination */
  .pagination {
    cursor: pointer;
  }
  .page-item {
  }
</style>
<template>
  <div>
    <ul class="pagination">
      <li v-if="pagination.current_page > 1">
        <a @click.prevent="changePage(pagination.current_page - 1)" href="#">Попередня</a>
      </li>

      <li v-for="page in pages" :key="page" :class="{ 'active': page === pagination.current_page }">
        <a @click.prevent="changePage(page)" href="#">{{ page }}</a>
      </li>

      <li v-if="pagination.current_page < pagination.last_page">
        <a @click.prevent="changePage(pagination.current_page + 1)" href="#">Наступна</a>
      </li>
    </ul>
  </div>
</template>

<script>
export default {
  props: {
    pagination: {
      type: Object,
      required: true
    },
    changePage: {
      type: Function,
      required: true
    }
  },
  computed: {
    pages() {
      const pagesArray = [];
      for (let i = 1; i <= this.pagination.last_page; i++) {
        pagesArray.push(i);
      }
      return pagesArray;
    }
  }
};
</script>

<style scoped>
.pagination {
  display: flex;
  list-style: none;
  padding: 0;
}

.pagination li {
  margin: 0 5px;
}

.pagination a {
  text-decoration: none;
  padding: 5px 10px;
  border: 1px solid #ccc;
  cursor: pointer;
}

.pagination .active a {
  background-color: #007bff;
  color: #fff;
}
</style>

<!-- Controller -->
<!-- use App\Models\YourModel; // Замініть "YourModel" на реальну назву вашої моделі

public function getItems()
{
    $items = YourModel::paginate(10); // Замініть "YourModel" на реальну назву вашої моделі та вкажіть бажану кількість елементів на сторінці

    return response()->json($items);
} -->
<template>
  <a :href="href" :class="classes"> <slot></slot> </a>

  <!-- <a v-if="isValid" :href="href" :class="classes"> <slot></slot> </a>
  <div v-else>
    Показати якусь повідомлення про помилку або встановити стандартне посилання
    <span>Помилка: файл не знайдено</span>
  </div> -->
</template>

<script>
export default {
  props: ["href", "active"],
  computed: {
    classes() {
      return this.active
        ? "inline-flex items-center px-1 pt-1 border-b-2 border-indigo-400 text-sm font-medium leading-5 text-gray-900 focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out"
        : "inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out";
    },
  },
};

// export default {
//   props: ['href', 'active'],
//   data() {
//     return {
//       isValid: false
//     };
//   },
//   mounted() {
//     // Виконати перевірку наявності файлу за адресою href
//     this.checkFileExists();
//   },
//   methods: {
//     checkFileExists() {
//       // Реалізуйте перевірку наявності файлу тут, наприклад, за допомогою AJAX запиту
//       // Якщо файл існує, встановіть isValid на true, в іншому випадку залиште його false
//       // Приклад:
//       axios.head(this.href)
//         .then(response => {
//           this.isValid = response.status === 200;
//         })
//         .catch(error => {
//           console.error('Помилка при перевірці файлу:', error);
//         });
//     }
//   }
// }
</script>

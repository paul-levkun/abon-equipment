<template>
  <div class="backdrop" @click="$emit('close')"></div>
  <transition name="modal">
    <dialog open :class="modSize()">
      <slot></slot>
    </dialog>
  </transition>
</template>

<script>
export default {
  name: "BaseModel",
  emits: ["close"],
  inject: ["modSize"],
};
</script>

<style scoped>
.backdrop {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100vh;
  z-index: 10;
  background-color: rgba(0, 0, 0, 0.75);
}
dialog {
  position: fixed;
  top: calc(30%);
  /* top: 30vh; */
  /* width: 30rem;
    left: calc(50% - 15rem); */
  margin: 0;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.26);
  border-radius: 12px;
  padding: 1rem;
  background-color: white;
  z-index: 100;
  border: none;
  animation: modal 0.4s ease-out forwards;
}

dialog.modal-size60 {
  width: 60rem;
  left: calc(50% - 30rem);
}
dialog.modal-size30 {
  width: 30rem;
  left: calc(50% - 15rem);
}

/* .modal-enter-active {
    animation: modal 0.9s ease-out;
  } */
@keyframes modal {
  from {
    opacity: 0;
    transform: translateY(-50px) scale(0.8);
  }
  to {
    opacity: 1;
    transform: translateY(0px) scale(1);
  }
}
</style>

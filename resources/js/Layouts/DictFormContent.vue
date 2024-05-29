<script setup>
import PrimaryButton from "./../Components/PrimaryButton";
import SecondaryButton from "./../Components/SecondaryButton";
import AskFormModify from "./../Components/Modal/AskFormModify";
</script>

<template>
  <div class="flex flex-col h-[calc(100vh-50px)] mx-auto">
    <form @submit.prevent="submit" enctype="multipart/form-data">
      <div class="flex-container">
        <div class="flex justify-left px-1">
          <PrimaryButton type="submit"> Зберегти </PrimaryButton>
          <SecondaryButton class="ml-1" @click="back"> Назад </SecondaryButton>
        </div>
        <div
          class="flex items-center justify-center message"
          v-if="successSaved || errorSaved"
          :class="{ success_saved: successSaved, error_saved: errorSaved }"
          @animationend="animationEnd"
        >
          {{ saveMessage }}
        </div>
      </div>

      <div v-if="isLoading" class="py-12">
        <base-spinner></base-spinner>
      </div>

      <div
        class="p-4 border-slate-400 border-t-2 mt-1 h-[calc(100vh-95px)] flex-grow overflow-auto"
      >
        <slot name="default"></slot>
      </div>
    </form>
  </div>
  <div>
    <AskFormModify
      v-if="modAskFormModifyVisible"
      @submitForm="submit"
      @hideDialog="hideDialog"
    ></AskFormModify>
  </div>
</template>

<script>
export default {
  emits: ["submitForm"],
  provide() {
    return {
      modSize: () => {
        // вертає функцію
        return "modal-size30";
      },
    };
  },

  data() {
    return {
      // pageId: 1
      modAskFormModifyVisible: false,
    };
  },

  methods: {
    submit() {
      this.$emit("submitForm");
      this.$store.commit("dictModule/setIsFormModified", 0);
      this.modAskFormModifyVisible = false;
    },
    back() {
      if (!!+this.$store.getters["dictModule/isFormModified"]) {
        this.modAskFormModifyVisible = true;
      } else {
        this.$store.commit("dictModule/setIsFormModified", 0);
        this.$store.dispatch("dictModule/showDict", {
          id: this.$store.getters["dictModule/currentDictId"],
          title: this.$store.getters["dictModule/currentDictTitle"],
          pageId: this.$store.getters["dictModule/currentDictPageId"],
        });
      }
    },
    animationEnd() {
      this.$store.commit("dictModule/setAddSaved", false);
      this.$store.commit("dictModule/setUpdateSaved", false);
      this.$store.commit("dictModule/setErrorSaved", false);
    },
    hideDialog() {
      this.$store.commit("dictModule/setIsFormModified", 0);
      this.modAskFormModifyVisible = false;

      this.$store.dispatch("dictModule/showDict", {
        id: this.$store.getters["dictModule/currentDictId"],
        title: this.$store.getters["dictModule/currentDictTitle"],
        pageId: this.$store.getters["dictModule/currentDictPageId"],
      });
    },
  },

  computed: {
    successSaved() {
      return (
        this.$store.getters["dictModule/addSaved"] ||
        this.$store.getters["dictModule/updateSaved"]
      );
    },
    errorSaved() {
      return this.$store.getters["dictModule/errorSaved"];
    },
    saveMessage() {
      return this.$store.getters["dictModule/errorSaved"] ? "ПОМИЛКА" : "ЗБЕРЕЖЕНО";
    },
    isLoading() {
      return this.$store.getters["dictModule/isLoading"];
    },
  },

  unmounted() {
    if (Object.keys(this.$store.getters["dictModule/formErrors"]).length > 0) {
      this.$store.commit("dictModule/setFormErrors", {});
    }
    // this.$store.commit("dictModule/setIsFormModified", 0);
  },
};
</script>
<style>
.flex-container {
  position: relative;
}
.message {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  text-align: center;
  font-weight: bold;
  color: white;
  z-index: 1;
  animation: saving 1s ease-out forwards;
}

.success_saved {
  background-color: rgba(0, 255, 0, 1);
}

.error_saved {
  background-color: rgba(255, 0, 0, 1);
}

.saving {
  animation: saving 1s ease-out forwards;
}

@keyframes saving {
  /* from {
    opacity: 1;
    transform: scale(100%)
  }
  to {
    opacity: 0;
    transform: scale(0%)
  } */
  0% {
    opacity: 1;
    transform: scale(100%);
  }
  60% {
    opacity: 1;
    transform: scale(100%);
  }
  100% {
    opacity: 0;
    transform: scale(0%);
  }
}
</style>

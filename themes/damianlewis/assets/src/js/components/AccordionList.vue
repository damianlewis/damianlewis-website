<template>
    <div>
        <div class="flex items-center justify-between">
            <span class="c-text text-grey-600 cursor-pointer" @click="isOpen = !isOpen">{{ title }}</span>
            <a href="#" class="h-6" @click.prevent="isOpen = !isOpen">
                <img v-if="isOpen" :src="closeButton" class="h-full" alt="Close icon">
                <img v-else :src="openButton" class="h-full" alt="Open icon">
            </a>
        </div>

        <div class="overflow-hidden" :class="{'accordion--closed': !isOpen, 'accordion--open': isOpen}">
            <div v-for="item in list" class="[ c-text c-text--small ] text-grey-600">{{ item.name }}</div>
        </div>
    </div>
</template>

<script>
  export default {
    name: 'AccordionList',

    props: {
      title: String,
      list: Array,
      openButton: String,
      closeButton: String,
    },

    data () {
      return {
        isOpen: false,
      }
    },
  }
</script>

<style lang="scss" scoped>
    .accordion--open {
        max-height: 500px;
        transition: max-height 0.4s ease-in;
    }

    .accordion--closed {
        max-height: 0;
        transition: max-height 0.4s ease-out;
    }
</style>
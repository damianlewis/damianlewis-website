<template>
    <nav class="fixed top-0 left-0 z-10 flex justify-center items-center w-screen h-screen bg-black-90" :class="{'nav--active': isVisible}">
        <ul class="font-heading font-light tracking-tight antialiased text-6xl text-center text-white">
            <slot></slot>
        </ul>
    </nav>
</template>

<script>
  export default {
    name: 'Navigation',
    props: {
      isVisible: Boolean,
    },
  }
</script>

<style scoped>
    nav {
        transform: translate3d(0, -100%, 0);
        transition: transform 0.4s cubic-bezier(0.775, 0.125, 0.15, 0.85);
    }

    .nav--active {
        transform: translate3d(0, 0, 0);
    }
</style>

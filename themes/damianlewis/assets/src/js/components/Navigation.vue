<template>
    <nav class="nav" :class="{'nav--active': isVisible}">
        <ul class="nav__list">
            <li v-for="item in list">
                <a :href="item.url" class="nav__link">{{ item.title }}</a>
            </li>
        </ul>
    </nav>
</template>

<script>
  export default {
    name: 'Navigation',

    props: {
      isVisible: Boolean,
      list: Array,
    },
  }
</script>

<style lang="scss" scoped>
    $line-width: 36px;
    $line-offset: -10px;

    .nav {
        @apply fixed top-0 left-0 z-10 flex justify-center items-center w-screen h-screen bg-black-90;
        transform: translate3d(0, -100%, 0);
        transition: transform 0.4s cubic-bezier(0.775, 0.125, 0.15, 0.85);
    }

    .nav__list {
        @apply font-heading font-light tracking-tight antialiased text-6xl text-center text-white;
    }

    .nav__link {
        @apply relative select-none;

        &::before,
        &::after {
            @apply absolute w-0 h-1 bg-white transition-all transition-ease-out;
            content: "";
            bottom: 40%;
        }

        &::before {
            left: $line-offset;
        }

        &::after {
            right: $line-offset;
        }

        &:hover {
            &::before,
            &::after {
                width: $line-width;
            }

            &::before {
                left: -$line-width + $line-offset;
            }

            &::after {
                right: -$line-width + $line-offset;
            }
        }
    }

    .nav--active {
        transform: translate3d(0, 0, 0);
    }
</style>

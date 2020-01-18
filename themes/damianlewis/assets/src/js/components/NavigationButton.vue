<template>
    <button class="block cursor-pointer focus:outline-none" :class="{'button--active': isActive}" @click="$emit('toggle')">
        <span class="button__box block relative">
            <span class="button__inner block"></span>
        </span>
    </button>
</template>

<script>
  export default {
    name: 'NavigationButton',
    props: {
      isActive: Boolean,
    },
  }
</script>

<style lang="scss" scoped>
    $hamburger-layer-width: 28px;
    $hamburger-layer-height: 3px;
    $hamburger-layer-spacing: 6px;

    .button--active {
        .button__inner {
            transform: rotate(-225deg);
            transition-delay: 0.12s;
            transition: transform 0.22s 0.12s cubic-bezier(0.215, 0.61, 0.355, 1), background-color 0.34s ease-out;

            &,
            &::before,
            &::after {
                @apply bg-white;
            }

            &::before {
                @apply top-0;
                @apply opacity-0;
                transition: top 0.1s ease-out, opacity 0.1s 0.12s ease-out, background-color 0.22s ease-out;
            }

            &::after {
                @apply bottom-0;
                transform: rotate(90deg);
                transition: bottom 0.1s ease-out, transform 0.22s 0.12s cubic-bezier(0.215, 0.61, 0.355, 1), background-color 0.34s ease-out;
            }
        }
    }

    .button__box {
        width: $hamburger-layer-width;
        height: ($hamburger-layer-height * 3) + ($hamburger-layer-spacing * 2);
    }

    .button__inner {
        top: 50%;
        margin-top: -($hamburger-layer-height / 2);
        transition: transform 0.22s cubic-bezier(0.55, 0.055, 0.675, 0.19), background-color 0.22s ease-in;

        &,
        &::before,
        &::after {
            @apply absolute;
            @apply bg-grey-900;
            width: $hamburger-layer-width;
            height: $hamburger-layer-height;
        }

        &::before,
        &::after {
            @apply block;
            content: '';
        }

        &::before {
            top: -($hamburger-layer-spacing + $hamburger-layer-height);
            transition: top 0.1s 0.25s ease-in, opacity 0.1s ease-in, background-color 0.35s ease-in;
        }

        &::after {
            bottom: -($hamburger-layer-spacing + $hamburger-layer-height);
            transition: bottom 0.1s 0.25s ease-in, transform 0.22s cubic-bezier(0.55, 0.055, 0.675, 0.19), background-color 0.35s ease-in;
        }
    }
</style>

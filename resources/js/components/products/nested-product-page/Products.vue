<template>
    <main>
        <h1>Products</h1>

        <NavProducts />

        <router-view v-slot="{ Component }">
            <transition name="fade" mode="out-in">
                <component :is="Component" />
            </transition>
        </router-view>
    </main>
</template>

<script>
import NavProducts from "../NavProductc.vue";

export default {
    components: {
        NavProducts,
    },
};
</script>

<style scoped>
a.router-link-active {
    background-color: red !important;
}

.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.3s ease;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}
</style>

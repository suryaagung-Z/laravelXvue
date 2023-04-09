<template>
    <nav>
        <router-link :to="{ name: 'Home' }">Home</router-link>
        <router-link :to="{ name: 'About' }">About</router-link>
        <router-link :to="{ name: 'Products' }">Products</router-link>
        <router-link :to="{ name: 'Contact' }">Contact</router-link>
    </nav>
    <router-view v-slot="{ Component }">
        <transition name="fade" mode="out-in">
            <component :is="Component" />
        </transition>
    </router-view>
</template>

<style scoped>
main {
    padding: 20px;
}

nav {
    display: flex;
    gap: 20px;
}
nav a {
    text-decoration: none;
    color: #fff;
    background-color: #000;
    padding: 10px 20px;
}

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
